@extends('layouts.app')

@section('content')

<div class="container-fluid py-4">

    {{-- HEADER --}}
    <div class="mb-4">
        <h2 class="fw-bold mb-1">
            Dashboard
        </h2>

        <p class="text-muted mb-0">
            Selamat datang, {{ $user->name }}
        </p>
    </div>


    {{-- ========================================================= --}}
    {{-- ADMIN DASHBOARD --}}
    {{-- ========================================================= --}}

    @if($user->role === 'admin')

        <div class="row g-4 mb-4">

            <div class="col-md-6 col-xl-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <div class="text-muted small mb-2">
                            Total User
                        </div>

                        <h2 class="fw-bold mb-0">
                            {{ $totalUsers }}
                        </h2>
                    </div>
                </div>
            </div>


            <div class="col-md-6 col-xl-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <div class="text-muted small mb-2">
                            Student
                        </div>

                        <h2 class="fw-bold mb-0">
                            {{ $totalStudents }}
                        </h2>
                    </div>
                </div>
            </div>


            <div class="col-md-6 col-xl-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <div class="text-muted small mb-2">
                            Teacher
                        </div>

                        <h2 class="fw-bold mb-0">
                            {{ $totalTeachers }}
                        </h2>
                    </div>
                </div>
            </div>


            <div class="col-md-6 col-xl-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <div class="text-muted small mb-2">
                            Total Kelas
                        </div>

                        <h2 class="fw-bold mb-0">
                            {{ $totalClasses }}
                        </h2>
                    </div>
                </div>
            </div>

        </div>


        {{-- ADMIN SECOND ROW --}}

        <div class="row g-4 mb-4">

            <div class="col-md-6 col-xl-3">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <div class="text-muted small mb-2">
                            Mata Pelajaran
                        </div>

                        <h3 class="fw-bold mb-0">
                            {{ $totalSubjects }}
                        </h3>
                    </div>
                </div>
            </div>


            <div class="col-md-6 col-xl-3">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <div class="text-muted small mb-2">
                            Materi
                        </div>

                        <h3 class="fw-bold mb-0">
                            {{ $totalMaterials }}
                        </h3>
                    </div>
                </div>
            </div>


            <div class="col-md-6 col-xl-3">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <div class="text-muted small mb-2">
                            Tugas
                        </div>

                        <h3 class="fw-bold mb-0">
                            {{ $totalAssignments }}
                        </h3>
                    </div>
                </div>
            </div>


            <div class="col-md-6 col-xl-3">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <div class="text-muted small mb-2">
                            Pengumuman
                        </div>

                        <h3 class="fw-bold mb-0">
                            {{ $totalAnnouncements }}
                        </h3>
                    </div>
                </div>
            </div>

        </div>


        {{-- ADMIN CONTENT --}}

        <div class="row g-4">

            <div class="col-lg-6">

                <div class="card border-0 shadow-sm h-100">

                    <div class="card-header bg-white border-0 pt-4 px-4">
                        <h5 class="fw-bold mb-1">
                            User Terbaru
                        </h5>

                        <p class="text-muted small mb-0">
                            Akun yang baru dibuat
                        </p>
                    </div>

                    <div class="card-body px-4">

                        @forelse($recentUsers as $item)

                            <div class="d-flex align-items-center py-3 border-bottom">

                                <div
                                    class="rounded-circle bg-primary bg-opacity-10
                                    d-flex align-items-center justify-content-center
                                    me-3"
                                    style="width:42px;height:42px;"
                                >
                                    <i class="bi bi-person text-primary"></i>
                                </div>

                                <div class="flex-grow-1">

                                    <div class="fw-semibold">
                                        {{ $item->name }}
                                    </div>

                                    <div class="small text-muted">
                                        {{ $item->email }}
                                    </div>

                                </div>

                                <span class="badge text-bg-light">
                                    {{ ucfirst($item->role) }}
                                </span>

                            </div>

                        @empty

                            <div class="text-center text-muted py-5">
                                Belum ada user.
                            </div>

                        @endforelse

                    </div>

                </div>

            </div>


            <div class="col-lg-6">

                <div class="card border-0 shadow-sm h-100">

                    <div class="card-header bg-white border-0 pt-4 px-4">
                        <h5 class="fw-bold mb-1">
                            Kelas Terbaru
                        </h5>

                        <p class="text-muted small mb-0">
                            Kelas yang baru dibuat
                        </p>
                    </div>

                    <div class="card-body px-4">

                        @forelse($recentClasses as $item)

                            <a
                                href="{{ route('classes.show', $item) }}"
                                class="text-decoration-none text-dark"
                            >

                                <div class="d-flex align-items-center py-3 border-bottom">

                                    <div
                                        class="rounded-3 bg-primary bg-opacity-10
                                        d-flex align-items-center justify-content-center
                                        me-3"
                                        style="width:45px;height:45px;"
                                    >
                                        <i class="bi bi-building text-primary"></i>
                                    </div>

                                    <div class="flex-grow-1">

                                        <div class="fw-semibold">
                                            {{ $item->name }}
                                        </div>

                                        <div class="small text-muted">
                                            {{ $item->code }}
                                        </div>

                                    </div>

                                    <i class="bi bi-chevron-right text-muted"></i>

                                </div>

                            </a>

                        @empty

                            <div class="text-center text-muted py-5">
                                Belum ada kelas.
                            </div>

                        @endforelse

                    </div>

                </div>

            </div>

        </div>


    {{-- ========================================================= --}}
    {{-- TEACHER DASHBOARD --}}
    {{-- ========================================================= --}}

    @elseif($user->role === 'teacher')

        <div class="row g-4 mb-4">

            <div class="col-md-6 col-xl-3">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <div class="text-muted small mb-2">
                            Kelas Saya
                        </div>

                        <h2 class="fw-bold mb-0">
                            {{ $totalClasses }}
                        </h2>
                    </div>
                </div>
            </div>


            <div class="col-md-6 col-xl-3">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <div class="text-muted small mb-2">
                            Materi
                        </div>

                        <h2 class="fw-bold mb-0">
                            {{ $totalMaterials }}
                        </h2>
                    </div>
                </div>
            </div>


            <div class="col-md-6 col-xl-3">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <div class="text-muted small mb-2">
                            Tugas
                        </div>

                        <h2 class="fw-bold mb-0">
                            {{ $totalAssignments }}
                        </h2>
                    </div>
                </div>
            </div>


            <div class="col-md-6 col-xl-3">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <div class="text-muted small mb-2">
                            Pengumuman
                        </div>

                        <h2 class="fw-bold mb-0">
                            {{ $totalAnnouncements }}
                        </h2>
                    </div>
                </div>
            </div>

        </div>


        {{-- TEACHER CLASSES --}}

        <div class="card border-0 shadow-sm mb-4">

            <div class="card-header bg-white border-0 pt-4 px-4">

                <h5 class="fw-bold mb-1">
                    Kelas Saya
                </h5>

                <p class="text-muted small mb-0">
                    Kelas yang Anda kelola
                </p>

            </div>

            <div class="card-body px-4">

                <div class="row g-3">

                    @forelse($classes as $class)

                        <div class="col-md-6 col-xl-4">

                            <a
                                href="{{ route('classes.show', $class) }}"
                                class="text-decoration-none text-dark"
                            >

                                <div class="border rounded-3 p-3 h-100">

                                    <div class="d-flex align-items-center mb-3">

                                        <div
                                            class="rounded-3 bg-primary bg-opacity-10
                                            d-flex align-items-center justify-content-center
                                            me-3"
                                            style="width:45px;height:45px;"
                                        >
                                            <i class="bi bi-building text-primary"></i>
                                        </div>

                                        <div>

                                            <div class="fw-semibold">
                                                {{ $class->name }}
                                            </div>

                                            <div class="small text-muted">
                                                {{ $class->code }}
                                            </div>

                                        </div>

                                    </div>

                                    <div class="d-flex gap-3 small text-muted">

                                        <span>
                                            <i class="bi bi-people me-1"></i>
                                            {{ $class->members_count }}
                                        </span>

                                        <span>
                                            <i class="bi bi-journal-text me-1"></i>
                                            {{ $class->subjects_count }}
                                        </span>

                                        <span>
                                            <i class="bi bi-list-task me-1"></i>
                                            {{ $class->assignments_count }}
                                        </span>

                                    </div>

                                </div>

                            </a>

                        </div>

                    @empty

                        <div class="col-12">

                            <div class="text-center text-muted py-5">
                                Anda belum memiliki kelas.
                            </div>

                        </div>

                    @endforelse

                </div>

            </div>

        </div>


        {{-- TEACHER RECENT CONTENT --}}

        <div class="row g-4">

            <div class="col-lg-6">

                <div class="card border-0 shadow-sm">

                    <div class="card-header bg-white border-0 pt-4 px-4">
                        <h5 class="fw-bold mb-0">
                            Tugas Terbaru
                        </h5>
                    </div>

                    <div class="card-body px-4">

                        @forelse($recentAssignments as $assignment)

                            <div class="py-3 border-bottom">

                                <div class="fw-semibold">
                                    {{ $assignment->title }}
                                </div>

                                <div class="small text-muted mt-1">

                                    {{ $assignment->subject->name ?? '-' }}

                                    ·

                                    {{ $assignment->schoolClass->name ?? '-' }}

                                </div>

                            </div>

                        @empty

                            <div class="text-center text-muted py-4">
                                Belum ada tugas.
                            </div>

                        @endforelse

                    </div>

                </div>

            </div>


            <div class="col-lg-6">

                <div class="card border-0 shadow-sm">

                    <div class="card-header bg-white border-0 pt-4 px-4">
                        <h5 class="fw-bold mb-0">
                            Pengumuman Terbaru
                        </h5>
                    </div>

                    <div class="card-body px-4">

                        @forelse($recentAnnouncements as $announcement)

                            <div class="py-3 border-bottom">

                                <div class="fw-semibold">
                                    {{ $announcement->title }}
                                </div>

                                <div class="small text-muted mt-1">
                                    {{ $announcement->created_at->format('d M Y H:i') }}
                                </div>

                            </div>

                        @empty

                            <div class="text-center text-muted py-4">
                                Belum ada pengumuman.
                            </div>

                        @endforelse

                    </div>

                </div>

            </div>

        </div>


    {{-- ========================================================= --}}
    {{-- STUDENT DASHBOARD --}}
    {{-- ========================================================= --}}

    @else

        <div class="row g-4 mb-4">

            <div class="col-md-4">

                <div class="card border-0 shadow-sm">
                    <div class="card-body">

                        <div class="text-muted small mb-2">
                            Kelas Saya
                        </div>

                        <h2 class="fw-bold mb-0">
                            {{ $totalClasses }}
                        </h2>

                    </div>
                </div>

            </div>


            <div class="col-md-4">

                <div class="card border-0 shadow-sm">
                    <div class="card-body">

                        <div class="text-muted small mb-2">
                            Total Tugas
                        </div>

                        <h2 class="fw-bold mb-0">
                            {{ $totalAssignments }}
                        </h2>

                    </div>
                </div>

            </div>


            <div class="col-md-4">

                <div class="card border-0 shadow-sm">
                    <div class="card-body">

                        <div class="text-muted small mb-2">
                            Belum Dikumpulkan
                        </div>

                        <h2 class="fw-bold mb-0">
                            {{ $pendingAssignments->count() }}
                        </h2>

                    </div>
                </div>

            </div>

        </div>


        {{-- STUDENT CLASSES --}}

        <div class="card border-0 shadow-sm mb-4">

            <div class="card-header bg-white border-0 pt-4 px-4">

                <h5 class="fw-bold mb-1">
                    Kelas Saya
                </h5>

                <p class="text-muted small mb-0">
                    Kelas yang sedang Anda ikuti
                </p>

            </div>

            <div class="card-body px-4">

                <div class="row g-3">

                    @forelse($classes as $class)

                        <div class="col-md-6 col-xl-4">

                            <a
                                href="{{ route('classes.show', $class) }}"
                                class="text-decoration-none text-dark"
                            >

                                <div class="border rounded-3 p-3 h-100">

                                    <div class="d-flex align-items-center mb-3">

                                        <div
                                            class="rounded-3 bg-primary bg-opacity-10
                                            d-flex align-items-center justify-content-center
                                            me-3"
                                            style="width:45px;height:45px;"
                                        >
                                            <i class="bi bi-mortarboard text-primary"></i>
                                        </div>

                                        <div>

                                            <div class="fw-semibold">
                                                {{ $class->name }}
                                            </div>

                                            <div class="small text-muted">
                                                {{ $class->code }}
                                            </div>

                                        </div>

                                    </div>

                                    <div class="small text-muted">

                                        <i class="bi bi-people me-1"></i>

                                        {{ $class->members_count }} anggota

                                    </div>

                                </div>

                            </a>

                        </div>

                    @empty

                        <div class="col-12">

                            <div class="text-center py-5">

                                <i class="bi bi-building fs-1 text-muted"></i>

                                <p class="text-muted mt-3 mb-0">
                                    Anda belum terdaftar di kelas mana pun.
                                </p>

                            </div>

                        </div>

                    @endforelse

                </div>

            </div>

        </div>


        {{-- STUDENT CONTENT --}}

        <div class="row g-4">

            {{-- PENDING ASSIGNMENTS --}}

            <div class="col-lg-7">

                <div class="card border-0 shadow-sm h-100">

                    <div class="card-header bg-white border-0 pt-4 px-4">

                        <h5 class="fw-bold mb-1">
                            Tugas Belum Dikumpulkan
                        </h5>

                        <p class="text-muted small mb-0">
                            Deadline yang masih aktif
                        </p>

                    </div>

                    <div class="card-body px-4">

                        @forelse($pendingAssignments as $assignment)

                            <a
                                href="{{ route('assignments.show', [
                                    'class' => $assignment->schoolClass,
                                    'assignment' => $assignment,
                                ]) }}"
                                class="text-decoration-none text-dark"
                            >

                                <div class="py-3 border-bottom">

                                    <div class="d-flex justify-content-between gap-3">

                                        <div>

                                            <div class="fw-semibold">
                                                {{ $assignment->title }}
                                            </div>

                                            <div class="small text-muted mt-1">

                                                {{ $assignment->subject->name ?? '-' }}

                                                ·

                                                {{ $assignment->schoolClass->name ?? '-' }}

                                            </div>

                                        </div>

                                        <span class="badge text-bg-warning align-self-start">
                                            {{ $assignment->deadline->format('d M') }}
                                        </span>

                                    </div>

                                </div>

                            </a>

                        @empty

                            <div class="text-center py-5">

                                <i class="bi bi-check-circle fs-1 text-success"></i>

                                <p class="text-muted mt-3 mb-0">
                                    Tidak ada tugas yang perlu dikumpulkan.
                                </p>

                            </div>

                        @endforelse

                    </div>

                </div>

            </div>


            {{-- RECENT GRADES --}}

            <div class="col-lg-5">

                <div class="card border-0 shadow-sm h-100">

                    <div class="card-header bg-white border-0 pt-4 px-4">

                        <h5 class="fw-bold mb-1">
                            Nilai Terbaru
                        </h5>

                        <p class="text-muted small mb-0">
                            Hasil penilaian terbaru
                        </p>

                    </div>

                    <div class="card-body px-4">

                        @forelse($recentGrades as $grade)

                            <div class="py-3 border-bottom">

                                <div class="d-flex justify-content-between">

                                    <div>

                                        <div class="fw-semibold">
                                            {{ $grade->title }}
                                        </div>

                                        <div class="small text-muted mt-1">
                                            {{ $grade->subject->name ?? '-' }}
                                        </div>

                                    </div>

                                    <div class="text-end">

                                        <div class="fw-bold">
                                            {{ $grade->score }}
                                        </div>

                                        <div class="small text-muted">
                                            / {{ $grade->max_score }}
                                        </div>

                                    </div>

                                </div>

                            </div>

                        @empty

                            <div class="text-center text-muted py-5">
                                Belum ada nilai.
                            </div>

                        @endforelse

                    </div>

                </div>

            </div>

        </div>

    @endif

</div>

@endsection