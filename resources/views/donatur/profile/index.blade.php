@extends('layouts.app')

@section('content')
    <div class="col-12 col-md-12 col-lg-7">
        <div class="card">
            <form method="POST" action="{{ route('donatur.profile.update') }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="card-header">
                    <h4>Edit Profile</h4>
                </div>

                <div class="card-body">

                    @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    <div class="form-group">
                        <label>Foto Profil</label><br>
                        @if ($user->photo)
                            <img src="{{ asset('storage/' . $user->photo) }}" width="100" class="mb-2 rounded-circle"
                                style="object-fit: cover;">
                        @else
                            <span class="text-muted">Tidak ada foto</span>
                        @endif
                        <input type="file" name="photo" class="form-control @error('photo') is-invalid @enderror">
                        @error('photo')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label>Username</label>
                        <input type="text" name="username" value="{{ old('username', $user->username) }}"
                            class="form-control @error('username') is-invalid @enderror" required>
                        @error('username')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" name="email" value="{{ old('email', $user->email) }}"
                            class="form-control @error('email') is-invalid @enderror" required>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label>No. Telepon</label>
                        <input type="text" name="no_telp" value="{{ old('no_telp', $user->no_telp) }}"
                            class="form-control @error('no_telp') is-invalid @enderror">
                        @error('no_telp')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label>Password <small class="text-muted">(kosongkan jika tidak ingin diubah)</small></label>
                        <input type="password" name="password" class="form-control @error('password') is-invalid @enderror">
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                </div>

                <div class="card-footer text-right">
                    <button class="btn btn-primary">Simpan Perubahan</button>
                </div>

            </form>
        </div>
    </div>
@endsection
