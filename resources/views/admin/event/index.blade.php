@extends('layouts.app')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Kelola Event</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                <div class="breadcrumb-item"><a href="#">Manajemen</a></div>
                <div class="breadcrumb-item">Event</div>
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
                            <a href="{{ route('event.create') }}" class="btn btn-success">Tambah Event</a>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped" id="table-1">
                                    <thead>
                                        <tr>
                                            <th class="text-center">#</th>
                                            <th>Foto</th>
                                            <th>Nama Event</th>
                                            <th>Target Donasi</th>
                                            <th>Tanggal</th>
                                            <th>Pengajuan</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($events as $index => $event)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>
                                                    @if ($event->foto_event)
                                                        <img src="{{ asset('storage/' . $event->foto_event) }}"
                                                            alt="Foto Event" width="60" height="60" class="rounded"
                                                            style="object-fit: cover;">
                                                    @else
                                                        <span class="text-muted">Tidak ada foto</span>
                                                    @endif
                                                </td>
                                                <td>{{ $event->nama_event }}</td>
                                                <td>Rp {{ number_format($event->target_donasi, 0, ',', '.') }}</td>
                                                <td>
                                                    {{ \Carbon\Carbon::parse($event->tanggal_mulai)->format('d M Y') }}
                                                    -
                                                    {{ \Carbon\Carbon::parse($event->tanggal_selesai)->format('d M Y') }}
                                                </td>
                                                <td>
                                                    {{ $event->pengajuan?->judul_pengajuan ?? '-' }}
                                                </td>
                                                <td>
                                                    <div class="d-flex">
                                                        <a href="{{ route('event.show', $event->id) }}" class="mr-1">
                                                            <i class="fa fa-eye bg-success text-white p-2 rounded"></i>
                                                        </a>
                                                        <a href="{{ route('event.edit', $event->id) }}" class="mr-1">
                                                            <i class="fa fa-edit bg-primary text-white p-2 rounded"></i>
                                                        </a>
                                                        <form action="{{ route('event.destroy', $event->id) }}"
                                                            method="POST"
                                                            onsubmit="return confirm('Yakin ingin menghapus event ini?')">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn p-0">
                                                                <i class="fa fa-trash bg-danger text-white p-2 rounded"></i>
                                                            </button>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="7" class="text-center text-muted">Belum ada data event</td>
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
