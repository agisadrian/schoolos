@extends('layouts.app')

@section('content')

<div class="container-fluid py-4">

    {{-- HEADER --}}

    <div class="d-flex justify-content-between align-items-start mb-4">

        <div>

            <div class="small text-muted mb-1">
                {{ $class->name }}
            </div>

            <h2 class="fw-bold mb-1">
                Nilai
            </h2>

            <p class="text-muted mb-0">
                Daftar nilai dalam kelas {{ $class->name }}.
            </p>

        </div>


        @if(in_array(auth()->user()->role, ['admin', 'teacher']))

            <a
                href="{{ route('grades.create', $class) }}"
                class="btn btn-primary"
            >
                <i class="bi bi-plus-lg me-1"></i>
                Tambah Nilai
            </a>

        @endif

    </div>


    {{-- STUDENT STATISTICS --}}

    @if(auth()->user()->role === 'student')

        <div class="row g-4 mb-4">

            <div class="col-md-4">

                <div class="card border-0 shadow-sm h-100">

                    <div class="card-body">

                        <div class="small text-muted mb-2">
                            Rata-rata Nilai
                        </div>

                        <h2 class="fw-bold mb-0">

                            @if($studentAverage !== null)

                                {{ number_format(
                                    $studentAverage,
                                    2
                                ) }}

                            @else

                                -

                            @endif

                        </h2>

                    </div>

                </div>

            </div>


            <div class="col-md-4">

                <div class="card border-0 shadow-sm h-100">

                    <div class="card-body">

                        <div class="small text-muted mb-2">
                            Nilai Tertinggi
                        </div>

                        <h2 class="fw-bold text-success mb-0">

                            @if($highestScore !== null)

                                {{ number_format(
                                    $highestScore,
                                    2
                                ) }}

                            @else

                                -

                            @endif

                        </h2>

                    </div>

                </div>

            </div>


            <div class="col-md-4">

                <div class="card border-0 shadow-sm h-100">

                    <div class="card-body">

                        <div class="small text-muted mb-2">
                            Nilai Terendah
                        </div>

                        <h2 class="fw-bold text-danger mb-0">

                            @if($lowestScore !== null)

                                {{ number_format(
                                    $lowestScore,
                                    2
                                ) }}

                            @else

                                -

                            @endif

                        </h2>

                    </div>

                </div>

            </div>

        </div>

    @endif


    {{-- FILTER --}}

    <div class="card border-0 shadow-sm mb-4">

        <div class="card-body">

            <form
                action="{{ route('grades.index', $class) }}"
                method="GET"
            >

                <div class="row g-3">

                    <div class="col-lg-7">

                        <label
                            for="search"
                            class="form-label fw-semibold"
                        >
                            Pencarian
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
                                placeholder="Cari siswa, mata pelajaran, atau judul..."
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
                                        request('subject_id') == $subject->id
                                    )
                                >
                                    {{ $subject->name }}
                                </option>

                            @endforeach

                        </select>

                    </div>


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
                                href="{{ route('grades.index', $class) }}"
                                class="btn btn-light border"
                            >
                                <i class="bi bi-arrow-counterclockwise"></i>
                            </a>

                        </div>

                    </div>

                </div>

            </form>

        </div>

    </div>


    {{-- TABLE --}}

    <div class="card border-0 shadow-sm">

        <div class="card-header bg-white border-0 pt-4 px-4">

            <h5 class="fw-bold mb-1">
                Daftar Nilai
            </h5>

            <p class="text-muted small mb-0">
                @if(auth()->user()->role === 'student')
                    Nilai yang diberikan kepada Anda.
                @else
                    Nilai seluruh siswa dalam kelas.
                @endif
            </p>

        </div>


        <div class="card-body p-0">

            <div class="table-responsive">

                <table class="table table-hover align-middle mb-0">

                    <thead class="table-light">

                        <tr>

                            @if(auth()->user()->role !== 'student')

                                <th class="px-4">
                                    Siswa
                                </th>

                            @endif

                            <th>
                                Mata Pelajaran
                            </th>

                            <th>
                                Penilaian
                            </th>

                            <th>
                                Nilai
                            </th>

                            <th>
                                Persentase
                            </th>

                            <th class="text-end px-4">
                                Aksi
                            </th>

                        </tr>

                    </thead>


                    <tbody>

                        @forelse($grades as $grade)

                            @php

                                $percentage =
                                    $grade->max_score > 0
                                    ? (
                                        $grade->score /
                                        $grade->max_score
                                    ) * 100
                                    : 0;

                            @endphp


                            <tr>

                                @if(auth()->user()->role !== 'student')

                                    <td class="px-4">

                                        <div class="fw-semibold">
                                            {{ $grade->student->name }}
                                        </div>

                                        <div class="small text-muted">
                                            {{ $grade->student->email }}
                                        </div>

                                    </td>

                                @endif


                                <td>

                                    <div class="fw-semibold">
                                        {{ $grade->subject->name }}
                                    </div>

                                    @if($grade->subject->code)

                                        <div class="small text-muted">
                                            {{ $grade->subject->code }}
                                        </div>

                                    @endif

                                </td>


                                <td>

                                    <span class="fw-semibold">
                                        {{ $grade->title }}
                                    </span>

                                </td>


                                <td>

                                    <span class="fw-bold">

                                        {{ number_format(
                                            $grade->score,
                                            2
                                        ) }}

                                        /

                                        {{ number_format(
                                            $grade->max_score,
                                            2
                                        ) }}

                                    </span>

                                </td>


                                <td style="min-width:150px;">

                                    <div class="d-flex align-items-center gap-2">

                                        <div
                                            class="progress flex-grow-1"
                                            style="height:8px;"
                                        >

                                            <div
                                                class="progress-bar"
                                                data-percentage="{{ $percentage }}"
                                            ></div>

                                        </div>

                                        <span class="small fw-semibold">
                                            {{ number_format(
                                                $percentage,
                                                0
                                            ) }}%
                                        </span>

                                    </div>

                                </td>


                                <td class="text-end px-4">

                                    <div class="d-flex justify-content-end gap-2">

                                        <a
                                            href="{{ route('grades.show', [
                                                'class' => $class,
                                                'grade' => $grade,
                                            ]) }}"
                                            class="btn btn-sm btn-light border"
                                        >
                                            <i class="bi bi-eye"></i>
                                        </a>

                                        @if(
                                            Auth::user()->role === 'admin' ||
                                            Auth::user()->role === 'teacher'
                                        )

                                            <a
                                                href="{{ route('grades.edit', [$class, $grade]) }}"
                                                class="btn btn-sm btn-outline-secondary"
                                            >
                                                <i class="bi bi-pencil-square"></i>
                                            </a>

                                            <form
                                                action="{{ route('grades.destroy', [$class, $grade]) }}"
                                                method="POST"
                                                onsubmit="return confirm('Hapus nilai ini?')"
                                            >
                                                @csrf
                                                @method('DELETE')

                                                <button
                                                    type="submit"
                                                    class="btn btn-sm btn-outline-danger"
                                                >
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>

                                        @endif

                                    </div>

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td
                                    colspan="{{ auth()->user()->role === 'student' ? 6 : 6 }}"
                                    class="text-center py-5"
                                >

                                    <i
                                        class="bi bi-bar-chart fs-1 text-muted"
                                    ></i>

                                    <h6 class="fw-semibold mt-3">
                                        Belum ada nilai
                                    </h6>

                                    <p class="text-muted small mb-0">
                                        Belum ada data nilai yang tersedia.
                                    </p>

                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>


        @if($grades->hasPages())

            <div class="card-footer bg-white border-0 px-4 py-3">

                {{ $grades->links() }}

            </div>

        @endif

    </div>

</div>


<script>

document
    .querySelectorAll('[data-percentage]')
    .forEach(function (bar) {

        const percentage =
            parseFloat(
                bar.dataset.percentage
            );

        bar.style.width =
            percentage + '%';

    });

</script>

@endsection