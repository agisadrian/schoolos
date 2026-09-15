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