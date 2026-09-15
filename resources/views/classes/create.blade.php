<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Buat Kelas - SchoolOS</title>

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

    <div class="card shadow-sm border-0 mx-auto p-4"
         style="max-width:600px">

        <h2 class="fw-bold">
            Buat Kelas
        </h2>

        <p class="text-muted">
            Buat ruang kelas baru untuk SchoolOS.
        </p>

        @if ($errors->any())
            <div class="alert alert-danger">
                {{ $errors->first() }}
            </div>
        @endif

        <form
            action="{{ route('classes.store') }}"
            method="POST"
        >

            @csrf

            <div class="mb-3">

                <label class="form-label">
                    Nama Kelas
                </label>

                <input
                    type="text"
                    name="name"
                    class="form-control"
                    placeholder="Contoh: XI RPL 1"
                    value="{{ old('name') }}"
                    required
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
                    placeholder="Deskripsi kelas..."
                >{{ old('description') }}</textarea>

            </div>

            <div class="d-flex gap-2">

                <a
                    href="{{ route('classes.index') }}"
                    class="btn btn-outline-secondary"
                >
                    Kembali
                </a>

                <button class="btn btn-dark">
                    Buat Kelas
                </button>

            </div>

        </form>

    </div>

</div>

</body>
</html>