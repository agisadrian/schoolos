<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Reset Password - SchoolOS Class</title>

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
            min-height: 100vh;
            background: #f5f7fb;
        }

        .login-wrapper {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .login-card {
            width: 100%;
            max-width: 430px;
            border: none;
            border-radius: 20px;
        }

        .logo {
            font-size: 52px;
        }

    </style>

</head>

<body>

<div class="login-wrapper">

    <div class="card login-card shadow-sm p-4">

        <div class="text-center mb-4">

            <div class="logo">
                <i class="bi bi-shield-lock-fill"></i>
            </div>

            <h2 class="fw-bold mt-2">
                Reset Password
            </h2>

            <p class="text-muted mb-0">
                Masukkan password baru untuk akun kamu.
            </p>

        </div>


        @if($errors->any())

            <div class="alert alert-danger">

                @foreach($errors->all() as $error)

                    <div>
                        {{ $error }}
                    </div>

                @endforeach

            </div>

        @endif


        <form
            action="{{ route('password.update') }}"
            method="POST"
        >

            @csrf

            <input
                type="hidden"
                name="token"
                value="{{ $token }}"
            >

            <div class="mb-3">

                <label class="form-label fw-semibold">
                    Email
                </label>

                <input
                    type="email"
                    name="email"
                    class="form-control form-control-lg"
                    value="{{ old('email', $email) }}"
                    placeholder="nama@email.com"
                    required
                    autofocus
                >

            </div>


            <div class="mb-3">

                <label class="form-label fw-semibold">
                    Password Baru
                </label>

                <input
                    type="password"
                    name="password"
                    class="form-control form-control-lg"
                    placeholder="Minimal 8 karakter"
                    required
                >

            </div>


            <div class="mb-4">

                <label class="form-label fw-semibold">
                    Konfirmasi Password Baru
                </label>

                <input
                    type="password"
                    name="password_confirmation"
                    class="form-control form-control-lg"
                    placeholder="Ulangi password baru"
                    required
                >

            </div>


            <button
                type="submit"
                class="btn btn-primary btn-lg w-100"
            >
                Reset Password
            </button>

        </form>


        <div class="text-center mt-4">

            <small class="text-muted">
                <a href="{{ route('login') }}">
                    <i class="bi bi-arrow-left me-1"></i>
                    Kembali ke Login
                </a>
            </small>

        </div>


        <div class="text-center mt-2">

            <small class="text-muted">
                SchoolOS Class
            </small>

        </div>

    </div>

</div>

</body>

</html>
