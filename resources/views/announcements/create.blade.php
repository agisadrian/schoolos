@extends('layouts.app')

@section('title', 'Buat Pengumuman - ' . $class->name)

@section('page-title', 'Buat Pengumuman')


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
                    Buat Pengumuman
                </h2>

                <p class="text-muted mb-0">
                    Sampaikan informasi penting
                    kepada anggota kelas.
                </p>

            </div>


            <!-- FORM -->

            <div class="card">

                <div class="card-body p-4 p-lg-5">

                    <form
                        action="{{ route(
                            'announcements.store',
                            $class
                        ) }}"
                        method="POST"
                    >

                        @csrf


                        <!-- TITLE -->

                        <div class="mb-4">

                            <label
                                for="title"
                                class="form-label fw-semibold"
                            >
                                Judul Pengumuman
                            </label>

                            <input
                                type="text"
                                name="title"
                                id="title"
                                class="form-control"
                                value="{{ old('title') }}"
                                placeholder="Contoh: Perubahan Jadwal Ujian"
                                required
                            >

                        </div>


                        <!-- CONTENT -->

                        <div class="mb-4">

                            <label
                                for="content"
                                class="form-label fw-semibold"
                            >
                                Isi Pengumuman
                            </label>

                            <textarea
                                name="content"
                                id="content"
                                class="form-control"
                                rows="8"
                                placeholder="Tuliskan informasi pengumuman..."
                                required
                            >{{ old('content') }}</textarea>

                            <div class="form-text">
                                Tulis informasi dengan jelas
                                agar mudah dipahami siswa.
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
                                    'announcements.index',
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
                                <i class="bi bi-megaphone-fill"></i> Publikasikan
                            </button>

                        </div>

                    </form>

                </div>

            </div>

        </div>

    </div>

@endsection