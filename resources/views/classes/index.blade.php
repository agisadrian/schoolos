@extends('layouts.app')

@section('content')

<div class="container-fluid py-4">

    {{-- HEADER --}}

    <div class="d-flex flex-column flex-md-row
                justify-content-between
                align-items-md-center
                gap-3 mb-4">

        <div>
            <h2 class="fw-bold mb-1">
                Kelas
            </h2>

            <p class="text-muted mb-0">
                Kelola dan lihat kelas yang tersedia.
            </p>
        </div>


        @if(auth()->user()->role === 'admin')

            <button
                type="button"
                class="btn btn-primary"
                data-bs-toggle="modal"
                data-bs-target="#createClassModal"
            >
                <i class="bi bi-plus-lg me-1"></i>
                Buat Kelas
            </button>

        @else

            <a
                href="{{ route('classes.join') }}"
                class="btn btn-primary"
            >
                <i class="bi bi-box-arrow-in-right me-1"></i>
                Gabung Kelas
            </a>

        @endif

    </div>


    {{-- SUCCESS MESSAGE --}}

    @if(session('success'))

        <div
            class="alert alert-success alert-dismissible fade show"
            role="alert"
        >
            <i class="bi bi-check-circle me-2"></i>

            {{ session('success') }}

            <button
                type="button"
                class="btn-close"
                data-bs-dismiss="alert"
            ></button>
        </div>

    @endif


    {{-- SEARCH --}}

    <div class="card border-0 shadow-sm mb-4">

        <div class="card-body">

            <form
                action="{{ route('classes.index') }}"
                method="GET"
            >

                <div class="row g-3">

                    <div class="col-lg-9">

                        <label
                            for="search"
                            class="form-label fw-semibold"
                        >
                            Cari Kelas
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
                                placeholder="Cari berdasarkan nama atau kode kelas..."
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
                                href="{{ route('classes.index') }}"
                                class="btn btn-light border"
                                title="Reset pencarian"
                            >
                                <i class="bi bi-arrow-counterclockwise"></i>
                            </a>

                        </div>

                    </div>

                </div>

            </form>

        </div>

    </div>


    {{-- CLASS LIST --}}

    <div class="row g-4">

        @forelse($classes as $class)

            <div class="col-md-6 col-xl-4">

                <div class="card border-0 shadow-sm h-100">

                    <div class="card-body p-4">

                        <div class="d-flex align-items-start mb-4">

                            <div
                                class="rounded-3
                                       bg-primary
                                       bg-opacity-10
                                       d-flex
                                       align-items-center
                                       justify-content-center
                                       me-3"
                                style="width:50px;height:50px;"
                            >
                                <i class="bi bi-building fs-4 text-primary"></i>
                            </div>


                            <div class="flex-grow-1">

                                <h5 class="fw-bold mb-1">
                                    {{ $class->name }}
                                </h5>

                                <div class="text-muted small">
                                    {{ $class->code }}
                                </div>

                            </div>

                        </div>


                        @if($class->description)

                            <p class="text-muted small mb-4">
                                {{ Str::limit($class->description, 120) }}
                            </p>

                        @else

                            <p class="text-muted small mb-4">
                                Tidak ada deskripsi kelas.
                            </p>

                        @endif


                        <div class="d-flex
                                    flex-wrap
                                    gap-3
                                    small
                                    text-muted
                                    mb-4">

                            <span>
                                <i class="bi bi-people me-1"></i>
                                {{ $class->members_count }}
                                anggota
                            </span>


                            <span>
                                <i class="bi bi-book me-1"></i>
                                {{ $class->subjects_count }}
                                mapel
                            </span>


                            <span>
                                <i class="bi bi-list-task me-1"></i>
                                {{ $class->assignments_count }}
                                tugas
                            </span>

                        </div>


                        @php
                            $myMembership = $class->members->first();
                            $isPending = $myMembership
                                && $myMembership->status === 'pending';
                        @endphp

                        @if($isPending)

                            <button
                                type="button"
                                class="btn btn-warning w-100"
                                disabled
                            >
                                <i class="bi bi-hourglass-split me-1"></i>
                                Menunggu Persetujuan
                            </button>

                        @else

                            <a
                                href="{{ route('classes.show', $class) }}"
                                class="btn btn-primary w-100"
                            >
                                Lihat Kelas
                                <i class="bi bi-arrow-right ms-1"></i>
                            </a>

                        @endif

                    </div>

                </div>

            </div>

        @empty

            <div class="col-12">

                <div class="card border-0 shadow-sm">

                    <div class="card-body text-center py-5">

                        <i
                            class="bi bi-building fs-1 text-muted"
                        ></i>

                        <h5 class="fw-semibold mt-3">
                            Kelas tidak ditemukan
                        </h5>

                        <p class="text-muted mb-0">
                            Tidak ada kelas yang sesuai dengan pencarian.
                        </p>

                    </div>

                </div>

            </div>

        @endforelse

    </div>


    {{-- PAGINATION --}}

    @if($classes->hasPages())

        <div class="d-flex justify-content-center mt-4">

            {{ $classes->links() }}

        </div>

    @endif

</div>


{{-- ============================================================ --}}
{{-- CREATE CLASS MODAL --}}
{{-- ============================================================ --}}

@if(auth()->user()->role === 'admin')

    <div
        class="modal fade"
        id="createClassModal"
        tabindex="-1"
        aria-hidden="true"
    >

        <div class="modal-dialog">

            <div class="modal-content border-0 shadow">

                <div class="modal-header">

                    <h5 class="modal-title fw-bold">
                        Buat Kelas Baru
                    </h5>

                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="modal"
                    ></button>

                </div>


                <form
                    action="{{ route('classes.store') }}"
                    method="POST"
                >

                    @csrf

                    <div class="modal-body">

                        <div class="mb-3">

                            <label
                                for="class_name"
                                class="form-label fw-semibold"
                            >
                                Nama Kelas
                            </label>

                            <input
                                type="text"
                                id="class_name"
                                name="name"
                                class="form-control @error('name') is-invalid @enderror"
                                value="{{ old('name') }}"
                                placeholder="Contoh: XI RPL 1"
                                required
                            >

                            @error('name')

                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>

                            @enderror

                        </div>


                        <div class="mb-3">

                            <label
                                for="class_code"
                                class="form-label fw-semibold"
                            >
                                Kode Kelas
                            </label>

                            <input
                                type="text"
                                id="class_code"
                                name="code"
                                class="form-control @error('code') is-invalid @enderror"
                                value="{{ old('code') }}"
                                placeholder="Contoh: RPL11"
                                required
                            >

                            @error('code')

                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>

                            @enderror

                        </div>


                        <div class="mb-0">

                            <label
                                for="class_description"
                                class="form-label fw-semibold"
                            >
                                Deskripsi
                            </label>

                            <textarea
                                id="class_description"
                                name="description"
                                class="form-control @error('description') is-invalid @enderror"
                                rows="4"
                                placeholder="Deskripsi singkat kelas..."
                            >{{ old('description') }}</textarea>

                            @error('description')

                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>

                            @enderror

                        </div>

                    </div>


                    <div class="modal-footer">

                        <button
                            type="button"
                            class="btn btn-light border"
                            data-bs-dismiss="modal"
                        >
                            Batal
                        </button>

                        <button
                            type="submit"
                            class="btn btn-primary"
                        >
                            <i class="bi bi-check-lg me-1"></i>
                            Buat Kelas
                        </button>

                    </div>

                </form>

            </div>

        </div>

    </div>

@endif

@endsection