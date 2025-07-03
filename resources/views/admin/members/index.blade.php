@extends('layouts.app')

@section('title', 'Manajemen Anggota')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Manajemen Anggota</h1>
        <a href="{{ route('admin.members.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i>
            Tambah Anggota
        </a>
    </div>

    <div class="card shadow">
        <div class="card-header">
            <h6 class="m-0 font-weight-bold text-primary">
                <i class="fas fa-user-graduate me-2"></i>
                Daftar Anggota
            </h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>No. Anggota</th>
                            <th>Nama</th>
                            <th>Lokasi</th>
                            <th>Level</th>
                            <th>Tipe</th>
                            <th>Status</th>
                            <th>Bergabung</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($members as $index => $member)
                            <tr>
                                <td>{{ $members->firstItem() + $index }}</td>
                                <td>
                                    <span class="badge badge-info">{{ $member->member_number }}</span>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="avatar me-3">
                                            <i class="fas fa-user-circle fa-2x text-gray-400"></i>
                                        </div>
                                        <div>
                                            <div class="font-weight-bold">{{ $member->user->name }}</div>
                                            <small class="text-muted">{{ $member->user->email }}</small>
                                            @if($member->user->phone)
                                                <br><small class="text-muted">{{ $member->user->phone }}</small>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <small>{{ $member->location->name }}</small>
                                </td>
                                <td>
                                    @if($member->currentLevel)
                                        <span class="badge" style="background-color: {{ $member->currentLevel->color }}; color: white;">
                                            {{ $member->currentLevel->name }}
                                        </span>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td>
                                    <span class="badge badge-{{ $member->membership_type === 'regular' ? 'primary' : ($member->membership_type === 'student' ? 'warning' : 'info') }}">
                                        {{ ucfirst($member->membership_type) }}
                                    </span>
                                </td>
                                <td>
                                    @switch($member->status)
                                        @case('active')
                                            <span class="badge badge-success">Aktif</span>
                                            @break
                                        @case('inactive')
                                            <span class="badge badge-secondary">Tidak Aktif</span>
                                            @break
                                        @case('suspended')
                                            <span class="badge badge-danger">Suspended</span>
                                            @break
                                        @case('graduated')
                                            <span class="badge badge-info">Lulus</span>
                                            @break
                                        @default
                                            <span class="badge badge-secondary">{{ $member->status }}</span>
                                    @endswitch
                                </td>
                                <td>
                                    <small>{{ \Carbon\Carbon::parse($member->join_date)->format('d/m/Y') }}</small>
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('admin.members.show', $member) }}" class="btn btn-sm btn-info" title="Lihat">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.members.edit', $member) }}" class="btn btn-sm btn-warning" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('admin.members.destroy', $member) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus anggota ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" title="Hapus">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="text-center">Tidak ada data anggota.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <!-- Pagination -->
            <div class="d-flex justify-content-center">
                {{ $members->links() }}
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    .badge {
        font-size: 0.75em;
    }
    .badge-info {
        background-color: #3498db;
    }
    .badge-primary {
        background-color: #007bff;
    }
    .badge-warning {
        background-color: #f39c12;
    }
    .badge-success {
        background-color: #2ecc71;
    }
    .badge-secondary {
        background-color: #95a5a6;
    }
    .badge-danger {
        background-color: #e74a3b;
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
