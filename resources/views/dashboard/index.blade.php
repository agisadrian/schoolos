<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>SchoolOS Class</title>

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

        .navbar-brand {
            font-weight: 700;
        }

        .card {
            border: none;
            border-radius: 16px;
        }

        .welcome-card {
            background: #212529;
            color: white;
        }

        .section-title {
            font-weight: 700;
        }
    </style>
</head>

<body>

<nav class="navbar navbar-expand-lg bg-white shadow-sm">
    <div class="container">

        <a class="navbar-brand" href="{{ route('dashboard') }}">
            SchoolOS Class
        </a>

        <div class="d-flex align-items-center gap-3">

            <span class="text-muted">
                Halo, {{ Auth::user()->name }}
            </span>

            <form action="{{ route('logout') }}" method="POST">
                @csrf

                <button
                    type="submit"
                    class="btn btn-outline-danger btn-sm"
                >
                    Logout
                </button>
            </form>

        </div>

    </div>
</nav>

<main class="container py-4">

    {{-- Welcome --}}
    <div class="card welcome-card p-4 mb-4">

        <h2 class="fw-bold">
            Selamat datang di SchoolOS
        </h2>

        <p class="mb-0">
            Semua kebutuhan kelas dalam satu tempat.
        </p>

    </div>


    {{-- Statistik --}}
    <div class="row g-3 mb-4">

        <div class="col-md-3">
            <div class="card bg-white p-4">
                <small class="text-muted">
                    Pengumuman
                </small>

                <h2 class="fw-bold mt-2">
                    {{ $announcements->count() }}
                </h2>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card bg-white p-4">
                <small class="text-muted">
                    Tugas
                </small>

                <h2 class="fw-bold mt-2">
                    {{ $assignments->count() }}
                </h2>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card bg-white p-4">
                <small class="text-muted">
                    Materi
                </small>

                <h2 class="fw-bold mt-2">
                    {{ $materials->count() }}
                </h2>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card bg-white p-4">
                <small class="text-muted">
                    Jadwal
                </small>

                <h2 class="fw-bold mt-2">
                    {{ $schedules->count() }}
                </h2>
            </div>
        </div>

    </div>


    <div class="row g-4">

        {{-- Pengumuman --}}
        <div class="col-lg-6">

            <div class="card bg-white p-4">

                <h5 class="section-title mb-3">
                    <i class="bi bi-megaphone-fill"></i> Pengumuman
                </h5>

                @forelse($announcements as $announcement)

                    <div class="border-bottom py-3">

                        <h6 class="fw-bold mb-1">
                            {{ $announcement->title }}
                        </h6>

                        <p class="text-muted small mb-0">
                            {{ Str::limit($announcement->content, 100) }}
                        </p>

                    </div>

                @empty

                    <p class="text-muted mb-0">
                        Belum ada pengumuman.
                    </p>

                @endforelse

            </div>

        </div>


        {{-- Tugas --}}
        <div class="col-lg-6">

            <div class="card bg-white p-4">

                <h5 class="section-title mb-3">
                    <i class="bi bi-pencil-square"></i> Tugas Terdekat
                </h5>

                @forelse($assignments as $assignment)

                    <div class="border-bottom py-3">

                        <h6 class="fw-bold mb-1">
                            {{ $assignment->title }}
                        </h6>

                        <small class="text-muted">
                            Deadline:
                            {{ $assignment->deadline->format('d M Y H:i') }}
                        </small>

                    </div>

                @empty

                    <p class="text-muted mb-0">
                        Belum ada tugas.
                    </p>

                @endforelse

            </div>

        </div>


        {{-- Materi --}}
        <div class="col-lg-6">

            <div class="card bg-white p-4">

                <h5 class="section-title mb-3">
                    <i class="bi bi-journal-bookmark-fill"></i> Materi Terbaru
                </h5>

                @forelse($materials as $material)

                    <div class="border-bottom py-3">

                        <h6 class="fw-bold mb-1">
                            {{ $material->title }}
                        </h6>

                        <small class="text-muted">
                            {{ $material->file_name }}
                        </small>

                    </div>

                @empty

                    <p class="text-muted mb-0">
                        Belum ada materi.
                    </p>

                @endforelse

            </div>

        </div>


        {{-- Jadwal --}}
        <div class="col-lg-6">

            <div class="card bg-white p-4">

                <h5 class="section-title mb-3">
                    <i class="bi bi-calendar3"></i> Jadwal
                </h5>

                @forelse($schedules as $schedule)

                    <div class="border-bottom py-3">

                        <h6 class="fw-bold mb-1">
                            {{ $schedule->subject->name ?? 'Mata Pelajaran' }}
                        </h6>

                        <small class="text-muted">
                            {{ $schedule->day }}
                            ·
                            {{ $schedule->start_time }}
                            -
                            {{ $schedule->end_time }}
                        </small>

                    </div>

                @empty

                    <p class="text-muted mb-0">
                        Belum ada jadwal.
                    </p>

                @endforelse

            </div>

        </div>

    </div>

</main>

</body>
</html>