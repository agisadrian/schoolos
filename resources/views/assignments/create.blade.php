@extends('layouts.app')

@section('title', 'Buat Tugas - ' . $class->name)

@section('page-title', 'Buat Tugas')


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
                    Buat Tugas
                </h2>

                <p class="text-muted mb-0">
                    Buat tugas baru untuk siswa
                    di kelas ini.
                </p>

            </div>


            <!-- FORM -->

            <div class="card">

                <div class="card-body p-4 p-lg-5">

                    <form
                        action="{{ route(
                            'assignments.store',
                            $class
                        ) }}"
                        method="POST"
                        enctype="multipart/form-data"
                    >

                        @csrf


                        <!-- SUBJECT -->

                        <div class="mb-4">

                            <label
                                for="subject_id"
                                class="form-label fw-semibold"
                            >
                                Mata Pelajaran
                            </label>

                            <select
                                class="form-select"
                                id="subject_id"
                                name="subject_id"
                                required
                            >

                                <option value="">
                                    Pilih Mata Pelajaran
                                </option>

                                @foreach($subjects as $subject)

                                    <option
                                        value="{{ $subject->id }}"
                                        {{
                                            old('subject_id')
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
                                Judul Tugas
                            </label>

                            <input
                                type="text"
                                class="form-control"
                                id="title"
                                name="title"
                                value="{{ old('title') }}"
                                placeholder="Contoh: Membuat Website Sederhana"
                                required
                            >

                        </div>


                        <!-- DESCRIPTION -->

                        <div class="mb-4">

                            <label
                                for="description"
                                class="form-label fw-semibold"
                            >
                                Deskripsi Tugas
                            </label>

                            <textarea
                                class="form-control"
                                id="description"
                                name="description"
                                rows="6"
                                placeholder="Jelaskan instruksi atau ketentuan tugas..."
                            >{{ old('description') }}</textarea>

                        </div>


                        <!-- DEADLINE -->

                        <div class="mb-4">

                            <label
                                for="deadline"
                                class="form-label fw-semibold"
                            >
                                Deadline
                            </label>

                            <input
                                type="datetime-local"
                                class="form-control"
                                id="deadline"
                                name="deadline"
                                value="{{ old('deadline') }}"
                                required
                            >

                            <div class="form-text">
                                Tentukan tanggal dan waktu
                                terakhir pengumpulan.
                            </div>

                        </div>


                        <!-- FILE -->

                        <div class="mb-4">

                            <label
                                for="file"
                                class="form-label fw-semibold"
                            >
                                File Tugas
                            </label>

                            <input
                                type="file"
                                class="form-control"
                                id="file"
                                name="file"
                                accept=".pdf,.doc,.docx,.ppt,.pptx,.xls,.xlsx,.zip"
                            >

                            <div class="form-text">

                                Opsional.

                                Format:
                                PDF, DOC, DOCX, PPT, PPTX,
                                XLS, XLSX, ZIP.

                                Maksimal 10 MB.

                            </div>

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
                                    'assignments.index',
                                    $class
                                ) }}"
                                class="btn btn-light border"
                            >
                                Batal
                            </a>


                            <button
                                type="submit"
                                class="btn btn-primary"
                            >
                                Buat Tugas
                            </button>

                        </div>

                    </form>

                </div>

            </div>

        </div>

    </div>

@endsection