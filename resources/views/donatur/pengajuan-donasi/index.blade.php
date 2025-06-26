@extends('layouts.app')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Pengajuan Donasi</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                <div class="breadcrumb-item"><a href="#">Donasi</a></div>
                <div class="breadcrumb-item">Pengajuan Donasi</div>
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
                        <div class="card-header">
                            <a href="{{ route('pengajuan-donasi.create') }}" class="btn btn-primary">Ajukan Donasi</a>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped" id="table-pengajuan">
                                    <thead>
                                        <tr>
                                            <th class="text-center">#</th>
                                            <th>Judul</th>
                                            <th>Target</th>
                                            <th>Status</th>
                                            <th>Tanggal</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($pengajuan as $index => $item)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>{{ $item->judul_pengajuan }}</td>
                                                <td>Rp {{ number_format($item->target_pengajuan, 0, ',', '.') }}</td>
                                                <td>
                                                    <span
                                                        class="badge 
                                                        @if ($item->status_pengajuan === 'diajukan') bg-warning 
                                                        @elseif($item->status_pengajuan === 'disetujui') bg-success 
                                                        @else bg-danger @endif">
                                                        {{ ucfirst($item->status_pengajuan) }}
                                                    </span>
                                                </td>
                                                <td>{{ \Carbon\Carbon::parse($item->tanggal_pengajuan)->format('d M Y') }}
                                                </td>
                                                <td>
                                                    <div class="d-flex">
                                                        <a href="{{ route('pengajuan-donasi.show', $item->id) }}"
                                                            class="mr-1">
                                                            <i class="fa fa-eye bg-success text-white p-2 rounded"></i>
                                                        </a>
                                                    </div>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="6" class="text-center text-muted">Belum ada pengajuan
                                                    donasi.</td>
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
