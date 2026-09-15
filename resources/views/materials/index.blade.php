@extends('layouts.app')

@section('content')

<div class="container-fluid py-4">

    {{-- HEADER --}}

    <div class="d-flex flex-column flex-md-row
                justify-content-between
                align-items-md-center
                gap-3 mb-4">

        <div>

            <div class="small text-muted mb-1">
                {{ $class->name }}
            </div>

            <h2 class="fw-bold mb-1">
                Materi
            </h2>

            <p class="text-muted mb-0">
                Materi pembelajaran untuk kelas ini.
            </p>

        </div>


        @if(in_array(auth()->user()->role, ['admin', 'teacher']))

            <a
                href="{{ route('materials.create', $class) }}"
                class="btn btn-primary"
            >
                <i class="bi bi-plus-lg me-1"></i>
                Tambah Materi
            </a>

        @endif

    </div>


    {{-- SUCCESS --}}

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


    {{-- SEARCH + FILTER --}}

    <div class="card border-0 shadow-sm mb-4">

        <div class="card-body">

            <form
                action="{{ route('materials.index', $class) }}"
                method="GET"
            >

                <div class="row g-3">

                    <div class="col-lg-6">

                        <label
                            for="search"
                            class="form-label fw-semibold"
                        >
                            Cari Materi
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
                                placeholder="Judul, deskripsi, atau nama file..."
                                value="{{ request('search') }}"
                            >

                        </div>

                    </div>


                    <div class="col-lg-3">

                        <label
                            for="subject_id"
                            class="form-label fw-semibold"
                        >
                            Mata Pelajaran
                        </label>

                        <select
                            id="subject_id"
                            name="subject_id"
                            class="form-select"
                        >

                            <option value="">
                                Semua Mata Pelajaran
                            </option>

                            @foreach($subjects as $subject)

                                <option
                                    value="{{ $subject->id }}"
                                    @selected(
                                        (string) request('subject_id') ===
                                        (string) $subject->id
                                    )
                                >
                                    {{ $subject->name }}
                                </option>

                            @endforeach

                        </select>

                    </div>


                    <div class="col-lg-3 d-flex align-items-end">

                        <div class="d-flex gap-2 w-100">

                            <button
                                type="submit"
                                class="btn btn-primary flex-grow-1"
                            >
                                <i class="bi bi-funnel me-1"></i>
                                Filter
                            </button>

                            <a
                                href="{{ route('materials.index', $class) }}"
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


    {{-- MATERIAL LIST --}}

    <div class="row g-4">

        @forelse($materials as $material)

            <div class="col-md-6 col-xl-4">

                <div class="card border-0 shadow-sm h-100">

                    <div class="card-body p-4">

                        <div class="d-flex align-items-start mb-3">

                            <div
                                class="rounded-3
                                       bg-danger
                                       bg-opacity-10
                                       d-flex
                                       align-items-center
                                       justify-content-center
                                       me-3"
                                style="width:48px;height:48px;"
                            >

                                <i class="bi bi-file-earmark-text fs-4 text-danger"></i>

                            </div>


                            <div class="flex-grow-1">

                                <h5 class="fw-bold mb-1">
                                    {{ $material->title }}
                                </h5>

                                <div class="small text-muted">

                                    {{ $material->subject->name ?? 'Tanpa mapel' }}

                                </div>

                            </div>

                        </div>


                        @if($material->description)

                            <p class="text-muted small mb-3">

                                {{ Str::limit($material->description, 110) }}

                            </p>

                        @else

                            <p class="text-muted small mb-3">

                                Tidak ada deskripsi.

                            </p>

                        @endif


                        <div class="small text-muted mb-3">

                            <div class="mb-1">

                                <i class="bi bi-file-earmark me-1"></i>

                                {{ $material->file_name }}

                            </div>


                            @if($material->file_size)

                                <div>

                                    <i class="bi bi-hdd me-1"></i>

                                    {{ number_format($material->file_size / 1024 / 1024, 2) }}
                                    MB

                                </div>

                            @endif

                        </div>


                        <div class="d-flex gap-2">

                            <a
                                href="{{ route('materials.show', [
                                    'class' => $class,
                                    'material' => $material,
                                ]) }}"
                                class="btn btn-light border flex-grow-1"
                            >
                                Detail
                            </a>


                            <a
                                href="{{ route('materials.file', [
                                    'class' => $class,
                                    'material' => $material,
                                ]) }}"
                                class="btn btn-primary"
                            >
                                <i class="bi bi-download"></i>
                            </a>

                        </div>

                    </div>

                </div>

            </div>

        @empty

            <div class="col-12">

                <div class="card border-0 shadow-sm">

                    <div class="card-body text-center py-5">

                        <i
                            class="bi bi-folder2-open fs-1 text-muted"
                        ></i>

                        <h5 class="fw-semibold mt-3">
                            Materi tidak ditemukan
                        </h5>

                        <p class="text-muted mb-0">
                            Belum ada materi yang sesuai dengan pencarian.
                        </p>

                    </div>

                </div>

            </div>

        @endforelse

    </div>


    {{-- PAGINATION --}}

    @if($materials->hasPages())

        <div class="d-flex justify-content-center mt-4">

            {{ $materials->links() }}

        </div>

    @endif

</div>

@endsection