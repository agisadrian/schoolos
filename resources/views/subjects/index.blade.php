@extends('layouts.app')

@section('title', 'Mata Pelajaran - ' . $class->name)

@section('page-title', 'Mata Pelajaran')


@section('content')

    <!-- =========================
         HEADER
    ========================== -->

    <div
        class="d-flex flex-column flex-md-row
               justify-content-between
               align-items-md-center
               gap-3 mb-4"
    >

        <div>

            <div class="text-muted small mb-1">
                {{ $class->name }}
                ·
                {{ $class->code }}
            </div>

            <h2 class="fw-bold mb-1">
                Mata Pelajaran
            </h2>

            <p class="text-muted mb-0">
                Daftar mata pelajaran yang digunakan
                dalam kelas ini.
            </p>

        </div>


        @if(
            Auth::user()->role === 'admin' ||
            Auth::user()->role === 'teacher'
        )

            <button
                type="button"
                class="btn btn-primary"
                data-bs-toggle="modal"
                data-bs-target="#addSubjectModal"
            >
                + Tambah Mata Pelajaran
            </button>

        @endif

    </div>


    <!-- =========================
         SUCCESS
    ========================== -->

    @if(session('success'))

        <div class="alert alert-success border-0 shadow-sm">
            {{ session('success') }}
        </div>

    @endif


    <!-- =========================
         SUBJECT COUNT
    ========================== -->

    <div class="card mb-4">

        <div class="card-body p-4">

            <div
                class="d-flex
                       align-items-center
                       justify-content-between"
            >

                <div>

                    <div class="text-muted small">
                        Total Mata Pelajaran
                    </div>

                    <div class="fw-bold fs-3">
                        {{ $subjects->count() }}
                    </div>

                </div>


                <div
                    class="rounded-4
                           d-flex
                           align-items-center
                           justify-content-center"
                    style="
                        width: 58px;
                        height: 58px;
                        background: #fff7ed;
                        font-size: 28px;
                    "
                >
                    <i class="bi bi-journal-bookmark-fill"></i>
                </div>

            </div>

        </div>

    </div>


    <!-- =========================
         SUBJECT LIST
    ========================== -->

    @if($subjects->count() > 0)

        <div class="row g-4">

            @foreach($subjects as $subject)

                <div class="col-md-6 col-xl-4">

                    <div class="card h-100 menu-card">

                        <div class="card-body p-4">


                            <!-- ICON -->

                            <div
                                class="rounded-4
                                       d-flex
                                       align-items-center
                                       justify-content-center
                                       mb-4"
                                style="
                                    width: 54px;
                                    height: 54px;
                                    background: #fff7ed;
                                    font-size: 25px;
                                "
                            >
                                <i class="bi bi-journal-bookmark-fill"></i>
                            </div>


                            <!-- TITLE -->

                            <h5 class="fw-bold mb-2">

                                {{ $subject->name }}

                            </h5>


                            <!-- CODE -->

                            @if($subject->code)

                                <div class="mb-3">

                                    <span
                                        class="badge
                                               rounded-pill
                                               bg-light
                                               text-dark
                                               border
                                               px-3 py-2"
                                    >
                                        {{ $subject->code }}
                                    </span>

                                </div>

                            @endif


                            <!-- DESCRIPTION -->

                            @if($subject->description)

                                <p
                                    class="text-muted
                                           small
                                           mb-0"
                                    style="min-height: 48px;"
                                >
                                    {{ Str::limit(
                                        $subject->description,
                                        100
                                    ) }}
                                </p>

                            @else

                                <p
                                    class="text-muted
                                           small
                                           mb-0"
                                    style="min-height: 48px;"
                                >
                                    Tidak ada deskripsi.
                                </p>

                            @endif


                        </div>

                    </div>

                </div>

            @endforeach

        </div>

    @else

        <!-- =========================
             EMPTY STATE
        ========================== -->

        <div class="card">

            <div
                class="card-body
                       text-center
                       py-5"
            >

                <div
                    class="mb-3"
                    style="font-size: 55px;"
                >
                    <i class="bi bi-journal-bookmark-fill"></i>
                </div>


                <h5 class="fw-bold mb-2">
                    Belum ada mata pelajaran
                </h5>


                <p
                    class="text-muted
                           mx-auto
                           mb-4"
                    style="max-width: 450px;"
                >
                    Tambahkan mata pelajaran untuk mulai
                    mengelola materi, tugas, dan nilai
                    kelas ini.
                </p>


                @if(
                    Auth::user()->role === 'admin' ||
                    Auth::user()->role === 'teacher'
                )

                    <button
                        type="button"
                        class="btn btn-primary"
                        data-bs-toggle="modal"
                        data-bs-target="#addSubjectModal"
                    >
                        + Tambah Mata Pelajaran
                    </button>

                @endif

            </div>

        </div>

    @endif


    <!-- =========================
         ADD SUBJECT MODAL
    ========================== -->

    @if(
        Auth::user()->role === 'admin' ||
        Auth::user()->role === 'teacher'
    )

        <div
            class="modal fade"
            id="addSubjectModal"
            tabindex="-1"
            aria-hidden="true"
        >

            <div
                class="modal-dialog
                       modal-dialog-centered"
            >

                <div class="modal-content border-0 rounded-4">


                    <!-- HEADER -->

                    <div class="modal-header">

                        <div>

                            <h5 class="modal-title fw-bold">
                                Tambah Mata Pelajaran
                            </h5>

                            <div class="text-muted small">
                                Tambahkan mata pelajaran
                                untuk {{ $class->name }}.
                            </div>

                        </div>


                        <button
                            type="button"
                            class="btn-close"
                            data-bs-dismiss="modal"
                            aria-label="Close"
                        ></button>

                    </div>


                    <!-- FORM -->

                    <form
                        action="{{ route(
                            'subjects.store',
                            $class
                        ) }}"
                        method="POST"
                    >

                        @csrf


                        <div class="modal-body">


                            <!-- NAME -->

                            <div class="mb-3">

                                <label
                                    for="subject_name"
                                    class="form-label fw-semibold"
                                >
                                    Nama Mata Pelajaran
                                </label>

                                <input
                                    type="text"
                                    class="form-control"
                                    id="subject_name"
                                    name="name"
                                    value="{{ old('name') }}"
                                    placeholder="Contoh: Pemrograman Web"
                                    required
                                >

                            </div>


                            <!-- CODE -->

                            <div class="mb-3">

                                <label
                                    for="subject_code"
                                    class="form-label fw-semibold"
                                >
                                    Kode Mata Pelajaran
                                </label>

                                <input
                                    type="text"
                                    class="form-control"
                                    id="subject_code"
                                    name="code"
                                    value="{{ old('code') }}"
                                    placeholder="Contoh: PWEB"
                                >

                                <div class="form-text">
                                    Opsional. Contoh kode:
                                    MTK, BIND, PWEB.
                                </div>

                            </div>


                            <!-- DESCRIPTION -->

                            <div class="mb-3">

                                <label
                                    for="subject_description"
                                    class="form-label fw-semibold"
                                >
                                    Deskripsi
                                </label>

                                <textarea
                                    class="form-control"
                                    id="subject_description"
                                    name="description"
                                    rows="4"
                                    placeholder="Deskripsi singkat mata pelajaran..."
                                >{{ old('description') }}</textarea>

                            </div>

                        </div>


                        <!-- FOOTER -->

                        <div class="modal-footer">

                            <button
                                type="button"
                                class="btn btn-light"
                                data-bs-dismiss="modal"
                            >
                                Batal
                            </button>


                            <button
                                type="submit"
                                class="btn btn-primary"
                            >
                                Tambah Mata Pelajaran
                            </button>

                        </div>

                    </form>

                </div>

            </div>

        </div>

    @endif


@endsection