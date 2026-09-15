@extends('layouts.app')

@section('title', $class->name . ' - SchoolOS')

@section('page-title', $class->name)


@section('content')

    <!-- =========================
         CLASS HEADER
    ========================== -->

    <div class="card mb-4">

        <div class="card-body p-4 p-lg-5">

            <div class="row align-items-center">

                <div class="col-lg-8">

                    <div
                        class="d-flex
                               align-items-center
                               gap-3
                               mb-3"
                    >

                        <div
                            class="rounded-4
                                   d-flex
                                   align-items-center
                                   justify-content-center"
                            style="
                                width: 60px;
                                height: 60px;
                                background: #eef2ff;
                                font-size: 28px;
                            "
                        >
                            <i class="bi bi-building"></i>
                        </div>


                        <div>

                            <div class="text-muted small">
                                Kelas
                            </div>

                            <h2 class="fw-bold mb-0">
                                {{ $class->name }}
                            </h2>

                        </div>

                    </div>


                    <p class="text-muted mb-3">

                        @if($class->description)

                            {{ $class->description }}

                        @else

                            Belum ada deskripsi untuk kelas ini.

                        @endif

                    </p>


                    <span
                        class="badge
                               rounded-pill
                               bg-light
                               text-dark
                               border
                               px-3 py-2"
                    >
                        Kode:
                        {{ $class->code }}
                    </span>

                </div>


                <div
                    class="col-lg-4
                           text-lg-end
                           mt-4
                           mt-lg-0"
                >

                    <a
                        href="{{ route('classes.index') }}"
                        class="btn btn-outline-secondary"
                    >
                        ← Kembali ke Kelas
                    </a>

                </div>

            </div>

        </div>

    </div>


    <!-- =========================
         QUICK STATS
    ========================== -->

    <div class="row g-3 mb-4">


        <!-- MEMBERS -->

        <div class="col-6 col-lg-3">

            <div class="card stat-card">

                <div class="card-body p-4">

                    <div
                        class="text-muted small mb-2"
                    >
                        Anggota
                    </div>


                    <div class="d-flex align-items-center gap-2">

                        <div
                            class="rounded-3 p-2"
                            style="background:#eef2ff;"
                        >
                            <i class="bi bi-people-fill"></i>
                        </div>


                        <div class="stat-number">
                            {{ $class->members->count() }}
                        </div>

                    </div>

                </div>

            </div>

        </div>


        <!-- SUBJECTS -->

        <div class="col-6 col-lg-3">

            <div class="card stat-card">

                <div class="card-body p-4">

                    <div
                        class="text-muted small mb-2"
                    >
                        Mata Pelajaran
                    </div>


                    <div class="d-flex align-items-center gap-2">

                        <div
                            class="rounded-3 p-2"
                            style="background:#fff7ed;"
                        >
                            <i class="bi bi-journal-bookmark-fill"></i>
                        </div>


                        <div class="stat-number">

                            {{ $class->subjects()->count() }}

                        </div>

                    </div>

                </div>

            </div>

        </div>


        <!-- ASSIGNMENTS -->

        <div class="col-6 col-lg-3">

            <div class="card stat-card">

                <div class="card-body p-4">

                    <div
                        class="text-muted small mb-2"
                    >
                        Tugas
                    </div>


                    <div class="d-flex align-items-center gap-2">

                        <div
                            class="rounded-3 p-2"
                            style="background:#fef2f2;"
                        >
                            <i class="bi bi-pencil-square"></i>
                        </div>


                        <div class="stat-number">

                            {{ $class->assignments()->count() }}

                        </div>

                    </div>

                </div>

            </div>

        </div>


        <!-- ANNOUNCEMENTS -->

        <div class="col-6 col-lg-3">

            <div class="card stat-card">

                <div class="card-body p-4">

                    <div
                        class="text-muted small mb-2"
                    >
                        Pengumuman
                    </div>


                    <div class="d-flex align-items-center gap-2">

                        <div
                            class="rounded-3 p-2"
                            style="background:#ecfdf5;"
                        >
                            <i class="bi bi-megaphone-fill"></i>
                        </div>


                        <div class="stat-number">

                            {{ $class->announcements()->count() }}

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>


    <!-- =========================
         FEATURE MENU
    ========================== -->

    <div class="card mb-4">

        <div class="card-body p-4">

            <div class="mb-4">

                <h5 class="fw-bold mb-1">
                    Menu Kelas
                </h5>

                <div class="text-muted small">
                    Akses seluruh fitur pembelajaran kelas.
                </div>

            </div>


            <div class="row g-3">


                <!-- MEMBERS -->

                <div class="col-md-6 col-xl-4">

                    <a
                        href="#members"
                        class="text-decoration-none"
                    >

                        <div
                            class="border
                                   rounded-4
                                   p-4
                                   menu-card
                                   h-100"
                        >

                            <div
                                class="rounded-3
                                       d-flex
                                       align-items-center
                                       justify-content-center
                                       mb-3"
                                style="
                                    width: 48px;
                                    height: 48px;
                                    background:#eef2ff;
                                    font-size:22px;
                                "
                            >
                                <i class="bi bi-people-fill"></i>
                            </div>


                            <h6 class="fw-bold text-dark">
                                Anggota Kelas
                            </h6>


                            <p
                                class="text-muted
                                       small
                                       mb-0"
                            >
                                Lihat daftar siswa dan anggota
                                yang tergabung dalam kelas.
                            </p>

                        </div>

                    </a>

                </div>


                <!-- SUBJECTS -->

                <div class="col-md-6 col-xl-4">

                    <a
                        href="{{ route(
                            'subjects.index',
                            $class
                        ) }}"
                        class="text-decoration-none"
                    >

                        <div
                            class="border
                                   rounded-4
                                   p-4
                                   menu-card
                                   h-100"
                        >

                            <div
                                class="rounded-3
                                       d-flex
                                       align-items-center
                                       justify-content-center
                                       mb-3"
                                style="
                                    width: 48px;
                                    height: 48px;
                                    background:#fff7ed;
                                    font-size:22px;
                                "
                            >
                                <i class="bi bi-journal-bookmark-fill"></i>
                            </div>


                            <h6 class="fw-bold text-dark">
                                Mata Pelajaran
                            </h6>


                            <p
                                class="text-muted
                                       small
                                       mb-0"
                            >
                                Kelola daftar mata pelajaran
                                yang digunakan kelas.
                            </p>

                        </div>

                    </a>

                </div>


                <!-- MATERIALS -->

                <div class="col-md-6 col-xl-4">

                    <a
                        href="{{ route(
                            'materials.index',
                            $class
                        ) }}"
                        class="text-decoration-none"
                    >

                        <div
                            class="border
                                   rounded-4
                                   p-4
                                   menu-card
                                   h-100"
                        >

                            <div
                                class="rounded-3
                                       d-flex
                                       align-items-center
                                       justify-content-center
                                       mb-3"
                                style="
                                    width: 48px;
                                    height: 48px;
                                    background:#ecfdf5;
                                    font-size:22px;
                                "
                            >
                                <i class="bi bi-journal-text"></i>
                            </div>


                            <h6 class="fw-bold text-dark">
                                Materi
                            </h6>


                            <p
                                class="text-muted
                                       small
                                       mb-0"
                            >
                                Akses materi pembelajaran
                                dan file yang dibagikan.
                            </p>

                        </div>

                    </a>

                </div>


                <!-- ASSIGNMENTS -->

                <div class="col-md-6 col-xl-4">

                    <a
                        href="{{ route(
                            'assignments.index',
                            $class
                        ) }}"
                        class="text-decoration-none"
                    >

                        <div
                            class="border
                                   rounded-4
                                   p-4
                                   menu-card
                                   h-100"
                        >

                            <div
                                class="rounded-3
                                       d-flex
                                       align-items-center
                                       justify-content-center
                                       mb-3"
                                style="
                                    width: 48px;
                                    height: 48px;
                                    background:#fef2f2;
                                    font-size:22px;
                                "
                            >
                                <i class="bi bi-pencil-square"></i>
                            </div>


                            <h6 class="fw-bold text-dark">
                                Tugas
                            </h6>


                            <p
                                class="text-muted
                                       small
                                       mb-0"
                            >
                                Lihat tugas, deadline,
                                dan pengumpulan tugas.
                            </p>

                        </div>

                    </a>

                </div>


                <!-- SCHEDULE -->

                <div class="col-md-6 col-xl-4">

                    <a
                        href="{{ route(
                            'schedules.index',
                            $class
                        ) }}"
                        class="text-decoration-none"
                    >

                        <div
                            class="border
                                   rounded-4
                                   p-4
                                   menu-card
                                   h-100"
                        >

                            <div
                                class="rounded-3
                                       d-flex
                                       align-items-center
                                       justify-content-center
                                       mb-3"
                                style="
                                    width: 48px;
                                    height: 48px;
                                    background:#f0f9ff;
                                    font-size:22px;
                                "
                            >
                                <i class="bi bi-calendar-event"></i>
                            </div>


                            <h6 class="fw-bold text-dark">
                                Jadwal
                            </h6>


                            <p
                                class="text-muted
                                       small
                                       mb-0"
                            >
                                Lihat jadwal pelajaran
                                kelas.
                            </p>

                        </div>

                    </a>

                </div>


                <!-- ANNOUNCEMENTS -->

                <div class="col-md-6 col-xl-4">

                    <a
                        href="{{ route(
                            'announcements.index',
                            $class
                        ) }}"
                        class="text-decoration-none"
                    >

                        <div
                            class="border
                                   rounded-4
                                   p-4
                                   menu-card
                                   h-100"
                        >

                            <div
                                class="rounded-3
                                       d-flex
                                       align-items-center
                                       justify-content-center
                                       mb-3"
                                style="
                                    width: 48px;
                                    height: 48px;
                                    background:#fffbeb;
                                    font-size:22px;
                                "
                            >
                                <i class="bi bi-megaphone-fill"></i>
                            </div>


                            <h6 class="fw-bold text-dark">
                                Pengumuman
                            </h6>


                            <p
                                class="text-muted
                                       small
                                       mb-0"
                            >
                                Informasi dan pengumuman
                                terbaru untuk kelas.
                            </p>

                        </div>

                    </a>

                </div>


                <!-- GRADES -->

                <div class="col-md-6 col-xl-4">

                    <a
                        href="{{ route(
                            'grades.index',
                            $class
                        ) }}"
                        class="text-decoration-none"
                    >

                        <div
                            class="border
                                   rounded-4
                                   p-4
                                   menu-card
                                   h-100"
                        >

                            <div
                                class="rounded-3
                                       d-flex
                                       align-items-center
                                       justify-content-center
                                       mb-3"
                                style="
                                    width: 48px;
                                    height: 48px;
                                    background:#f5f3ff;
                                    font-size:22px;
                                "
                            >
                                <i class="bi bi-bar-chart-fill"></i>
                            </div>


                            <h6 class="fw-bold text-dark">
                                Nilai
                            </h6>


                            <p
                                class="text-muted
                                       small
                                       mb-0"
                            >
                                Lihat dan kelola nilai
                                siswa dalam kelas.
                            </p>

                        </div>

                    </a>

                </div>

            </div>

        </div>

    </div>


    <!-- =========================
         MEMBERS
    ========================== -->

    <div
        class="card"
        id="members"
    >

        <div class="card-body p-4">

            <div
                class="d-flex
                       flex-column
                       flex-md-row
                       justify-content-between
                       align-items-md-center
                       gap-3
                       mb-4"
            >

                <div>

                    <h5 class="fw-bold mb-1">
                        Anggota Kelas
                    </h5>

                    <div class="text-muted small">
                        Daftar anggota yang tergabung
                        dalam kelas ini.
                    </div>

                </div>


                <span
                    class="badge
                           rounded-pill
                           bg-light
                           text-dark
                           border
                           px-3 py-2"
                >
                    {{ $class->members->count() }}
                    anggota
                </span>

            </div>


            @if($class->members->count() > 0)

                <div class="table-responsive">

                    <table
                        class="table
                               align-middle
                               mb-0"
                    >

                        <thead>

                            <tr>

                                <th>
                                    Nama
                                </th>

                                <th>
                                    Email
                                </th>

                                <th>
                                    Peran
                                </th>

                            </tr>

                        </thead>


                        <tbody>

                            @foreach($class->members as $member)

                                <tr>

                                    <td>

                                        <div
                                            class="d-flex
                                                   align-items-center
                                                   gap-2"
                                        >

                                            <div
                                                class="user-avatar"
                                            >
                                                {{
                                                    strtoupper(
                                                        substr(
                                                            $member->user->name,
                                                            0,
                                                            1
                                                        )
                                                    )
                                                }}
                                            </div>


                                            <div>

                                                <div class="fw-semibold">

                                                    {{
                                                        $member->user->name
                                                    }}

                                                </div>

                                            </div>

                                        </div>

                                    </td>


                                    <td class="text-muted">

                                        {{
                                            $member->user->email
                                        }}

                                    </td>


                                    <td>

                                        @if(
                                            $member->role === 'admin'
                                        )

                                            <span
                                                class="badge
                                                       text-bg-danger"
                                            >
                                                Admin
                                            </span>

                                        @elseif(
                                            $member->role === 'teacher'
                                        )

                                            <span
                                                class="badge
                                                       text-bg-warning"
                                            >
                                                Guru
                                            </span>

                                        @else

                                            <span
                                                class="badge
                                                       text-bg-primary"
                                            >
                                                Siswa
                                            </span>

                                        @endif

                                    </td>

                                </tr>

                            @endforeach

                        </tbody>

                    </table>

                </div>

            @else

                <div
                    class="text-center
                           text-muted
                           py-4"
                >

                    Belum ada anggota
                    yang terdaftar di kelas ini.

                </div>

            @endif

        </div>

    </div>

@endsection