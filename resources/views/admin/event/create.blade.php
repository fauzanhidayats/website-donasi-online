@extends('layouts.app')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Tambah Event</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item"><a href="#">Dashboard</a></div>
                <div class="breadcrumb-item"><a href="{{ route('event.index') }}">Event</a></div>
                <div class="breadcrumb-item active">Tambah</div>
            </div>
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-12 col-md-8 col-lg-8">
                    <div class="card">
                        <div class="card-header">
                            <h4>Form Tambah Event</h4>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('event.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf

                                <div class="form-group">
                                    <label for="nama_event">Nama Event</label>
                                    <input type="text" name="nama_event"
                                        class="form-control @error('nama_event') is-invalid @enderror"
                                        value="{{ old('nama_event') }}" required>
                                    @error('nama_event')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="deskripsi">Deskripsi</label>
                                    <textarea name="deskripsi" class="form-control @error('deskripsi') is-invalid @enderror" rows="4">{{ old('deskripsi') }}</textarea>
                                    @error('deskripsi')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="tanggal_mulai">Tanggal Mulai</label>
                                    <input type="date" name="tanggal_mulai"
                                        class="form-control @error('tanggal_mulai') is-invalid @enderror"
                                        value="{{ old('tanggal_mulai') }}">
                                    @error('tanggal_mulai')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="tanggal_selesai">Tanggal Selesai</label>
                                    <input type="date" name="tanggal_selesai"
                                        class="form-control @error('tanggal_selesai') is-invalid @enderror"
                                        value="{{ old('tanggal_selesai') }}">
                                    @error('tanggal_selesai')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="target_donasi">Target Donasi</label>
                                    <input type="number" name="target_donasi"
                                        class="form-control @error('target_donasi') is-invalid @enderror"
                                        value="{{ old('target_donasi') }}" step="0.01">
                                    @error('target_donasi')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="pengajuan_id">Pengajuan Donasi (Opsional)</label>
                                    <select name="pengajuan_id"
                                        class="form-control @error('pengajuan_id') is-invalid @enderror">
                                        <option value="">-- Pilih Pengajuan Donasi --</option>
                                        @foreach ($pengajuans as $pengajuan)
                                            <option value="{{ $pengajuan->id }}"
                                                {{ old('pengajuan_id') == $pengajuan->id ? 'selected' : '' }}>
                                                {{ $pengajuan->judul_pengajuan }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('pengajuan_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="foto_event">Foto Event</label>
                                    <input type="file" name="foto_event"
                                        class="form-control-file @error('foto_event') is-invalid @enderror">
                                    @error('foto_event')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>

                                <button type="submit" class="btn btn-primary">Simpan</button>
                                <a href="{{ route('event.index') }}" class="btn btn-secondary">Batal</a>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
