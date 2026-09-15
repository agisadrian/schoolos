@extends('layouts.app')

@section('title', 'Tambah Jadwal - ' . $class->name)

@section('page-title', 'Tambah Jadwal')

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
                Tambah Jadwal
            </h2>

            <p class="text-muted mb-0">
                Tambahkan jadwal pelajaran untuk kelas ini.
            </p>

        </div>


        <!-- FORM -->

        <div class="card">

            <div class="card-body p-4 p-lg-5">

                <form
                    action="{{ route('schedules.store', $class) }}"
                    method="POST"
                >

                    @csrf


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
                            class="form-select @error('day') is-invalid @enderror"
                            required
                        >

                            <option value="">
                                Pilih Hari
                            </option>

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
                                    {{ old('day') === $day ? 'selected' : '' }}
                                >
                                    {{ $day }}
                                </option>

                            @endforeach

                        </select>

                        @error('day')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror

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
                            class="form-select @error('subject_id') is-invalid @enderror"
                            required
                        >

                            <option value="">
                                Pilih Mata Pelajaran
                            </option>

                            @foreach($subjects as $subject)

                                <option
                                    value="{{ $subject->id }}"
                                    {{ old('subject_id') == $subject->id ? 'selected' : '' }}
                                >
                                    {{ $subject->name }}

                                    @if($subject->code)
                                        ({{ $subject->code }})
                                    @endif

                                </option>

                            @endforeach

                        </select>

                        @error('subject_id')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror

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
                            class="form-select @error('teacher_id') is-invalid @enderror"
                        >

                            <option value="">
                                Pilih Guru
                            </option>

                            @foreach($teachers as $teacher)

                                <option
                                    value="{{ $teacher->id }}"
                                    {{ old('teacher_id') == $teacher->id ? 'selected' : '' }}
                                >
                                    {{ $teacher->name }}

                                    @if($teacher->email)
                                        - {{ $teacher->email }}
                                    @endif

                                </option>

                            @endforeach

                        </select>

                        @error('teacher_id')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror

                        <div class="form-text">
                            Guru diambil dari akun yang memiliki role teacher.
                        </div>

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
                                class="form-control @error('start_time') is-invalid @enderror"
                                value="{{ old('start_time') }}"
                                required
                            >

                            @error('start_time')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror

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
                                class="form-control @error('end_time') is-invalid @enderror"
                                value="{{ old('end_time') }}"
                                required
                            >

                            @error('end_time')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror

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
                            class="form-control @error('room') is-invalid @enderror"
                            value="{{ old('room') }}"
                            placeholder="Contoh: Lab Komputer 1"
                        >

                        @error('room')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror

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
                            class="form-control @error('notes') is-invalid @enderror"
                            rows="4"
                            placeholder="Catatan tambahan jika diperlukan..."
                        >{{ old('notes') }}</textarea>

                        @error('notes')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror

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
                            Simpan Jadwal
                        </button>

                    </div>

                </form>

            </div>

        </div>

    </div>

</div>

@endsection