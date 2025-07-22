@extends('layouts.app')

@section('title', 'Saldo Simpanan')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0">Saldo Simpanan</h1>
    <div class="d-flex gap-2">
        <a href="{{ route('anggota.simpanan.history') }}" class="btn btn-info">
            <i class="fas fa-history me-2"></i>
            Riwayat
        </a>
        <a href="{{ route('anggota.simpanan.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i>
            Tambah Simpanan
        </a>
        <a href="{{ route('anggota.simpanan.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-2"></i>
            Kembali
        </a>
    </div>
</div>

<!-- Total Balance Card -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card bg-gradient-primary text-white shadow">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-white-50 text-uppercase mb-1">
                            Total Saldo Simpanan
                        </div>
                        <div class="h2 mb-0 font-weight-bold">
                            Rp {{ number_format($savings->total_balance, 0, ',', '.') }}
                        </div>
                        <div class="text-white-50 small mt-2">
                            <i class="fas fa-calendar me-1"></i>
                            Update terakhir: {{ date('d M Y H:i') }}
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-piggy-bank fa-3x text-white-25"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Balance Breakdown -->
<div class="row">
    <!-- Simpanan Pokok -->
    <div class="col-xl-4 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                            Simpanan Pokok
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            Rp {{ number_format($savings->simpanan_pokok, 0, ',', '.') }}
                        </div>
                        <div class="text-muted small mt-1">
                            <i class="fas fa-check-circle text-success me-1"></i>
                            Lunas
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-coins fa-2x text-success"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Simpanan Wajib -->
    <div class="col-xl-4 col-md-6 mb-4">
        <div class="card border-left-info shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                            Simpanan Wajib
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            Rp {{ number_format($savings->simpanan_wajib, 0, ',', '.') }}
                        </div>
                        <div class="text-muted small mt-1">
                            <i class="fas fa-calendar-check text-info me-1"></i>
                            Min. Rp 3.000/hari
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-calendar-alt fa-2x text-info"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Simpanan Sukarela -->
    <div class="col-xl-4 col-md-6 mb-4">
        <div class="card border-left-warning shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                            Simpanan Sukarela
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            Rp {{ number_format($savings->simpanan_sukarela, 0, ',', '.') }}
                        </div>
                        <div class="text-muted small mt-1">
                            <i class="fas fa-heart text-warning me-1"></i>
                            Tabungan bebas
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-hand-holding-heart fa-2x text-warning"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Savings Chart -->
<div class="row">
    <div class="col-lg-8">
        <div class="card shadow">
            <div class="card-header">
                <h6 class="m-0 font-weight-bold">
                    <i class="fas fa-chart-pie me-2"></i>
                    Komposisi Simpanan
                </h6>
            </div>
            <div class="card-body">
                <div class="chart-container" style="position: relative; height: 300px;">
                    <canvas id="savingsChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <!-- Quick Actions -->
        <div class="card shadow">
            <div class="card-header">
                <h6 class="m-0 font-weight-bold">
                    <i class="fas fa-bolt me-2"></i>
                    Aksi Cepat
                </h6>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <a href="{{ route('anggota.simpanan.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus me-2"></i>
                        Tambah Simpanan
                    </a>
                    <a href="{{ route('anggota.simpanan.history') }}" class="btn btn-info">
                        <i class="fas fa-history me-2"></i>
                        Lihat Riwayat
                    </a>
                    <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#withdrawModal">
                        <i class="fas fa-money-bill-wave me-2"></i>
                        Ajukan Penarikan
                    </button>
                    <button type="button" class="btn btn-warning">
                        <i class="fas fa-download me-2"></i>
                        Cetak Laporan
                    </button>
                </div>
            </div>
        </div>

        <!-- Savings Info -->
        <div class="card shadow mt-4">
            <div class="card-header">
                <h6 class="m-0 font-weight-bold">
                    <i class="fas fa-info-circle me-2"></i>
                    Informasi Simpanan
                </h6>
            </div>
            <div class="card-body">
                <div class="alert alert-info">
                    <h6><i class="fas fa-lightbulb me-2"></i>Ketentuan:</h6>
                    <ul class="mb-0 small">
                        <li>Simpanan pokok: Rp 50.000 (tidak dapat ditarik)</li>
                        <li>Simpanan wajib: Min. Rp 3.000/hari (dapat ditarik setelah 6 bulan)</li>
                        <li>Simpanan sukarela: Nominal bebas (dapat ditarik kapan saja)</li>
                        <li>Penarikan memerlukan persetujuan pengurus</li>
                    </ul>
                </div>

                <div class="alert alert-success">
                    <h6><i class="fas fa-percentage me-2"></i>Bagi Hasil:</h6>
                    <p class="mb-0 small">
                        Simpanan mendapat bagi hasil 8% per tahun yang dibagikan setiap akhir tahun.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Withdraw Modal -->
<div class="modal fade" id="withdrawModal" tabindex="-1" aria-labelledby="withdrawModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="withdrawModalLabel">
                    <i class="fas fa-money-bill-wave me-2"></i>
                    Ajukan Penarikan Simpanan
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="withdraw_type" class="form-label">Jenis Simpanan</label>
                        <select class="form-select" id="withdraw_type" name="withdraw_type" required>
                            <option value="">Pilih jenis simpanan</option>
                            <option value="simpanan_wajib">Simpanan Wajib (Rp {{ number_format($savings->simpanan_wajib, 0, ',', '.') }})</option>
                            <option value="simpanan_sukarela">Simpanan Sukarela (Rp {{ number_format($savings->simpanan_sukarela, 0, ',', '.') }})</option>
                        </select>
                    </div>
                    
                    <div class="mb-3">
                        <label for="withdraw_amount" class="form-label">Jumlah Penarikan</label>
                        <div class="input-group">
                            <span class="input-group-text">Rp</span>
                            <input type="number" class="form-control" id="withdraw_amount" name="withdraw_amount" min="10000" step="1000" required>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="withdraw_reason" class="form-label">Alasan Penarikan</label>
                        <textarea class="form-control" id="withdraw_reason" name="withdraw_reason" rows="3" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-paper-plane me-2"></i>
                        Ajukan Penarikan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Savings Pie Chart
    const ctx = document.getElementById('savingsChart').getContext('2d');
    const savingsChart = new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: ['Simpanan Pokok', 'Simpanan Wajib', 'Simpanan Sukarela'],
            datasets: [{
                data: [{{ $savings->simpanan_pokok }}, {{ $savings->simpanan_wajib }}, {{ $savings->simpanan_sukarela }}],
                backgroundColor: [
                    '#1cc88a',
                    '#36b9cc',
                    '#f6c23e'
                ],
                borderWidth: 2,
                borderColor: '#ffffff'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        padding: 20,
                        usePointStyle: true
                    }
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            const value = context.parsed;
                            const total = context.dataset.data.reduce((a, b) => a + b, 0);
                            const percentage = ((value / total) * 100).toFixed(1);
                            return context.label + ': Rp ' + value.toLocaleString('id-ID') + ' (' + percentage + '%)';
                        }
                    }
                }
            }
        }
    });
});
</script>
@endpush
@endsection
