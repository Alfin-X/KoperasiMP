@extends('layouts.app')

@section('title', 'Dashboard Admin Pusat')

@section('content')
<div class="container-fluid">
    <!-- Stats Cards -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Total Anggota
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ number_format($stats['total_members']) }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-users fa-2x text-gray-300"></i>
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
                                Total Lokasi
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ number_format($stats['total_locations']) }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-map-marker-alt fa-2x text-gray-300"></i>
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
                                Total Pelatih
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ number_format($stats['total_instructors']) }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-chalkboard-teacher fa-2x text-gray-300"></i>
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
                                Pendapatan Bulan Ini
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                Rp {{ number_format($stats['monthly_revenue'], 0, ',', '.') }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-money-bill-wave fa-2x text-gray-300"></i>
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
                            <a href="{{ route('admin.members.create') }}" class="btn btn-primary btn-block">
                                <i class="fas fa-user-plus me-2"></i>
                                Tambah Anggota
                            </a>
                        </div>
                        <div class="col-md-6 mb-3">
                            <a href="{{ route('admin.locations.create') }}" class="btn btn-success btn-block">
                                <i class="fas fa-map-marker-alt me-2"></i>
                                Tambah Lokasi
                            </a>
                        </div>
                        <div class="col-md-6 mb-3">
                            <a href="{{ route('admin.announcements.create') }}" class="btn btn-info btn-block">
                                <i class="fas fa-bullhorn me-2"></i>
                                Buat Pengumuman
                            </a>
                        </div>
                        <div class="col-md-6 mb-3">
                            <a href="#" class="btn btn-warning btn-block">
                                <i class="fas fa-chart-bar me-2"></i>
                                Lihat Laporan
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Activities -->
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
                                <i class="fas fa-user-plus text-success me-2"></i>
                                Anggota baru bergabung
                            </div>
                            <small class="text-muted">2 jam lalu</small>
                        </div>
                        <div class="list-group-item d-flex justify-content-between align-items-center">
                            <div>
                                <i class="fas fa-money-bill text-primary me-2"></i>
                                Pembayaran SPP diterima
                            </div>
                            <small class="text-muted">4 jam lalu</small>
                        </div>
                        <div class="list-group-item d-flex justify-content-between align-items-center">
                            <div>
                                <i class="fas fa-trophy text-warning me-2"></i>
                                Event baru dibuat
                            </div>
                            <small class="text-muted">1 hari lalu</small>
                        </div>
                        <div class="list-group-item d-flex justify-content-between align-items-center">
                            <div>
                                <i class="fas fa-level-up-alt text-info me-2"></i>
                                Kenaikan tingkat disetujui
                            </div>
                            <small class="text-muted">2 hari lalu</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Row -->
    <div class="row">
        <div class="col-lg-12 mb-4">
            <div class="card shadow">
                <div class="card-header">
                    <h6 class="m-0 font-weight-bold">
                        <i class="fas fa-chart-area me-2"></i>
                        Grafik Pertumbuhan Anggota
                    </h6>
                </div>
                <div class="card-body">
                    <div class="text-center">
                        <p class="text-muted">Grafik akan ditampilkan di sini</p>
                        <i class="fas fa-chart-line fa-3x text-gray-300"></i>
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
