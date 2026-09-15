@extends('layouts.app')

@section('title', 'Kumpulkan Tugas - SchoolOS')

@section('page-title', 'Kumpulkan Tugas')


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


    <div class="row justify-content-center">

        <div class="col-xl-8">


            <!-- HEADER -->

            <div class="mb-4">

                <div class="text-muted small mb-1">
                    {{ $class->name }}
                    ·
                    {{ $assignment->subject->name ?? '-' }}
                </div>

                <h2 class="fw-bold mb-1">
                    Kumpulkan Tugas
                </h2>

                <p class="text-muted mb-0">
                    Upload hasil pekerjaan kamu
                    untuk tugas ini.
                </p>

            </div>


            <!-- ASSIGNMENT INFO -->

            <div class="card mb-4">

                <div class="card-body p-4">

                    <div
                        class="d-flex
                               align-items-start
                               gap-3"
                    >

                        <div
                            class="rounded-4
                                   d-flex
                                   align-items-center
                                   justify-content-center"
                            style="
                                width: 55px;
                                height: 55px;
                                background: #fef2f2;
                                font-size: 26px;
                                flex-shrink: 0;
                            "
                        >
                            <i class="bi bi-pencil-square"></i>
                        </div>


                        <div class="flex-grow-1">

                            <h5 class="fw-bold mb-1">
                                {{ $assignment->title }}
                            </h5>

                            <div
                                class="text-muted
                                       small"
                            >

                                Deadline:

                                <span class="fw-semibold">

                                    {{
                                        $assignment->deadline
                                            ->format(
                                                'd M Y, H:i'
                                            )
                                    }}

                                </span>

                            </div>

                        </div>

                    </div>

                </div>

            </div>


            <!-- FORM -->

            <div class="card">

                <div class="card-body p-4 p-lg-5">

                    <form
                        action="{{ route(
                            'submissions.store',
                            [
                                $class,
                                $assignment
                            ]
                        ) }}"
                        method="POST"
                        enctype="multipart/form-data"
                    >

                        @csrf


                        <!-- FILE -->

                        <div class="mb-4">

                            <label
                                for="file"
                                class="form-label fw-semibold"
                            >
                                File Tugas
                            </label>

                            <input
                                type="file"
                                class="form-control"
                                id="file"
                                name="file"
                                accept=".pdf,.doc,.docx,.ppt,.pptx,.xls,.xlsx,.zip"
                                required
                            >

                            <div class="form-text">

                                Format yang diperbolehkan:

                                PDF, DOC, DOCX, PPT, PPTX,
                                XLS, XLSX, ZIP.

                                Maksimal 10 MB.

                            </div>

                        </div>


                        <!-- NOTE -->

                        <div class="mb-4">

                            <label
                                for="note"
                                class="form-label fw-semibold"
                            >
                                Catatan
                            </label>

                            <textarea
                                class="form-control"
                                id="note"
                                name="note"
                                rows="5"
                                placeholder="Tambahkan catatan untuk guru jika diperlukan..."
                            >{{ old('note') }}</textarea>

                            <div class="form-text">
                                Bagian ini opsional.
                            </div>

                        </div>


                        <!-- WARNING -->

                        <div
                            class="alert
                                   alert-warning
                                   border-0
                                   small"
                        >

                            <strong>Perhatian:</strong>

                            Pastikan file yang kamu upload
                            merupakan hasil pekerjaan yang benar
                            sebelum mengirimkannya.

                        </div>


                        <!-- BUTTON -->

                        <div
                            class="d-flex
                                   flex-column
                                   flex-sm-row
                                   justify-content-end
                                   gap-2"
                        >

                            <a
                                href="{{ route(
                                    'assignments.show',
                                    [
                                        $class,
                                        $assignment
                                    ]
                                ) }}"
                                class="btn btn-light border"
                            >
                                Batal
                            </a>


                            <button
                                type="submit"
                                class="btn btn-primary"
                            >
                                <i class="bi bi-upload"></i> Kumpulkan Tugas
                            </button>

                        </div>

                    </form>

                </div>

            </div>

        </div>

    </div>

@endsection