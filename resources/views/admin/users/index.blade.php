@extends('layouts.app')

@section('title', 'Manajemen User')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Manajemen User</h1>
        <a href="{{ route('admin.users.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i>
            Tambah User
        </a>
    </div>

    <div class="card shadow">
        <div class="card-header">
            <h6 class="m-0 font-weight-bold text-primary">
                <i class="fas fa-users me-2"></i>
                Daftar User
            </h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Lokasi</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($users as $index => $user)
                            <tr>
                                <td>{{ $users->firstItem() + $index }}</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="avatar me-3">
                                            <i class="fas fa-user-circle fa-2x text-gray-400"></i>
                                        </div>
                                        <div>
                                            <div class="font-weight-bold">{{ $user->name }}</div>
                                            @if($user->phone)
                                                <small class="text-muted">{{ $user->phone }}</small>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td>{{ $user->email }}</td>
                                <td>
                                    <span class="badge badge-{{ $user->role->name === 'admin_pusat' ? 'danger' : ($user->role->name === 'admin_cabang' ? 'warning' : ($user->role->name === 'pelatih' ? 'info' : 'success')) }}">
                                        {{ $user->role->display_name }}
                                    </span>
                                </td>
                                <td>
                                    @if($user->location)
                                        <small>{{ $user->location->name }}</small>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td>
                                    @if($user->is_active)
                                        <span class="badge badge-success">Aktif</span>
                                    @else
                                        <span class="badge badge-secondary">Tidak Aktif</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('admin.users.show', $user) }}" class="btn btn-sm btn-info" title="Lihat">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-sm btn-warning" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        @if($user->id !== auth()->id())
                                            <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus user ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" title="Hapus">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center">Tidak ada data user.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <!-- Pagination -->
            <div class="d-flex justify-content-center">
                {{ $users->links() }}
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    .badge {
        font-size: 0.75em;
    }
    .badge-danger {
        background-color: #e74a3b;
    }
    .badge-warning {
        background-color: #f39c12;
    }
    .badge-info {
        background-color: #3498db;
    }
    .badge-success {
        background-color: #2ecc71;
    }
    .badge-secondary {
        background-color: #95a5a6;
    }
    .avatar {
        width: 40px;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
</style>
@endpush
@endsection
