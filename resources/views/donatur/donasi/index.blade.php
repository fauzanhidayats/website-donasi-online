@extends('layouts.app')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Data Donasi</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                <div class="breadcrumb-item"><a href="#">Donasi</a></div>
                <div class="breadcrumb-item">Data Donasi</div>
            </div>
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-12">

                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped" id="table-1">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Nama Donatur</th>
                                            <th>Email</th>
                                            <th>No HP</th>
                                            <th>Jumlah Donasi</th>
                                            <th>Tanggal Donasi</th>
                                            <th>Status Pembayaran</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($donasi as $index => $item)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>{{ $item->nama_donatur ?? ($item->user->name ?? '-') }}</td>
                                                <td>{{ $item->email_donatur ?? ($item->user->email ?? '-') }}</td>
                                                <td>{{ $item->no_hp_donatur ?? '-' }}</td>
                                                <td>Rp {{ number_format($item->jumlah_donasi, 0, ',', '.') }}</td>
                                                <td>{{ \Carbon\Carbon::parse($item->tanggal_donasi)->format('d M Y H:i') }}
                                                </td>
                                                <td>
                                                    <span
                                                        class="badge 
                                                        @if ($item->status_pembayaran == 'berhasil') bg-success 
                                                        @elseif ($item->status_pembayaran == 'pending') bg-warning 
                                                        @else bg-danger @endif">
                                                        {{ ucfirst($item->status_pembayaran) }}
                                                    </span>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="7" class="text-center text-muted">Belum ada donasi.</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>
@endsection
