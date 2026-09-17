<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Lupa Password - SchoolOS Class</title>

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
                <i class="bi bi-key-fill"></i>
            </div>

            <h2 class="fw-bold mt-2">
                Lupa Password
            </h2>

            <p class="text-muted mb-0">
                Masukkan email akun kamu, kami kirim link
                buat reset password.
            </p>

        </div>


        @if(session('success'))

            <div class="alert alert-success">
                {{ session('success') }}
            </div>

        @endif


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
            action="{{ route('password.email') }}"
            method="POST"
        >

            @csrf

            <div class="mb-4">

                <label class="form-label fw-semibold">
                    Email
                </label>

                <input
                    type="email"
                    name="email"
                    class="form-control form-control-lg"
                    value="{{ old('email') }}"
                    placeholder="nama@email.com"
                    required
                    autofocus
                >

            </div>


            <button
                type="submit"
                class="btn btn-primary btn-lg w-100"
            >
                Kirim Link Reset
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
