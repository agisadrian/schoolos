<?php

use App\Http\Controllers\AnnouncementController;
use App\Http\Controllers\AssignmentController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ClassController;
use App\Http\Controllers\ClassMemberController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\GradeController;
use App\Http\Controllers\MaterialController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\SubmissionController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get(
    '/login',
    [AuthController::class, 'showLogin']
)->name('login');

Route::post(
    '/login',
    [AuthController::class, 'login']
)->name('login.process');

Route::get(
    '/register',
    [AuthController::class, 'showRegister']
)->name('register');

Route::post(
    '/register',
    [AuthController::class, 'register']
)
    ->middleware('throttle:5,1')
    ->name('register.process');

Route::post(
    '/logout',
    [AuthController::class, 'logout']
)
    ->middleware('auth')
    ->name('logout');

Route::get(
    '/forgot-password',
    [AuthController::class, 'showForgotPassword']
)->name('password.request');

Route::post(
    '/forgot-password',
    [AuthController::class, 'sendResetLink']
)
    ->middleware('throttle:5,1')
    ->name('password.email');

Route::get(
    '/reset-password/{token}',
    [AuthController::class, 'showResetPassword']
)->name('password.reset');

Route::post(
    '/reset-password',
    [AuthController::class, 'resetPassword']
)
    ->middleware('throttle:5,1')
    ->name('password.update');

Route::middleware('auth')->group(function () {

    Route::get(
        '/',
        [DashboardController::class, 'index']
    )->name('dashboard');

    /*
    |--------------------------------------------------------------------------
    | Users
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/users',
        [UserController::class, 'index']
    )
        ->middleware('role:admin')
        ->name('users.index');

    Route::get(
        '/users/create',
        [UserController::class, 'create']
    )
        ->middleware('role:admin')
        ->name('users.create');

    Route::post(
        '/users',
        [UserController::class, 'store']
    )
        ->middleware('role:admin')
        ->name('users.store');

    Route::get(
        '/users/{user}/edit',
        [UserController::class, 'edit']
    )
        ->middleware('role:admin')
        ->name('users.edit');

    Route::put(
        '/users/{user}',
        [UserController::class, 'update']
    )
        ->middleware('role:admin')
        ->name('users.update');

    Route::delete(
        '/users/{user}',
        [UserController::class, 'destroy']
    )
        ->middleware('role:admin')
        ->name('users.destroy');


    /*
    |--------------------------------------------------------------------------
    | Classes
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/classes',
        [ClassController::class, 'index']
    )->name('classes.index');

    Route::post(
        '/classes',
        [ClassController::class, 'store']
    )
        ->middleware('role:admin')
        ->name('classes.store');

    Route::get(
        '/classes/join',
        [ClassController::class, 'showJoin']
    )->name('classes.join');

    Route::post(
        '/classes/join',
        [ClassController::class, 'join']
    )->name('classes.join.store');


    /*
    |--------------------------------------------------------------------------
    | Class Member Protected Routes
    |--------------------------------------------------------------------------
    */

    Route::middleware('class.member')->group(function () {

        Route::get(
            '/classes/{class}',
            [ClassController::class, 'show']
        )->name('classes.show');


        /*
        |--------------------------------------------------------------------------
        | Members
        |--------------------------------------------------------------------------
        */

        Route::get(
            '/classes/{class}/members',
            [ClassMemberController::class, 'index']
        )->name('members.index');

        Route::post(
            '/classes/{class}/members',
            [ClassMemberController::class, 'store']
        )
            ->middleware('role:admin')
            ->name('members.store');

        Route::post(
            '/classes/{class}/members/{member}/approve',
            [ClassMemberController::class, 'approve']
        )
            ->middleware('role:admin,teacher')
            ->name('members.approve');

        Route::delete(
            '/classes/{class}/members/{member}/reject',
            [ClassMemberController::class, 'reject']
        )
            ->middleware('role:admin,teacher')
            ->name('members.reject');

        Route::delete(
            '/classes/{class}/members/{member}',
            [ClassMemberController::class, 'destroy']
        )
            ->middleware('role:admin')
            ->name('members.destroy');


        /*
        |--------------------------------------------------------------------------
        | Subjects
        |--------------------------------------------------------------------------
        */

        Route::get(
            '/classes/{class}/subjects',
            [SubjectController::class, 'index']
        )->name('subjects.index');

        Route::post(
            '/classes/{class}/subjects',
            [SubjectController::class, 'store']
        )
            ->middleware('role:admin,teacher')
            ->name('subjects.store');

        Route::put(
            '/classes/{class}/subjects/{subject}',
            [SubjectController::class, 'update']
        )
            ->middleware('role:admin,teacher')
            ->name('subjects.update');

        Route::delete(
            '/classes/{class}/subjects/{subject}',
            [SubjectController::class, 'destroy']
        )
            ->middleware('role:admin,teacher')
            ->name('subjects.destroy');


        /*
        |--------------------------------------------------------------------------
        | Materials
        |--------------------------------------------------------------------------
        */

        Route::get(
            '/classes/{class}/materials',
            [MaterialController::class, 'index']
        )->name('materials.index');

        Route::get(
            '/classes/{class}/materials/create',
            [MaterialController::class, 'create']
        )
            ->middleware('role:admin,teacher')
            ->name('materials.create');

        Route::post(
            '/classes/{class}/materials',
            [MaterialController::class, 'store']
        )
            ->middleware('role:admin,teacher')
            ->name('materials.store');

        Route::get(
            '/classes/{class}/materials/{material}',
            [MaterialController::class, 'show']
        )->name('materials.show');

        Route::get(
            '/classes/{class}/materials/{material}/edit',
            [MaterialController::class, 'edit']
        )
            ->middleware('role:admin,teacher')
            ->name('materials.edit');

        Route::put(
            '/classes/{class}/materials/{material}',
            [MaterialController::class, 'update']
        )
            ->middleware('role:admin,teacher')
            ->name('materials.update');

        Route::delete(
            '/classes/{class}/materials/{material}',
            [MaterialController::class, 'destroy']
        )
            ->middleware('role:admin,teacher')
            ->name('materials.destroy');


        /*
        |--------------------------------------------------------------------------
        | Assignments
        |--------------------------------------------------------------------------
        */

        Route::get(
            '/classes/{class}/assignments',
            [AssignmentController::class, 'index']
        )->name('assignments.index');

        Route::get(
            '/classes/{class}/assignments/create',
            [AssignmentController::class, 'create']
        )
            ->middleware('role:admin,teacher')
            ->name('assignments.create');

        Route::post(
            '/classes/{class}/assignments',
            [AssignmentController::class, 'store']
        )
            ->middleware('role:admin,teacher')
            ->name('assignments.store');

        Route::get(
            '/classes/{class}/assignments/{assignment}',
            [AssignmentController::class, 'show']
        )->name('assignments.show');

        Route::get(
            '/classes/{class}/assignments/{assignment}/edit',
            [AssignmentController::class, 'edit']
        )
            ->middleware('role:admin,teacher')
            ->name('assignments.edit');

        Route::put(
            '/classes/{class}/assignments/{assignment}',
            [AssignmentController::class, 'update']
        )
            ->middleware('role:admin,teacher')
            ->name('assignments.update');

        Route::delete(
            '/classes/{class}/assignments/{assignment}',
            [AssignmentController::class, 'destroy']
        )
            ->middleware('role:admin,teacher')
            ->name('assignments.destroy');


        /*
        |--------------------------------------------------------------------------
        | Submissions
        |--------------------------------------------------------------------------
        */

        Route::get(
            '/classes/{class}/assignments/{assignment}/submit',
            [SubmissionController::class, 'create']
        )
            ->middleware('role:student')
            ->name('submissions.create');

        Route::post(
            '/classes/{class}/assignments/{assignment}/submit',
            [SubmissionController::class, 'store']
        )
            ->middleware('role:student')
            ->name('submissions.store');

        Route::get(
            '/classes/{class}/assignments/{assignment}/submissions',
            [SubmissionController::class, 'index']
        )
            ->middleware('role:admin,teacher')
            ->name('submissions.index');

        Route::get(
            '/classes/{class}/assignments/{assignment}/submissions/{submission}',
            [SubmissionController::class, 'show']
        )->name('submissions.show');


        /*
        |--------------------------------------------------------------------------
        | Schedules
        |--------------------------------------------------------------------------
        */

        Route::get(
            '/classes/{class}/schedules',
            [ScheduleController::class, 'index']
        )->name('schedules.index');

        Route::get(
            '/classes/{class}/schedules/create',
            [ScheduleController::class, 'create']
        )
            ->middleware('role:admin,teacher')
            ->name('schedules.create');

        Route::post(
            '/classes/{class}/schedules',
            [ScheduleController::class, 'store']
        )
            ->middleware('role:admin,teacher')
            ->name('schedules.store');

        Route::get(
            '/classes/{class}/schedules/{schedule}/edit',
            [ScheduleController::class, 'edit']
        )
            ->middleware('role:admin,teacher')
            ->name('schedules.edit');

        Route::put(
            '/classes/{class}/schedules/{schedule}',
            [ScheduleController::class, 'update']
        )
            ->middleware('role:admin,teacher')
            ->name('schedules.update');

        Route::delete(
            '/classes/{class}/schedules/{schedule}',
            [ScheduleController::class, 'destroy']
        )
            ->middleware('role:admin,teacher')
            ->name('schedules.destroy');


        /*
        |--------------------------------------------------------------------------
        | Announcements
        |--------------------------------------------------------------------------
        */

        Route::get(
            '/classes/{class}/announcements',
            [AnnouncementController::class, 'index']
        )->name('announcements.index');

        Route::get(
            '/classes/{class}/announcements/create',
            [AnnouncementController::class, 'create']
        )
            ->middleware('role:admin,teacher')
            ->name('announcements.create');

        Route::post(
            '/classes/{class}/announcements',
            [AnnouncementController::class, 'store']
        )
            ->middleware('role:admin,teacher')
            ->name('announcements.store');

        Route::get(
            '/classes/{class}/announcements/{announcement}',
            [AnnouncementController::class, 'show']
        )->name('announcements.show');

        Route::get(
            '/classes/{class}/announcements/{announcement}/edit',
            [AnnouncementController::class, 'edit']
        )
            ->middleware('role:admin,teacher')
            ->name('announcements.edit');

        Route::put(
            '/classes/{class}/announcements/{announcement}',
            [AnnouncementController::class, 'update']
        )
            ->middleware('role:admin,teacher')
            ->name('announcements.update');

        Route::delete(
            '/classes/{class}/announcements/{announcement}',
            [AnnouncementController::class, 'destroy']
        )
            ->middleware('role:admin,teacher')
            ->name('announcements.destroy');


        /*
        |--------------------------------------------------------------------------
        | Grades
        |--------------------------------------------------------------------------
        */

        Route::get(
            '/classes/{class}/grades',
            [GradeController::class, 'index']
        )->name('grades.index');

        Route::get(
            '/classes/{class}/grades/create',
            [GradeController::class, 'create']
        )
            ->middleware('role:admin,teacher')
            ->name('grades.create');

        Route::post(
            '/classes/{class}/grades',
            [GradeController::class, 'store']
        )
            ->middleware('role:admin,teacher')
            ->name('grades.store');

        Route::get(
            '/classes/{class}/grades/{grade}',
            [GradeController::class, 'show']
        )->name('grades.show');

        Route::get(
            '/classes/{class}/grades/{grade}/edit',
            [GradeController::class, 'edit']
        )
            ->middleware('role:admin,teacher')
            ->name('grades.edit');

        Route::put(
            '/classes/{class}/grades/{grade}',
            [GradeController::class, 'update']
        )
            ->middleware('role:admin,teacher')
            ->name('grades.update');

        Route::delete(
            '/classes/{class}/grades/{grade}',
            [GradeController::class, 'destroy']
        )
            ->middleware('role:admin,teacher')
            ->name('grades.destroy');


        /*
        |--------------------------------------------------------------------------
        | Protected Files
        |--------------------------------------------------------------------------
        */

        Route::get(
            '/classes/{class}/materials/{material}/file',
            [FileController::class, 'material']
        )->name('materials.file');

        Route::get(
            '/classes/{class}/assignments/{assignment}/file',
            [FileController::class, 'assignment']
        )->name('assignments.file');

        Route::get(
            '/classes/{class}/assignments/{assignment}/submissions/{submission}/file',
            [FileController::class, 'submission']
        )->name('submissions.file');

    });

});