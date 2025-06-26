@extends('layouts.app')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Detail Event</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item"><a href="#">Dashboard</a></div>
                <div class="breadcrumb-item"><a href="{{ route('event.index') }}">Event</a></div>
                <div class="breadcrumb-item active">Detail</div>
            </div>
        </div>

        <div class="section-body">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Informasi Event</h4>
                        </div>
                        <div class="card-body">
                            <div class="text-center mb-4">
                                @if ($event->foto_event)
                                    <img src="{{ asset('storage/' . $event->foto_event) }}" alt="Foto Event" width="100%"
                                        class="rounded" style="max-height: 300px; object-fit: cover;">
                                @else
                                    <span class="text-muted">Tidak ada foto</span>
                                @endif
                            </div>

                            <table class="table table-bordered">
                                <tr>
                                    <th>Nama Event</th>
                                    <td>{{ $event->nama_event }}</td>
                                </tr>
                                <tr>
                                    <th>Deskripsi</th>
                                    <td>{!! nl2br(e($event->deskripsi)) ?? '-' !!}</td>
                                </tr>
                                <tr>
                                    <th>Tanggal Mulai</th>
                                    <td>{{ $event->tanggal_mulai ? \Carbon\Carbon::parse($event->tanggal_mulai)->format('d M Y') : '-' }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>Tanggal Selesai</th>
                                    <td>{{ $event->tanggal_selesai ? \Carbon\Carbon::parse($event->tanggal_selesai)->format('d M Y') : '-' }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>Target Donasi</th>
                                    <td>Rp {{ number_format($event->target_donasi, 0, ',', '.') }}</td>
                                </tr>
                                <tr>
                                    <th>Pengajuan Terkait</th>
                                    <td>{{ $event->pengajuan->judul_pengajuan ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th>Dibuat pada</th>
                                    <td>{{ $event->created_at->format('d M Y - H:i') }}</td>
                                </tr>
                                <tr>
                                    <th>Diperbarui pada</th>
                                    <td>{{ $event->updated_at->format('d M Y - H:i') }}</td>
                                </tr>
                            </table>

                            <div class="mt-4">
                                <a href="{{ route('event.edit', $event->id) }}" class="btn btn-primary">Edit</a>
                                <a href="{{ route('event.index') }}" class="btn btn-secondary">Kembali</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
