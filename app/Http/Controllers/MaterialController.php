<?php

namespace App\Http\Controllers;

use App\Models\Material;
use App\Models\SchoolClass;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class MaterialController extends Controller
{
    public function index(
        Request $request,
        SchoolClass $class
    ) {
        $query = $class->materials()
            ->with([
                'subject',
                'uploader',
            ]);

        /*
        |--------------------------------------------------------------------------
        | Search
        |--------------------------------------------------------------------------
        */

        if ($request->filled('search')) {
            $search = trim($request->search);

            $query->where(function ($materialQuery) use ($search) {
                $materialQuery
                    ->where(
                        'title',
                        'like',
                        '%' . $search . '%'
                    )
                    ->orWhere(
                        'description',
                        'like',
                        '%' . $search . '%'
                    )
                    ->orWhere(
                        'file_name',
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
        | Pagination
        |--------------------------------------------------------------------------
        */

        $materials = $query
            ->latest()
            ->paginate(9)
            ->withQueryString();


        $subjects = $class->subjects()
            ->orderBy('name')
            ->get();


        return view(
            'materials.index',
            compact(
                'class',
                'materials',
                'subjects'
            )
        );
    }


    public function create(SchoolClass $class)
    {
        $subjects = $class->subjects()
            ->orderBy('name')
            ->get();

        return view(
            'materials.create',
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

            'file' => [
                'required',
                'file',
                'mimes:pdf,doc,docx,ppt,pptx,xls,xlsx,zip',
                'max:10240',
            ],
        ]);


        /*
        |--------------------------------------------------------------------------
        | Pastikan Subject berasal dari kelas
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


        /*
        |--------------------------------------------------------------------------
        | Upload File
        |--------------------------------------------------------------------------
        */

        $file = $request->file('file');

        $filePath = $file->store(
            'materials',
            'public'
        );


        Material::create([
            'class_id' => $class->id,

            'subject_id' =>
                $validated['subject_id'],

            'uploaded_by' =>
                Auth::id(),

            'title' =>
                $validated['title'],

            'description' =>
                $validated['description'] ?? null,

            'file_path' =>
                $filePath,

            'file_name' =>
                $file->getClientOriginalName(),

            'file_type' =>
                $file->getClientMimeType(),

            'file_size' =>
                $file->getSize(),
        ]);


        return redirect()
            ->route(
                'materials.index',
                $class
            )
            ->with(
                'success',
                'Materi berhasil ditambahkan.'
            );
    }


    public function show(
        SchoolClass $class,
        Material $material
    ) {
        if ($material->class_id !== $class->id) {
            abort(404);
        }


        $material->load([
            'subject',
            'uploader',
        ]);


        return view(
            'materials.show',
            compact(
                'class',
                'material'
            )
        );
    }
}