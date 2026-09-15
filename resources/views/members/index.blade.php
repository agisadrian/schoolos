@extends('layouts.app')

@section('title', 'Anggota - ' . $class->name)

@section('page-title', 'Anggota Kelas')

@section('content')

<div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">

    <div>

        <div class="text-muted small mb-1">
            {{ $class->name }} · {{ $class->code }}
        </div>

        <h2 class="fw-bold mb-1">
            Anggota Kelas
        </h2>

        <p class="text-muted mb-0">
            Kelola siswa, guru, dan admin yang tergabung
            dalam kelas ini.
        </p>

    </div>


    @if(Auth::user()->role === 'admin')

        <button
            type="button"
            class="btn btn-primary"
            data-bs-toggle="modal"
            data-bs-target="#addMemberModal"
        >
            + Tambah Anggota
        </button>

    @endif

</div>


<!-- STATISTICS -->

<div class="row g-3 mb-4">

    <div class="col-md-4">

        <div class="card h-100">

            <div class="card-body p-4">

                <div class="d-flex align-items-center gap-3">

                    <div
                        class="rounded-4 d-flex align-items-center justify-content-center"
                        style="width: 55px; height: 55px; background: #eef2ff; font-size: 25px;"
                    >
                        <i class="bi bi-people-fill"></i>
                    </div>

                    <div>

                        <div class="text-muted small">
                            Total Anggota
                        </div>

                        <div class="fw-bold fs-3">
                            {{ $members->count() }}
                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>


    <div class="col-md-4">

        <div class="card h-100">

            <div class="card-body p-4">

                <div class="d-flex align-items-center gap-3">

                    <div
                        class="rounded-4 d-flex align-items-center justify-content-center"
                        style="width: 55px; height: 55px; background: #ecfdf5; font-size: 25px;"
                    >
                        <i class="bi bi-mortarboard-fill"></i>
                    </div>

                    <div>

                        <div class="text-muted small">
                            Siswa
                        </div>

                        <div class="fw-bold fs-3">
                            {{ $members->where('role', 'student')->count() }}
                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>


    <div class="col-md-4">

        <div class="card h-100">

            <div class="card-body p-4">

                <div class="d-flex align-items-center gap-3">

                    <div
                        class="rounded-4 d-flex align-items-center justify-content-center"
                        style="width: 55px; height: 55px; background: #fff7ed; font-size: 25px;"
                    >
                        <i class="bi bi-person-badge-fill"></i>
                    </div>

                    <div>

                        <div class="text-muted small">
                            Guru / Admin
                        </div>

                        <div class="fw-bold fs-3">
                            {{
                                $members->whereIn(
                                    'role',
                                    ['teacher', 'admin']
                                )->count()
                            }}
                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>


<!-- MEMBER LIST -->

<div class="card">

    <div class="card-body p-0">

        @if($members->count() > 0)

            <div class="table-responsive">

                <table class="table table-hover align-middle mb-0">

                    <thead class="table-light">

                        <tr>

                            <th class="px-4 py-3">
                                Anggota
                            </th>

                            <th>
                                Email
                            </th>

                            <th>
                                Role Kelas
                            </th>

                            @if(Auth::user()->role === 'admin')
                                <th class="text-end px-4">
                                    Aksi
                                </th>
                            @endif

                        </tr>

                    </thead>


                    <tbody>

                        @foreach($members as $member)

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
                                                        $member->user->name,
                                                        0,
                                                        1
                                                    )
                                                )
                                            }}
                                        </div>


                                        <div>

                                            <div class="fw-semibold">
                                                {{ $member->user->name }}
                                            </div>

                                            <div class="text-muted small">
                                                Akun SchoolOS
                                            </div>

                                        </div>

                                    </div>

                                </td>


                                <td>

                                    <span class="text-muted">
                                        {{ $member->user->email }}
                                    </span>

                                </td>


                                <td>

                                    @if($member->role === 'student')

                                        <span class="badge rounded-pill bg-primary">
                                            Siswa
                                        </span>

                                    @elseif($member->role === 'teacher')

                                        <span class="badge rounded-pill bg-success">
                                            Guru
                                        </span>

                                    @else

                                        <span class="badge rounded-pill bg-dark">
                                            Admin
                                        </span>

                                    @endif

                                </td>


                                @if(Auth::user()->role === 'admin')

                                    <td class="text-end px-4">

                                        <form
                                            action="{{ route(
                                                'members.destroy',
                                                [
                                                    $class,
                                                    $member
                                                ]
                                            ) }}"
                                            method="POST"
                                            onsubmit="return confirm('Keluarkan anggota ini dari kelas?')"
                                        >

                                            @csrf

                                            @method('DELETE')

                                            <button
                                                type="submit"
                                                class="btn btn-sm btn-outline-danger"
                                            >
                                                Keluarkan
                                            </button>

                                        </form>

                                    </td>

                                @endif

                            </tr>

                        @endforeach

                    </tbody>

                </table>

            </div>

        @else

            <div class="text-center py-5 px-4">

                <div
                    class="mb-3"
                    style="font-size: 55px;"
                >
                    <i class="bi bi-people-fill"></i>
                </div>

                <h5 class="fw-bold mb-2">
                    Belum ada anggota
                </h5>

                <p class="text-muted mb-4">
                    Belum ada siswa, guru, atau admin
                    yang tergabung dalam kelas ini.
                </p>

                @if(Auth::user()->role === 'admin')

                    <button
                        type="button"
                        class="btn btn-primary"
                        data-bs-toggle="modal"
                        data-bs-target="#addMemberModal"
                    >
                        + Tambah Anggota
                    </button>

                @endif

            </div>

        @endif

    </div>

</div>


<!-- ADD MEMBER MODAL -->

@if(Auth::user()->role === 'admin')

<div
    class="modal fade"
    id="addMemberModal"
    tabindex="-1"
    aria-hidden="true"
>

    <div class="modal-dialog modal-dialog-centered">

        <div class="modal-content">

            <div class="modal-header">

                <div>

                    <h5 class="modal-title fw-bold">
                        Tambah Anggota
                    </h5>

                    <div class="text-muted small">
                        Tambahkan akun ke {{ $class->name }}
                    </div>

                </div>

                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal"
                ></button>

            </div>


            <form
                action="{{ route(
                    'members.store',
                    $class
                ) }}"
                method="POST"
            >

                @csrf


                <div class="modal-body">

                    @if($users->count() > 0)

                        <div class="mb-3">

                            <label
                                for="user_id"
                                class="form-label fw-semibold"
                            >
                                Pilih User
                            </label>

                            <select
                                name="user_id"
                                id="user_id"
                                class="form-select"
                                required
                            >

                                <option value="">
                                    Pilih user
                                </option>

                                @foreach($users as $user)

                                    <option
                                        value="{{ $user->id }}"
                                    >
                                        {{ $user->name }}
                                        ·
                                        {{ $user->email }}
                                    </option>

                                @endforeach

                            </select>

                        </div>


                        <div class="mb-2">

                            <label
                                for="role"
                                class="form-label fw-semibold"
                            >
                                Role di Kelas
                            </label>

                            <select
                                name="role"
                                id="role"
                                class="form-select"
                                required
                            >

                                <option value="student">
                                    Siswa
                                </option>

                                <option value="teacher">
                                    Guru
                                </option>

                                <option value="admin">
                                    Admin
                                </option>

                            </select>

                        </div>


                        <div class="alert alert-light border small mb-0 mt-3">

                            <strong>Catatan:</strong>

                            Role ini menentukan posisi user
                            di kelas ini. Role akun utama user
                            tetap tersimpan secara terpisah.

                        </div>

                    @else

                        <div class="text-center py-3">

                            <div
                                class="mb-2"
                                style="font-size: 40px;"
                            >
                                <i class="bi bi-person-fill"></i>
                            </div>

                            <h6 class="fw-bold">
                                Tidak ada user tersedia
                            </h6>

                            <p class="text-muted small mb-0">
                                Semua user yang tersedia
                                sudah menjadi anggota kelas.
                            </p>

                        </div>

                    @endif

                </div>


                <div class="modal-footer">

                    <button
                        type="button"
                        class="btn btn-light border"
                        data-bs-dismiss="modal"
                    >
                        Batal
                    </button>


                    @if($users->count() > 0)

                        <button
                            type="submit"
                            class="btn btn-primary"
                        >
                            Tambahkan
                        </button>

                    @endif

                </div>

            </form>

        </div>

    </div>

</div>

@endif

@endsection