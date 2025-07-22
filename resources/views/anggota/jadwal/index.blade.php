@extends('layouts.app')

@section('title', 'Jadwal Latihan')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0">Jadwal Latihan Saya</h1>
    <div class="btn-group">
        <button type="button" class="btn btn-info">
            <i class="fas fa-calendar-week me-2"></i>
            Minggu Ini
        </button>
        <button type="button" class="btn btn-outline-info">
            <i class="fas fa-calendar-month me-2"></i>
            Bulan Ini
        </button>
    </div>
</div>

<!-- Statistics Cards -->
<div class="row mb-4">
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                            Jadwal Minggu Ini
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">0</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-calendar-week fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                            Kehadiran Bulan Ini
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">0%</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-check-circle fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-info shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                            Total Latihan
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">0</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-dumbbell fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-warning shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                            Jadwal Mendatang
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">0</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-clock fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Schedule Table -->
<div class="card shadow">
    <div class="card-header">
        <h6 class="m-0 font-weight-bold">
            <i class="fas fa-calendar me-2"></i>
            Jadwal Latihan
        </h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>Waktu</th>
                        <th>Topik Latihan</th>
                        <th>Pelatih</th>
                        <th>Lokasi</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td colspan="7" class="text-center py-4">
                            <i class="fas fa-calendar fa-3x text-muted mb-3"></i>
                            <p class="text-muted">Belum ada jadwal latihan untuk Anda.</p>
                            <p class="text-muted small">Hubungi pelatih Anda untuk informasi jadwal latihan.</p>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Quick Info -->
<div class="row mt-4">
    <div class="col-lg-6">
        <div class="card shadow">
            <div class="card-header">
                <h6 class="m-0 font-weight-bold">
                    <i class="fas fa-info-circle me-2"></i>
                    Informasi Penting
                </h6>
            </div>
            <div class="card-body">
                <ul class="list-unstyled mb-0">
                    <li class="mb-2">
                        <i class="fas fa-clock text-primary me-2"></i>
                        Datang 15 menit sebelum latihan dimulai
                    </li>
                    <li class="mb-2">
                        <i class="fas fa-tshirt text-success me-2"></i>
                        Gunakan seragam latihan yang sesuai
                    </li>
                    <li class="mb-2">
                        <i class="fas fa-phone text-info me-2"></i>
                        Hubungi pelatih jika berhalangan hadir
                    </li>
                    <li>
                        <i class="fas fa-heart text-danger me-2"></i>
                        Jaga kesehatan dan stamina
                    </li>
                </ul>
            </div>
        </div>
    </div>
    
    <div class="col-lg-6">
        <div class="card shadow">
            <div class="card-header">
                <h6 class="m-0 font-weight-bold">
                    <i class="fas fa-user-tie me-2"></i>
                    Kontak Pelatih
                </h6>
            </div>
            <div class="card-body">
                <div class="text-center">
                    <i class="fas fa-user-circle fa-3x text-muted mb-3"></i>
                    <p class="text-muted">Informasi pelatih akan ditampilkan di sini setelah Anda terdaftar di kolat.</p>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    .border-left-success {
        border-left: 0.25rem solid #1cc88a !important;
    }
    .border-left-warning {
        border-left: 0.25rem solid #f6c23e !important;
    }
    .border-left-danger {
        border-left: 0.25rem solid #e74a3b !important;
    }
    .border-left-info {
        border-left: 0.25rem solid #36b9cc !important;
    }
    .border-left-primary {
        border-left: 0.25rem solid #4e73df !important;
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
