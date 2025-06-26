@extends('layouts.app')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Laporan</h1>
        </div>

        <div class="row">
            {{-- Form Laporan Peminjaman --}}
            <div class="col-md-6">
                <h4>Laporan Pengajuan Donasi</h4>
                <form action="{{ route('admin.laporan.pengajuan') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="tanggal_mulai_peminjaman">Tanggal Mulai</label>
                        <input type="date" id="tanggal_mulai_peminjaman" name="tanggal_mulai" class="form-control"
                            required>
                    </div>
                    <div class="form-group">
                        <label for="tanggal_selesai_peminjaman">Tanggal Selesai</label>
                        <input type="date" id="tanggal_selesai_peminjaman" name="tanggal_selesai" class="form-control"
                            required>
                    </div>
                    <button class="btn btn-primary">Lihat Laporan</button>
                </form>
            </div>


        </div>
    </section>
@endsection
