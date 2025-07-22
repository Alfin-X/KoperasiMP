@extends('layouts.app')

@section('title', 'Profil Saya')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0">Profil Saya</h1>
    <a href="{{ route('anggota.profile.edit') }}" class="btn btn-primary">
        <i class="fas fa-edit me-2"></i>
        Edit Profil
    </a>
</div>

<div class="row">
    <div class="col-lg-4">
        <!-- Profile Picture Card -->
        <div class="card shadow">
            <div class="card-body text-center">
                <div class="mb-3">
                    <img src="https://via.placeholder.com/150x150/6c757d/ffffff?text=MP" 
                         class="rounded-circle" 
                         width="150" 
                         height="150" 
                         alt="Profile Picture">
                </div>
                <h5 class="card-title">{{ $user->name }}</h5>
                <p class="text-muted">{{ $user->email }}</p>
                <span class="badge bg-success">Anggota Aktif</span>
            </div>
        </div>

        <!-- Quick Stats -->
        <div class="card shadow mt-4">
            <div class="card-header">
                <h6 class="m-0 font-weight-bold">
                    <i class="fas fa-chart-bar me-2"></i>
                    Statistik Saya
                </h6>
            </div>
            <div class="card-body">
                <div class="row text-center">
                    <div class="col-6">
                        <div class="border-right">
                            <h4 class="text-primary">0</h4>
                            <small class="text-muted">Latihan</small>
                        </div>
                    </div>
                    <div class="col-6">
                        <h4 class="text-success">0%</h4>
                        <small class="text-muted">Kehadiran</small>
                    </div>
                </div>
                <hr>
                <div class="row text-center">
                    <div class="col-6">
                        <div class="border-right">
                            <h4 class="text-info">Rp 0</h4>
                            <small class="text-muted">Simpanan</small>
                        </div>
                    </div>
                    <div class="col-6">
                        <h4 class="text-warning">0</h4>
                        <small class="text-muted">Pesanan</small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-8">
        <!-- Personal Information -->
        <div class="card shadow">
            <div class="card-header">
                <h6 class="m-0 font-weight-bold">
                    <i class="fas fa-user me-2"></i>
                    Informasi Personal
                </h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label text-muted">Nama Lengkap</label>
                            <p class="fw-bold">{{ $user->name }}</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label text-muted">Email</label>
                            <p class="fw-bold">{{ $user->email }}</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label text-muted">ID Anggota</label>
                            <p class="fw-bold">{{ $user->id_anggota ?? 'Belum diset' }}</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label text-muted">Kolat</label>
                            <p class="fw-bold">{{ $user->kolat->name ?? 'Belum ditentukan' }}</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label text-muted">Tingkat</label>
                            <p class="fw-bold">{{ $user->tingkat ?? 'Pemula' }}</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label text-muted">Status</label>
                            <span class="badge bg-success">Aktif</span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label text-muted">Tanggal Bergabung</label>
                            <p class="fw-bold">{{ $user->created_at->format('d M Y') }}</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label text-muted">Terakhir Update</label>
                            <p class="fw-bold">{{ $user->updated_at->format('d M Y') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Activities -->
        <div class="card shadow mt-4">
            <div class="card-header">
                <h6 class="m-0 font-weight-bold">
                    <i class="fas fa-history me-2"></i>
                    Aktivitas Terbaru
                </h6>
            </div>
            <div class="card-body">
                <div class="text-center py-4">
                    <i class="fas fa-history fa-3x text-muted mb-3"></i>
                    <p class="text-muted">Belum ada aktivitas terbaru.</p>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    .border-right {
        border-right: 1px solid #e3e6f0;
    }
    .text-gray-800 {
        color: #5a5c69 !important;
    }
    .text-gray-300 {
        color: #dddfeb !important;
    }
</style>
@endpush
@endsection
