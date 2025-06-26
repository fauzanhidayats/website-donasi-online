@extends('layouts.app')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Dashboard</h1>
        </div>

        <div class="section-body">
            <h2 class="section-title">
                Selamat Datang, {{ Auth::user()->username }} di Website <br>
                <strong>DONASI ONLINE BAZNAS PROVINSI BANTEN</strong>
            </h2>

            <div class="row mt-4">
                {{-- Total Event --}}
                <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-primary">
                            <i class="fas fa-calendar-alt"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>Total Event</h4>
                            </div>
                            <div class="card-body">
                                {{ $totalEvent }}
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Total Donasi (jumlah uang) --}}
                <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-success">
                            <i class="fas fa-donate"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>Total Donasi</h4>
                            </div>
                            <div class="card-body">
                                Rp {{ number_format($totalDonasi, 0, ',', '.') }}
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Total Pengajuan Donasi --}}
                <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-warning">
                            <i class="fas fa-file-alt"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>Total Pengajuan</h4>
                            </div>
                            <div class="card-body">
                                {{ $totalPengajuan }}
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Total Donatur --}}
                <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-info">
                            <i class="fas fa-user-check"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>Total Donatur</h4>
                            </div>
                            <div class="card-body">
                                {{ $totalDonatur }}
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Total User --}}
                <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-danger">
                            <i class="fas fa-users"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>Total User</h4>
                            </div>
                            <div class="card-body">
                                {{ $totalUser }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
