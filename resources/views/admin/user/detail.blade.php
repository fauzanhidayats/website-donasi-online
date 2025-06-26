@extends('layouts.app')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Detail Pengguna</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item"><a href="#">Dashboard</a></div>
                <div class="breadcrumb-item"><a href="{{ route('users.index') }}">Pengguna</a></div>
                <div class="breadcrumb-item active">Detail</div>
            </div>
        </div>

        <div class="section-body">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Informasi Pengguna</h4>
                        </div>
                        <div class="card-body">
                            <div class="text-center mb-4">
                                @if ($user->photo)
                                    <img src="{{ asset('storage/' . $user->photo) }}" alt="Foto Pengguna" width="100"
                                        height="100" class="rounded-circle" style="object-fit: cover;">
                                @else
                                    <span class="text-muted">Tidak ada foto</span>
                                @endif
                            </div>

                            <table class="table table-bordered">
                                <tr>
                                    <th>Username</th>
                                    <td>{{ $user->username }}</td>
                                </tr>
                                <tr>
                                    <th>Email</th>
                                    <td>{{ $user->email ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th>No. Telepon</th>
                                    <td>{{ $user->no_telp ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th>Role</th>
                                    <td>{{ ucfirst($user->role) }}</td>
                                </tr>
                                <tr>
                                    <th>Dibuat pada</th>
                                    <td>{{ $user->created_at->format('d M Y - H:i') }}</td>
                                </tr>
                                <tr>
                                    <th>Diperbarui pada</th>
                                    <td>{{ $user->updated_at->format('d M Y - H:i') }}</td>
                                </tr>
                            </table>

                            <div class="mt-4">
                                <a href="{{ route('users.edit', $user->id) }}" class="btn btn-primary">Edit</a>
                                <a href="{{ route('users.index') }}" class="btn btn-secondary">Kembali</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
