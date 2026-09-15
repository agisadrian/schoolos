<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Register - SchoolOS</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"
        rel="stylesheet"
    >

    <style>
        body {
            background: #f5f7fb;
        }

        .auth-card {
            max-width: 420px;
            margin: 60px auto;
            border: none;
            border-radius: 18px;
        }
    </style>
</head>

<body>

<div class="container">

    <div class="card auth-card shadow-sm p-4">

        <div class="text-center mb-4">

            <h2 class="fw-bold">
                Buat Akun
            </h2>

            <p class="text-muted mb-0">
                Daftar ke SchoolOS Class
            </p>

        </div>

        @if ($errors->any())
            <div class="alert alert-danger">

                <ul class="mb-0">

                    @foreach ($errors->all() as $error)

                        <li>
                            {{ $error }}
                        </li>

                    @endforeach

                </ul>

            </div>
        @endif

        <form action="{{ route('register') }}" method="POST">

            @csrf

            <div class="mb-3">

                <label class="form-label">
                    Nama
                </label>

                <input
                    type="text"
                    name="name"
                    class="form-control"
                    value="{{ old('name') }}"
                    required
                >

            </div>

            <div class="mb-3">

                <label class="form-label">
                    Email
                </label>

                <input
                    type="email"
                    name="email"
                    class="form-control"
                    value="{{ old('email') }}"
                    required
                >

            </div>

            <div class="mb-3">

                <label class="form-label">
                    Password
                </label>

                <input
                    type="password"
                    name="password"
                    class="form-control"
                    required
                >

                <small class="text-muted">
                    Minimal 8 karakter.
                </small>

            </div>

            <div class="mb-3">

                <label class="form-label">
                    Konfirmasi Password
                </label>

                <input
                    type="password"
                    name="password_confirmation"
                    class="form-control"
                    required
                >

            </div>

            <button class="btn btn-dark w-100">
                Register
            </button>

        </form>

        <div class="text-center mt-4">

            <span class="text-muted">
                Sudah punya akun?
            </span>

            <a href="{{ route('login') }}">
                Login
            </a>

        </div>

    </div>

</div>

</body>
</html>