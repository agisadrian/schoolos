<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use App\Models\Assignment;
use App\Models\Grade;
use App\Models\Material;
use App\Models\SchoolClass;
use App\Models\Schedule;
use App\Models\Submission;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if ($user->role === 'admin') {
            $totalUsers = User::count();

            $totalStudents = User::where(
                'role',
                'student'
            )->count();

            $totalTeachers = User::where(
                'role',
                'teacher'
            )->count();

            $totalClasses = SchoolClass::count();

            $totalSubjects = \App\Models\Subject::count();

            $totalMaterials = Material::count();

            $totalAssignments = Assignment::count();

            $totalAnnouncements = Announcement::count();

            $recentUsers = User::latest()
                ->take(5)
                ->get();

            $recentClasses = SchoolClass::latest()
                ->take(5)
                ->get();

            return view(
                'dashboard',
                compact(
                    'user',
                    'totalUsers',
                    'totalStudents',
                    'totalTeachers',
                    'totalClasses',
                    'totalSubjects',
                    'totalMaterials',
                    'totalAssignments',
                    'totalAnnouncements',
                    'recentUsers',
                    'recentClasses'
                )
            );
        }


        $classes = SchoolClass::whereHas(
            'members',
            function ($query) use ($user) {
                $query->where(
                    'user_id',
                    $user->id
                );
            }
        )
            ->withCount([
                'members',
                'subjects',
                'assignments',
                'announcements',
            ])
            ->latest()
            ->get();


        if ($user->role === 'teacher') {

            $classIds = $classes->pluck('id');

            $totalClasses = $classes->count();

            $totalMaterials = Material::whereIn(
                'class_id',
                $classIds
            )->count();

            $totalAssignments = Assignment::whereIn(
                'class_id',
                $classIds
            )->count();

            $totalAnnouncements = Announcement::whereIn(
                'class_id',
                $classIds
            )->count();

            $recentAssignments = Assignment::whereIn(
                'class_id',
                $classIds
            )
                ->with([
                    'subject',
                    'schoolClass',
                ])
                ->latest()
                ->take(5)
                ->get();

            $recentAnnouncements = Announcement::whereIn(
                'class_id',
                $classIds
            )
                ->latest()
                ->take(5)
                ->get();

            return view(
                'dashboard',
                compact(
                    'user',
                    'classes',
                    'totalClasses',
                    'totalMaterials',
                    'totalAssignments',
                    'totalAnnouncements',
                    'recentAssignments',
                    'recentAnnouncements'
                )
            );
        }


        $classIds = $classes->pluck('id');

        $totalClasses = $classes->count();

        $totalAssignments = Assignment::whereIn(
            'class_id',
            $classIds
        )->count();


        $submittedAssignmentIds = Submission::where(
            'user_id',
            $user->id
        )
            ->pluck('assignment_id');


        $pendingAssignments = Assignment::whereIn(
            'class_id',
            $classIds
        )
            ->whereNotIn(
                'id',
                $submittedAssignmentIds
            )
            ->where(
                'deadline',
                '>=',
                now()
            )
            ->with([
                'subject',
                'schoolClass',
            ])
            ->orderBy('deadline')
            ->take(5)
            ->get();


        $recentGrades = Grade::where(
            'student_id',
            $user->id
        )
            ->with([
                'subject',
                'schoolClass',
            ])
            ->latest()
            ->take(5)
            ->get();


        $upcomingSchedules = Schedule::whereIn(
            'class_id',
            $classIds
        )
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
            ->take(5)
            ->get();


        return view(
            'dashboard',
            compact(
                'user',
                'classes',
                'totalClasses',
                'totalAssignments',
                'pendingAssignments',
                'recentGrades',
                'upcomingSchedules'
            )
        );
    }
}