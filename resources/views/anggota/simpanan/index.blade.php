@extends('layouts.app')

@section('title', 'Simpanan Saya')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0">Simpanan Saya</h1>
    <div class="d-flex gap-2">
        <a href="{{ route('anggota.simpanan.balance') }}" class="btn btn-info">
            <i class="fas fa-wallet me-2"></i>
            Lihat Saldo
        </a>
        <a href="{{ route('anggota.simpanan.history') }}" class="btn btn-warning">
            <i class="fas fa-history me-2"></i>
            Riwayat
        </a>
        <a href="{{ route('anggota.simpanan.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i>
            Tambah Simpanan
        </a>
    </div>
</div>

<!-- Balance Card -->
<div class="row mb-4">
    <div class="col-lg-6">
        <div class="card bg-gradient-primary text-white shadow">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-white text-uppercase mb-1">
                            Saldo Simpanan
                        </div>
                        <div class="h3 mb-0 font-weight-bold text-white">
                            Rp {{ number_format($savings->total_balance ?? 0, 0, ',', '.') }}
                        </div>
                        <div class="text-xs text-white-50 mt-2">
                            <i class="fas fa-calendar me-1"></i>
                            Update terakhir: {{ $savings->updated_at ? $savings->updated_at->format('d M Y') : now()->format('d M Y') }}
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-piggy-bank fa-3x text-white-50"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-lg-6">
        <div class="row">
            <div class="col-6">
                <div class="card border-left-success shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                    Total Setor
                                </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                    Rp {{ number_format($savings->total_balance ?? 0, 0, ',', '.') }}
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-arrow-up fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-6">
                <div class="card border-left-warning shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                    Total Tarik
                                </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                    Rp {{ number_format(0, 0, ',', '.') }}
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-arrow-down fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Transaction History -->
<div class="card shadow">
    <div class="card-header">
        <h6 class="m-0 font-weight-bold">
            <i class="fas fa-history me-2"></i>
            Riwayat Transaksi Simpanan
        </h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>Jenis</th>
                        <th>Nominal</th>
                        <th>Saldo</th>
                        <th>Keterangan</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td colspan="6" class="text-center py-4">
                            <i class="fas fa-piggy-bank fa-3x text-muted mb-3"></i>
                            <p class="text-muted">Belum ada transaksi simpanan.</p>
                            <a href="{{ route('anggota.simpanan.create') }}" class="btn btn-primary">
                                <i class="fas fa-plus me-2"></i>
                                Mulai Menabung
                            </a>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

@push('styles')
<style>
    .bg-gradient-primary {
        background: linear-gradient(87deg, #4e73df 0, #224abe 100%) !important;
    }
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
    .text-white-50 {
        color: rgba(255, 255, 255, 0.5) !important;
    }
</style>
@endpush
@endsection
