@extends('layouts.app')

@section('title', $material->title . ' - SchoolOS')

@section('page-title', 'Detail Materi')


@section('content')

    <!-- =========================
         BACK
    ========================== -->

    <div class="mb-4">

        <a
            href="{{ route(
                'materials.index',
                $class
            ) }}"
            class="text-decoration-none"
        >
            ← Kembali ke Materi
        </a>

    </div>


    <!-- =========================
         MATERIAL HEADER
    ========================== -->

    <div class="card mb-4">

        <div class="card-body p-4 p-lg-5">

            <div class="row">

                <div class="col-lg-8">


                    <!-- SUBJECT -->

                    @if($material->subject)

                        <div class="mb-3">

                            <span
                                class="badge
                                       rounded-pill
                                       text-bg-light
                                       border
                                       px-3 py-2"
                            >
                                <i class="bi bi-journal-bookmark-fill"></i>
                                {{ $material->subject->name }}

                            </span>

                        </div>

                    @endif


                    <!-- TITLE -->

                    <h1
                        class="fw-bold
                               mb-3"
                    >
                        {{ $material->title }}
                    </h1>


                    <!-- DESCRIPTION -->

                    @if($material->description)

                        <p
                            class="text-muted
                                   mb-4"
                            style="white-space: pre-line;"
                        >
                            {{ $material->description }}
                        </p>

                    @endif


                    <!-- META -->

                    <div
                        class="d-flex
                               flex-wrap
                               gap-3
                               text-muted
                               small"
                    >

                        <span>
                            <i class="bi bi-person-fill"></i>
                            {{
                                $material->uploader->name
                                ?? '-'
                            }}
                        </span>


                        <span>
                            <i class="bi bi-calendar-event"></i>
                            {{
                                $material->created_at
                                    ->format('d M Y, H:i')
                            }}
                        </span>


                        @if($material->file_size)

                            <span>
                                <i class="bi bi-save-fill"></i>
                                {{
                                    number_format(
                                        $material->file_size / 1024 / 1024,
                                        2
                                    )
                                }}
                                MB
                            </span>

                        @endif

                    </div>

                </div>


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
                                background: #ecfdf5;
                                font-size: 34px;
                            "
                        >
                            <i class="bi bi-file-earmark-text-fill"></i>
                        </div>


                        <div
                            class="text-center
                                   fw-semibold
                                   text-truncate
                                   mb-1"
                            title="{{ $material->file_name }}"
                        >
                            {{ $material->file_name }}
                        </div>


                        @if($material->file_type)

                            <div
                                class="text-center
                                       text-muted
                                       small
                                       mb-4"
                            >
                                {{ $material->file_type }}
                            </div>

                        @endif


                        <div class="d-grid">

                            <a
                                href="{{ asset(
                                    'storage/' .
                                    $material->file_path
                                ) }}"
                                target="_blank"
                                class="btn btn-primary"
                            >
                                Buka File
                            </a>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>


    <!-- =========================
         FILE INFORMATION
    ========================== -->

    <div class="card">

        <div class="card-body p-4">

            <h5 class="fw-bold mb-4">
                Informasi File
            </h5>


            <div class="table-responsive">

                <table class="table align-middle mb-0">

                    <tbody>

                        <tr>

                            <td
                                class="text-muted"
                                style="width: 35%;"
                            >
                                Nama File
                            </td>

                            <td class="fw-semibold">
                                {{ $material->file_name }}
                            </td>

                        </tr>


                        <tr>

                            <td class="text-muted">
                                Tipe File
                            </td>

                            <td>
                                {{ $material->file_type ?? '-' }}
                            </td>

                        </tr>


                        <tr>

                            <td class="text-muted">
                                Ukuran
                            </td>

                            <td>

                                @if($material->file_size)

                                    {{
                                        number_format(
                                            $material->file_size / 1024 / 1024,
                                            2
                                        )
                                    }}
                                    MB

                                @else

                                    -

                                @endif

                            </td>

                        </tr>


                        <tr>

                            <td class="text-muted">
                                Diunggah Oleh
                            </td>

                            <td>
                                {{
                                    $material->uploader->name
                                    ?? '-'
                                }}
                            </td>

                        </tr>


                        <tr>

                            <td class="text-muted">
                                Tanggal Upload
                            </td>

                            <td>

                                {{
                                    $material->created_at
                                        ->format('d M Y, H:i')
                                }}

                            </td>

                        </tr>

                    </tbody>

                </table>

            </div>

        </div>

    </div>

@endsection