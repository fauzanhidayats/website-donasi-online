@extends('layouts.app')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Laporan</h1>
        </div>

        <div class="row">
            {{-- Form Laporan Dnasi --}}
            <div class="col-md-6">
                <h4>Laporan Donasi Berdasarkan Event</h4>
                <form action="{{ route('admin.laporan.donasi') }}" method="POST" target="_blank">
                    @csrf
                    <div class="form-group">
                        <label for="event_id">Pilih Event</label>
                        <select name="event_id" id="event_id" class="form-control" required>
                            <option value="">-- Pilih Event --</option>
                            @foreach ($events as $event)
                                <option value="{{ $event->id }}">{{ $event->nama_event }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="tanggal_mulai_donasi">Tanggal Donasi Mulai</label>
                        <input type="date" name="tanggal_mulai" id="tanggal_mulai_donasi" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="tanggal_selesai_donasi">Tanggal Donasi Selesai</label>
                        <input type="date" name="tanggal_selesai" id="tanggal_selesai_donasi" class="form-control"
                            required>
                    </div>
                    <button class="btn btn-danger">Lihat Laporan</button>
                </form>
            </div>


        </div>
    </section>
@endsection
