@extends('layouts.app')

@section('title', 'Dashboard Anggota')

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
                <div class="row">
                    <div class="col-md-6">
                        <p class="mb-1"><strong>ID Anggota:</strong> {{ auth()->user()->member_id ?? 'Belum ditetapkan' }}</p>
                        <p class="mb-1"><strong>Tingkatan:</strong> {{ auth()->user()->tingkatan ?? 'Belum ditetapkan' }}</p>
                        <p class="mb-0"><strong>Kolat:</strong> {{ $kolat ? $kolat->name : 'Belum ditugaskan' }}</p>
                    </div>
                    <div class="col-md-6">
                        @if($kolat)
                        <p class="mb-1"><strong>Alamat Kolat:</strong> {{ $kolat->address }}</p>
                        <p class="mb-0"><strong>Jadwal:</strong> {{ $kolat->schedule_day }} {{ $kolat->schedule_time }}</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Statistics Cards -->
    <div class="col-xl-4 col-md-6 mb-4">
        <div class="card border-left-warning shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                            SPP Belum Bayar
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $sppBelumBayar }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-money-bill-wave fa-2x text-gray-300"></i>
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
                            Saldo Simpanan
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">Rp 0</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-piggy-bank fa-2x text-gray-300"></i>
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
                            Kehadiran Bulan Ini
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">85%</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-chart-line fa-2x text-gray-300"></i>
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
                            <i class="fas fa-money-bill me-2"></i>
                            Bayar SPP
                        </a>
                    </div>
                    <div class="col-md-6 mb-3">
                        <a href="#" class="btn btn-success btn-block">
                            <i class="fas fa-piggy-bank me-2"></i>
                            Lihat Simpanan
                        </a>
                    </div>
                    <div class="col-md-6 mb-3">
                        <a href="#" class="btn btn-info btn-block">
                            <i class="fas fa-shopping-cart me-2"></i>
                            Belanja
                        </a>
                    </div>
                    <div class="col-md-6 mb-3">
                        <a href="#" class="btn btn-warning btn-block">
                            <i class="fas fa-user me-2"></i>
                            Edit Profil
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
                    Jadwal Terdekat
                </h6>
            </div>
            <div class="card-body">
                @if($jadwalTerdekat)
                <div class="list-group list-group-flush">
                    <div class="list-group-item d-flex justify-content-between align-items-center">
                        <div>
                            <strong>{{ $jadwalTerdekat->date->format('d F Y') }}</strong><br>
                            <small class="text-muted">
                                {{ $jadwalTerdekat->start_time }} - {{ $jadwalTerdekat->end_time }}
                            </small><br>
                            <small class="text-muted">{{ $jadwalTerdekat->topic ?? 'Latihan Rutin' }}</small>
                        </div>
                        <span class="badge bg-primary rounded-pill">
                            {{ $jadwalTerdekat->date->diffForHumans() }}
                        </span>
                    </div>
                </div>
                @elseif($kolat)
                <div class="list-group list-group-flush">
                    <div class="list-group-item d-flex justify-content-between align-items-center">
                        <div>
                            <strong>{{ $kolat->schedule_day }}</strong><br>
                            <small class="text-muted">{{ $kolat->schedule_time }}</small><br>
                            <small class="text-muted">Latihan Rutin</small>
                        </div>
                        <span class="badge bg-primary rounded-pill">Mingguan</span>
                    </div>
                </div>
                @else
                <p class="text-muted">Belum ada jadwal tersedia.</p>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Notifications -->
@if($sppBelumBayar > 0)
<div class="row">
    <div class="col-12 mb-4">
        <div class="alert alert-warning" role="alert">
            <h6 class="alert-heading">
                <i class="fas fa-exclamation-triangle me-2"></i>
                Perhatian!
            </h6>
            <p class="mb-0">
                Anda memiliki {{ $sppBelumBayar }} tagihan SPP yang belum dibayar. 
                Silakan lakukan pembayaran segera untuk menghindari denda.
            </p>
        </div>
    </div>
</div>
@endif

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
                                <th>Tanggal</th>
                                <th>Aktivitas</th>
                                <th>Detail</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>{{ now()->format('d/m/Y') }}</td>
                                <td>Absensi Latihan</td>
                                <td>Kolat {{ $kolat?->name ?? 'N/A' }}</td>
                                <td><span class="badge bg-success">Hadir</span></td>
                            </tr>
                            <tr>
                                <td>{{ now()->subDays(3)->format('d/m/Y') }}</td>
                                <td>Pembayaran SPP</td>
                                <td>Bulan {{ now()->subMonth()->format('F Y') }}</td>
                                <td><span class="badge bg-success">Lunas</span></td>
                            </tr>
                            <tr>
                                <td>{{ now()->subWeek()->format('d/m/Y') }}</td>
                                <td>Absensi Latihan</td>
                                <td>Kolat {{ $kolat?->name ?? 'N/A' }}</td>
                                <td><span class="badge bg-success">Hadir</span></td>
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
