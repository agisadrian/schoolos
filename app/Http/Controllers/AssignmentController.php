<?php

namespace App\Http\Controllers;

use App\Models\Assignment;
use App\Models\SchoolClass;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AssignmentController extends Controller
{
    public function index(
        Request $request,
        SchoolClass $class
    ) {
        $query = $class->assignments()
            ->with('subject');

        /*
        |--------------------------------------------------------------------------
        | Search
        |--------------------------------------------------------------------------
        */

        if ($request->filled('search')) {
            $search = trim($request->search);

            $query->where(function ($assignmentQuery) use ($search) {
                $assignmentQuery
                    ->where(
                        'title',
                        'like',
                        '%' . $search . '%'
                    )
                    ->orWhere(
                        'description',
                        'like',
                        '%' . $search . '%'
                    );
            });
        }


        /*
        |--------------------------------------------------------------------------
        | Filter Mata Pelajaran
        |--------------------------------------------------------------------------
        */

        if ($request->filled('subject_id')) {
            $subjectExists = $class->subjects()
                ->where(
                    'id',
                    $request->subject_id
                )
                ->exists();

            if ($subjectExists) {
                $query->where(
                    'subject_id',
                    $request->subject_id
                );
            }
        }


        /*
        |--------------------------------------------------------------------------
        | Filter Deadline
        |--------------------------------------------------------------------------
        */

        if ($request->deadline === 'active') {
            $query->where(
                'deadline',
                '>=',
                now()
            );
        }

        if ($request->deadline === 'expired') {
            $query->where(
                'deadline',
                '<',
                now()
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Pagination
        |--------------------------------------------------------------------------
        */

        $assignments = $query
            ->latest()
            ->paginate(9)
            ->withQueryString();


        /*
        |--------------------------------------------------------------------------
        | Student Submission Status
        |--------------------------------------------------------------------------
        */

        $submissions = collect();

        if (Auth::user()->role === 'student') {
            $submissions = \App\Models\Submission::where(
                'user_id',
                Auth::id()
            )
                ->whereIn(
                    'assignment_id',
                    $assignments->pluck('id')
                )
                ->get()
                ->keyBy('assignment_id');
        }


        /*
        |--------------------------------------------------------------------------
        | Subjects
        |--------------------------------------------------------------------------
        */

        $subjects = $class->subjects()
            ->orderBy('name')
            ->get();


        return view(
            'assignments.index',
            compact(
                'class',
                'assignments',
                'subjects',
                'submissions'
            )
        );
    }


    public function create(SchoolClass $class)
    {
        $subjects = $class->subjects()
            ->orderBy('name')
            ->get();

        return view(
            'assignments.create',
            compact(
                'class',
                'subjects'
            )
        );
    }


    public function store(
        Request $request,
        SchoolClass $class
    ) {
        $validated = $request->validate([
            'subject_id' => [
                'required',
                'integer',
                'exists:subjects,id',
            ],

            'title' => [
                'required',
                'string',
                'max:255',
            ],

            'description' => [
                'nullable',
                'string',
                'max:10000',
            ],

            'deadline' => [
                'required',
                'date',
                'after:now',
            ],

            'file' => [
                'nullable',
                'file',
                'mimes:pdf,doc,docx,ppt,pptx,xls,xlsx,zip',
                'max:10240',
            ],
        ]);


        /*
        |--------------------------------------------------------------------------
        | Pastikan Subject Milik Kelas
        |--------------------------------------------------------------------------
        */

        $subjectExists = $class->subjects()
            ->where(
                'id',
                $validated['subject_id']
            )
            ->exists();

        if (!$subjectExists) {
            return back()
                ->withInput()
                ->withErrors([
                    'subject_id' =>
                        'Mata pelajaran tidak berasal dari kelas ini.',
                ]);
        }


        $filePath = null;
        $fileName = null;
        $fileType = null;
        $fileSize = null;


        /*
        |--------------------------------------------------------------------------
        | Upload File
        |--------------------------------------------------------------------------
        */

        if ($request->hasFile('file')) {
            $file = $request->file('file');

            $filePath = $file->store(
                'assignments',
                'public'
            );

            $fileName =
                $file->getClientOriginalName();

            $fileType =
                $file->getClientMimeType();

            $fileSize =
                $file->getSize();
        }


        Assignment::create([
            'class_id' =>
                $class->id,

            'subject_id' =>
                $validated['subject_id'],

            'created_by' =>
                Auth::id(),

            'title' =>
                $validated['title'],

            'description' =>
                $validated['description'] ?? null,

            'deadline' =>
                $validated['deadline'],

            'file_path' =>
                $filePath,

            'file_name' =>
                $fileName,

            'file_type' =>
                $fileType,

            'file_size' =>
                $fileSize,
        ]);


        return redirect()
            ->route(
                'assignments.index',
                $class
            )
            ->with(
                'success',
                'Tugas berhasil dibuat.'
            );
    }


    public function show(
        SchoolClass $class,
        Assignment $assignment
    ) {
        if ($assignment->class_id !== $class->id) {
            abort(404);
        }


        $assignment->load([
            'subject',
            'creator',
        ]);


        $submission = null;


        if (
            Auth::user()->role === 'student'
        ) {
            $submission = $assignment
                ->submissions()
                ->where(
                    'user_id',
                    Auth::id()
                )
                ->first();
        }


        return view(
            'assignments.show',
            compact(
                'class',
                'assignment',
                'submission'
            )
        );
    }


    public function edit(
        SchoolClass $class,
        Assignment $assignment
    ) {
        if ($assignment->class_id !== $class->id) {
            abort(404);
        }

        $subjects = $class->subjects()
            ->orderBy('name')
            ->get();

        return view(
            'assignments.edit',
            compact(
                'class',
                'assignment',
                'subjects'
            )
        );
    }


    public function update(
        Request $request,
        SchoolClass $class,
        Assignment $assignment
    ) {
        if ($assignment->class_id !== $class->id) {
            abort(404);
        }

        $validated = $request->validate([
            'subject_id' => [
                'required',
                'integer',
                'exists:subjects,id',
            ],

            'title' => [
                'required',
                'string',
                'max:255',
            ],

            'description' => [
                'nullable',
                'string',
                'max:10000',
            ],

            'deadline' => [
                'required',
                'date',
            ],

            'file' => [
                'nullable',
                'file',
                'mimes:pdf,doc,docx,ppt,pptx,xls,xlsx,zip',
                'max:10240',
            ],
        ]);

        $subjectExists = $class->subjects()
            ->where('id', $validated['subject_id'])
            ->exists();

        if (!$subjectExists) {
            return back()
                ->withInput()
                ->withErrors([
                    'subject_id' =>
                        'Mata pelajaran tidak berasal dari kelas ini.',
                ]);
        }

        $updateData = [
            'subject_id' => $validated['subject_id'],
            'title' => $validated['title'],
            'description' => $validated['description'] ?? null,
            'deadline' => $validated['deadline'],
        ];

        if ($request->hasFile('file')) {
            if ($assignment->file_path) {
                Storage::disk('public')->delete(
                    $assignment->file_path
                );
            }

            $file = $request->file('file');

            $updateData['file_path'] = $file->store(
                'assignments',
                'public'
            );
            $updateData['file_name'] = $file->getClientOriginalName();
            $updateData['file_type'] = $file->getClientMimeType();
            $updateData['file_size'] = $file->getSize();
        }

        $assignment->update($updateData);

        return redirect()
            ->route('assignments.show', [$class, $assignment])
            ->with(
                'success',
                'Tugas berhasil diperbarui.'
            );
    }


    public function destroy(
        SchoolClass $class,
        Assignment $assignment
    ) {
        if ($assignment->class_id !== $class->id) {
            abort(404);
        }

        if ($assignment->file_path) {
            Storage::disk('public')->delete(
                $assignment->file_path
            );
        }

        $assignment->delete();

        return redirect()
            ->route('assignments.index', $class)
            ->with(
                'success',
                'Tugas berhasil dihapus.'
            );
    }
}