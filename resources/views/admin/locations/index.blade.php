@extends('layouts.app')

@section('title', 'Manajemen Lokasi')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Manajemen Lokasi</h1>
        <a href="{{ route('admin.locations.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i>
            Tambah Lokasi
        </a>
    </div>

    <div class="card shadow">
        <div class="card-header">
            <h6 class="m-0 font-weight-bold text-primary">
                <i class="fas fa-map-marker-alt me-2"></i>
                Daftar Lokasi
            </h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Kode</th>
                            <th>Nama Lokasi</th>
                            <th>Alamat</th>
                            <th>Kapasitas</th>
                            <th>Jumlah User</th>
                            <th>Jumlah Anggota</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($locations as $index => $location)
                            <tr>
                                <td>{{ $locations->firstItem() + $index }}</td>
                                <td>
                                    <span class="badge badge-info">{{ $location->code }}</span>
                                </td>
                                <td>
                                    <div>
                                        <div class="font-weight-bold">{{ $location->name }}</div>
                                        @if($location->phone)
                                            <small class="text-muted">
                                                <i class="fas fa-phone me-1"></i>
                                                {{ $location->phone }}
                                            </small>
                                        @endif
                                    </div>
                                </td>
                                <td>
                                    <small>{{ Str::limit($location->address, 50) }}</small>
                                </td>
                                <td>
                                    <span class="badge badge-secondary">{{ $location->capacity }} orang</span>
                                </td>
                                <td>
                                    <span class="badge badge-primary">{{ $location->users_count }}</span>
                                </td>
                                <td>
                                    <span class="badge badge-success">{{ $location->members_count }}</span>
                                </td>
                                <td>
                                    @if($location->is_active)
                                        <span class="badge badge-success">Aktif</span>
                                    @else
                                        <span class="badge badge-secondary">Tidak Aktif</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('admin.locations.show', $location) }}" class="btn btn-sm btn-info" title="Lihat">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.locations.edit', $location) }}" class="btn btn-sm btn-warning" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('admin.locations.destroy', $location) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus lokasi ini?')">
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
                                <td colspan="9" class="text-center">Tidak ada data lokasi.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <!-- Pagination -->
            <div class="d-flex justify-content-center">
                {{ $locations->links() }}
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
    .badge-success {
        background-color: #2ecc71;
    }
    .badge-secondary {
        background-color: #95a5a6;
    }
</style>
@endpush
@endsection
