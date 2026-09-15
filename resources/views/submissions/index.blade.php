@extends('layouts.app')

@section('content')

<div class="container-fluid py-4">

    {{-- HEADER --}}

    <div class="mb-4">

        <div class="small text-muted mb-1">
            {{ $class->name }}
        </div>

        <h2 class="fw-bold mb-1">
            Pengumpulan Tugas
        </h2>

        <p class="text-muted mb-0">
            {{ $assignment->title }}
        </p>

    </div>


    {{-- STATISTICS --}}

    <div class="row g-4 mb-4">

        <div class="col-md-4">

            <div class="card border-0 shadow-sm">

                <div class="card-body">

                    <div class="text-muted small mb-2">
                        Total Siswa
                    </div>

                    <h2 class="fw-bold mb-0">
                        {{ $totalStudents }}
                    </h2>

                </div>

            </div>

        </div>


        <div class="col-md-4">

            <div class="card border-0 shadow-sm">

                <div class="card-body">

                    <div class="text-muted small mb-2">
                        Sudah Mengumpulkan
                    </div>

                    <h2 class="fw-bold text-success mb-0">
                        {{ $submittedCount }}
                    </h2>

                </div>

            </div>

        </div>


        <div class="col-md-4">

            <div class="card border-0 shadow-sm">

                <div class="card-body">

                    <div class="text-muted small mb-2">
                        Belum Mengumpulkan
                    </div>

                    <h2 class="fw-bold text-danger mb-0">
                        {{ $notSubmittedCount }}
                    </h2>

                </div>

            </div>

        </div>

    </div>


    {{-- SEARCH --}}

    <div class="card border-0 shadow-sm mb-4">

        <div class="card-body">

            <form
                action="{{ route('submissions.index', [
                    'class' => $class,
                    'assignment' => $assignment,
                ]) }}"
                method="GET"
            >

                <div class="row g-3">

                    <div class="col-lg-9">

                        <label
                            for="search"
                            class="form-label fw-semibold"
                        >
                            Cari Siswa
                        </label>

                        <div class="input-group">

                            <span class="input-group-text bg-white">
                                <i class="bi bi-search"></i>
                            </span>

                            <input
                                type="text"
                                id="search"
                                name="search"
                                class="form-control"
                                placeholder="Nama atau email siswa..."
                                value="{{ request('search') }}"
                            >

                        </div>

                    </div>


                    <div class="col-lg-3 d-flex align-items-end">

                        <div class="d-flex gap-2 w-100">

                            <button
                                type="submit"
                                class="btn btn-primary flex-grow-1"
                            >
                                <i class="bi bi-search me-1"></i>
                                Cari
                            </button>

                            <a
                                href="{{ route('submissions.index', [
                                    'class' => $class,
                                    'assignment' => $assignment,
                                ]) }}"
                                class="btn btn-light border"
                                title="Reset"
                            >
                                <i class="bi bi-arrow-counterclockwise"></i>
                            </a>

                        </div>

                    </div>

                </div>

            </form>

        </div>

    </div>


    {{-- SUBMISSIONS TABLE --}}

    <div class="card border-0 shadow-sm">

        <div class="card-header bg-white border-0 pt-4 px-4">

            <h5 class="fw-bold mb-1">
                Siswa yang Sudah Mengumpulkan
            </h5>

            <p class="text-muted small mb-0">
                Daftar file yang telah dikirim.
            </p>

        </div>


        <div class="card-body p-0">

            <div class="table-responsive">

                <table class="table table-hover align-middle mb-0">

                    <thead class="table-light">

                        <tr>

                            <th class="px-4">
                                Siswa
                            </th>

                            <th>
                                File
                            </th>

                            <th>
                                Waktu Pengumpulan
                            </th>

                            <th>
                                Status
                            </th>

                            <th class="text-end px-4">
                                Aksi
                            </th>

                        </tr>

                    </thead>


                    <tbody>

                        @forelse($submissions as $submission)

                            <tr>

                                <td class="px-4">

                                    <div class="fw-semibold">
                                        {{ $submission->user->name }}
                                    </div>

                                    <div class="small text-muted">
                                        {{ $submission->user->email }}
                                    </div>

                                </td>


                                <td>

                                    <div class="small">

                                        <i class="bi bi-file-earmark me-1"></i>

                                        {{ $submission->file_name }}

                                    </div>

                                    @if($submission->file_size)

                                        <div class="small text-muted">

                                            {{ number_format(
                                                $submission->file_size / 1024 / 1024,
                                                2
                                            ) }}
                                            MB

                                        </div>

                                    @endif

                                </td>


                                <td>

                                    <span class="small">

                                        {{ $submission->submitted_at->format(
                                            'd M Y H:i'
                                        ) }}

                                    </span>

                                </td>


                                <td>

                                    <span class="badge text-bg-success">

                                        <i class="bi bi-check-circle me-1"></i>

                                        Terkumpul

                                    </span>

                                </td>


                                <td class="text-end px-4">

                                    <div class="d-flex
                                                justify-content-end
                                                gap-2">

                                        <a
                                            href="{{ route('submissions.show', [
                                                'class' => $class,
                                                'assignment' => $assignment,
                                                'submission' => $submission,
                                            ]) }}"
                                            class="btn btn-sm btn-light border"
                                            title="Detail"
                                        >
                                            <i class="bi bi-eye"></i>
                                        </a>


                                        <a
                                            href="{{ route('submissions.file', [
                                                'class' => $class,
                                                'assignment' => $assignment,
                                                'submission' => $submission,
                                            ]) }}"
                                            class="btn btn-sm btn-primary"
                                            title="Download"
                                        >
                                            <i class="bi bi-download"></i>
                                        </a>

                                    </div>

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td
                                    colspan="5"
                                    class="text-center py-5"
                                >

                                    <i
                                        class="bi bi-inbox fs-1 text-muted"
                                    ></i>

                                    <h6 class="fw-semibold mt-3">
                                        Belum ada pengumpulan
                                    </h6>

                                    <p class="text-muted small mb-0">
                                        Belum ada siswa yang mengumpulkan tugas ini.
                                    </p>

                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>


        {{-- PAGINATION --}}

        @if($submissions->hasPages())

            <div class="card-footer bg-white border-0 px-4 py-3">

                {{ $submissions->links() }}

            </div>

        @endif

    </div>


    {{-- STUDENTS WHO HAVE NOT SUBMITTED --}}

    <div class="card border-0 shadow-sm mt-4">

        <div class="card-header bg-white border-0 pt-4 px-4">

            <h5 class="fw-bold mb-1">
                Siswa Belum Mengumpulkan
            </h5>

            <p class="text-muted small mb-0">
                Siswa kelas yang belum memiliki submission.
            </p>

        </div>


        <div class="card-body">

            <div class="row g-3">

                @php
                    $submittedUserIds = $assignment
                        ->submissions()
                        ->pluck('user_id');
                @endphp


                @forelse($students as $student)

                    @if(!$submittedUserIds->contains($student->user_id))

                        <div class="col-md-6 col-xl-4">

                            <div class="border rounded-3 p-3">

                                <div class="d-flex align-items-center">

                                    <div
                                        class="rounded-circle
                                               bg-danger
                                               bg-opacity-10
                                               d-flex
                                               align-items-center
                                               justify-content-center
                                               me-3"
                                        style="width:42px;height:42px;"
                                    >

                                        <i class="bi bi-person text-danger"></i>

                                    </div>


                                    <div>

                                        <div class="fw-semibold">
                                            {{ $student->user->name }}
                                        </div>

                                        <div class="small text-muted">
                                            {{ $student->user->email }}
                                        </div>

                                    </div>

                                </div>

                            </div>

                        </div>

                    @endif

                @empty

                    <div class="col-12 text-center text-muted py-4">
                        Tidak ada siswa di kelas ini.
                    </div>

                @endforelse

            </div>

        </div>

    </div>

</div>

@endsection