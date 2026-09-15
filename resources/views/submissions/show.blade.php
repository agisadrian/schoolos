@extends('layouts.app')

@section('title', 'Pengumpulan Tugas - SchoolOS')

@section('page-title', 'Pengumpulan Tugas')


@section('content')


    <!-- BACK -->

    <div class="mb-4">

        <a
            href="{{ route(
                'assignments.show',
                [
                    $class,
                    $assignment
                ]
            ) }}"
            class="text-decoration-none"
        >
            ← Kembali ke Detail Tugas
        </a>

    </div>


    <!-- HEADER -->

    <div class="mb-4">

        <div class="text-muted small mb-1">
            {{ $class->name }}
            ·
            {{ $assignment->subject->name ?? '-' }}
        </div>

        <h2 class="fw-bold mb-1">
            Pengumpulan Tugas
        </h2>

        <p class="text-muted mb-0">
            Detail file tugas yang telah dikumpulkan.
        </p>

    </div>


    <!-- STATUS -->

    <div class="card mb-4">

        <div class="card-body p-4">

            <div
                class="d-flex
                       flex-column
                       flex-md-row
                       align-items-md-center
                       gap-3"
            >

                <div
                    class="rounded-circle
                           d-flex
                           align-items-center
                           justify-content-center"
                    style="
                        width: 58px;
                        height: 58px;
                        background: #ecfdf5;
                        font-size: 27px;
                        flex-shrink: 0;
                    "
                >
                    <i class="bi bi-check-circle-fill"></i>
                </div>


                <div class="flex-grow-1">

                    <div
                        class="text-success
                               fw-bold
                               mb-1"
                    >
                        Tugas Berhasil Dikumpulkan
                    </div>

                    <div class="text-muted small">

                        Dikumpulkan:

                        {{
                            $submission->submitted_at
                                ->format(
                                    'd M Y, H:i'
                                )
                        }}

                    </div>

                </div>


                <span
                    class="badge
                           text-bg-success
                           rounded-pill
                           px-3 py-2"
                >
                    Terkirim
                </span>

            </div>

        </div>

    </div>


    <!-- ASSIGNMENT -->

    <div class="card mb-4">

        <div class="card-body p-4">

            <h5 class="fw-bold mb-4">
                Detail Tugas
            </h5>


            <div class="row g-4">

                <div class="col-md-6">

                    <div class="text-muted small mb-1">
                        Judul Tugas
                    </div>

                    <div class="fw-semibold">
                        {{ $assignment->title }}
                    </div>

                </div>


                <div class="col-md-6">

                    <div class="text-muted small mb-1">
                        Mata Pelajaran
                    </div>

                    <div class="fw-semibold">
                        {{ $assignment->subject->name ?? '-' }}
                    </div>

                </div>


                <div class="col-md-6">

                    <div class="text-muted small mb-1">
                        Deadline
                    </div>

                    <div class="fw-semibold">

                        {{
                            $assignment->deadline
                                ->format(
                                    'd M Y, H:i'
                                )
                        }}

                    </div>

                </div>


                <div class="col-md-6">

                    <div class="text-muted small mb-1">
                        Siswa
                    </div>

                    <div class="fw-semibold">
                        {{ $submission->user->name }}
                    </div>

                </div>

            </div>

        </div>

    </div>


    <!-- FILE -->

    <div class="card mb-4">

        <div class="card-body p-4">

            <h5 class="fw-bold mb-4">
                File yang Dikumpulkan
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

                    <div
                        class="rounded-3
                               d-flex
                               align-items-center
                               justify-content-center"
                        style="
                            width: 52px;
                            height: 52px;
                            background: #f3f4f6;
                            font-size: 23px;
                            flex-shrink: 0;
                        "
                    >
                        <i class="bi bi-file-earmark-text-fill"></i>
                    </div>


                    <div class="flex-grow-1">

                        <div class="fw-semibold">

                            {{ $submission->file_name }}

                        </div>


                        <div
                            class="text-muted
                                   small"
                        >

                            @if($submission->file_size)

                                {{
                                    number_format(
                                        $submission->file_size
                                        / 1024 / 1024,
                                        2
                                    )
                                }}
                                MB

                            @else

                                Ukuran tidak diketahui

                            @endif

                        </div>

                    </div>


                    <a
                        href="{{ asset(
                            'storage/' .
                            $submission->file_path
                        ) }}"
                        target="_blank"
                        class="btn btn-outline-primary"
                    >
                        Buka File
                    </a>

                </div>

            </div>

        </div>

    </div>


    <!-- NOTE -->

    @if($submission->note)

        <div class="card mb-4">

            <div class="card-body p-4">

                <h5 class="fw-bold mb-3">
                    Catatan
                </h5>


                <div
                    class="text-muted"
                    style="white-space: pre-line;"
                >
                    {{ $submission->note }}
                </div>

            </div>

        </div>

    @endif


    <!-- INFORMATION -->

    <div class="card">

        <div class="card-body p-4">

            <div
                class="d-flex
                       gap-3
                       align-items-start"
            >

                <div
                    style="font-size: 22px;"
                >
                    ℹ️
                </div>


                <div>

                    <div class="fw-semibold mb-1">
                        Pengumpulan Tugas
                    </div>

                    <div
                        class="text-muted
                               small"
                    >
                        File ini merupakan pengumpulan
                        tugas yang tersimpan di SchoolOS.
                        Pastikan file yang dikumpulkan
                        sudah sesuai dengan instruksi guru.
                    </div>

                </div>

            </div>

        </div>

    </div>


@endsection