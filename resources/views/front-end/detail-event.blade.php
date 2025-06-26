@include('front-end.header')
<header class="navbar navbar-expand-md navbar-light bg-white py-3">
    <div class="container">
        <a class="navbar-brand" href="/">
            <img alt="BAZNAS logo" src="{{ asset('assets/img/logo baznas.png') }}" width="50"
                class="d-inline-block align-text-top" />
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0 fw-semibold fs-6">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('tentang-kami') }}">Tentang Kami</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('all-event.index') }}">Event Donasi</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('pengajuan-donasi.create') }}">Pengajuan Bantuan</a>
                </li>

                @guest
                    <!-- Tampilkan tombol login jika belum login -->
                    <li class="nav-item me-2">
                        <a class="btn btn-danger px-4 py-1 rounded-3 fw-semibold" href="{{ route('login') }}">
                            Login
                        </a>
                    </li>
                @else
                    <!-- Dropdown jika sudah login -->
                    <li class="nav-item dropdown me-2">
                        <a class="nav-link dropdown-toggle btn  px-4 py-1 rounded-3 fw-semibold" href="#"
                            id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            {{ Auth::user()->username }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                            <li>
                                @php
                                    $user = Auth::user();
                                    if ($user->hasRole('admin')) {
                                        $dashboardRoute = route('dashboard.admin');
                                    } elseif ($user->hasRole('donatur')) {
                                        $dashboardRoute = route('dashboard.donatur');
                                    } elseif ($user->hasRole('pimpinan')) {
                                        $dashboardRoute = route('dashboard.pimpinan');
                                    } else {
                                        $dashboardRoute = '#'; // fallback
                                    }
                                @endphp

                                <a class="dropdown-item" href="{{ $dashboardRoute }}">Dashboard</a>
                            </li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="dropdown-item">Logout</button>
                                </form>
                            </li>
                        </ul>

                    </li>
                @endguest

            </ul>
        </div>
    </div>
</header>
<div class="container">
    <!-- Top container with image left and donation box right -->
    <div class="row g-4">
        <!-- Left image container -->
        <div class="col-md-8 position-relative">
            @if ($event->foto_event)
                <img alt="{{ $event->nama_event }}" class="w-100 rounded-3" height="350" loading="lazy"
                    src="{{ asset('storage/' . $event->foto_event) }}" width="600" />
            @else
                <div class="bg-secondary text-white d-flex align-items-center justify-content-center rounded-3"
                    style="height: 350px;">
                    <span>Tidak Ada Gambar</span>
                </div>
            @endif
        </div>

        <!-- Right donation box -->
        <div class="col-md-4">
            <div class="bg-white rounded-3 shadow-sm p-3">
                <p class="small text-muted mb-1">Program Donasi</p>
                <h2 class="fw-bold text-success mb-1">
                    {{ strtoupper($event->nama_event) }}
                </h2>
                <p class="small text-muted mb-3">
                    Sampai:
                    {{ $event->tanggal_selesai ? \Carbon\Carbon::parse($event->tanggal_selesai)->translatedFormat('d F Y') : 'Tanpa Batas Waktu' }}
                </p>

                <hr class="border-muted mb-3" />

                @php
                    $terkumpul = $event->donasis_sum_nominal_donasi ?? 0;
                    $target = $event->target_donasi;
                    $progress = $target > 0 ? min(100, ($terkumpul / $target) * 100) : 0;
                @endphp

                <div class="text-end mb-3">
                    <p class="small text-muted mb-1">Dana Terkumpul</p>
                    <p class="fs-5 fw-bold text-warning">Rp {{ number_format($terkumpul, 0, ',', '.') }}</p>
                </div>
                <p class="small text-muted mb-3">
                    Terkumpul {{ round($progress) }}% dari Rp {{ number_format($target, 0, ',', '.') }}
                </p>

                <div class="progress mb-3" style="height: 8px;">
                    <div class="progress-bar bg-success" role="progressbar" style="width: {{ $progress }}%;"></div>
                </div>

                <hr class="border-muted mb-3" />

                <a href="{{ route('donasi.create') }}?event_id={{ $event->id }}" class="btn btn-success w-100">
                    BANTU SEKARANG
                </a>
            </div>
        </div>
    </div>

    <!-- Bottom content area -->
    <div class="row">
        <!-- Left text content -->
        <div class="col-lg-8 mt-3">
            <div class="border-bottom mb-4 d-flex gap-4 small fw-semibold text-success">
                <button class="border-bottom border-success pb-1">Detail</button>
            </div>

            <div class="mb-4">
                <p class="fw-bold small mb-2 border-start border-success ps-2">
                    DESKRIPSI PROGRAM
                </p>

                <p class="small lh-base">
                    {{ $event->deskripsi }}
                </p>
            </div>
        </div>
    </div>
</div>

@include('front-end.footer')
