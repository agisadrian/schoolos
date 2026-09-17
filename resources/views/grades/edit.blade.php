@extends('layouts.app')

@section('title', 'Edit Nilai - ' . $class->name)

@section('page-title', 'Edit Nilai')


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
                    Edit Nilai
                </h2>

                <p class="text-muted mb-0">
                    {{ $grade->student->name }}
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
                        action="{{ route(
                            'grades.update',
                            [$class, $grade]
                        ) }}"
                        method="POST"
                    >

                        @csrf
                        @method('PUT')


                        <!-- STUDENT (read-only info) -->

                        <div class="mb-4">

                            <label class="form-label fw-semibold">
                                Siswa
                            </label>

                            <input
                                type="text"
                                class="form-control"
                                value="{{ $grade->student->name }} · {{ $grade->student->email }}"
                                disabled
                            >

                            <div class="form-text">
                                Siswa tidak bisa diubah. Kalau
                                salah siswa, hapus nilai ini
                                lalu buat baru.
                            </div>

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
                                        {{
                                            old('subject_id', $grade->subject_id)
                                                == $subject->id
                                                ? 'selected'
                                                : ''
                                        }}
                                    >

                                        {{ $subject->name }}

                                        @if($subject->code)
                                            ({{ $subject->code }})
                                        @endif

                                    </option>

                                @endforeach

                            </select>

                        </div>


                        <!-- TITLE -->

                        <div class="mb-4">

                            <label
                                for="title"
                                class="form-label fw-semibold"
                            >
                                Nama Penilaian
                            </label>

                            <input
                                type="text"
                                name="title"
                                id="title"
                                class="form-control"
                                value="{{ old('title', $grade->title) }}"
                                required
                            >

                        </div>


                        <!-- SCORE -->

                        <div class="row g-3 mb-4">

                            <div class="col-md-6">

                                <label
                                    for="score"
                                    class="form-label fw-semibold"
                                >
                                    Nilai
                                </label>

                                <input
                                    type="number"
                                    name="score"
                                    id="score"
                                    class="form-control"
                                    value="{{ old('score', $grade->score) }}"
                                    min="0"
                                    step="0.01"
                                    required
                                >

                            </div>


                            <div class="col-md-6">

                                <label
                                    for="max_score"
                                    class="form-label fw-semibold"
                                >
                                    Nilai Maksimal
                                </label>

                                <input
                                    type="number"
                                    name="max_score"
                                    id="max_score"
                                    class="form-control"
                                    value="{{ old('max_score', $grade->max_score) }}"
                                    min="1"
                                    step="0.01"
                                    required
                                >

                            </div>

                        </div>


                        <!-- SCORE PREVIEW -->

                        <div
                            class="alert alert-light border mb-4"
                            id="scorePreview"
                        >

                            <div class="d-flex justify-content-between align-items-center">

                                <span class="text-muted">
                                    Persentase Nilai
                                </span>

                                <strong id="percentageText">
                                    0%
                                </strong>

                            </div>

                            <div class="progress mt-2" style="height: 8px;">
                                <div
                                    id="percentageBar"
                                    class="progress-bar"
                                    style="width: 0%;"
                                ></div>
                            </div>

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
                            >{{ old('notes', $grade->notes) }}</textarea>

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
                                href="{{ route(
                                    'grades.show',
                                    [$class, $grade]
                                ) }}"
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


    @push('scripts')

        <script>

            const scoreInput = document.getElementById('score');
            const maxScoreInput = document.getElementById('max_score');
            const percentageText = document.getElementById('percentageText');
            const percentageBar = document.getElementById('percentageBar');

            function updatePercentage()
            {
                const score = parseFloat(scoreInput.value) || 0;
                const maxScore = parseFloat(maxScoreInput.value) || 0;

                if (maxScore <= 0) {
                    percentageText.textContent = '0%';
                    percentageBar.style.width = '0%';
                    return;
                }

                const percentage = (score / maxScore) * 100;
                const safePercentage = Math.max(0, Math.min(percentage, 100));

                percentageText.textContent = safePercentage.toFixed(1) + '%';
                percentageBar.style.width = safePercentage + '%';
            }

            scoreInput.addEventListener('input', updatePercentage);
            maxScoreInput.addEventListener('input', updatePercentage);

            updatePercentage();

        </script>

    @endpush

@endsection
