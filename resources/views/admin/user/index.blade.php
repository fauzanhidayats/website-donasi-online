@extends('layouts.app')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Kelola Pengguna</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                <div class="breadcrumb-item"><a href="#">Manajemen</a></div>
                <div class="breadcrumb-item">Kelola Pengguna</div>
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
                            <a href="{{ route('users.create') }}" class="btn btn-success">Tambah Pengguna</a>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped" id="table-1">
                                    <thead>
                                        <tr>
                                            <th class="text-center">#</th>
                                            <th>Foto</th>
                                            <th>Username</th>
                                            <th>Email</th>
                                            <th>Role</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($users as $index => $user)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>
                                                    @if ($user->photo)
                                                        <img src="{{ asset('storage/' . $user->photo) }}"
                                                            alt="Foto Pengguna" width="60" height="60"
                                                            class="rounded-circle" style="object-fit: cover;">
                                                    @else
                                                        <span class="text-muted">Tidak ada foto</span>
                                                    @endif
                                                </td>

                                                <td>{{ $user->username }}</td>
                                                <td>{{ $user->email ?? '-' }}</td>
                                                <td>{{ ucfirst($user->role) }}</td>
                                                <td>
                                                    <div class="d-flex">
                                                        <a href="{{ route('users.show', $user->id) }}" class="mr-1">
                                                            <i class="fa fa-eye bg-success text-white p-2 rounded"></i>
                                                        </a>
                                                        <a href="{{ route('users.edit', $user->id) }}" class="mr-1">
                                                            <i class="fa fa-edit bg-primary text-white p-2 rounded"></i>
                                                        </a>
                                                        <form action="{{ route('users.destroy', $user->id) }}"
                                                            method="POST"
                                                            onsubmit="return confirm('Yakin ingin menghapus pengguna ini?')">
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
                                                <td colspan="6" class="text-center text-muted">Belum ada data pengguna
                                                </td>
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
