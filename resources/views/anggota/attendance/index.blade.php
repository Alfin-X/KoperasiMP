@extends('layouts.app')

@section('title', 'Absensi Saya - Anggota')

@section('content')
<div class="container-fluid">
    <div class="row">
        <!-- Statistics Cards -->
        <div class="col-md-3">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h6 class="card-title">Bulan Ini</h6>
                            <h4 class="mb-0">12 Hari</h4>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-calendar-check fa-2x"></i>
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
                            <h6 class="card-title">Hadir</h6>
                            <h4 class="mb-0">10 Hari</h4>
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
                            <h4 class="mb-0">2 Hari</h4>
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
                            <h6 class="card-title">Persentase</h6>
                            <h4 class="mb-0">83%</h4>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-chart-pie fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">
                        <i class="fas fa-clipboard-check me-2"></i>
                        Riwayat Absensi Saya
                    </h5>
                    <div>
                        <button class="btn btn-success">
                            <i class="fas fa-download me-1"></i>
                            Export PDF
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
                                <option value="hadir">Hadir</option>
                                <option value="tidak_hadir">Tidak Hadir</option>
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

                    <!-- Attendance Table -->
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead class="table-dark">
                                <tr>
                                    <th>No</th>
                                    <th>Tanggal</th>
                                    <th>Hari</th>
                                    <th>Jadwal</th>
                                    <th>Status</th>
                                    <th>Waktu Absen</th>
                                    <th>Pelatih</th>
                                    <th>Keterangan</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td>03/07/2025</td>
                                    <td>Kamis</td>
                                    <td>Pagi (06:00-08:00)</td>
                                    <td><span class="badge bg-success">Hadir</span></td>
                                    <td>06:15</td>
                                    <td>Pak Budi</td>
                                    <td>-</td>
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td>02/07/2025</td>
                                    <td>Rabu</td>
                                    <td>Pagi (06:00-08:00)</td>
                                    <td><span class="badge bg-success">Hadir</span></td>
                                    <td>06:10</td>
                                    <td>Pak Budi</td>
                                    <td>-</td>
                                </tr>
                                <tr>
                                    <td>3</td>
                                    <td>01/07/2025</td>
                                    <td>Selasa</td>
                                    <td>Pagi (06:00-08:00)</td>
                                    <td><span class="badge bg-danger">Tidak Hadir</span></td>
                                    <td>-</td>
                                    <td>Pak Budi</td>
                                    <td>Sakit</td>
                                </tr>
                                <tr>
                                    <td>4</td>
                                    <td>30/06/2025</td>
                                    <td>Senin</td>
                                    <td>Pagi (06:00-08:00)</td>
                                    <td><span class="badge bg-success">Hadir</span></td>
                                    <td>06:05</td>
                                    <td>Pak Budi</td>
                                    <td>-</td>
                                </tr>
                                <tr>
                                    <td>5</td>
                                    <td>29/06/2025</td>
                                    <td>Minggu</td>
                                    <td>Pagi (06:00-08:00)</td>
                                    <td><span class="badge bg-success">Hadir</span></td>
                                    <td>06:20</td>
                                    <td>Pak Budi</td>
                                    <td>-</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="d-flex justify-content-between align-items-center mt-3">
                        <div>
                            <small class="text-muted">Menampilkan 1-5 dari 25 data</small>
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

    <!-- Jadwal Latihan -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="fas fa-calendar-alt me-2"></i>
                        Jadwal Latihan Minggu Ini
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card border-primary">
                                <div class="card-body">
                                    <h6 class="card-title text-primary">
                                        <i class="fas fa-sun me-1"></i>
                                        Latihan Pagi
                                    </h6>
                                    <p class="card-text">
                                        <strong>Waktu:</strong> 06:00 - 08:00<br>
                                        <strong>Hari:</strong> Senin, Rabu, Jumat<br>
                                        <strong>Pelatih:</strong> Pak Budi<br>
                                        <strong>Lokasi:</strong> Lapangan Utama
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card border-warning">
                                <div class="card-body">
                                    <h6 class="card-title text-warning">
                                        <i class="fas fa-moon me-1"></i>
                                        Latihan Sore
                                    </h6>
                                    <p class="card-text">
                                        <strong>Waktu:</strong> 16:00 - 18:00<br>
                                        <strong>Hari:</strong> Selasa, Kamis, Sabtu<br>
                                        <strong>Pelatih:</strong> Pak Andi<br>
                                        <strong>Lokasi:</strong> Lapangan Samping
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
