@extends('layouts.app')

@section('title', $announcement->title . ' - SchoolOS')

@section('page-title', 'Detail Pengumuman')


@section('content')


    <!-- BACK -->

    <div class="mb-4">

        <a
            href="{{ route(
                'announcements.index',
                $class
            ) }}"
            class="text-decoration-none"
        >
            ← Kembali ke Pengumuman
        </a>

    </div>


    @if(session('success'))

        <div class="alert alert-success border-0 shadow-sm">
            {{ session('success') }}
        </div>

    @endif


    @if(
        Auth::user()->role === 'admin' ||
        Auth::user()->role === 'teacher'
    )

        <div class="d-flex justify-content-end gap-2 mb-3">

            <a
                href="{{ route(
                    'announcements.edit',
                    [$class, $announcement]
                ) }}"
                class="btn btn-outline-secondary btn-sm"
            >
                <i class="bi bi-pencil-square"></i>
                Edit
            </a>

            <form
                action="{{ route(
                    'announcements.destroy',
                    [$class, $announcement]
                ) }}"
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
                    Hapus
                </button>
            </form>

        </div>

    @endif


    <!-- ANNOUNCEMENT -->

    <div class="card mb-4">

        <div class="card-body p-4 p-lg-5">


            <!-- ICON -->

            <div
                class="rounded-4
                       d-flex
                       align-items-center
                       justify-content-center
                       mb-4"
                style="
                    width: 65px;
                    height: 65px;
                    background: #fff7ed;
                    font-size: 31px;
                "
            >
                <i class="bi bi-megaphone-fill"></i>
            </div>


            <!-- TITLE -->

            <h1
                class="fw-bold
                       mb-3"
            >
                {{ $announcement->title }}
            </h1>


            <!-- META -->

            <div
                class="d-flex
                       flex-wrap
                       gap-3
                       text-muted
                       small
                       mb-4"
            >

                <span>
                    <i class="bi bi-calendar-event"></i>
                    {{
                        $announcement->created_at
                            ->format(
                                'd M Y, H:i'
                            )
                    }}
                </span>


                <span>
                    <i class="bi bi-person-fill"></i>
                    {{
                        $announcement->creator->name
                        ?? '-'
                    }}
                </span>

            </div>


            <hr class="mb-4">


            <!-- CONTENT -->

            @if($announcement->content)

                <div
                    class="text-dark"
                    style="
                        white-space: pre-line;
                        line-height: 1.8;
                    "
                >
                    {{ $announcement->content }}
                </div>

            @else

                <p class="text-muted mb-0">
                    Tidak ada isi pengumuman.
                </p>

            @endif

        </div>

    </div>


    <!-- CLASS INFO -->

    <div class="card">

        <div class="card-body p-4">

            <div
                class="d-flex
                       align-items-center
                       gap-3"
            >

                <div
                    class="rounded-3
                           d-flex
                           align-items-center
                           justify-content-center"
                    style="
                        width: 45px;
                        height: 45px;
                        background: #eef2ff;
                        font-size: 20px;
                    "
                >
                    <i class="bi bi-building"></i>
                </div>


                <div>

                    <div
                        class="text-muted
                               small"
                    >
                        Pengumuman untuk
                    </div>

                    <div class="fw-bold">
                        {{ $class->name }}
                    </div>

                </div>

            </div>

        </div>

    </div>


@endsection