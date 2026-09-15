<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Gabung Kelas - SchoolOS</title>

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
         style="max-width:500px">

        <h2 class="fw-bold">
            Gabung Kelas
        </h2>

        <p class="text-muted">
            Masukkan kode kelas yang diberikan guru atau admin.
        </p>

        @if ($errors->any())
            <div class="alert alert-danger">
                {{ $errors->first() }}
            </div>
        @endif

        <form
            action="{{ route('classes.join.store') }}"
            method="POST"
        >

            @csrf

            <div class="mb-4">

                <label class="form-label">
                    Kode Kelas
                </label>

                <input
                    type="text"
                    name="code"
                    class="form-control text-uppercase"
                    placeholder="Contoh: A1B2C3"
                    maxlength="6"
                    required
                >

            </div>

            <div class="d-flex gap-2">

                <a
                    href="{{ route('classes.index') }}"
                    class="btn btn-outline-secondary"
                >
                    Kembali
                </a>

                <button class="btn btn-dark">
                    Gabung Kelas
                </button>

            </div>

        </form>

    </div>

</div>

</body>
</html>