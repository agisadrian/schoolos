@extends('layouts.app')

@section('title', $assignment->title . ' - SchoolOS')

@section('page-title', 'Detail Tugas')


@section('content')

    @php

        $isOverdue =
            $assignment->deadline->isPast();

        $isToday =
            $assignment->deadline->isToday();

    @endphp


    <!-- BACK -->

    <div class="mb-4">

        <a
            href="{{ route(
                'assignments.index',
                $class
            ) }}"
            class="text-decoration-none"
        >
            ← Kembali ke Tugas
        </a>

    </div>


    <!-- =========================
         ASSIGNMENT DETAIL
    ========================== -->

    <div class="card mb-4">

        <div class="card-body p-4 p-lg-5">

            <div class="row">


                <!-- LEFT -->

                <div class="col-lg-8">


                    <!-- SUBJECT -->

                    <div class="mb-3">

                        @if($assignment->subject)

                            <span
                                class="badge
                                       rounded-pill
                                       bg-light
                                       text-dark
                                       border
                                       px-3 py-2"
                            >
                                <i class="bi bi-journal-bookmark-fill"></i>
                                {{ $assignment->subject->name }}
                            </span>

                        @endif


                        @if($isOverdue)

                            <span
                                class="badge
                                       rounded-pill
                                       text-bg-danger
                                       ms-1"
                            >
                                Lewat Deadline
                            </span>

                        @elseif($isToday)

                            <span
                                class="badge
                                       rounded-pill
                                       text-bg-warning
                                       ms-1"
                            >
                                Deadline Hari Ini
                            </span>

                        @else

                            <span
                                class="badge
                                       rounded-pill
                                       text-bg-success
                                       ms-1"
                            >
                                Aktif
                            </span>

                        @endif

                    </div>


                    <!-- TITLE -->

                    <h1 class="fw-bold mb-3">
                        {{ $assignment->title }}
                    </h1>


                    <!-- DESCRIPTION -->

                    @if($assignment->description)

                        <div
                            class="text-muted mb-4"
                            style="white-space: pre-line;"
                        >
                            {{ $assignment->description }}
                        </div>

                    @else

                        <p class="text-muted mb-4">
                            Tidak ada deskripsi tugas.
                        </p>

                    @endif


                    <!-- CREATOR -->

                    <div class="text-muted small">

                        Dibuat oleh:

                        <span class="fw-semibold">
                            {{
                                $assignment->creator->name
                                ?? '-'
                            }}
                        </span>

                        <span class="mx-2">
                            ·
                        </span>

                        {{
                            $assignment->created_at
                                ->format('d M Y, H:i')
                        }}

                    </div>

                </div>


                <!-- RIGHT -->

                <div
                    class="col-lg-4
                           mt-4
                           mt-lg-0"
                >

                    <div
                        class="border
                               rounded-4
                               p-4
                               h-100"
                    >


                        <!-- ICON -->

                        <div
                            class="rounded-4
                                   d-flex
                                   align-items-center
                                   justify-content-center
                                   mx-auto
                                   mb-3"
                            style="
                                width: 70px;
                                height: 70px;
                                background: #fef2f2;
                                font-size: 34px;
                            "
                        >
                            <i class="bi bi-pencil-square"></i>
                        </div>


                        <!-- DEADLINE -->

                        <div
                            class="text-center
                                   text-muted
                                   small
                                   mb-1"
                        >
                            Deadline
                        </div>


                        <div
                            class="text-center
                                   fw-bold
                                   {{
                                       $isOverdue
                                           ? 'text-danger'
                                           : ''
                                   }}"
                        >

                            {{
                                $assignment->deadline
                                    ->format('d M Y')
                            }}

                        </div>


                        <div
                            class="text-center
                                   text-muted
                                   small"
                        >

                            {{
                                $assignment->deadline
                                    ->format('H:i')
                            }}

                        </div>


                        <div
                            class="text-center
                                   text-muted
                                   small
                                   mt-2
                                   mb-4"
                        >

                            {{
                                $assignment->deadline
                                    ->diffForHumans()
                            }}

                        </div>


                        <!-- ASSIGNMENT FILE -->

                        @if($assignment->file_path)

                            <a
                                href="{{ asset(
                                    'storage/' .
                                    $assignment->file_path
                                ) }}"
                                target="_blank"
                                class="btn
                                       btn-outline-primary
                                       w-100
                                       mb-2"
                            >
                                <i class="bi bi-file-earmark-text-fill"></i> Buka File Tugas
                            </a>

                        @endif


                        <!-- =========================
                             STUDENT SUBMISSION
                        ========================== -->

                        @if(Auth::user()->role === 'student')


                            {{-- SUDAH MENGUMPULKAN --}}

                            @if($submission)

                                <div
                                    class="alert
                                           alert-success
                                           small
                                           mb-2"
                                >

                                    <strong>
                                        <i class="bi bi-check-circle-fill"></i> Tugas sudah dikumpulkan.
                                    </strong>

                                    <div class="mt-1">

                                        {{
                                            $submission
                                                ->submitted_at
                                                ->format(
                                                    'd M Y, H:i'
                                                )
                                        }}

                                    </div>

                                </div>


                                <a
                                    href="{{ route(
                                        'submissions.show',
                                        [
                                            $class,
                                            $assignment,
                                            $submission
                                        ]
                                    ) }}"
                                    class="btn
                                           btn-outline-success
                                           w-100
                                           mb-2"
                                >
                                    <i class="bi bi-file-earmark-text-fill"></i> Lihat Pengumpulan
                                </a>


                                {{-- MASIH BOLEH KIRIM ULANG --}}

                                @if(!$isOverdue)

                                    <a
                                        href="{{ route(
                                            'submissions.create',
                                            [
                                                $class,
                                                $assignment
                                            ]
                                        ) }}"
                                        class="btn
                                               btn-primary
                                               w-100"
                                    >
                                        <i class="bi bi-arrow-repeat"></i> Kirim Ulang Tugas
                                    </a>

                                @endif


                            {{-- BELUM MENGUMPULKAN --}}

                            @elseif(!$isOverdue)

                                <a
                                    href="{{ route(
                                        'submissions.create',
                                        [
                                            $class,
                                            $assignment
                                        ]
                                    ) }}"
                                    class="btn
                                           btn-primary
                                           w-100"
                                >
                                    <i class="bi bi-upload"></i> Kumpulkan Tugas
                                </a>


                            {{-- DEADLINE SUDAH LEWAT --}}

                            @else

                                <div
                                    class="alert
                                           alert-danger
                                           small
                                           mb-0"
                                >
                                    Deadline tugas telah lewat.
                                </div>

                            @endif

                        @endif

                    </div>

                </div>

            </div>

        </div>

    </div>


    <!-- =========================
         FILE INFORMATION
    ========================== -->

    @if(
        $assignment->file_path ||
        $assignment->file_name
    )

        <div class="card mb-4">

            <div class="card-body p-4">

                <h5 class="fw-bold mb-4">
                    Lampiran Tugas
                </h5>


                <div
                    class="border
                           rounded-4
                           p-3"
                >

                    <div
                        class="d-flex
                               align-items-center
                               gap-3"
                    >


                        <!-- FILE ICON -->

                        <div
                            class="rounded-3
                                   d-flex
                                   align-items-center
                                   justify-content-center"
                            style="
                                width: 48px;
                                height: 48px;
                                background: #f3f4f6;
                                font-size: 22px;
                                flex-shrink: 0;
                            "
                        >
                            <i class="bi bi-file-earmark-text-fill"></i>
                        </div>


                        <!-- FILE INFO -->

                        <div class="flex-grow-1">

                            <div class="fw-semibold">

                                {{
                                    $assignment->file_name
                                    ?? 'File Tugas'
                                }}

                            </div>


                            <div
                                class="text-muted
                                       small"
                            >

                                @if($assignment->file_size)

                                    {{
                                        number_format(
                                            $assignment->file_size
                                            / 1024
                                            / 1024,
                                            2
                                        )
                                    }}
                                    MB

                                @else

                                    Ukuran tidak diketahui

                                @endif

                            </div>

                        </div>


                        <!-- OPEN FILE -->

                        @if($assignment->file_path)

                            <a
                                href="{{ asset(
                                    'storage/' .
                                    $assignment->file_path
                                ) }}"
                                target="_blank"
                                class="btn
                                       btn-sm
                                       btn-outline-primary"
                            >
                                Buka
                            </a>

                        @endif

                    </div>

                </div>

            </div>

        </div>

    @endif


    <!-- =========================
         SUBMISSION INFORMATION
    ========================== -->

    @if(Auth::user()->role === 'student')

        <div class="card">

            <div class="card-body p-4">

                <h5 class="fw-bold mb-2">
                    Pengumpulan Tugas
                </h5>


                @if($submission)

                    <div
                        class="d-flex
                               align-items-start
                               gap-3"
                    >

                        <div
                            class="rounded-circle
                                   d-flex
                                   align-items-center
                                   justify-content-center"
                            style="
                                width: 42px;
                                height: 42px;
                                background: #ecfdf5;
                                color: #16a34a;
                                flex-shrink: 0;
                            "
                        >
                            <i class="bi bi-check-circle-fill"></i>
                        </div>


                        <div>

                            <div class="fw-semibold">
                                Tugas sudah dikumpulkan
                            </div>

                            <div
                                class="text-muted
                                       small"
                            >

                                File:

                                {{ $submission->file_name }}

                                <br>

                                Waktu:

                                {{
                                    $submission
                                        ->submitted_at
                                        ->format(
                                            'd M Y, H:i'
                                        )
                                }}

                            </div>

                        </div>

                    </div>

                @else

                    <p
                        class="text-muted
                               small
                               mb-0"
                    >
                        Kamu belum mengumpulkan tugas ini.
                        Gunakan tombol "Kumpulkan Tugas"
                        untuk mengirim pekerjaanmu.
                    </p>

                @endif

            </div>

        </div>

    @else

        <div class="card">

            <div class="card-body p-4">

                <h5 class="fw-bold mb-2">
                    Pengumpulan Siswa
                </h5>

                <p
                    class="text-muted
                           small
                           mb-0"
                >
                    Data pengumpulan siswa akan tersedia
                    pada fitur pengelolaan pengumpulan tugas.
                </p>

            </div>

        </div>

    @endif

@endsection