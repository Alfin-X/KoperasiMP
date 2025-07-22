@extends('layouts.app')

@section('title', 'Detail Kolat')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0">Detail Kolat</h1>
    <div class="btn-group">
        <a href="{{ route('admin.kolats.edit', 1) }}" class="btn btn-warning">
            <i class="fas fa-edit me-2"></i>
            Edit
        </a>
        <a href="{{ route('admin.kolats.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-2"></i>
            Kembali
        </a>
    </div>
</div>

<div class="row">
    <div class="col-lg-8">
        <!-- Basic Information -->
        <div class="card shadow mb-4">
            <div class="card-header">
                <h6 class="m-0 font-weight-bold">
                    <i class="fas fa-info-circle me-2"></i>
                    Informasi Dasar
                </h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label text-muted">Nama Kolat</label>
                            <p class="fw-bold">Kolat Contoh</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label text-muted">Kode Kolat</label>
                            <p class="fw-bold">KOLAT-001</p>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="mb-3">
                            <label class="form-label text-muted">Alamat</label>
                            <p class="fw-bold">Jl. Contoh No. 123, Jember, Jawa Timur</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label text-muted">Telepon</label>
                            <p class="fw-bold">0331-123456</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label text-muted">Email</label>
                            <p class="fw-bold">kolat@example.com</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label text-muted">Tanggal Berdiri</label>
                            <p class="fw-bold">01 Januari 2024</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label text-muted">Status</label>
                            <span class="badge bg-success fs-6">Aktif</span>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="mb-3">
                            <label class="form-label text-muted">Deskripsi</label>
                            <p class="fw-bold">Kolat yang berlokasi di Jember dengan fokus pada pengembangan karakter dan keterampilan bela diri anggota.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Members List -->
        <div class="card shadow">
            <div class="card-header">
                <h6 class="m-0 font-weight-bold">
                    <i class="fas fa-users me-2"></i>
                    Daftar Anggota
                </h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>ID Anggota</th>
                                <th>Nama</th>
                                <th>Tingkat</th>
                                <th>Status</th>
                                <th>Bergabung</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td colspan="5" class="text-center py-4">
                                    <i class="fas fa-users fa-3x text-muted mb-3"></i>
                                    <p class="text-muted">Belum ada anggota terdaftar di kolat ini.</p>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <!-- Statistics -->
        <div class="card shadow mb-4">
            <div class="card-header">
                <h6 class="m-0 font-weight-bold">
                    <i class="fas fa-chart-bar me-2"></i>
                    Statistik Kolat
                </h6>
            </div>
            <div class="card-body">
                <div class="row text-center">
                    <div class="col-6">
                        <div class="border-right">
                            <h4 class="text-primary">0</h4>
                            <small class="text-muted">Total Anggota</small>
                        </div>
                    </div>
                    <div class="col-6">
                        <h4 class="text-success">0</h4>
                        <small class="text-muted">Anggota Aktif</small>
                    </div>
                </div>
                <hr>
                <div class="row text-center">
                    <div class="col-6">
                        <div class="border-right">
                            <h4 class="text-info">50</h4>
                            <small class="text-muted">Kapasitas</small>
                        </div>
                    </div>
                    <div class="col-6">
                        <h4 class="text-warning">0%</h4>
                        <small class="text-muted">Terisi</small>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pelatih Information -->
        <div class="card shadow mb-4">
            <div class="card-header">
                <h6 class="m-0 font-weight-bold">
                    <i class="fas fa-user-tie me-2"></i>
                    Pelatih Utama
                </h6>
            </div>
            <div class="card-body text-center">
                <img src="https://via.placeholder.com/80x80/6c757d/ffffff?text=P" 
                     class="rounded-circle mb-3" 
                     width="80" 
                     height="80" 
                     alt="Pelatih">
                <h6>Pelatih Contoh</h6>
                <p class="text-muted small">pelatih@example.com</p>
                <span class="badge bg-success">Aktif</span>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="card shadow">
            <div class="card-header">
                <h6 class="m-0 font-weight-bold">
                    <i class="fas fa-cog me-2"></i>
                    Aksi Cepat
                </h6>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <a href="{{ route('admin.kolats.edit', 1) }}" class="btn btn-warning btn-sm">
                        <i class="fas fa-edit me-2"></i>
                        Edit Kolat
                    </a>
                    <button type="button" class="btn btn-info btn-sm">
                        <i class="fas fa-users me-2"></i>
                        Kelola Anggota
                    </button>
                    <button type="button" class="btn btn-success btn-sm">
                        <i class="fas fa-calendar me-2"></i>
                        Jadwal Latihan
                    </button>
                    <button type="button" class="btn btn-primary btn-sm">
                        <i class="fas fa-chart-line me-2"></i>
                        Laporan
                    </button>
                    <hr>
                    <button type="button" class="btn btn-danger btn-sm" onclick="confirmDelete()">
                        <i class="fas fa-trash me-2"></i>
                        Hapus Kolat
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
function confirmDelete() {
    if (confirm('Yakin ingin menghapus kolat ini? Semua data anggota dan riwayat akan ikut terhapus. Tindakan ini tidak dapat dibatalkan.')) {
        // Delete logic here
        alert('Fitur hapus akan diimplementasi');
    }
}
</script>
@endpush

@push('styles')
<style>
    .border-right {
        border-right: 1px solid #e3e6f0;
    }
</style>
@endpush
@endsection
