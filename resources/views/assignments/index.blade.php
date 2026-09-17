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
                Tugas
            </h2>

            <p class="text-muted mb-0">
                Daftar tugas untuk kelas ini.
            </p>

        </div>


        @if(in_array(auth()->user()->role, ['admin', 'teacher']))

            <a
                href="{{ route('assignments.create', $class) }}"
                class="btn btn-primary"
            >
                <i class="bi bi-plus-lg me-1"></i>
                Buat Tugas
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
                action="{{ route('assignments.index', $class) }}"
                method="GET"
            >

                <div class="row g-3">

                    {{-- SEARCH --}}

                    <div class="col-lg-5">

                        <label
                            for="search"
                            class="form-label fw-semibold"
                        >
                            Cari Tugas
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
                                placeholder="Judul atau deskripsi..."
                                value="{{ request('search') }}"
                            >

                        </div>

                    </div>


                    {{-- SUBJECT --}}

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


                    {{-- DEADLINE --}}

                    <div class="col-lg-2">

                        <label
                            for="deadline"
                            class="form-label fw-semibold"
                        >
                            Deadline
                        </label>

                        <select
                            id="deadline"
                            name="deadline"
                            class="form-select"
                        >

                            <option value="">
                                Semua
                            </option>

                            <option
                                value="active"
                                @selected(request('deadline') === 'active')
                            >
                                Aktif
                            </option>

                            <option
                                value="expired"
                                @selected(request('deadline') === 'expired')
                            >
                                Berakhir
                            </option>

                        </select>

                    </div>


                    {{-- BUTTON --}}

                    <div class="col-lg-2 d-flex align-items-end">

                        <div class="d-flex gap-2 w-100">

                            <button
                                type="submit"
                                class="btn btn-primary flex-grow-1"
                            >
                                <i class="bi bi-funnel me-1"></i>
                                Filter
                            </button>

                            <a
                                href="{{ route('assignments.index', $class) }}"
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


    {{-- ASSIGNMENTS --}}

    <div class="row g-4">

        @forelse($assignments as $assignment)

            @php
                $submission =
                    $submissions->get($assignment->id);

                $isExpired =
                    $assignment->deadline->isPast();

                $isSubmitted =
                    $submission !== null;
            @endphp


            <div class="col-md-6 col-xl-4">

                <div class="card border-0 shadow-sm h-100">

                    <div class="card-body p-4">

                        {{-- ICON + TITLE --}}

                        <div class="d-flex align-items-start mb-3">

                            <div
                                class="rounded-3
                                       bg-primary
                                       bg-opacity-10
                                       d-flex
                                       align-items-center
                                       justify-content-center
                                       me-3"
                                style="width:48px;height:48px;"
                            >

                                <i class="bi bi-journal-text fs-4 text-primary"></i>

                            </div>


                            <div class="flex-grow-1">

                                <h5 class="fw-bold mb-1">
                                    {{ $assignment->title }}
                                </h5>

                                <div class="small text-muted">
                                    {{ $assignment->subject->name ?? 'Tanpa mapel' }}
                                </div>

                            </div>

                        </div>


                        {{-- DESCRIPTION --}}

                        @if($assignment->description)

                            <p class="text-muted small mb-3">
                                {{ Str::limit($assignment->description, 120) }}
                            </p>

                        @else

                            <p class="text-muted small mb-3">
                                Tidak ada deskripsi.
                            </p>

                        @endif


                        {{-- DEADLINE --}}

                        <div class="mb-3">

                            @if($isExpired)

                                <span class="badge text-bg-danger">
                                    <i class="bi bi-clock me-1"></i>
                                    Deadline berakhir
                                </span>

                            @else

                                <span class="badge text-bg-warning">
                                    <i class="bi bi-clock me-1"></i>
                                    Deadline
                                    {{ $assignment->deadline->format('d M Y H:i') }}
                                </span>

                            @endif

                        </div>


                        {{-- STUDENT STATUS --}}

                        @if(auth()->user()->role === 'student')

                            @if($isSubmitted)

                                <div class="alert alert-success py-2 small mb-3">

                                    <i class="bi bi-check-circle me-1"></i>

                                    Sudah dikumpulkan

                                </div>

                            @elseif($isExpired)

                                <div class="alert alert-danger py-2 small mb-3">

                                    <i class="bi bi-x-circle me-1"></i>

                                    Belum dikumpulkan

                                </div>

                            @else

                                <div class="alert alert-warning py-2 small mb-3">

                                    <i class="bi bi-exclamation-circle me-1"></i>

                                    Belum dikumpulkan

                                </div>

                            @endif

                        @endif


                        {{-- FILE --}}

                        @if($assignment->file_name)

                            <div class="small text-muted mb-3">

                                <i class="bi bi-paperclip me-1"></i>

                                {{ $assignment->file_name }}

                            </div>

                        @endif


                        {{-- ACTION --}}

                        <div class="d-flex gap-2">

                            <a
                                href="{{ route('assignments.show', [
                                    'class' => $class,
                                    'assignment' => $assignment,
                                ]) }}"
                                class="btn btn-light border flex-grow-1"
                            >
                                Detail
                            </a>


                            @if(
                                auth()->user()->role === 'student' &&
                                !$isExpired &&
                                !$isSubmitted
                            )

                                <a
                                    href="{{ route('submissions.create', [
                                        'class' => $class,
                                        'assignment' => $assignment,
                                    ]) }}"
                                    class="btn btn-primary"
                                >
                                    <i class="bi bi-upload"></i>
                                </a>

                            @endif


                            @if(
                                $assignment->file_path
                            )

                                <a
                                    href="{{ route('assignments.file', [
                                        'class' => $class,
                                        'assignment' => $assignment,
                                    ]) }}"
                                    class="btn btn-light border"
                                    title="Download"
                                >
                                    <i class="bi bi-download"></i>
                                </a>

                            @endif


                            @if(
                                Auth::user()->role === 'admin' ||
                                Auth::user()->role === 'teacher'
                            )

                                <a
                                    href="{{ route('assignments.edit', [$class, $assignment]) }}"
                                    class="btn btn-outline-secondary"
                                >
                                    <i class="bi bi-pencil-square"></i>
                                </a>

                                <form
                                    action="{{ route('assignments.destroy', [$class, $assignment]) }}"
                                    method="POST"
                                    onsubmit="return confirm('Hapus tugas ini? Semua submission siswa untuk tugas ini juga akan ikut terhapus.')"
                                >
                                    @csrf
                                    @method('DELETE')

                                    <button
                                        type="submit"
                                        class="btn btn-outline-danger"
                                    >
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>

                            @endif

                        </div>

                    </div>

                </div>

            </div>

        @empty

            <div class="col-12">

                <div class="card border-0 shadow-sm">

                    <div class="card-body text-center py-5">

                        <i
                            class="bi bi-journal-x fs-1 text-muted"
                        ></i>

                        <h5 class="fw-semibold mt-3">
                            Tugas tidak ditemukan
                        </h5>

                        <p class="text-muted mb-0">
                            Tidak ada tugas yang sesuai dengan filter.
                        </p>

                    </div>

                </div>

            </div>

        @endforelse

    </div>


    {{-- PAGINATION --}}

    @if($assignments->hasPages())

        <div class="d-flex justify-content-center mt-4">

            {{ $assignments->links() }}

        </div>

    @endif

</div>

@endsection