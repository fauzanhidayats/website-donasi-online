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
<section class="py-5 bg-light">
    <div class="container">
        <div class="row align-items-center">
            <!-- Gambar BAZNAS -->
            <div class="col-md-5 text-center mb-4 mb-md-0">
                <img src="{{ asset('assets/img/logo baznas.png') }}" alt="Logo BAZNAS Banten" class="img-fluid"
                    style="max-width: 80%;">
            </div>

            <!-- Deskripsi Tentang Kami -->
            <div class="col-md-7">
                <h2 class="fw-bold">Tentang BAZNAS Provinsi Banten</h2>
                <p class="text-muted mt-3" style="text-align: justify;">
                    Badan Amil Zakat Nasional (BAZNAS) Provinsi Banten merupakan lembaga resmi yang dibentuk oleh
                    pemerintah
                    untuk mengelola zakat, infak, dan sedekah secara profesional, transparan, dan amanah. Kami hadir
                    untuk mendorong
                    pertumbuhan ekonomi umat melalui distribusi zakat yang tepat sasaran serta program-program
                    pemberdayaan
                    yang berkelanjutan.
                </p>
                <p class="text-muted" style="text-align: justify;">
                    Dengan mengusung visi menjadi lembaga pengelola zakat yang terpercaya dan modern, BAZNAS Provinsi
                    Banten berkomitmen
                    untuk melayani masyarakat Banten dalam menunaikan zakat serta menyalurkannya kepada mereka yang
                    berhak menerima,
                    sesuai prinsip syariah dan regulasi yang berlaku.
                </p>
                <p class="mb-0">
                    <a href="#contact" class="btn btn-danger px-4 py-2 mt-3 fw-semibold">Hubungi Kami</a>
                </p>
            </div>
        </div>
    </div>
</section>
@include('front-end.footer')
