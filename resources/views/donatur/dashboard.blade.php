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
        </div>

        <div class="row mt-4">
            {{-- Total Donasi --}}
            <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-danger">
                        <i class="fas fa-donate"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Total Donasi Saya</h4>
                        </div>
                        <div class="card-body">
                            Rp {{ number_format($totalDonasi, 0, ',', '.') }}
                        </div>
                    </div>
                </div>
            </div>

            {{-- Total Pengajuan --}}
            <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-warning">
                        <i class="fas fa-hand-holding-heart"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Total Pengajuan Saya</h4>
                        </div>
                        <div class="card-body">
                            {{ $totalPengajuan }} Pengajuan
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
