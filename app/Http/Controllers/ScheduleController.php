<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use App\Models\SchoolClass;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ScheduleController extends Controller
{
    public function index(SchoolClass $class)
    {
        $schedules = $class->schedules()
            ->with([
                'subject',
                'teacher',
            ])
            ->orderByRaw("
                CASE day
                    WHEN 'Senin' THEN 1
                    WHEN 'Selasa' THEN 2
                    WHEN 'Rabu' THEN 3
                    WHEN 'Kamis' THEN 4
                    WHEN 'Jumat' THEN 5
                    WHEN 'Sabtu' THEN 6
                    WHEN 'Minggu' THEN 7
                    ELSE 8
                END
            ")
            ->orderBy('start_time')
            ->get();

        return view(
            'schedules.index',
            compact(
                'class',
                'schedules'
            )
        );
    }

    public function create(SchoolClass $class)
    {
        $subjects = $class->subjects()
            ->orderBy('name')
            ->get();

        $teachers = User::whereHas(
            'classMembers',
            function ($query) use ($class) {
                $query->where(
                    'class_id',
                    $class->id
                )
                    ->where(
                        'role',
                        'teacher'
                    );
            }
        )
            ->where(
                'role',
                'teacher'
            )
            ->orderBy('name')
            ->get();

        return view(
            'schedules.create',
            compact(
                'class',
                'subjects',
                'teachers'
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

            'teacher_id' => [
                'nullable',
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
                        'teacher'
                    ),
            ],

            'day' => [
                'required',
                'in:Senin,Selasa,Rabu,Kamis,Jumat,Sabtu,Minggu',
            ],

            'start_time' => [
                'required',
                'date_format:H:i',
            ],

            'end_time' => [
                'required',
                'date_format:H:i',
                'after:start_time',
            ],

            'room' => [
                'nullable',
                'string',
                'max:100',
            ],

            'notes' => [
                'nullable',
                'string',
                'max:5000',
            ],
        ]);

        Schedule::create([
            'class_id' => $class->id,
            'subject_id' => $validated['subject_id'],
            'teacher_id' => $validated['teacher_id'] ?? null,
            'day' => $validated['day'],
            'start_time' => $validated['start_time'],
            'end_time' => $validated['end_time'],
            'room' => $validated['room'] ?? null,
            'notes' => $validated['notes'] ?? null,
        ]);

        return redirect()
            ->route(
                'schedules.index',
                $class
            )
            ->with(
                'success',
                'Jadwal berhasil ditambahkan.'
            );
    }
}