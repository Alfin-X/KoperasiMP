@extends('layouts.app')

@section('title', 'Dashboard Admin')

@section('content')
<div class="row">
    <!-- Statistics Cards -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                            Total Anggota Aktif
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalAnggota }}</div>
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
                            Total Pelatih
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalPelatih }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-user-tie fa-2x text-gray-300"></i>
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
                            Total Kolat
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalKolat }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-building fa-2x text-gray-300"></i>
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
                            SPP Pending
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $pendingSppPayments }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-money-bill-wave fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="row">
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
                            <i class="fas fa-user-plus me-2"></i>
                            Tambah Anggota
                        </a>
                    </div>
                    <div class="col-md-6 mb-3">
                        <a href="#" class="btn btn-success btn-block">
                            <i class="fas fa-calendar-plus me-2"></i>
                            Buat Jadwal
                        </a>
                    </div>
                    <div class="col-md-6 mb-3">
                        <a href="#" class="btn btn-info btn-block">
                            <i class="fas fa-money-bill me-2"></i>
                            Generate SPP
                        </a>
                    </div>
                    <div class="col-md-6 mb-3">
                        <a href="#" class="btn btn-warning btn-block">
                            <i class="fas fa-box me-2"></i>
                            Tambah Produk
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-6 mb-4">
        <div class="card shadow">
            <div class="card-header">
                <h6 class="m-0 font-weight-bold">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    Notifikasi Penting
                </h6>
            </div>
            <div class="card-body">
                <div class="list-group list-group-flush">
                    @if($pendingSppPayments > 0)
                    <div class="list-group-item d-flex justify-content-between align-items-center">
                        <div>
                            <i class="fas fa-money-bill text-warning me-2"></i>
                            {{ $pendingSppPayments }} pembayaran SPP menunggu verifikasi
                        </div>
                        <span class="badge bg-warning rounded-pill">{{ $pendingSppPayments }}</span>
                    </div>
                    @endif

                    <div class="list-group-item d-flex justify-content-between align-items-center">
                        <div>
                            <i class="fas fa-calendar text-info me-2"></i>
                            Jadwal latihan minggu ini
                        </div>
                        <span class="badge bg-info rounded-pill">5</span>
                    </div>

                    <div class="list-group-item d-flex justify-content-between align-items-center">
                        <div>
                            <i class="fas fa-shopping-cart text-success me-2"></i>
                            Pesanan baru
                        </div>
                        <span class="badge bg-success rounded-pill">3</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Recent Activities -->
<div class="row">
    <div class="col-12">
        <div class="card shadow">
            <div class="card-header">
                <h6 class="m-0 font-weight-bold">
                    <i class="fas fa-history me-2"></i>
                    Aktivitas Terbaru
                </h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Waktu</th>
                                <th>Aktivitas</th>
                                <th>User</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>{{ now()->format('d/m/Y H:i') }}</td>
                                <td>Pembayaran SPP bulan {{ now()->format('F Y') }}</td>
                                <td>John Doe</td>
                                <td><span class="badge bg-warning">Pending</span></td>
                            </tr>
                            <tr>
                                <td>{{ now()->subHours(2)->format('d/m/Y H:i') }}</td>
                                <td>Absensi latihan Kolat Pusat</td>
                                <td>Pelatih Ahmad</td>
                                <td><span class="badge bg-success">Completed</span></td>
                            </tr>
                            <tr>
                                <td>{{ now()->subHours(5)->format('d/m/Y H:i') }}</td>
                                <td>Pendaftaran anggota baru</td>
                                <td>Jane Smith</td>
                                <td><span class="badge bg-info">Processed</span></td>
                            </tr>
                        </tbody>
                    </table>
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
    .text-gray-800 {
        color: #5a5c69 !important;
    }
    .text-gray-300 {
        color: #dddfeb !important;
    }
</style>
@endpush
@endsection
