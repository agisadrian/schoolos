<?php

namespace App\Http\Controllers;

use App\Models\SchoolClass;
use App\Models\Subject;
use Illuminate\Http\Request;

class SubjectController extends Controller
{
    public function index(SchoolClass $class)
    {
        $subjects = $class->subjects()
            ->orderBy('name')
            ->get();

        return view(
            'subjects.index',
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
            'name' => [
                'required',
                'string',
                'max:255',
            ],

            'code' => [
                'nullable',
                'string',
                'max:50',
            ],

            'description' => [
                'nullable',
                'string',
            ],
        ]);

        Subject::create([
            'class_id' => $class->id,
            'name' => $validated['name'],
            'code' => $validated['code'] ?? null,
            'description' => $validated['description'] ?? null,
        ]);

        return redirect()
            ->route(
                'subjects.index',
                $class
            )
            ->with(
                'success',
                'Mata pelajaran berhasil ditambahkan.'
            );
    }

    public function update(
        Request $request,
        SchoolClass $class,
        Subject $subject
    ) {
        if ($subject->class_id !== $class->id) {
            abort(404);
        }

        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
            ],

            'code' => [
                'nullable',
                'string',
                'max:50',
            ],

            'description' => [
                'nullable',
                'string',
            ],
        ]);

        $subject->update([
            'name' => $validated['name'],
            'code' => $validated['code'] ?? null,
            'description' => $validated['description'] ?? null,
        ]);

        return redirect()
            ->route('subjects.index', $class)
            ->with(
                'success',
                'Mata pelajaran berhasil diperbarui.'
            );
    }

    public function destroy(
        SchoolClass $class,
        Subject $subject
    ) {
        if ($subject->class_id !== $class->id) {
            abort(404);
        }

        $subject->delete();

        return redirect()
            ->route('subjects.index', $class)
            ->with(
                'success',
                'Mata pelajaran berhasil dihapus.'
            );
    }
}