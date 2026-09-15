<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Tambah Mata Pelajaran - SchoolOS</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"
        rel="stylesheet"
    >

</head>

<body style="background:#f5f7fb">

<div class="container py-5">

    <div
        class="card border-0 shadow-sm mx-auto p-4"
        style="max-width:600px"
    >

        <h2 class="fw-bold">
            Tambah Mata Pelajaran
        </h2>

        <p class="text-muted">
            {{ $class->name }}
        </p>


        @if($errors->any())

            <div class="alert alert-danger">

                <ul class="mb-0">

                    @foreach($errors->all() as $error)

                        <li>
                            {{ $error }}
                        </li>

                    @endforeach

                </ul>

            </div>

        @endif


        <form
            action="{{ route('subjects.store', $class) }}"
            method="POST"
        >

            @csrf


            <div class="mb-3">

                <label class="form-label">
                    Nama Mata Pelajaran
                </label>

                <input
                    type="text"
                    name="name"
                    class="form-control"
                    placeholder="Contoh: Matematika"
                    value="{{ old('name') }}"
                    required
                >

            </div>


            <div class="mb-3">

                <label class="form-label">
                    Kode Mata Pelajaran
                </label>

                <input
                    type="text"
                    name="code"
                    class="form-control"
                    placeholder="Contoh: MTK"
                    value="{{ old('code') }}"
                >

            </div>


            <div class="mb-4">

                <label class="form-label">
                    Deskripsi
                </label>

                <textarea
                    name="description"
                    class="form-control"
                    rows="4"
                    placeholder="Deskripsi mata pelajaran..."
                >{{ old('description') }}</textarea>

            </div>


            <div class="d-flex gap-2">

                <a
                    href="{{ route('subjects.index', $class) }}"
                    class="btn btn-outline-secondary"
                >
                    Kembali
                </a>

                <button class="btn btn-dark">
                    Simpan Mata Pelajaran
                </button>

            </div>

        </form>

    </div>

</div>

</body>

</html>