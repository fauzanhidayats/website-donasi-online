@extends('layouts.app')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Dashboard</h1>
        </div>

        <div class="section-body">
            <h2 class="section-title">
                Selamat Datang,Fauzan di Website <br>
                <strong>PEMINJAMAN BARANG DAN TEMPAT UNIVERSITAS BANTEN JAYA</strong>
            </h2>
        </div>

        <div class="row mt-4">
            <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-danger">
                        <i class="fas fa-toolbox"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Total Barang</h4>
                        </div>
                        <div class="card-body"></div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-warning">
                        <i class="fas fa-building"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Total Ruangan</h4>
                        </div>
                        <div class="card-body"></div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-warning">
                        <i class="fas fa-car"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Total Kendaraan</h4>
                        </div>
                        <div class="card-body"></div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-success">
                        <i class="fas fa-toolbox"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Total Peminjaman Barang</h4>
                        </div>
                        <div class="card-body"></div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-success">
                        <i class="fas fa-building"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Total Peminjaman Ruangan</h4>
                        </div>
                        <div class="card-body"></div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-success">
                        <i class="fas fa-car"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Total Peminjaman Kendaraan</h4>
                        </div>
                        <div class="card-body"></div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
