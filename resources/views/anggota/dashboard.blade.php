@extends('layouts.app')

@section('title', 'Dashboard Anggota')

@section('content')
<div class="container-fluid">
    <!-- Welcome Card -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card shadow">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <h4 class="mb-2">Selamat datang, {{ auth()->user()->name }}!</h4>
                            <p class="text-muted mb-0">
                                Nomor Anggota: <strong>{{ $member->member_number ?? 'Belum ditentukan' }}</strong> | 
                                Tingkatan: <strong>{{ $stats['current_level'] }}</strong>
                            </p>
                        </div>
                        <div class="col-md-4 text-center">
                            <i class="fas fa-user-circle fa-4x text-primary"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="row mb-4">
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Tingkatan Saat Ini
                            </div>
                            <div class="h6 mb-0 font-weight-bold text-gray-800">
                                {{ $stats['current_level'] }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-medal fa-2x text-gray-300"></i>
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
                                Kehadiran Bulan Ini
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ number_format($stats['monthly_attendance']) }} kali
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
                                Tunggakan SPP
                            </div>
                            <div class="h6 mb-0 font-weight-bold text-gray-800">
                                Rp {{ number_format($stats['outstanding_spp'], 0, ',', '.') }}
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
                        Menu Cepat
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <a href="#" class="btn btn-primary btn-block">
                                <i class="fas fa-user me-2"></i>
                                Profil Saya
                            </a>
                        </div>
                        <div class="col-md-6 mb-3">
                            <a href="#" class="btn btn-success btn-block">
                                <i class="fas fa-clipboard-check me-2"></i>
                                Riwayat Absensi
                            </a>
                        </div>
                        <div class="col-md-6 mb-3">
                            <a href="#" class="btn btn-info btn-block">
                                <i class="fas fa-money-bill me-2"></i>
                                Status SPP
                            </a>
                        </div>
                        <div class="col-md-6 mb-3">
                            <a href="#" class="btn btn-warning btn-block">
                                <i class="fas fa-store me-2"></i>
                                Koperasi
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Member Info -->
        <div class="col-lg-6 mb-4">
            <div class="card shadow">
                <div class="card-header">
                    <h6 class="m-0 font-weight-bold">
                        <i class="fas fa-id-card me-2"></i>
                        Informasi Anggota
                    </h6>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <strong>Nomor Anggota:</strong> {{ $member->member_number ?? 'Belum ditentukan' }}
                    </div>
                    <div class="mb-3">
                        <strong>Tanggal Bergabung:</strong> 
                        {{ $member ? \Carbon\Carbon::parse($member->join_date)->format('d F Y') : 'Belum ditentukan' }}
                    </div>
                    <div class="mb-3">
                        <strong>Lokasi Latihan:</strong> {{ auth()->user()->location->name ?? 'Belum ditentukan' }}
                    </div>
                    <div class="mb-3">
                        <strong>Status:</strong> 
                        <span class="badge bg-success">{{ ucfirst($member->status ?? 'active') }}</span>
                    </div>
                    <div class="mb-3">
                        <strong>Jenis Keanggotaan:</strong> 
                        {{ ucfirst($member->membership_type ?? 'regular') }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Progress and Schedule -->
    <div class="row">
        <div class="col-lg-6 mb-4">
            <div class="card shadow">
                <div class="card-header">
                    <h6 class="m-0 font-weight-bold">
                        <i class="fas fa-chart-line me-2"></i>
                        Progress Latihan
                    </h6>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <div class="d-flex justify-content-between">
                            <span>Kehadiran Bulan Ini</span>
                            <span>{{ $stats['monthly_attendance'] }}/20</span>
                        </div>
                        <div class="progress">
                            <div class="progress-bar bg-success" role="progressbar" 
                                 style="width: {{ min(($stats['monthly_attendance'] / 20) * 100, 100) }}%"></div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="d-flex justify-content-between">
                            <span>Target Kenaikan Tingkat</span>
                            <span>75%</span>
                        </div>
                        <div class="progress">
                            <div class="progress-bar bg-warning" role="progressbar" style="width: 75%"></div>
                        </div>
                    </div>
                    <div class="text-center mt-3">
                        <small class="text-muted">
                            Terus semangat berlatih untuk mencapai tingkatan berikutnya!
                        </small>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-6 mb-4">
            <div class="card shadow">
                <div class="card-header">
                    <h6 class="m-0 font-weight-bold">
                        <i class="fas fa-calendar me-2"></i>
                        Jadwal Latihan Minggu Ini
                    </h6>
                </div>
                <div class="card-body">
                    <div class="list-group list-group-flush">
                        <div class="list-group-item d-flex justify-content-between align-items-center">
                            <div>
                                <strong>Senin</strong><br>
                                <small class="text-muted">Latihan Rutin</small>
                            </div>
                            <span class="badge bg-primary">16:00 - 18:00</span>
                        </div>
                        <div class="list-group-item d-flex justify-content-between align-items-center">
                            <div>
                                <strong>Rabu</strong><br>
                                <small class="text-muted">Latihan Rutin</small>
                            </div>
                            <span class="badge bg-primary">16:00 - 18:00</span>
                        </div>
                        <div class="list-group-item d-flex justify-content-between align-items-center">
                            <div>
                                <strong>Jumat</strong><br>
                                <small class="text-muted">Latihan Rutin</small>
                            </div>
                            <span class="badge bg-primary">16:00 - 18:00</span>
                        </div>
                        <div class="list-group-item d-flex justify-content-between align-items-center">
                            <div>
                                <strong>Sabtu</strong><br>
                                <small class="text-muted">Latihan Khusus</small>
                            </div>
                            <span class="badge bg-success">08:00 - 10:00</span>
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
    .progress {
        height: 0.5rem;
    }
</style>
@endpush
@endsection
