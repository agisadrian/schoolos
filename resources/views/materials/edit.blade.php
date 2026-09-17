@extends('layouts.app')

@section('title', 'Edit Materi - ' . $class->name)

@section('page-title', 'Edit Materi')


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
                    Edit Materi
                </h2>

                <p class="text-muted mb-0">
                    Perbarui informasi materi ini.
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
                            'materials.update',
                            [$class, $material]
                        ) }}"
                        method="POST"
                        enctype="multipart/form-data"
                    >

                        @csrf
                        @method('PUT')


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

                                @foreach($subjects as $subject)

                                    <option
                                        value="{{ $subject->id }}"
                                        {{ old('subject_id', $material->subject_id) == $subject->id
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
                                value="{{ old('title', $material->title) }}"
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
                            >{{ old('description', $material->description) }}</textarea>

                        </div>


                        <!-- CURRENT FILE -->

                        <div class="mb-4">

                            <label class="form-label fw-semibold">
                                File Saat Ini
                            </label>

                            <div class="alert alert-light border d-flex align-items-center gap-2 mb-0">
                                <i class="bi bi-file-earmark-text-fill"></i>
                                <span>{{ $material->file_name }}</span>
                            </div>

                        </div>


                        <!-- FILE -->

                        <div class="mb-4">

                            <label
                                for="file"
                                class="form-label fw-semibold"
                            >
                                Ganti File (opsional)
                            </label>

                            <input
                                type="file"
                                class="form-control"
                                id="file"
                                name="file"
                                accept=".pdf,.doc,.docx,.ppt,.pptx,.xls,.xlsx,.zip"
                            >

                            <div class="form-text">
                                Biarkan kosong kalau tidak mau
                                mengganti file. Format yang
                                didukung: PDF, DOC, DOCX, PPT,
                                PPTX, XLS, XLSX, ZIP. Maksimal
                                10 MB.
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
                                    'materials.show',
                                    [$class, $material]
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
                                <i class="bi bi-check-lg"></i> Simpan Perubahan
                            </button>

                        </div>

                    </form>

                </div>

            </div>

        </div>

    </div>

@endsection
