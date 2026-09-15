@extends('layouts.app')

@section('title', 'Tambah Materi - ' . $class->name)

@section('page-title', 'Tambah Materi')


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
                    Tambah Materi
                </h2>

                <p class="text-muted mb-0">
                    Bagikan materi pembelajaran
                    kepada anggota kelas.
                </p>

            </div>


            <!-- FORM -->

            <div class="card">

                <div class="card-body p-4 p-lg-5">

                    <form
                        action="{{ route(
                            'materials.store',
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
                                        {{ old('subject_id') == $subject->id
                                            ? 'selected'
                                            : '' }}
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
                                Judul Materi
                            </label>

                            <input
                                type="text"
                                class="form-control"
                                id="title"
                                name="title"
                                value="{{ old('title') }}"
                                placeholder="Contoh: Materi HTML Dasar"
                                required
                            >

                        </div>


                        <!-- DESCRIPTION -->

                        <div class="mb-4">

                            <label
                                for="description"
                                class="form-label fw-semibold"
                            >
                                Deskripsi
                            </label>

                            <textarea
                                class="form-control"
                                id="description"
                                name="description"
                                rows="5"
                                placeholder="Jelaskan secara singkat isi materi..."
                            >{{ old('description') }}</textarea>

                        </div>


                        <!-- FILE -->

                        <div class="mb-4">

                            <label
                                for="file"
                                class="form-label fw-semibold"
                            >
                                File Materi
                            </label>

                            <input
                                type="file"
                                class="form-control"
                                id="file"
                                name="file"
                                accept=".pdf,.doc,.docx,.ppt,.pptx,.xls,.xlsx,.zip"
                                required
                            >


                            <div class="form-text">

                                Format yang didukung:
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
                                    'materials.index',
                                    $class
                                ) }}"
                                class="btn btn-light
                                       border"
                            >
                                Batal
                            </a>


                            <button
                                type="submit"
                                class="btn btn-primary"
                            >
                                Upload Materi
                            </button>

                        </div>

                    </form>

                </div>

            </div>

        </div>

    </div>

@endsection