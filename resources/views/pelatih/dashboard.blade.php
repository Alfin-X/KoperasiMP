@extends('layouts.app')

@section('title', 'Dashboard Pelatih')

@section('content')
<div class="container-fluid">
    <!-- Stats Cards -->
    <div class="row mb-4">
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Anggota di Lokasi
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ number_format($stats['location_members']) }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-users fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Kehadiran Hari Ini
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ number_format($stats['today_attendance']) }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-clipboard-check fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Usulan Kenaikan Tingkat
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ number_format($stats['pending_promotions']) }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-level-up-alt fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Content Row -->
    <div class="row">
        <!-- Quick Actions -->
        <div class="col-lg-6 mb-4">
            <div class="card shadow">
                <div class="card-header">
                    <h6 class="m-0 font-weight-bold">
                        <i class="fas fa-bolt me-2"></i>
                        Aksi Cepat
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <a href="#" class="btn btn-primary btn-block">
                                <i class="fas fa-clipboard-check me-2"></i>
                                Catat Absensi
                            </a>
                        </div>
                        <div class="col-md-6 mb-3">
                            <a href="#" class="btn btn-success btn-block">
                                <i class="fas fa-users me-2"></i>
                                Kelola Anggota
                            </a>
                        </div>
                        <div class="col-md-6 mb-3">
                            <a href="#" class="btn btn-info btn-block">
                                <i class="fas fa-level-up-alt me-2"></i>
                                Usulkan Kenaikan
                            </a>
                        </div>
                        <div class="col-md-6 mb-3">
                            <a href="#" class="btn btn-warning btn-block">
                                <i class="fas fa-calendar me-2"></i>
                                Jadwal Latihan
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Today's Schedule -->
        <div class="col-lg-6 mb-4">
            <div class="card shadow">
                <div class="card-header">
                    <h6 class="m-0 font-weight-bold">
                        <i class="fas fa-calendar-day me-2"></i>
                        Jadwal Hari Ini
                    </h6>
                </div>
                <div class="card-body">
                    <div class="list-group list-group-flush">
                        <div class="list-group-item d-flex justify-content-between align-items-center">
                            <div>
                                <strong>Latihan Pagi</strong><br>
                                <small class="text-muted">Sabuk Putih - Kuning</small>
                            </div>
                            <span class="badge bg-primary">06:00 - 08:00</span>
                        </div>
                        <div class="list-group-item d-flex justify-content-between align-items-center">
                            <div>
                                <strong>Latihan Sore</strong><br>
                                <small class="text-muted">Sabuk Hijau - Biru</small>
                            </div>
                            <span class="badge bg-success">16:00 - 18:00</span>
                        </div>
                        <div class="list-group-item d-flex justify-content-between align-items-center">
                            <div>
                                <strong>Latihan Malam</strong><br>
                                <small class="text-muted">Sabuk Coklat - Hitam</small>
                            </div>
                            <span class="badge bg-warning">19:00 - 21:00</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Activities and Member Progress -->
    <div class="row">
        <div class="col-lg-6 mb-4">
            <div class="card shadow">
                <div class="card-header">
                    <h6 class="m-0 font-weight-bold">
                        <i class="fas fa-clock me-2"></i>
                        Aktivitas Terbaru
                    </h6>
                </div>
                <div class="card-body">
                    <div class="list-group list-group-flush">
                        <div class="list-group-item d-flex justify-content-between align-items-center">
                            <div>
                                <i class="fas fa-clipboard-check text-success me-2"></i>
                                Absensi pagi telah dicatat
                            </div>
                            <small class="text-muted">2 jam lalu</small>
                        </div>
                        <div class="list-group-item d-flex justify-content-between align-items-center">
                            <div>
                                <i class="fas fa-user-plus text-primary me-2"></i>
                                Anggota baru ditambahkan
                            </div>
                            <small class="text-muted">4 jam lalu</small>
                        </div>
                        <div class="list-group-item d-flex justify-content-between align-items-center">
                            <div>
                                <i class="fas fa-level-up-alt text-warning me-2"></i>
                                Usulan kenaikan tingkat dibuat
                            </div>
                            <small class="text-muted">1 hari lalu</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-6 mb-4">
            <div class="card shadow">
                <div class="card-header">
                    <h6 class="m-0 font-weight-bold">
                        <i class="fas fa-chart-pie me-2"></i>
                        Distribusi Tingkatan Anggota
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-6 mb-3">
                            <div class="border-left-primary p-3">
                                <div class="h6 mb-0">15</div>
                                <small class="text-muted">Sabuk Putih</small>
                            </div>
                        </div>
                        <div class="col-6 mb-3">
                            <div class="border-left-warning p-3">
                                <div class="h6 mb-0">12</div>
                                <small class="text-muted">Sabuk Kuning</small>
                            </div>
                        </div>
                        <div class="col-6 mb-3">
                            <div class="border-left-success p-3">
                                <div class="h6 mb-0">8</div>
                                <small class="text-muted">Sabuk Hijau</small>
                            </div>
                        </div>
                        <div class="col-6 mb-3">
                            <div class="border-left-info p-3">
                                <div class="h6 mb-0">5</div>
                                <small class="text-muted">Sabuk Biru</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    .border-left-primary {
        border-left: 0.25rem solid #4e73df !important;
    }
    .border-left-success {
        border-left: 0.25rem solid #1cc88a !important;
    }
    .border-left-info {
        border-left: 0.25rem solid #36b9cc !important;
    }
    .border-left-warning {
        border-left: 0.25rem solid #f6c23e !important;
    }
    .text-xs {
        font-size: 0.7rem;
    }
    .btn-block {
        width: 100%;
    }
</style>
@endpush
@endsection
