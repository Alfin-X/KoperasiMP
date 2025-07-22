@extends('layouts.app')

@section('title', 'Dashboard Pelatih')

@section('content')
<div class="row">
    <!-- Welcome Card -->
    <div class="col-12 mb-4">
        <div class="card shadow">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-hand-paper me-2"></i>
                    Selamat Datang, {{ auth()->user()->name }}
                </h5>
            </div>
            <div class="card-body">
                <p class="mb-0">
                    Anda bertanggung jawab untuk kolat: 
                    <strong>{{ $kolat ? $kolat->name : 'Belum ditugaskan ke kolat' }}</strong>
                </p>
                @if($kolat)
                <small class="text-muted">
                    <i class="fas fa-map-marker-alt me-1"></i>
                    {{ $kolat->address }} | 
                    <i class="fas fa-calendar me-1"></i>
                    {{ $kolat->schedule_day }} {{ $kolat->schedule_time }}
                </small>
                @endif
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Statistics Cards -->
    <div class="col-xl-4 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                            Anggota di Kolat
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $anggotaKolat }}</div>
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
                            Jadwal Hari Ini
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $jadwalHariIni }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-calendar-day fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-4 col-md-6 mb-4">
        <div class="card border-left-info shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                            Transaksi Pending
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
                            <i class="fas fa-clipboard-check me-2"></i>
                            Buka Absensi
                        </a>
                    </div>
                    <div class="col-md-6 mb-3">
                        <a href="#" class="btn btn-success btn-block">
                            <i class="fas fa-users me-2"></i>
                            Lihat Anggota
                        </a>
                    </div>
                    <div class="col-md-6 mb-3">
                        <a href="#" class="btn btn-info btn-block">
                            <i class="fas fa-piggy-bank me-2"></i>
                            Input Simpanan
                        </a>
                    </div>
                    <div class="col-md-6 mb-3">
                        <a href="#" class="btn btn-warning btn-block">
                            <i class="fas fa-history me-2"></i>
                            Riwayat Absensi
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
                    <i class="fas fa-calendar me-2"></i>
                    Jadwal Minggu Ini
                </h6>
            </div>
            <div class="card-body">
                @if($kolat)
                <div class="list-group list-group-flush">
                    <div class="list-group-item d-flex justify-content-between align-items-center">
                        <div>
                            <strong>{{ $kolat->schedule_day }}</strong><br>
                            <small class="text-muted">{{ $kolat->schedule_time }}</small>
                        </div>
                        <span class="badge bg-primary rounded-pill">Rutin</span>
                    </div>
                </div>
                @else
                <p class="text-muted">Anda belum ditugaskan ke kolat manapun.</p>
                @endif
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
                                <th>Detail</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>{{ now()->format('d/m/Y H:i') }}</td>
                                <td>Absensi Latihan</td>
                                <td>15 anggota hadir</td>
                                <td><span class="badge bg-success">Completed</span></td>
                            </tr>
                            <tr>
                                <td>{{ now()->subDays(2)->format('d/m/Y H:i') }}</td>
                                <td>Input Simpanan Wajib</td>
                                <td>10 transaksi dicatat</td>
                                <td><span class="badge bg-warning">Pending Verifikasi</span></td>
                            </tr>
                            <tr>
                                <td>{{ now()->subDays(5)->format('d/m/Y H:i') }}</td>
                                <td>Absensi Latihan</td>
                                <td>12 anggota hadir</td>
                                <td><span class="badge bg-success">Completed</span></td>
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
    .text-gray-800 {
        color: #5a5c69 !important;
    }
    .text-gray-300 {
        color: #dddfeb !important;
    }
</style>
@endpush
@endsection
