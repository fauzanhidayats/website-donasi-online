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
<div class="container card bg-light p-3">
    <h2 class="mb-4">Form Pengajuan Donasi</h2>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('pengajuan-donasi.store') }}" method="POST" enctype="multipart/form-data" class="row g-3">
        @csrf

        <div class="col-md-6">
            <label for="nama" class="form-label">Nama Lengkap</label>
            <input type="text" class="form-control" name="nama" id="nama" value="{{ old('nama') }}">
        </div>

        <div class="col-md-6">
            <label for="email" class="form-label">Alamat Email</label>
            <input type="email" class="form-control" name="email" id="email" value="{{ old('email') }}">
        </div>

        <div class="col-md-6">
            <label for="no_telp" class="form-label">No. Telepon</label>
            <input type="text" class="form-control" name="no_telp" id="no_telp" value="{{ old('no_telp') }}">
        </div>

        <div class="col-md-6">
            <label for="alamat" class="form-label">Alamat</label>
            <textarea class="form-control" name="alamat" id="alamat" rows="2">{{ old('alamat') }}</textarea>
        </div>

        <div class="col-12">
            <label for="judul_pengajuan" class="form-label">Judul Pengajuan</label>
            <input type="text" class="form-control" name="judul_pengajuan" id="judul_pengajuan" required
                value="{{ old('judul_pengajuan') }}">
        </div>

        <div class="col-12">
            <label for="deskripsi" class="form-label">Deskripsi Pengajuan</label>
            <textarea class="form-control" name="deskripsi" id="deskripsi" rows="4">{{ old('deskripsi') }}</textarea>
        </div>

        <div class="col-md-6">
            <label for="target_pengajuan" class="form-label">Target Donasi (Rp)</label>
            <input type="number" class="form-control" name="target_pengajuan" id="target_pengajuan" required
                value="{{ old('target_pengajuan') }}">
        </div>

        <div class="col-md-6">
            <label for="bukti" class="form-label">Upload Bukti (Opsional)</label>
            <input type="file" class="form-control" name="bukti" id="bukti" accept="image/*">
        </div>

        <div class="col-12 text-end">
            <button type="submit" class="btn btn-primary">Kirim Pengajuan</button>
        </div>
    </form>
</div>

@include('front-end.footer')
