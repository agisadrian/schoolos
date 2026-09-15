<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>
        @yield('title', 'SchoolOS')
    </title>


    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"
        rel="stylesheet"
    >


    <style>

        :root {
            --sidebar-width: 260px;
            --primary: #4f46e5;
            --primary-dark: #4338ca;
            --sidebar-bg: #111827;
            --sidebar-hover: #1f2937;
            --page-bg: #f8fafc;
            --border: #e5e7eb;
        }


        * {
            box-sizing: border-box;
        }


        body {
            margin: 0;
            background: var(--page-bg);
            color: #111827;
            font-family:
                Inter,
                ui-sans-serif,
                system-ui,
                -apple-system,
                BlinkMacSystemFont,
                "Segoe UI",
                sans-serif;
        }


        a {
            text-decoration: none;
        }


        /* SIDEBAR */

        .schoolos-sidebar {
            position: fixed;
            top: 0;
            left: 0;
            width: var(--sidebar-width);
            height: 100vh;
            background: var(--sidebar-bg);
            color: white;
            z-index: 1050;
            overflow-y: auto;
            transition: transform .25s ease;
        }


        .sidebar-brand {
            padding: 24px 22px;
            border-bottom: 1px solid rgba(255,255,255,.08);
        }


        .brand-icon {
            width: 42px;
            height: 42px;
            border-radius: 12px;
            background: var(--primary);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            font-weight: 800;
            flex-shrink: 0;
        }


        .brand-title {
            font-size: 18px;
            font-weight: 800;
            color: white;
        }


        .brand-subtitle {
            color: #9ca3af;
            font-size: 12px;
        }


        .sidebar-section {
            padding: 20px 14px 6px;
        }


        .sidebar-section-title {
            padding: 0 10px 8px;
            color: #6b7280;
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .08em;
        }


        .sidebar-link {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 11px 12px;
            margin-bottom: 4px;
            border-radius: 10px;
            color: #d1d5db;
            font-size: 14px;
            font-weight: 500;
            transition: .2s;
        }


        .sidebar-link:hover {
            background: var(--sidebar-hover);
            color: white;
        }


        .sidebar-link.active {
            background: var(--primary);
            color: white;
        }


        .sidebar-icon {
            width: 22px;
            text-align: center;
            font-size: 17px;
        }


        .sidebar-class-card {
            margin: 10px 14px;
            padding: 14px;
            border-radius: 12px;
            background: rgba(255,255,255,.06);
            border: 1px solid rgba(255,255,255,.07);
        }


        .sidebar-class-name {
            color: white;
            font-weight: 700;
            font-size: 14px;
        }


        .sidebar-class-code {
            color: #9ca3af;
            font-size: 12px;
        }


        .sidebar-user {
            position: sticky;
            bottom: 0;
            padding: 14px;
            margin-top: 20px;
            background: var(--sidebar-bg);
            border-top: 1px solid rgba(255,255,255,.08);
        }


        .sidebar-user-avatar {
            width: 38px;
            height: 38px;
            border-radius: 50%;
            background: #374151;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 14px;
            font-weight: 700;
            flex-shrink: 0;
        }


        .sidebar-user-name {
            color: white;
            font-size: 13px;
            font-weight: 600;
        }


        .sidebar-user-role {
            color: #9ca3af;
            font-size: 11px;
        }


        /* MAIN */

        .schoolos-main {
            margin-left: var(--sidebar-width);
            min-height: 100vh;
        }


        .schoolos-topbar {
            height: 72px;
            background: white;
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 30px;
            position: sticky;
            top: 0;
            z-index: 1000;
        }


        .topbar-title {
            font-weight: 700;
            font-size: 18px;
        }


        .topbar-date {
            color: #6b7280;
            font-size: 13px;
        }


        .schoolos-content {
            padding: 30px;
        }


        /* CARDS */

        .card {
            border: 1px solid var(--border);
            border-radius: 16px;
            box-shadow: 0 2px 8px rgba(15,23,42,.03);
        }


        .btn-primary {
            background: var(--primary);
            border-color: var(--primary);
        }


        .btn-primary:hover {
            background: var(--primary-dark);
            border-color: var(--primary-dark);
        }


        .form-control,
        .form-select {
            border-radius: 10px;
            border-color: #d1d5db;
            padding: 10px 13px;
        }


        .form-control:focus,
        .form-select:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 .2rem rgba(79,70,229,.12);
        }


        /* MOBILE */

        .mobile-menu-button {
            display: none;
            border: 0;
            background: #f3f4f6;
            border-radius: 10px;
            width: 42px;
            height: 42px;
            font-size: 20px;
        }


        .sidebar-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,.45);
            z-index: 1040;
        }


        @media (max-width: 991.98px) {

            .schoolos-sidebar {
                transform: translateX(-100%);
            }


            .schoolos-sidebar.show {
                transform: translateX(0);
            }


            .schoolos-main {
                margin-left: 0;
            }


            .schoolos-topbar {
                padding: 0 18px;
            }


            .schoolos-content {
                padding: 20px;
            }


            .mobile-menu-button {
                display: inline-flex;
                align-items: center;
                justify-content: center;
            }


            .sidebar-overlay.show {
                display: block;
            }

        }


        @media (max-width: 575.98px) {

            .schoolos-content {
                padding: 16px;
            }


            .topbar-date {
                display: none;
            }


            .schoolos-topbar {
                height: 64px;
            }

        }

    </style>

</head>


<body>


@php

    $currentClass =
        $class
        ?? request()->route('class');

@endphp


<!-- SIDEBAR -->

<aside
    id="schoolosSidebar"
    class="schoolos-sidebar"
>

    <!-- BRAND -->

    <div class="sidebar-brand">

        <a
            href="{{ route('dashboard') }}"
            class="d-flex align-items-center gap-3"
        >

            <div class="brand-icon">
                S
            </div>

            <div>

                <div class="brand-title">
                    SchoolOS
                </div>

                <div class="brand-subtitle">
                    Class Management
                </div>

            </div>

        </a>

    </div>


    <!-- MAIN MENU -->

    <div class="sidebar-section">

        <div class="sidebar-section-title">
            Utama
        </div>


        <a
            href="{{ route('dashboard') }}"
            class="sidebar-link {{ request()->routeIs('dashboard') ? 'active' : '' }}"
        >

            <span class="sidebar-icon">
                <i class="bi bi-house-door-fill"></i>
            </span>

            <span>
                Dashboard
            </span>

        </a>


        <a
            href="{{ route('classes.index') }}"
            class="sidebar-link {{ request()->routeIs('classes.*') && !request()->routeIs('members.*') ? 'active' : '' }}"
        >

            <span class="sidebar-icon">
                <i class="bi bi-building"></i>
            </span>

            <span>
                Kelas
            </span>

        </a>

    </div>


    <!-- CLASS MENU -->

    @if($currentClass)

        <div class="sidebar-class-card">

            <div class="sidebar-class-name">

                {{ $currentClass->name }}

            </div>

            <div class="sidebar-class-code">

                {{ $currentClass->code }}

            </div>

        </div>


        <div class="sidebar-section pt-1">

            <div class="sidebar-section-title">
                Kelas
            </div>


            <a
                href="{{ route(
                    'classes.show',
                    $currentClass
                ) }}"
                class="sidebar-link {{ request()->routeIs('classes.show') ? 'active' : '' }}"
            >

                <span class="sidebar-icon">
                    <i class="bi bi-bar-chart-fill"></i>
                </span>

                <span>
                    Overview
                </span>

            </a>


            <a
                href="{{ route(
                    'members.index',
                    $currentClass
                ) }}"
                class="sidebar-link {{ request()->routeIs('members.*') ? 'active' : '' }}"
            >

                <span class="sidebar-icon">
                    <i class="bi bi-people-fill"></i>
                </span>

                <span>
                    Anggota
                </span>

            </a>


            <a
                href="{{ route(
                    'subjects.index',
                    $currentClass
                ) }}"
                class="sidebar-link {{ request()->routeIs('subjects.*') ? 'active' : '' }}"
            >

                <span class="sidebar-icon">
                    <i class="bi bi-journal-bookmark-fill"></i>
                </span>

                <span>
                    Mata Pelajaran
                </span>

            </a>


            <a
                href="{{ route(
                    'materials.index',
                    $currentClass
                ) }}"
                class="sidebar-link {{ request()->routeIs('materials.*') ? 'active' : '' }}"
            >

                <span class="sidebar-icon">
                    <i class="bi bi-journal-text"></i>
                </span>

                <span>
                    Materi
                </span>

            </a>


            <a
                href="{{ route(
                    'assignments.index',
                    $currentClass
                ) }}"
                class="sidebar-link {{ request()->routeIs('assignments.*') || request()->routeIs('submissions.*') ? 'active' : '' }}"
            >

                <span class="sidebar-icon">
                    <i class="bi bi-pencil-square"></i>
                </span>

                <span>
                    Tugas
                </span>

            </a>


            <a
                href="{{ route(
                    'schedules.index',
                    $currentClass
                ) }}"
                class="sidebar-link {{ request()->routeIs('schedules.*') ? 'active' : '' }}"
            >

                <span class="sidebar-icon">
                    <i class="bi bi-calendar3"></i>
                </span>

                <span>
                    Jadwal
                </span>

            </a>


            <a
                href="{{ route(
                    'announcements.index',
                    $currentClass
                ) }}"
                class="sidebar-link {{ request()->routeIs('announcements.*') ? 'active' : '' }}"
            >

                <span class="sidebar-icon">
                    <i class="bi bi-megaphone-fill"></i>
                </span>

                <span>
                    Pengumuman
                </span>

            </a>


            <a
                href="{{ route(
                    'grades.index',
                    $currentClass
                ) }}"
                class="sidebar-link {{ request()->routeIs('grades.*') ? 'active' : '' }}"
            >

                <span class="sidebar-icon">
                    <i class="bi bi-mortarboard-fill"></i>
                </span>

                <span>
                    Nilai
                </span>

            </a>

        </div>

    @endif


    <!-- ADMIN MENU -->

    @if(Auth::user()->role === 'admin')

        <div class="sidebar-section">

            <div class="sidebar-section-title">
                Administrasi
            </div>


            <a
                href="{{ route('users.index') }}"
                class="sidebar-link {{ request()->routeIs('users.*') ? 'active' : '' }}"
            >

                <span class="sidebar-icon">
                    <i class="bi bi-gear-fill"></i>
                </span>

                <span>
                    Manajemen User
                </span>

            </a>


            <a
                href="{{ route('classes.index') }}"
                class="sidebar-link"
            >

                <span class="sidebar-icon">
                    <i class="bi bi-building"></i>
                </span>

                <span>
                    Manajemen Kelas
                </span>

            </a>

        </div>

    @endif


    <!-- USER -->

    <div class="sidebar-user">

        <div class="d-flex align-items-center gap-3">

            <div class="sidebar-user-avatar">

                {{
                    strtoupper(
                        substr(
                            Auth::user()->name,
                            0,
                            1
                        )
                    )
                }}

            </div>


            <div class="flex-grow-1 overflow-hidden">

                <div class="sidebar-user-name text-truncate">

                    {{ Auth::user()->name }}

                </div>

                <div class="sidebar-user-role">

                    @if(Auth::user()->role === 'admin')
                        Administrator
                    @elseif(Auth::user()->role === 'teacher')
                        Guru
                    @else
                        Siswa
                    @endif

                </div>

            </div>

        </div>


        <form
            action="{{ route('logout') }}"
            method="POST"
            class="mt-3"
        >

            @csrf

            <button
                type="submit"
                class="btn btn-sm btn-outline-light w-100"
            >
                Keluar
            </button>

        </form>

    </div>

</aside>


<div
    id="sidebarOverlay"
    class="sidebar-overlay"
></div>


<!-- MAIN -->

<main class="schoolos-main">


    <!-- TOPBAR -->

    <header class="schoolos-topbar">

        <div class="d-flex align-items-center gap-3">

            <button
                id="mobileMenuButton"
                class="mobile-menu-button"
                type="button"
            >
                <i class="bi bi-list"></i>
            </button>


            <div>

                <div class="topbar-title">
                    @yield('page-title', 'SchoolOS')
                </div>

                <div class="topbar-date">
                    {{ now()->translatedFormat('l, d F Y') }}
                </div>

            </div>

        </div>


        <div class="d-none d-md-flex align-items-center gap-2">

            <span class="text-muted small">
                {{ Auth::user()->name }}
            </span>

            <span class="badge bg-light text-dark border">
                @if(Auth::user()->role === 'admin')
                    Admin
                @elseif(Auth::user()->role === 'teacher')
                    Guru
                @else
                    Siswa
                @endif
            </span>

        </div>

    </header>


    <!-- CONTENT -->

    <div class="schoolos-content">


        @if(session('success'))

            <div class="alert alert-success alert-dismissible fade show">

                {{ session('success') }}

                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="alert"
                ></button>

            </div>

        @endif


        @if($errors->any())

            <div class="alert alert-danger alert-dismissible fade show">

                <strong>
                    Terjadi kesalahan.
                </strong>

                <ul class="mb-0 mt-2">

                    @foreach($errors->all() as $error)

                        <li>
                            {{ $error }}
                        </li>

                    @endforeach

                </ul>

                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="alert"
                ></button>

            </div>

        @endif


        @yield('content')

    </div>

</main>


<script
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
></script>


<script>

    const sidebar =
        document.getElementById(
            'schoolosSidebar'
        );

    const overlay =
        document.getElementById(
            'sidebarOverlay'
        );

    const menuButton =
        document.getElementById(
            'mobileMenuButton'
        );


    function openSidebar() {

        sidebar.classList.add('show');

        overlay.classList.add('show');

    }


    function closeSidebar() {

        sidebar.classList.remove('show');

        overlay.classList.remove('show');

    }


    if (menuButton) {

        menuButton.addEventListener(
            'click',
            openSidebar
        );

    }


    if (overlay) {

        overlay.addEventListener(
            'click',
            closeSidebar
        );

    }


    document
        .querySelectorAll('.schoolos-sidebar a')
        .forEach(function (link) {

            link.addEventListener(
                'click',
                function () {

                    if (
                        window.innerWidth <= 991
                    ) {

                        closeSidebar();

                    }

                }
            );

        });

</script>


</body>

</html>