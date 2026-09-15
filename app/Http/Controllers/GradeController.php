<?php

namespace App\Http\Controllers;

use App\Models\Grade;
use App\Models\SchoolClass;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class GradeController extends Controller
{
    public function index(
        Request $request,
        SchoolClass $class
    ) {
        $user = Auth::user();

        $query = $class->grades()
            ->with([
                'subject',
                'student',
                'enteredBy',
            ]);

        /*
        |--------------------------------------------------------------------------
        | Student hanya melihat nilainya sendiri
        |--------------------------------------------------------------------------
        */

        if ($user->role === 'student') {
            $query->where(
                'student_id',
                $user->id
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Search
        |--------------------------------------------------------------------------
        */

        if ($request->filled('search')) {

            $search = trim(
                $request->search
            );

            $query->where(function ($gradeQuery) use ($search) {

                $gradeQuery
                    ->where(
                        'title',
                        'like',
                        '%' . $search . '%'
                    )
                    ->orWhereHas(
                        'student',
                        function ($studentQuery) use ($search) {

                            $studentQuery
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
                    )
                    ->orWhereHas(
                        'subject',
                        function ($subjectQuery) use ($search) {

                            $subjectQuery->where(
                                'name',
                                'like',
                                '%' . $search . '%'
                            );
                        }
                    );

            });
        }


        /*
        |--------------------------------------------------------------------------
        | Filter Subject
        |--------------------------------------------------------------------------
        */

        if ($request->filled('subject_id')) {

            $subjectExists = $class
                ->subjects()
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

        $grades = $query
            ->latest()
            ->paginate(10)
            ->withQueryString();


        /*
        |--------------------------------------------------------------------------
        | Subjects
        |--------------------------------------------------------------------------
        */

        $subjects = $class
            ->subjects()
            ->orderBy('name')
            ->get();


        /*
        |--------------------------------------------------------------------------
        | Statistik siswa
        |--------------------------------------------------------------------------
        */

        $studentAverage = null;
        $highestScore = null;
        $lowestScore = null;

        if ($user->role === 'student') {

            $studentGrades = $class
                ->grades()
                ->where(
                    'student_id',
                    $user->id
                )
                ->get();

            if ($studentGrades->count() > 0) {

                $percentages = $studentGrades
                    ->map(function ($grade) {

                        if (
                            (float) $grade->max_score <= 0
                        ) {
                            return 0;
                        }

                        return (
                            (float) $grade->score /
                            (float) $grade->max_score
                        ) * 100;

                    });

                $studentAverage =
                    round(
                        $percentages->avg(),
                        2
                    );

                $highestScore =
                    round(
                        $percentages->max(),
                        2
                    );

                $lowestScore =
                    round(
                        $percentages->min(),
                        2
                    );
            }
        }


        return view(
            'grades.index',
            compact(
                'class',
                'grades',
                'subjects',
                'studentAverage',
                'highestScore',
                'lowestScore'
            )
        );
    }


    public function create(
        SchoolClass $class
    ) {
        $subjects = $class
            ->subjects()
            ->orderBy('name')
            ->get();


        $students = $class
            ->members()
            ->with('user')
            ->where(
                'role',
                'student'
            )
            ->get()
            ->sortBy('user.name')
            ->values();


        return view(
            'grades.create',
            compact(
                'class',
                'subjects',
                'students'
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
                Rule::exists(
                    'subjects',
                    'id'
                )->where(
                    'class_id',
                    $class->id
                ),
            ],

            'student_id' => [
                'required',
                'integer',
                Rule::exists(
                    'class_members',
                    'user_id'
                )
                    ->where(
                        'class_id',
                        $class->id
                    )
                    ->where(
                        'role',
                        'student'
                    ),
            ],

            'title' => [
                'required',
                'string',
                'max:255',
            ],

            'score' => [
                'required',
                'numeric',
                'min:0',
            ],

            'max_score' => [
                'required',
                'numeric',
                'gt:0',
            ],

            'notes' => [
                'nullable',
                'string',
                'max:5000',
            ],

        ]);


        /*
        |--------------------------------------------------------------------------
        | Score tidak boleh lebih besar dari max score
        |--------------------------------------------------------------------------
        */

        if (
            $validated['score'] >
            $validated['max_score']
        ) {

            return back()
                ->withInput()
                ->withErrors([
                    'score' =>
                        'Nilai tidak boleh melebihi nilai maksimal.',
                ]);

        }


        /*
        |--------------------------------------------------------------------------
        | Cek duplicate
        |--------------------------------------------------------------------------
        */

        $duplicate = Grade::where(
            'class_id',
            $class->id
        )
            ->where(
                'subject_id',
                $validated['subject_id']
            )
            ->where(
                'student_id',
                $validated['student_id']
            )
            ->where(
                'title',
                $validated['title']
            )
            ->exists();


        if ($duplicate) {

            return back()
                ->withInput()
                ->withErrors([
                    'title' =>
                        'Nilai dengan judul tersebut sudah ada untuk siswa ini.',
                ]);

        }


        /*
        |--------------------------------------------------------------------------
        | Simpan nilai
        |--------------------------------------------------------------------------
        */

        Grade::create([

            'class_id' =>
                $class->id,

            'subject_id' =>
                $validated['subject_id'],

            'student_id' =>
                $validated['student_id'],

            'entered_by' =>
                Auth::id(),

            'title' =>
                $validated['title'],

            'score' =>
                $validated['score'],

            'max_score' =>
                $validated['max_score'],

            'notes' =>
                $validated['notes'] ?? null,

        ]);


        return redirect()
            ->route(
                'grades.index',
                $class
            )
            ->with(
                'success',
                'Nilai berhasil ditambahkan.'
            );
    }


    public function show(
        SchoolClass $class,
        Grade $grade
    ) {
        if (
            $grade->class_id !==
            $class->id
        ) {
            abort(404);
        }


        /*
        |--------------------------------------------------------------------------
        | Student hanya boleh melihat nilainya sendiri
        |--------------------------------------------------------------------------
        */

        if (
            Auth::user()->role === 'student' &&
            $grade->student_id !== Auth::id()
        ) {
            abort(403);
        }


        $grade->load([
            'subject',
            'student',
            'enteredBy',
        ]);


        return view(
            'grades.show',
            compact(
                'class',
                'grade'
            )
        );
    }
}