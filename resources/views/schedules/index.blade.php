@extends('layouts.app')

@section('title', 'Jadwal - ' . $class->name)

@section('page-title', 'Jadwal')

@section('content')

<div
    class="d-flex
           flex-column
           flex-md-row
           justify-content-between
           align-items-md-center
           gap-3
           mb-4"
>

    <div>

        <div class="text-muted small mb-1">
            {{ $class->name }}
            ·
            {{ $class->code }}
        </div>

        <h2 class="fw-bold mb-1">
            Jadwal Pelajaran
        </h2>

        <p class="text-muted mb-0">
            Jadwal kegiatan pembelajaran kelas.
        </p>

    </div>

    @if(
        Auth::user()->role === 'admin' ||
        Auth::user()->role === 'teacher'
    )

        <a
            href="{{ route('schedules.create', $class) }}"
            class="btn btn-primary"
        >
            + Tambah Jadwal
        </a>

    @endif

</div>


<!-- SUMMARY -->

<div class="card mb-4">

    <div class="card-body p-4">

        <div
            class="d-flex
                   align-items-center
                   gap-3"
        >

            <div
                class="rounded-4
                       d-flex
                       align-items-center
                       justify-content-center"
                style="
                    width: 58px;
                    height: 58px;
                    background: #eef2ff;
                    font-size: 28px;
                "
            >
                <i class="bi bi-calendar-event"></i>
            </div>

            <div>

                <div class="text-muted small">
                    Kelas
                </div>

                <div class="fw-bold fs-5">
                    {{ $class->name }}
                </div>

            </div>

            <div class="ms-auto text-end">

                <div class="text-muted small">
                    Total Jadwal
                </div>

                <div class="fw-bold fs-4">
                    {{ $schedules->count() }}
                </div>

            </div>

        </div>

    </div>

</div>


@if($schedules->count() > 0)

    @php

        $dayOrder = [
            'Senin' => 1,
            'Selasa' => 2,
            'Rabu' => 3,
            'Kamis' => 4,
            'Jumat' => 5,
            'Sabtu' => 6,
            'Minggu' => 7,
        ];

        $groupedSchedules = $schedules
            ->sortBy(function ($schedule) use ($dayOrder) {
                return [
                    $dayOrder[$schedule->day] ?? 99,
                    $schedule->start_time ?? '',
                ];
            })
            ->groupBy('day');

    @endphp


    <div class="row g-4">

        @foreach($groupedSchedules as $day => $daySchedules)

            <div class="col-12">

                <div class="card">

                    <div class="card-body p-4">

                        <div
                            class="d-flex
                                   align-items-center
                                   gap-3
                                   mb-4"
                        >

                            <div
                                class="rounded-3
                                       d-flex
                                       align-items-center
                                       justify-content-center"
                                style="
                                    width: 45px;
                                    height: 45px;
                                    background: #eef2ff;
                                    font-size: 21px;
                                "
                            >
                                <i class="bi bi-calendar-event"></i>
                            </div>

                            <div>

                                <h5 class="fw-bold mb-0">
                                    {{ $day }}
                                </h5>

                                <div class="text-muted small">
                                    {{ $daySchedules->count() }}
                                    jadwal
                                </div>

                            </div>

                        </div>


                        <div class="row g-3">

                            @foreach($daySchedules as $schedule)

                                <div class="col-md-6 col-xl-4">

                                    <div
                                        class="border
                                               rounded-4
                                               p-3
                                               h-100"
                                    >

                                        <div
                                            class="d-flex
                                                   justify-content-between
                                                   align-items-start
                                                   gap-2
                                                   mb-3"
                                        >

                                            <div>

                                                <div
                                                    class="fw-bold
                                                           fs-5"
                                                >

                                                    {{ $schedule->start_time }}

                                                    @if($schedule->end_time)

                                                        -
                                                        {{ $schedule->end_time }}

                                                    @endif

                                                </div>

                                                <div
                                                    class="text-muted
                                                           small"
                                                >
                                                    Waktu Pelajaran
                                                </div>

                                            </div>

                                            <span
                                                class="badge
                                                       rounded-pill
                                                       bg-light
                                                       text-dark
                                                       border"
                                            >
                                                {{ $day }}
                                            </span>

                                        </div>


                                        <!-- SUBJECT -->

                                        <div class="mb-2">

                                            <div class="text-muted small">
                                                Mata Pelajaran
                                            </div>

                                            <div class="fw-semibold">

                                                {{
                                                    $schedule->subject->name
                                                    ?? '-'
                                                }}

                                            </div>

                                        </div>


                                        <!-- TEACHER -->

                                        @if($schedule->teacher)

                                            <div class="mb-2">

                                                <div
                                                    class="text-muted
                                                           small"
                                                >
                                                    Guru
                                                </div>

                                                <div class="fw-semibold">

                                                    {{
                                                        $schedule->teacher->name
                                                    }}

                                                </div>

                                            </div>

                                        @endif


                                        <!-- ROOM -->

                                        @if($schedule->room)

                                            <div class="mb-2">

                                                <div
                                                    class="text-muted
                                                           small"
                                                >
                                                    Ruangan
                                                </div>

                                                <div class="fw-semibold">

                                                    <i class="bi bi-geo-alt-fill"></i>
                                                    {{ $schedule->room }}

                                                </div>

                                            </div>

                                        @endif


                                        <!-- NOTES -->

                                        @if($schedule->notes)

                                            <div>

                                                <div
                                                    class="text-muted
                                                           small"
                                                >
                                                    Catatan
                                                </div>

                                                <div class="small">

                                                    {{
                                                        $schedule->notes
                                                    }}

                                                </div>

                                            </div>

                                        @endif


                                        <!-- ACTIONS -->

                                        @if(
                                            Auth::user()->role === 'admin' ||
                                            Auth::user()->role === 'teacher'
                                        )

                                            <div class="d-flex gap-2 mt-3 pt-3 border-top">

                                                <a
                                                    href="{{ route('schedules.edit', [$class, $schedule]) }}"
                                                    class="btn btn-sm btn-outline-secondary"
                                                >
                                                    <i class="bi bi-pencil-square"></i>
                                                    Edit
                                                </a>

                                                <form
                                                    action="{{ route('schedules.destroy', [$class, $schedule]) }}"
                                                    method="POST"
                                                    onsubmit="return confirm('Hapus jadwal ini?')"
                                                >
                                                    @csrf
                                                    @method('DELETE')

                                                    <button
                                                        type="submit"
                                                        class="btn btn-sm btn-outline-danger"
                                                    >
                                                        <i class="bi bi-trash"></i>
                                                        Hapus
                                                    </button>
                                                </form>

                                            </div>

                                        @endif

                                    </div>

                                </div>

                            @endforeach

                        </div>

                    </div>

                </div>

            </div>

        @endforeach

    </div>


@else

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
                <i class="bi bi-calendar-event"></i>
            </div>

            <h5 class="fw-bold mb-2">
                Belum ada jadwal
            </h5>

            <p
                class="text-muted
                       mx-auto
                       mb-4"
                style="max-width: 450px;"
            >
                Belum ada jadwal pelajaran
                yang ditambahkan untuk kelas ini.
            </p>

            @if(
                Auth::user()->role === 'admin' ||
                Auth::user()->role === 'teacher'
            )

                <a
                    href="{{ route('schedules.create', $class) }}"
                    class="btn btn-primary"
                >
                    + Tambah Jadwal
                </a>

            @endif

        </div>

    </div>

@endif

@endsection