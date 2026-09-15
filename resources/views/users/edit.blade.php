@extends('layouts.app')

@section('title', 'Edit User')

@section('page-title', 'Edit User')

@section('content')

<div class="row justify-content-center">

    <div class="col-xl-7">

        <div class="mb-4">

            <a
                href="{{ route('users.index') }}"
                class="text-decoration-none"
            >
                ← Kembali ke User
            </a>

        </div>


        <div class="card">

            <div class="card-body p-4 p-lg-5">

                <div class="d-flex align-items-center gap-3 mb-4">

                    <div
                        class="rounded-circle d-flex align-items-center justify-content-center"
                        style="
                            width: 58px;
                            height: 58px;
                            background: #eef2ff;
                            color: #4f46e5;
                            font-size: 22px;
                            font-weight: 700;
                        "
                    >
                        {{ strtoupper(substr($user->name, 0, 1)) }}
                    </div>

                    <div>

                        <h3 class="fw-bold mb-1">
                            Edit User
                        </h3>

                        <p class="text-muted mb-0">
                            Perbarui informasi akun
                            {{ $user->name }}.
                        </p>

                    </div>

                </div>


                @if($errors->any())

                    <div class="alert alert-danger">

                        <strong>
                            Ada data yang perlu diperbaiki:
                        </strong>

                        <ul class="mb-0 mt-2">

                            @foreach($errors->all() as $error)

                                <li>
                                    {{ $error }}
                                </li>

                            @endforeach

                        </ul>

                    </div>

                @endif


                <form
                    action="{{ route(
                        'users.update',
                        $user
                    ) }}"
                    method="POST"
                >

                    @csrf

                    @method('PUT')


                    <div class="mb-4">

                        <label
                            for="name"
                            class="form-label fw-semibold"
                        >
                            Nama Lengkap
                        </label>

                        <input
                            type="text"
                            name="name"
                            id="name"
                            class="form-control"
                            value="{{ old(
                                'name',
                                $user->name
                            ) }}"
                            required
                        >

                    </div>


                    <div class="mb-4">

                        <label
                            for="email"
                            class="form-label fw-semibold"
                        >
                            Email
                        </label>

                        <input
                            type="email"
                            name="email"
                            id="email"
                            class="form-control"
                            value="{{ old(
                                'email',
                                $user->email
                            ) }}"
                            required
                        >

                    </div>


                    <div class="mb-4">

                        <label
                            for="role"
                            class="form-label fw-semibold"
                        >
                            Role
                        </label>

                        <select
                            name="role"
                            id="role"
                            class="form-select"
                            required
                        >

                            <option
                                value="student"
                                {{
                                    old(
                                        'role',
                                        $user->role
                                    ) === 'student'
                                    ? 'selected'
                                    : ''
                                }}
                            >
                                Siswa
                            </option>

                            <option
                                value="teacher"
                                {{
                                    old(
                                        'role',
                                        $user->role
                                    ) === 'teacher'
                                    ? 'selected'
                                    : ''
                                }}
                            >
                                Guru
                            </option>

                            <option
                                value="admin"
                                {{
                                    old(
                                        'role',
                                        $user->role
                                    ) === 'admin'
                                    ? 'selected'
                                    : ''
                                }}
                            >
                                Admin
                            </option>

                        </select>

                    </div>


                    <div class="border rounded-4 p-4 mb-4">

                        <h6 class="fw-bold mb-1">
                            Ganti Password
                        </h6>

                        <p class="text-muted small mb-3">
                            Kosongkan jika password tidak ingin diubah.
                        </p>


                        <div class="row g-3">

                            <div class="col-md-6">

                                <label
                                    for="password"
                                    class="form-label fw-semibold"
                                >
                                    Password Baru
                                </label>

                                <input
                                    type="password"
                                    name="password"
                                    id="password"
                                    class="form-control"
                                    minlength="8"
                                >

                                <div class="form-text">
                                    Minimal 8 karakter.
                                </div>

                            </div>


                            <div class="col-md-6">

                                <label
                                    for="password_confirmation"
                                    class="form-label fw-semibold"
                                >
                                    Konfirmasi Password
                                </label>

                                <input
                                    type="password"
                                    name="password_confirmation"
                                    id="password_confirmation"
                                    class="form-control"
                                    minlength="8"
                                >

                            </div>

                        </div>

                    </div>


                    @if($user->id === Auth::id())

                        <div class="alert alert-warning">

                            <strong>Perhatian:</strong>

                            Ini adalah akun yang sedang digunakan.
                            Jika role diubah, hak akses akun juga akan
                            berubah.

                        </div>

                    @endif


                    <div
                        class="d-flex flex-column flex-sm-row justify-content-end gap-2"
                    >

                        <a
                            href="{{ route('users.index') }}"
                            class="btn btn-light border"
                        >
                            Batal
                        </a>


                        <button
                            type="submit"
                            class="btn btn-primary"
                        >
                            Simpan Perubahan
                        </button>

                    </div>

                </form>

            </div>

        </div>

    </div>

</div>

@endsection