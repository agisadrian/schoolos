@extends('layouts.app')

@section('title', 'Tambah User')

@section('page-title', 'Tambah User')

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

                <div class="mb-4">

                    <h3 class="fw-bold mb-1">
                        Buat Akun Baru
                    </h3>

                    <p class="text-muted mb-0">
                        Tambahkan akun siswa, guru,
                        atau admin ke SchoolOS.
                    </p>

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
                    action="{{ route('users.store') }}"
                    method="POST"
                >

                    @csrf


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
                            value="{{ old('name') }}"
                            placeholder="Contoh: Agis Adrian"
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
                            value="{{ old('email') }}"
                            placeholder="nama@email.com"
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

                            <option value="">
                                Pilih Role
                            </option>

                            <option
                                value="student"
                                {{ old('role') === 'student' ? 'selected' : '' }}
                            >
                                Siswa
                            </option>

                            <option
                                value="teacher"
                                {{ old('role') === 'teacher' ? 'selected' : '' }}
                            >
                                Guru
                            </option>

                            <option
                                value="admin"
                                {{ old('role') === 'admin' ? 'selected' : '' }}
                            >
                                Admin
                            </option>

                        </select>


                        <div class="form-text">

                            <strong>Siswa</strong> untuk akun peserta didik.

                            <br>

                            <strong>Guru</strong> untuk akun pengajar.

                            <br>

                            <strong>Admin</strong> untuk pengelola SchoolOS.

                        </div>

                    </div>


                    <div class="row g-3 mb-4">

                        <div class="col-md-6">

                            <label
                                for="password"
                                class="form-label fw-semibold"
                            >
                                Password
                            </label>

                            <input
                                type="password"
                                name="password"
                                id="password"
                                class="form-control"
                                minlength="8"
                                required
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
                                required
                            >

                        </div>

                    </div>


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
                            <i class="bi bi-save-fill"></i> Buat Akun
                        </button>

                    </div>

                </form>

            </div>

        </div>

    </div>

</div>

@endsection