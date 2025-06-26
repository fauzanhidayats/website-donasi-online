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

<!-- Heading -->
<section aria-label="Berbagi Apa Hari Ini heading" class="container px-3 px-sm-4 px-md-5 mt-5 text-center">
    <h2 class="text-custom-green fw-bolder fs-6 tracking-wider mb-1 text-uppercase">
        BERBAGI <span class="fw-normal"> APA HARI INI? </span>
    </h2>
    <p class="fs-6 text-secondary tracking-wider">Program Pilihan Bagi Orang Baik</p>
</section>

<!-- List Event Dinamis -->
<section aria-label="Zakat and donation programs"
    class="container px-3 px-sm-4 px-md-5 mt-4 bg-light-green rounded-3 py-5">
    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-4">
        @forelse($events as $event)
            @php
                $terkumpul = $event->donasis_sum_nominal_donasi ?? 0;
                $progress = $event->target_donasi > 0 ? min(100, ($terkumpul / $event->target_donasi) * 100) : 0;
            @endphp

            <div class="col">
                <article class="card h-100 shadow-sm">
                    @if ($event->foto_event)
                        <img src="{{ asset('storage/' . $event->foto_event) }}" class="card-img-top object-fit-cover"
                            alt="{{ $event->nama_event }}" style="height: 200px; width: 100%;" />
                    @else
                        <div class="bg-secondary text-white d-flex align-items-center justify-content-center"
                            style="height: 200px;">
                            <span class="text-center">Tidak Ada Gambar</span>
                        </div>
                    @endif

                    <div class="card-body d-flex flex-column justify-content-between">
                        <h3 class="card-title fw-semibold fs-6 mb-3">
                            <a href="{{ route('detail-event.show', $event->id) }}"
                                class="text-decoration-none text-dark">
                                {{ $event->nama_event }}
                            </a>
                        </h3>

                        <div class="mb-1">
                            <div class="text-end text-secondary">Target</div>
                            <div class="text-end fs-6 text-custom-green fw-semibold">
                                Rp {{ number_format($event->target_donasi, 0, ',', '.') }}
                            </div>
                        </div>

                        <div class="mb-1">
                            <div class="text-end text-secondary">Terkumpul</div>
                            <div class="text-end fs-6 text-custom-green fw-semibold">
                                Rp {{ number_format($terkumpul, 0, ',', '.') }}
                            </div>
                        </div>

                        <div class="progress my-2" role="progressbar" aria-valuenow="{{ round($progress) }}"
                            aria-valuemin="0" aria-valuemax="100">
                            <div class="progress-bar bg-success" style="width: {{ $progress }}%"></div>
                        </div>

                        <div class="text-end fs-6 text-secondary mb-3">
                            Dari:
                            {{ $event->tanggal_mulai ? \Carbon\Carbon::parse($event->tanggal_mulai)->format('d M Y') : '-' }}<br>
                            Sampai:
                            {{ $event->tanggal_selesai ? \Carbon\Carbon::parse($event->tanggal_selesai)->format('d M Y') : '-' }}
                        </div>

                        <a href="{{ route('donasi.create') }}?event_id={{ $event->id }}"
                            class="btn btn-custom-green btn-sm fw-semibold py-2 rounded-3">
                            DONASI SEKARANG
                        </a>
                    </div>
                </article>
            </div>
        @empty
            <div class="col-12">
                <p class="text-center text-muted">Belum ada event yang tersedia.</p>
            </div>
        @endforelse
    </div>

</section>

@include('front-end.footer')
