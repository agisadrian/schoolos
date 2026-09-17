@extends('layouts.app')

@section('title', 'Edit Jadwal - ' . $class->name)

@section('page-title', 'Edit Jadwal')

@section('content')

<div class="row justify-content-center">

    <div class="col-xl-8">

        <!-- HEADER -->

        <div class="mb-4">

            <div class="text-muted small mb-1">
                {{ $class->name }}
                ·
                {{ $class->code }}
            </div>

            <h2 class="fw-bold mb-1">
                Edit Jadwal
            </h2>

            <p class="text-muted mb-0">
                Perbarui jadwal pelajaran ini.
            </p>

        </div>


        @if($errors->any())

            <div class="alert alert-danger">

                @foreach($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach

            </div>

        @endif


        <!-- FORM -->

        <div class="card">

            <div class="card-body p-4 p-lg-5">

                <form
                    action="{{ route('schedules.update', [$class, $schedule]) }}"
                    method="POST"
                >

                    @csrf
                    @method('PUT')


                    <!-- DAY -->

                    <div class="mb-4">

                        <label
                            for="day"
                            class="form-label fw-semibold"
                        >
                            Hari
                        </label>

                        <select
                            name="day"
                            id="day"
                            class="form-select"
                            required
                        >

                            @foreach([
                                'Senin',
                                'Selasa',
                                'Rabu',
                                'Kamis',
                                'Jumat',
                                'Sabtu',
                                'Minggu'
                            ] as $day)

                                <option
                                    value="{{ $day }}"
                                    {{ old('day', $schedule->day) === $day ? 'selected' : '' }}
                                >
                                    {{ $day }}
                                </option>

                            @endforeach

                        </select>

                    </div>


                    <!-- SUBJECT -->

                    <div class="mb-4">

                        <label
                            for="subject_id"
                            class="form-label fw-semibold"
                        >
                            Mata Pelajaran
                        </label>

                        <select
                            name="subject_id"
                            id="subject_id"
                            class="form-select"
                            required
                        >

                            @foreach($subjects as $subject)

                                <option
                                    value="{{ $subject->id }}"
                                    {{ old('subject_id', $schedule->subject_id) == $subject->id ? 'selected' : '' }}
                                >
                                    {{ $subject->name }}

                                    @if($subject->code)
                                        ({{ $subject->code }})
                                    @endif

                                </option>

                            @endforeach

                        </select>

                    </div>


                    <!-- TEACHER -->

                    <div class="mb-4">

                        <label
                            for="teacher_id"
                            class="form-label fw-semibold"
                        >
                            Guru
                        </label>

                        <select
                            name="teacher_id"
                            id="teacher_id"
                            class="form-select"
                        >

                            <option value="">
                                Pilih Guru
                            </option>

                            @foreach($teachers as $teacher)

                                <option
                                    value="{{ $teacher->id }}"
                                    {{ old('teacher_id', $schedule->teacher_id) == $teacher->id ? 'selected' : '' }}
                                >
                                    {{ $teacher->name }}

                                    @if($teacher->email)
                                        - {{ $teacher->email }}
                                    @endif

                                </option>

                            @endforeach

                        </select>

                    </div>


                    <!-- START & END -->

                    <div class="row g-3 mb-4">

                        <div class="col-md-6">

                            <label
                                for="start_time"
                                class="form-label fw-semibold"
                            >
                                Jam Mulai
                            </label>

                            <input
                                type="time"
                                name="start_time"
                                id="start_time"
                                class="form-control"
                                value="{{ old('start_time', substr($schedule->start_time, 0, 5)) }}"
                                required
                            >

                        </div>


                        <div class="col-md-6">

                            <label
                                for="end_time"
                                class="form-label fw-semibold"
                            >
                                Jam Selesai
                            </label>

                            <input
                                type="time"
                                name="end_time"
                                id="end_time"
                                class="form-control"
                                value="{{ old('end_time', substr($schedule->end_time, 0, 5)) }}"
                                required
                            >

                        </div>

                    </div>


                    <!-- ROOM -->

                    <div class="mb-4">

                        <label
                            for="room"
                            class="form-label fw-semibold"
                        >
                            Ruangan
                        </label>

                        <input
                            type="text"
                            name="room"
                            id="room"
                            class="form-control"
                            value="{{ old('room', $schedule->room) }}"
                            placeholder="Contoh: Lab Komputer 1"
                        >

                    </div>


                    <!-- NOTES -->

                    <div class="mb-4">

                        <label
                            for="notes"
                            class="form-label fw-semibold"
                        >
                            Catatan
                        </label>

                        <textarea
                            name="notes"
                            id="notes"
                            class="form-control"
                            rows="4"
                        >{{ old('notes', $schedule->notes) }}</textarea>

                    </div>


                    <!-- ACTION -->

                    <div
                        class="d-flex
                               flex-column
                               flex-sm-row
                               justify-content-end
                               gap-2"
                    >

                        <a
                            href="{{ route('schedules.index', $class) }}"
                            class="btn btn-light border"
                        >
                            Batal
                        </a>

                        <button
                            type="submit"
                            class="btn btn-primary"
                        >
                            <i class="bi bi-check-lg"></i> Simpan Perubahan
                        </button>

                    </div>

                </form>

            </div>

        </div>

    </div>

</div>

@endsection
