<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="{{ route('home') }}">BAZNAS BANTEN</a>
        </div>
        <ul class="sidebar-menu">

            @if (auth()->user()->role === 'admin')
                <li class="menu-header">Dashboard</li>
                <li>
                    <a class="nav-link" href="{{ route('dashboard.admin') }}"><i class="fas fa-home"></i>
                        <span>Dashboard</span></a>
                </li>
                <li class="menu-header">Kelola Data</li>
                <li>
                    <a class="nav-link" href="{{ route('event.index') }}"><i class="fas fa-toolbox"></i>
                        <span>Data Event</span></a>
                </li>
                <li>
                    <a class="nav-link" href="{{ route('admin.data-donasi') }}"><i class="fas fa-building"></i>
                        <span>Data Donasi</span></a>
                </li>
                <li>
                    <a class="nav-link" href="{{ route('admin.pengajuan.index') }}"><i class="fas fa-car"></i>
                        <span>Data Pengajuan Donasi</span></a>
                </li>

                <li class="menu-header">Kelola Laporan</li>
                <li class="dropdown">
                    <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i
                            class="fas fa-file-alt"></i> <span>Laporan</span></a>
                    <ul class="dropdown-menu">
                        <li><a class="nav-link" href="{{ route('admin.laporan.event.index') }}">Data Event</a></li>
                        <li><a class="nav-link" href="{{ route('admin.laporan.donasi.index') }}">Data Donasi</a></li>
                        <li><a class="nav-link" href="{{ route('admin.laporan.pengajuan.index') }}">Data Pengajuan
                                Donasi</a></li>
                    </ul>
                </li>
                <li class="menu-header">Kelola Akun</li>
                <li>
                    <a class="nav-link" href="{{ route('users.index') }}"><i class="fas fa-user-alt"></i>
                        <span>User</span></a>
                </li>
            @elseif (auth()->user()->role === 'donatur')
                <li class="menu-header">Dashboard</li>
                <li>
                    <a class="nav-link" href="{{ route('dashboard.donatur') }}"><i class="fas fa-home"></i>
                        <span>Dashboard</span></a>
                </li>
                <li class="menu-header">DONASI</li>

                <li>
                    <a class="nav-link" href="{{ route('donatur.data-donasi') }}"><i class="fas fa-toolbox"></i>
                        <span> Donasi Saya</span></a>
                </li>
                <li>
                    <a class="nav-link" href="{{ route('pengajuan-donasi.index') }}"><i class="fas fa-building"></i>
                        <span>Data Pengajuan Donasi</span></a>
                </li>
            @elseif (auth()->user()->role === 'pimpinan')
                <li class="menu-header">Dashboard</li>
                <li>
                    <a class="nav-link" href="{{ route('dashboard.pimpinan') }}"><i class="fas fa-home"></i>
                        <span>Dashboard</span></a>
                </li>
                <li class="menu-header">Kelola Data</li>
                <li>
                    <a class="nav-link" href="{{ route('pimpinan.pengajuan.index') }}"><i class="fas fa-toolbox"></i>
                        <span>Data Pengajuan Donasi</span></a>
                </li>
                <li class="menu-header">Kelola Laporan</li>
                <li class="dropdown">
                    <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i
                            class="fas fa-file-alt"></i> <span>Laporan</span></a>
                    <ul class="dropdown-menu">
                        <li><a class="nav-link" href="{{ route('pimpinan.laporan.event.index') }}">Data Event</a></li>
                        <li><a class="nav-link" href="{{ route('pimpinan.laporan.donasi.index') }}">Data Donasi</a>
                        </li>
                        <li><a class="nav-link" href="{{ route('pimpinan.laporan.pengajuan.index') }}">Data
                                Pengajuan Donasi</a></li>
                    </ul>
                </li>
            @endif

        </ul>
    </aside>
</div>
