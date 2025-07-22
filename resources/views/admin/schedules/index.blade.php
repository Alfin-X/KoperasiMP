@extends('layouts.app')

@section('title', 'Jadwal & Absensi')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0">Jadwal & Absensi</h1>
    <a href="{{ route('admin.schedules.create') }}" class="btn btn-primary">
        <i class="fas fa-plus me-2"></i>
        Tambah Jadwal
    </a>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card shadow">
            <div class="card-header">
                <h6 class="m-0 font-weight-bold">
                    <i class="fas fa-calendar me-2"></i>
                    Daftar Jadwal Latihan
                </h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Tanggal</th>
                                <th>Kolat</th>
                                <th>Waktu</th>
                                <th>Topik</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td colspan="6" class="text-center py-4">
                                    <i class="fas fa-calendar fa-3x text-muted mb-3"></i>
                                    <p class="text-muted">Belum ada jadwal latihan.</p>
                                    <a href="{{ route('admin.schedules.create') }}" class="btn btn-primary">
                                        <i class="fas fa-plus me-2"></i>
                                        Buat Jadwal Pertama
                                    </a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-lg-4">
        <div class="card shadow">
            <div class="card-header">
                <h6 class="m-0 font-weight-bold">
                    <i class="fas fa-info-circle me-2"></i>
                    Quick Actions
                </h6>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <a href="{{ route('admin.schedules.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus me-2"></i>
                        Buat Jadwal Baru
                    </a>
                    <a href="{{ route('admin.attendance.index') }}" class="btn btn-info">
                        <i class="fas fa-clipboard-check me-2"></i>
                        Lihat Absensi
                    </a>
                    <a href="#" class="btn btn-success">
                        <i class="fas fa-download me-2"></i>
                        Export Laporan
                    </a>
                </div>
            </div>
        </div>
        
        <div class="card shadow mt-4">
            <div class="card-header">
                <h6 class="m-0 font-weight-bold">
                    <i class="fas fa-chart-bar me-2"></i>
                    Statistik Minggu Ini
                </h6>
            </div>
            <div class="card-body">
                <div class="row text-center">
                    <div class="col-6">
                        <div class="border-right">
                            <h4 class="text-primary">0</h4>
                            <small class="text-muted">Jadwal</small>
                        </div>
                    </div>
                    <div class="col-6">
                        <h4 class="text-success">0%</h4>
                        <small class="text-muted">Kehadiran</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
