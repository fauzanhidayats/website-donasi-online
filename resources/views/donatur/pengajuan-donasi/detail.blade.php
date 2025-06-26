@extends('layouts.app')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Detail Pengajuan Donasi</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item"><a href="#">Dashboard</a></div>
                <div class="breadcrumb-item"><a href="{{ route('pengajuan-donasi.index') }}">Pengajuan Donasi</a></div>
                <div class="breadcrumb-item active">Detail</div>
            </div>
        </div>

        <div class="section-body">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Informasi Pengajuan</h4>
                        </div>
                        <div class="card-body">
                            @if ($pengajuan->bukti)
                                <div class="text-center mb-4">
                                    <img src="{{ asset('storage/' . $pengajuan->bukti) }}" alt="Bukti Pengajuan"
                                        width="100%" class="rounded" style="max-height: 300px; object-fit: contain;">
                                </div>
                            @endif

                            <table class="table table-bordered">
                                <tr>
                                    <th>Nama Pengaju</th>
                                    <td>{{ $pengajuan->nama ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th>Email</th>
                                    <td>{{ $pengajuan->email ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th>No. Telepon</th>
                                    <td>{{ $pengajuan->no_telp ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th>Alamat</th>
                                    <td>{{ $pengajuan->alamat ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th>Judul Pengajuan</th>
                                    <td>{{ $pengajuan->judul_pengajuan }}</td>
                                </tr>
                                <tr>
                                    <th>Deskripsi</th>
                                    <td>{!! nl2br(e($pengajuan->deskripsi)) ?? '-' !!}</td>
                                </tr>
                                <tr>
                                    <th>Target Pengajuan</th>
                                    <td>Rp {{ number_format($pengajuan->target_pengajuan, 0, ',', '.') }}</td>
                                </tr>
                                <tr>
                                    <th>Status</th>
                                    <td>
                                        <span
                                            class="badge 
                                            @if ($pengajuan->status_pengajuan === 'diajukan') bg-warning 
                                            @elseif($pengajuan->status_pengajuan === 'disetujui') bg-success 
                                            @else bg-danger @endif">
                                            {{ ucfirst($pengajuan->status_pengajuan) }}
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Tanggal Pengajuan</th>
                                    <td>{{ \Carbon\Carbon::parse($pengajuan->tanggal_pengajuan)->format('d M Y H:i') }}</td>
                                </tr>
                            </table>

                            <div class="mt-4 d-flex justify-content-between">
                                <a href="{{ route('pengajuan-donasi.edit', $pengajuan->id) }}"
                                    class="btn btn-primary {{ $pengajuan->status_pengajuan !== 'diajukan' ? 'disabled' : '' }}">
                                    Edit
                                </a>
                                <a href="{{ route('pengajuan-donasi.index') }}" class="btn btn-secondary">Kembali</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
