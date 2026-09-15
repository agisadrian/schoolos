@extends('layouts.app')

@section('title', 'Detail Nilai - SchoolOS')

@section('page-title', 'Detail Nilai')

@section('content')

<div class="mb-4">

    <a
        href="{{ route('grades.index', $class) }}"
        class="text-decoration-none"
    >
        ← Kembali ke Nilai
    </a>

</div>


@php
    $percentage = $grade->max_score > 0
        ? ($grade->score / $grade->max_score) * 100
        : 0;
@endphp


<div class="card mb-4">

    <div class="card-body p-4 p-lg-5">

        <div class="row align-items-center">

            <div class="col-lg-8">

                <div class="mb-3">

                    <span class="badge rounded-pill bg-light text-dark border px-3 py-2">
                        <i class="bi bi-journal-bookmark-fill"></i> {{ $grade->subject->name ?? '-' }}
                    </span>

                </div>


                <h1 class="fw-bold mb-2">
                    {{ $grade->title }}
                </h1>


                <p class="text-muted mb-4">

                    Nilai untuk

                    <strong>
                        {{ $grade->student->name }}
                    </strong>

                </p>


                <div class="d-flex flex-wrap gap-4">

                    <div>

                        <div class="text-muted small">
                            Nilai
                        </div>

                        <div class="fw-bold fs-5">

                            {{ number_format($grade->score, 2) }}

                            /

                            {{ number_format($grade->max_score, 2) }}

                        </div>

                    </div>


                    <div>

                        <div class="text-muted small">
                            Persentase
                        </div>

                        <div class="fw-bold fs-5">
                            {{ number_format($percentage, 1) }}%
                        </div>

                    </div>


                    <div>

                        <div class="text-muted small">
                            Dimasukkan
                        </div>

                        <div class="fw-semibold">
                            {{ $grade->created_at->format('d M Y') }}
                        </div>

                    </div>

                </div>

            </div>


            <div class="col-lg-4 mt-4 mt-lg-0">

                <div class="border rounded-4 p-4 text-center">

                    <div class="text-muted small mb-2">
                        Nilai Akhir
                    </div>


                    <div
                        class="fw-bold"
                        style="font-size: 52px; line-height: 1;"
                    >
                        {{ number_format($percentage, 1) }}%
                    </div>


                    <div
                        class="progress mt-3"
                        style="height: 10px;"
                    >

                        <div
                            class="progress-bar grade-detail-progress"
                            data-percentage="{{ $percentage }}"
                        ></div>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>


<div class="card mb-4">

    <div class="card-body p-4">

        <h5 class="fw-bold mb-4">
            Informasi Siswa
        </h5>


        <div class="d-flex align-items-center gap-3">

            <div
                class="rounded-circle d-flex align-items-center justify-content-center"
                style="width: 52px; height: 52px; background: #eef2ff; color: #4f46e5; font-weight: 700; font-size: 20px;"
            >
                {{ strtoupper(substr($grade->student->name, 0, 1)) }}
            </div>


            <div>

                <div class="fw-bold">
                    {{ $grade->student->name }}
                </div>

                <div class="text-muted small">
                    {{ $grade->student->email }}
                </div>

            </div>

        </div>

    </div>

</div>


<div class="card mb-4">

    <div class="card-body p-4">

        <h5 class="fw-bold mb-4">
            Detail Penilaian
        </h5>


        <div class="row g-4">

            <div class="col-md-6">

                <div class="text-muted small mb-1">
                    Mata Pelajaran
                </div>

                <div class="fw-semibold">
                    {{ $grade->subject->name ?? '-' }}
                </div>

            </div>


            <div class="col-md-6">

                <div class="text-muted small mb-1">
                    Nama Penilaian
                </div>

                <div class="fw-semibold">
                    {{ $grade->title }}
                </div>

            </div>


            <div class="col-md-6">

                <div class="text-muted small mb-1">
                    Nilai
                </div>

                <div class="fw-semibold">

                    {{ number_format($grade->score, 2) }}

                    /

                    {{ number_format($grade->max_score, 2) }}

                </div>

            </div>


            <div class="col-md-6">

                <div class="text-muted small mb-1">
                    Dimasukkan Oleh
                </div>

                <div class="fw-semibold">
                    {{ $grade->enteredBy->name ?? '-' }}
                </div>

            </div>

        </div>

    </div>

</div>


@if($grade->notes)

    <div class="card">

        <div class="card-body p-4">

            <h5 class="fw-bold mb-3">
                Catatan
            </h5>

            <div
                class="text-muted"
                style="white-space: pre-line; line-height: 1.7;"
            >
                {{ $grade->notes }}
            </div>

        </div>

    </div>

@endif


@push('scripts')

<script>
    const detailProgress =
        document.querySelector('.grade-detail-progress');

    if (detailProgress) {

        const percentage =
            parseFloat(
                detailProgress.dataset.percentage
            ) || 0;

        const safePercentage =
            Math.max(
                0,
                Math.min(
                    percentage,
                    100
                )
            );

        detailProgress.style.width =
            safePercentage + '%';
    }
</script>

@endpush

@endsection