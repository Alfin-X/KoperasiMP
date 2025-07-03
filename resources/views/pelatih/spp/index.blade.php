@extends('layouts.app')

@section('title', 'SPP - Pelatih')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">
                        <i class="fas fa-money-bill me-2"></i>
                        Manajemen SPP
                    </h5>
                    <div>
                        <button class="btn btn-success me-2">
                            <i class="fas fa-download me-1"></i>
                            Export Excel
                        </button>
                        <button class="btn btn-primary">
                            <i class="fas fa-plus me-1"></i>
                            Catat Pembayaran
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <!-- Filter Section -->
                    <div class="row mb-4">
                        <div class="col-md-3">
                            <label for="month_filter" class="form-label">Bulan</label>
                            <select class="form-select" id="month_filter">
                                <option value="">Pilih Bulan</option>
                                <option value="1">Januari</option>
                                <option value="2">Februari</option>
                                <option value="3">Maret</option>
                                <option value="4">April</option>
                                <option value="5">Mei</option>
                                <option value="6">Juni</option>
                                <option value="7" selected>Juli</option>
                                <option value="8">Agustus</option>
                                <option value="9">September</option>
                                <option value="10">Oktober</option>
                                <option value="11">November</option>
                                <option value="12">Desember</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label for="year_filter" class="form-label">Tahun</label>
                            <select class="form-select" id="year_filter">
                                <option value="2024">2024</option>
                                <option value="2025" selected>2025</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label for="status_filter" class="form-label">Status</label>
                            <select class="form-select" id="status_filter">
                                <option value="">Semua Status</option>
                                <option value="paid">Sudah Bayar</option>
                                <option value="unpaid">Belum Bayar</option>
                                <option value="overdue">Terlambat</option>
                            </select>
                        </div>
                        <div class="col-md-3 d-flex align-items-end">
                            <button type="button" class="btn btn-outline-primary me-2">
                                <i class="fas fa-search me-1"></i>
                                Filter
                            </button>
                            <button type="button" class="btn btn-outline-secondary">
                                <i class="fas fa-redo me-1"></i>
                                Reset
                            </button>
                        </div>
                    </div>

                    <!-- Statistics Cards -->
                    <div class="row mb-4">
                        <div class="col-md-3">
                            <div class="card bg-primary text-white">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <h6 class="card-title">Total Anggota</h6>
                                            <h4 class="mb-0">45</h4>
                                        </div>
                                        <div class="align-self-center">
                                            <i class="fas fa-users fa-2x"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card bg-success text-white">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <h6 class="card-title">Sudah Bayar</h6>
                                            <h4 class="mb-0">32</h4>
                                        </div>
                                        <div class="align-self-center">
                                            <i class="fas fa-check-circle fa-2x"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card bg-warning text-white">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <h6 class="card-title">Belum Bayar</h6>
                                            <h4 class="mb-0">13</h4>
                                        </div>
                                        <div class="align-self-center">
                                            <i class="fas fa-clock fa-2x"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card bg-info text-white">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <h6 class="card-title">Total Terkumpul</h6>
                                            <h4 class="mb-0">Rp 1.6M</h4>
                                        </div>
                                        <div class="align-self-center">
                                            <i class="fas fa-money-bill-wave fa-2x"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- SPP Table -->
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead class="table-dark">
                                <tr>
                                    <th>No</th>
                                    <th>Nama Anggota</th>
                                    <th>Tingkat</th>
                                    <th>Bulan/Tahun</th>
                                    <th>Jumlah SPP</th>
                                    <th>Status</th>
                                    <th>Tanggal Bayar</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="avatar-sm bg-primary rounded-circle d-flex align-items-center justify-content-center me-2">
                                                <span class="text-white fw-bold">AB</span>
                                            </div>
                                            <div>
                                                <div class="fw-bold">Ahmad Budi</div>
                                                <small class="text-muted">ID: MP001</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td><span class="badge bg-success">Hijau</span></td>
                                    <td>Juli 2025</td>
                                    <td>Rp 50.000</td>
                                    <td><span class="badge bg-success">Sudah Bayar</span></td>
                                    <td>01/07/2025</td>
                                    <td>
                                        <button class="btn btn-sm btn-outline-info" title="Lihat Detail">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <button class="btn btn-sm btn-outline-primary" title="Print Kwitansi">
                                            <i class="fas fa-print"></i>
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="avatar-sm bg-info rounded-circle d-flex align-items-center justify-content-center me-2">
                                                <span class="text-white fw-bold">CD</span>
                                            </div>
                                            <div>
                                                <div class="fw-bold">Citra Dewi</div>
                                                <small class="text-muted">ID: MP002</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td><span class="badge bg-warning">Kuning</span></td>
                                    <td>Juli 2025</td>
                                    <td>Rp 40.000</td>
                                    <td><span class="badge bg-warning">Belum Bayar</span></td>
                                    <td>-</td>
                                    <td>
                                        <button class="btn btn-sm btn-success" title="Catat Pembayaran">
                                            <i class="fas fa-plus"></i>
                                        </button>
                                        <button class="btn btn-sm btn-outline-warning" title="Kirim Reminder">
                                            <i class="fas fa-bell"></i>
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>3</td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="avatar-sm bg-warning rounded-circle d-flex align-items-center justify-content-center me-2">
                                                <span class="text-white fw-bold">EF</span>
                                            </div>
                                            <div>
                                                <div class="fw-bold">Eko Firmansyah</div>
                                                <small class="text-muted">ID: MP003</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td><span class="badge bg-primary">Biru</span></td>
                                    <td>Juli 2025</td>
                                    <td>Rp 60.000</td>
                                    <td><span class="badge bg-danger">Terlambat</span></td>
                                    <td>-</td>
                                    <td>
                                        <button class="btn btn-sm btn-success" title="Catat Pembayaran">
                                            <i class="fas fa-plus"></i>
                                        </button>
                                        <button class="btn btn-sm btn-outline-danger" title="Kirim Peringatan">
                                            <i class="fas fa-exclamation-triangle"></i>
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="d-flex justify-content-between align-items-center mt-3">
                        <div>
                            <small class="text-muted">Menampilkan 1-3 dari 45 data</small>
                        </div>
                        <nav>
                            <ul class="pagination pagination-sm mb-0">
                                <li class="page-item disabled">
                                    <span class="page-link">Previous</span>
                                </li>
                                <li class="page-item active">
                                    <span class="page-link">1</span>
                                </li>
                                <li class="page-item">
                                    <a class="page-link" href="#">2</a>
                                </li>
                                <li class="page-item">
                                    <a class="page-link" href="#">3</a>
                                </li>
                                <li class="page-item">
                                    <a class="page-link" href="#">Next</a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.avatar-sm {
    width: 40px;
    height: 40px;
    font-size: 14px;
}
</style>
@endsection
