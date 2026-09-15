@extends('layouts.app')

@section('title', 'Kelola User')

@section('page-title', 'Kelola User')

@section('content')

<div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">

    <div>

        <h2 class="fw-bold mb-1">
            Kelola User
        </h2>

        <p class="text-muted mb-0">
            Kelola akun siswa, guru, dan admin di SchoolOS.
        </p>

    </div>

    <a
        href="{{ route('users.create') }}"
        class="btn btn-primary"
    >
        + Tambah User
    </a>

</div>


@if(session('success'))

    <div class="alert alert-success">
        {{ session('success') }}
    </div>

@endif

@if($errors->any())

    <div class="alert alert-danger">
        {{ $errors->first() }}
    </div>

@endif


<!-- FILTER -->

<div class="card mb-4">

    <div class="card-body p-4">

        <form
            action="{{ route('users.index') }}"
            method="GET"
        >

            <div class="row g-3">

                <div class="col-lg-7">

                    <label
                        for="search"
                        class="form-label fw-semibold"
                    >
                        Cari User
                    </label>

                    <div class="input-group">

                        <span class="input-group-text bg-white">
                            <i class="bi bi-search"></i>
                        </span>

                        <input
                            type="text"
                            id="search"
                            name="search"
                            class="form-control"
                            placeholder="Nama atau email..."
                            value="{{ request('search') }}"
                        >

                    </div>

                </div>


                <div class="col-lg-3">

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
                    >

                        <option value="">
                            Semua Role
                        </option>

                        <option
                            value="student"
                            {{ request('role') === 'student' ? 'selected' : '' }}
                        >
                            Siswa
                        </option>

                        <option
                            value="teacher"
                            {{ request('role') === 'teacher' ? 'selected' : '' }}
                        >
                            Guru
                        </option>

                        <option
                            value="admin"
                            {{ request('role') === 'admin' ? 'selected' : '' }}
                        >
                            Admin
                        </option>

                    </select>

                </div>


                <div class="col-lg-2 d-flex align-items-end">

                    <button
                        type="submit"
                        class="btn btn-dark w-100"
                    >
                        Terapkan
                    </button>

                </div>

            </div>

        </form>

    </div>

</div>


<!-- USER LIST -->

<div class="card">

    <div class="card-body p-0">

        @if($users->count() > 0)

            <div class="table-responsive">

                <table class="table table-hover align-middle mb-0">

                    <thead class="table-light">

                        <tr>

                            <th class="px-4 py-3">
                                User
                            </th>

                            <th>
                                Email
                            </th>

                            <th>
                                Role
                            </th>

                            <th class="text-end px-4">
                                Aksi
                            </th>

                        </tr>

                    </thead>


                    <tbody>

                        @foreach($users as $user)

                            <tr>

                                <td class="px-4">

                                    <div class="d-flex align-items-center gap-3">

                                        <div
                                            class="rounded-circle d-flex align-items-center justify-content-center"
                                            style="width: 42px; height: 42px; background: #eef2ff; color: #4f46e5; font-weight: 700; flex-shrink: 0;"
                                        >
                                            {{
                                                strtoupper(
                                                    substr(
                                                        $user->name,
                                                        0,
                                                        1
                                                    )
                                                )
                                            }}
                                        </div>


                                        <div>

                                            <div class="fw-semibold">
                                                {{ $user->name }}
                                            </div>

                                            <div class="text-muted small">
                                                Akun SchoolOS
                                            </div>

                                        </div>

                                    </div>

                                </td>


                                <td>

                                    <span class="text-muted">
                                        {{ $user->email }}
                                    </span>

                                </td>


                                <td>

                                    @if($user->role === 'student')

                                        <span class="badge rounded-pill bg-primary">
                                            Siswa
                                        </span>

                                    @elseif($user->role === 'teacher')

                                        <span class="badge rounded-pill bg-success">
                                            Guru
                                        </span>

                                    @else

                                        <span class="badge rounded-pill bg-dark">
                                            Admin
                                        </span>

                                    @endif

                                </td>


                                <td class="text-end px-4">

                                    <div class="d-flex justify-content-end gap-2">

                                        <a
                                            href="{{ route('users.edit', $user) }}"
                                            class="btn btn-sm btn-outline-secondary"
                                        >
                                            Edit
                                        </a>

                                        <form
                                            action="{{ route('users.destroy', $user) }}"
                                            method="POST"
                                            onsubmit="return confirm('Hapus user ini?')"
                                        >

                                            @csrf

                                            @method('DELETE')

                                            <button
                                                type="submit"
                                                class="btn btn-sm btn-outline-danger"
                                                {{ $user->id === auth()->id() ? 'disabled' : '' }}
                                            >
                                                Hapus
                                            </button>

                                        </form>

                                    </div>

                                </td>

                            </tr>

                        @endforeach

                    </tbody>

                </table>

            </div>


            <div class="p-4">
                {{ $users->links() }}
            </div>

        @else

            <div class="text-center py-5 px-4">

                <div
                    class="mb-3"
                    style="font-size: 55px;"
                >
                    <i class="bi bi-person-fill"></i>
                </div>

                <h5 class="fw-bold mb-2">
                    Belum ada user
                </h5>

                <p class="text-muted mb-4">
                    Belum ada user yang cocok dengan pencarian ini.
                </p>

                <a
                    href="{{ route('users.create') }}"
                    class="btn btn-primary"
                >
                    + Tambah User
                </a>

            </div>

        @endif

    </div>

</div>

@endsection
