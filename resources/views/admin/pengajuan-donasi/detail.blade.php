@extends('layouts.app')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Detail Pengajuan Donasi</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item"><a href="#">Dashboard</a></div>
                <div class="breadcrumb-item"><a href="{{ route('admin.pengajuan.index') }}">Pengajuan Donasi</a>
                </div>
                <div class="breadcrumb-item active">Detail</div>
            </div>
        </div>

        <div class="section-body">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

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
                                    <th>Tanggal Pengajuan</th>
                                    <td>{{ \Carbon\Carbon::parse($pengajuan->tanggal_pengajuan)->format('d M Y H:i') }}</td>
                                </tr>
                            </table>

                            {{-- Form untuk ubah status --}}
                            @if ($pengajuan->status_pengajuan === 'diajukan')
                                <form action="{{ route('admin.pengajuan.updateStatus', $pengajuan->id) }}" method="POST"
                                    class="mt-4">
                                    @csrf
                                    @method('PATCH')
                                    <div class="form-group">
                                        <label for="status_pengajuan">Ubah Status Pengajuan</label>
                                        <select name="status_pengajuan" id="status_pengajuan"
                                            class="form-control @error('status_pengajuan') is-invalid @enderror" required>
                                            <option value="">-- Pilih Status --</option>
                                            <option value="disetujui"
                                                {{ old('status_pengajuan') == 'disetujui' ? 'selected' : '' }}>Disetujui
                                            </option>
                                            <option value="ditolak"
                                                {{ old('status_pengajuan') == 'ditolak' ? 'selected' : '' }}>Ditolak
                                            </option>
                                        </select>
                                        @error('status_pengajuan')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <button type="submit" class="btn btn-success">Simpan Status</button>
                                    <a href="{{ route('admin.pengajuan.index') }}" class="btn btn-secondary">Kembali</a>
                                </form>
                            @else
                                <div class="mt-4">
                                    <p>Status saat ini:
                                        <span
                                            class="badge
                                            @if ($pengajuan->status_pengajuan === 'disetujui') bg-success
                                            @elseif($pengajuan->status_pengajuan === 'ditolak') bg-danger
                                            @else bg-warning @endif">
                                            {{ ucfirst($pengajuan->status_pengajuan) }}
                                        </span>
                                    </p>
                                    <a href="{{ route('admin.pengajuan.index') }}" class="btn btn-secondary">Kembali</a>
                                </div>
                            @endif

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
