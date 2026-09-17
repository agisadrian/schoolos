@extends('layouts.app')

@section('title', 'Edit Pengumuman - ' . $class->name)

@section('page-title', 'Edit Pengumuman')


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
                    Edit Pengumuman
                </h2>

                <p class="text-muted mb-0">
                    Perbarui informasi pengumuman ini.
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
                            'announcements.update',
                            [$class, $announcement]
                        ) }}"
                        method="POST"
                    >

                        @csrf
                        @method('PUT')


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
                                value="{{ old('title', $announcement->title) }}"
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
                                required
                            >{{ old('content', $announcement->content) }}</textarea>

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
                                    'announcements.show',
                                    [$class, $announcement]
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

@endsection
