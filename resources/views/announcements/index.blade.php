@extends('layouts.app')

@section('title', 'Pengumuman - ' . $class->name)

@section('page-title', 'Pengumuman')


@section('content')

    <!-- HEADER -->

    <div
        class="d-flex
               flex-column
               flex-md-row
               justify-content-between
               align-items-md-center
               gap-3
               mb-4"
    >

        <div>

            <div class="text-muted small mb-1">
                {{ $class->name }}
                ·
                {{ $class->code }}
            </div>

            <h2 class="fw-bold mb-1">
                Pengumuman
            </h2>

            <p class="text-muted mb-0">
                Informasi dan pengumuman penting
                untuk anggota kelas.
            </p>

        </div>


        @if(
            Auth::user()->role === 'admin' ||
            Auth::user()->role === 'teacher'
        )

            <a
                href="{{ route(
                    'announcements.create',
                    $class
                ) }}"
                class="btn btn-primary"
            >
                + Buat Pengumuman
            </a>

        @endif

    </div>


    <!-- TOTAL -->

    <div class="card mb-4">

        <div class="card-body p-4">

            <div
                class="d-flex
                       align-items-center
                       gap-3"
            >

                <div
                    class="rounded-4
                           d-flex
                           align-items-center
                           justify-content-center"
                    style="
                        width: 58px;
                        height: 58px;
                        background: #fff7ed;
                        font-size: 28px;
                    "
                >
                    <i class="bi bi-megaphone-fill"></i>
                </div>


                <div>

                    <div class="text-muted small">
                        Total Pengumuman
                    </div>

                    <div class="fw-bold fs-3">
                        {{ $announcements->count() }}
                    </div>

                </div>

            </div>

        </div>

    </div>


    <!-- ANNOUNCEMENTS -->

    @if($announcements->count() > 0)

        <div class="row g-4">

            @foreach($announcements as $announcement)

                <div class="col-12">

                    <div class="card menu-card">

                        <div class="card-body p-4">


                            <div
                                class="d-flex
                                       flex-column
                                       flex-md-row
                                       align-items-md-start
                                       gap-3"
                            >


                                <!-- ICON -->

                                <div
                                    class="rounded-4
                                           d-flex
                                           align-items-center
                                           justify-content-center"
                                    style="
                                        width: 55px;
                                        height: 55px;
                                        background: #fff7ed;
                                        font-size: 26px;
                                        flex-shrink: 0;
                                    "
                                >
                                    <i class="bi bi-megaphone-fill"></i>
                                </div>


                                <!-- CONTENT -->

                                <div class="flex-grow-1">

                                    <div
                                        class="d-flex
                                               flex-wrap
                                               align-items-center
                                               gap-2
                                               mb-2"
                                    >

                                        <h5
                                            class="fw-bold
                                                   mb-0"
                                        >
                                            {{ $announcement->title }}
                                        </h5>


                                        @if(
                                            $announcement->created_at
                                                ->isToday()
                                        )

                                            <span
                                                class="badge
                                                       rounded-pill
                                                       text-bg-primary"
                                            >
                                                Baru
                                            </span>

                                        @endif

                                    </div>


                                    <div
                                        class="text-muted
                                               small
                                               mb-3"
                                    >

                                        <i class="bi bi-calendar-event"></i>
                                        {{
                                            $announcement->created_at
                                                ->format(
                                                    'd M Y, H:i'
                                                )
                                        }}

                                        <span class="mx-2">
                                            ·
                                        </span>

                                        <i class="bi bi-person-fill"></i>
                                        {{
                                            $announcement->creator->name
                                            ?? '-'
                                        }}

                                    </div>


                                    @if($announcement->content)

                                        <p
                                            class="text-muted
                                                   mb-3"
                                        >
                                            {{
                                                Str::limit(
                                                    $announcement->content,
                                                    220
                                                )
                                            }}
                                        </p>

                                    @else

                                        <p
                                            class="text-muted
                                                   mb-3"
                                        >
                                            Tidak ada isi pengumuman.
                                        </p>

                                    @endif


                                    <div class="d-flex flex-wrap gap-2">

                                        <a
                                            href="{{ route(
                                                'announcements.show',
                                                [
                                                    $class,
                                                    $announcement
                                                ]
                                            ) }}"
                                            class="btn
                                                   btn-outline-primary
                                                   btn-sm"
                                        >
                                            Baca Pengumuman
                                        </a>

                                        @if(
                                            Auth::user()->role === 'admin' ||
                                            Auth::user()->role === 'teacher'
                                        )

                                            <a
                                                href="{{ route('announcements.edit', [$class, $announcement]) }}"
                                                class="btn btn-outline-secondary btn-sm"
                                            >
                                                <i class="bi bi-pencil-square"></i>
                                            </a>

                                            <form
                                                action="{{ route('announcements.destroy', [$class, $announcement]) }}"
                                                method="POST"
                                                onsubmit="return confirm('Hapus pengumuman ini?')"
                                            >
                                                @csrf
                                                @method('DELETE')

                                                <button
                                                    type="submit"
                                                    class="btn btn-outline-danger btn-sm"
                                                >
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>

                                        @endif

                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

            @endforeach

        </div>

    @else

        <!-- EMPTY -->

        <div class="card">

            <div
                class="card-body
                       text-center
                       py-5"
            >

                <div
                    class="mb-3"
                    style="font-size: 55px;"
                >
                    <i class="bi bi-megaphone-fill"></i>
                </div>


                <h5 class="fw-bold mb-2">
                    Belum ada pengumuman
                </h5>


                <p
                    class="text-muted
                           mx-auto
                           mb-4"
                    style="max-width: 450px;"
                >
                    Belum ada pengumuman yang
                    dibuat untuk kelas ini.
                </p>


                @if(
                    Auth::user()->role === 'admin' ||
                    Auth::user()->role === 'teacher'
                )

                    <a
                        href="{{ route(
                            'announcements.create',
                            $class
                        ) }}"
                        class="btn btn-primary"
                    >
                        + Buat Pengumuman
                    </a>

                @endif

            </div>

        </div>

    @endif

@endsection