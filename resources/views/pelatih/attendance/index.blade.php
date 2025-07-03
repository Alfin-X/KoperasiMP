@extends('layouts.app')

@section('title', 'Absensi - Pelatih')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">
                        <i class="fas fa-clipboard-check me-2"></i>
                        Manajemen Absensi
                    </h5>
                    <a href="{{ route('attendance.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus me-1"></i>
                        Buat Absensi Baru
                    </a>
                </div>
                <div class="card-body">
                    <!-- Filter Section -->
                    <div class="row mb-4">
                        <div class="col-md-3">
                            <label for="date_filter" class="form-label">Tanggal</label>
                            <input type="date" class="form-control" id="date_filter" value="{{ date('Y-m-d') }}">
                        </div>
                        <div class="col-md-3">
                            <label for="schedule_filter" class="form-label">Jadwal</label>
                            <select class="form-select" id="schedule_filter">
                                <option value="">Semua Jadwal</option>
                                <option value="pagi">Pagi (06:00-08:00)</option>
                                <option value="sore">Sore (16:00-18:00)</option>
                                <option value="malam">Malam (19:00-21:00)</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label for="level_filter" class="form-label">Tingkat</label>
                            <select class="form-select" id="level_filter">
                                <option value="">Semua Tingkat</option>
                                <option value="putih">Putih</option>
                                <option value="kuning">Kuning</option>
                                <option value="hijau">Hijau</option>
                                <option value="biru">Biru</option>
                                <option value="coklat">Coklat</option>
                                <option value="hitam">Hitam</option>
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
                                            <h6 class="card-title">Hadir Hari Ini</h6>
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
                                            <h6 class="card-title">Tidak Hadir</h6>
                                            <h4 class="mb-0">13</h4>
                                        </div>
                                        <div class="align-self-center">
                                            <i class="fas fa-times-circle fa-2x"></i>
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
                                            <h6 class="card-title">Persentase Kehadiran</h6>
                                            <h4 class="mb-0">71%</h4>
                                        </div>
                                        <div class="align-self-center">
                                            <i class="fas fa-chart-pie fa-2x"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Attendance Table -->
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead class="table-dark">
                                <tr>
                                    <th>No</th>
                                    <th>Nama Anggota</th>
                                    <th>Tingkat</th>
                                    <th>Jadwal</th>
                                    <th>Tanggal</th>
                                    <th>Status</th>
                                    <th>Waktu Absen</th>
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
                                    <td>Pagi (06:00-08:00)</td>
                                    <td>{{ date('d/m/Y') }}</td>
                                    <td><span class="badge bg-success">Hadir</span></td>
                                    <td>06:15</td>
                                    <td>
                                        <button class="btn btn-sm btn-outline-primary" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="btn btn-sm btn-outline-danger" title="Hapus">
                                            <i class="fas fa-trash"></i>
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
                                    <td>Pagi (06:00-08:00)</td>
                                    <td>{{ date('d/m/Y') }}</td>
                                    <td><span class="badge bg-danger">Tidak Hadir</span></td>
                                    <td>-</td>
                                    <td>
                                        <button class="btn btn-sm btn-outline-primary" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="btn btn-sm btn-outline-danger" title="Hapus">
                                            <i class="fas fa-trash"></i>
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
                                    <td>Sore (16:00-18:00)</td>
                                    <td>{{ date('d/m/Y') }}</td>
                                    <td><span class="badge bg-success">Hadir</span></td>
                                    <td>16:05</td>
                                    <td>
                                        <button class="btn btn-sm btn-outline-primary" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="btn btn-sm btn-outline-danger" title="Hapus">
                                            <i class="fas fa-trash"></i>
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
