<?php

namespace App\Http\Controllers;

use App\Models\Assignment;
use App\Models\SchoolClass;
use App\Models\Submission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class SubmissionController extends Controller
{
    public function create(
        SchoolClass $class,
        Assignment $assignment
    ) {
        if ($assignment->class_id !== $class->id) {
            abort(404);
        }

        if (now()->greaterThan($assignment->deadline)) {
            return redirect()
                ->route('assignments.show', [
                    'class' => $class,
                    'assignment' => $assignment,
                ])
                ->withErrors([
                    'deadline' =>
                        'Deadline tugas sudah berakhir.',
                ]);
        }

        $submission = Submission::where(
            'assignment_id',
            $assignment->id
        )
            ->where(
                'user_id',
                Auth::id()
            )
            ->first();

        return view(
            'submissions.create',
            compact(
                'class',
                'assignment',
                'submission'
            )
        );
    }


    public function store(
        Request $request,
        SchoolClass $class,
        Assignment $assignment
    ) {
        if ($assignment->class_id !== $class->id) {
            abort(404);
        }

        if (now()->greaterThan($assignment->deadline)) {
            return back()
                ->withErrors([
                    'deadline' =>
                        'Deadline tugas sudah berakhir. Pengumpulan tidak dapat dilakukan.',
                ]);
        }

        $validated = $request->validate([
            'file' => [
                'required',
                'file',
                'mimes:pdf,doc,docx,ppt,pptx,xls,xlsx,zip',
                'max:10240',
            ],

            'note' => [
                'nullable',
                'string',
                'max:5000',
            ],
        ]);


        $existingSubmission = Submission::where(
            'assignment_id',
            $assignment->id
        )
            ->where(
                'user_id',
                Auth::id()
            )
            ->first();


        /*
        |--------------------------------------------------------------------------
        | Hapus file submission lama
        |--------------------------------------------------------------------------
        */

        if (
            $existingSubmission &&
            $existingSubmission->file_path &&
            Storage::disk('public')->exists(
                $existingSubmission->file_path
            )
        ) {
            Storage::disk('public')->delete(
                $existingSubmission->file_path
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Upload file baru
        |--------------------------------------------------------------------------
        */

        $file = $validated['file'];

        $path = $file->store(
            'submissions',
            'public'
        );


        /*
        |--------------------------------------------------------------------------
        | Update / Create Submission
        |--------------------------------------------------------------------------
        */

        if ($existingSubmission) {

            $existingSubmission->update([
                'file_path' =>
                    $path,

                'file_name' =>
                    $file->getClientOriginalName(),

                'file_type' =>
                    $file->getClientMimeType(),

                'file_size' =>
                    $file->getSize(),

                'note' =>
                    $validated['note'] ?? null,

                'submitted_at' =>
                    now(),
            ]);

        } else {

            Submission::create([
                'assignment_id' =>
                    $assignment->id,

                'user_id' =>
                    Auth::id(),

                'file_path' =>
                    $path,

                'file_name' =>
                    $file->getClientOriginalName(),

                'file_type' =>
                    $file->getClientMimeType(),

                'file_size' =>
                    $file->getSize(),

                'note' =>
                    $validated['note'] ?? null,

                'submitted_at' =>
                    now(),
            ]);

        }


        return redirect()
            ->route('assignments.show', [
                'class' => $class,
                'assignment' => $assignment,
            ])
            ->with(
                'success',
                'Tugas berhasil dikumpulkan.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | Daftar Submission
    |--------------------------------------------------------------------------
    */

    public function index(
        Request $request,
        SchoolClass $class,
        Assignment $assignment
    ) {
        if ($assignment->class_id !== $class->id) {
            abort(404);
        }


        /*
        |--------------------------------------------------------------------------
        | Student tidak boleh melihat daftar submission siswa lain
        |--------------------------------------------------------------------------
        */

        if (Auth::user()->role === 'student') {
            abort(403);
        }


        $query = $assignment
            ->submissions()
            ->with('user');


        /*
        |--------------------------------------------------------------------------
        | Search nama / email siswa
        |--------------------------------------------------------------------------
        */

        if ($request->filled('search')) {
            $search = trim($request->search);

            $query->whereHas(
                'user',
                function ($userQuery) use ($search) {
                    $userQuery
                        ->where(
                            'name',
                            'like',
                            '%' . $search . '%'
                        )
                        ->orWhere(
                            'email',
                            'like',
                            '%' . $search . '%'
                        );
                }
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Submission yang sudah masuk
        |--------------------------------------------------------------------------
        */

        $submissions = $query
            ->latest('submitted_at')
            ->paginate(20)
            ->withQueryString();


        /*
        |--------------------------------------------------------------------------
        | Semua siswa dalam kelas
        |--------------------------------------------------------------------------
        */

        $students = $class->members()
            ->with('user')
            ->where(
                'role',
                'student'
            )
            ->get()
            ->sortBy('user.name')
            ->values();


        /*
        |--------------------------------------------------------------------------
        | Hitung statistik
        |--------------------------------------------------------------------------
        */

        $submittedCount = $assignment
            ->submissions()
            ->whereHas(
                'user',
                function ($query) use ($class) {
                    $query->whereHas(
                        'classMembers',
                        function ($memberQuery) use ($class) {
                            $memberQuery->where(
                                'class_id',
                                $class->id
                            );
                        }
                    );
                }
            )
            ->count();


        $totalStudents = $students->count();

        $notSubmittedCount =
            max(
                $totalStudents - $submittedCount,
                0
            );


        return view(
            'submissions.index',
            compact(
                'class',
                'assignment',
                'submissions',
                'students',
                'submittedCount',
                'notSubmittedCount',
                'totalStudents'
            )
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Detail Submission
    |--------------------------------------------------------------------------
    */

    public function show(
        SchoolClass $class,
        Assignment $assignment,
        Submission $submission
    ) {
        if ($assignment->class_id !== $class->id) {
            abort(404);
        }


        if (
            $submission->assignment_id !==
            $assignment->id
        ) {
            abort(404);
        }


        /*
        |--------------------------------------------------------------------------
        | Student hanya boleh melihat miliknya
        |--------------------------------------------------------------------------
        */

        if (
            Auth::user()->role === 'student' &&
            $submission->user_id !== Auth::id()
        ) {
            abort(403);
        }


        $submission->load([
            'assignment.subject',
            'user',
        ]);


        return view(
            'submissions.show',
            compact(
                'class',
                'assignment',
                'submission'
            )
        );
    }
}