@extends('layouts.app')

@section('title', 'Riwayat Simpanan')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0">Riwayat Simpanan</h1>
    <div class="d-flex gap-2">
        <a href="{{ route('anggota.simpanan.balance') }}" class="btn btn-info">
            <i class="fas fa-wallet me-2"></i>
            Lihat Saldo
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

<!-- Filter Section -->
<div class="card shadow mb-4">
    <div class="card-header">
        <h6 class="m-0 font-weight-bold">
            <i class="fas fa-filter me-2"></i>
            Filter Riwayat
        </h6>
    </div>
    <div class="card-body">
        <form method="GET" action="{{ route('anggota.simpanan.history') }}">
            <div class="row">
                <div class="col-md-3">
                    <div class="mb-3">
                        <label for="type" class="form-label">Jenis Simpanan</label>
                        <select class="form-select" id="type" name="type">
                            <option value="">Semua Jenis</option>
                            <option value="simpanan_pokok" {{ request('type') == 'simpanan_pokok' ? 'selected' : '' }}>
                                Simpanan Pokok
                            </option>
                            <option value="simpanan_wajib" {{ request('type') == 'simpanan_wajib' ? 'selected' : '' }}>
                                Simpanan Wajib
                            </option>
                            <option value="simpanan_sukarela" {{ request('type') == 'simpanan_sukarela' ? 'selected' : '' }}>
                                Simpanan Sukarela
                            </option>
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="mb-3">
                        <label for="status" class="form-label">Status</label>
                        <select class="form-select" id="status" name="status">
                            <option value="">Semua Status</option>
                            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="verified" {{ request('status') == 'verified' ? 'selected' : '' }}>Terverifikasi</option>
                            <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Ditolak</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="mb-3">
                        <label for="date_from" class="form-label">Dari Tanggal</label>
                        <input type="date" class="form-control" id="date_from" name="date_from" value="{{ request('date_from') }}">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="mb-3">
                        <label for="date_to" class="form-label">Sampai Tanggal</label>
                        <input type="date" class="form-control" id="date_to" name="date_to" value="{{ request('date_to') }}">
                    </div>
                </div>
            </div>
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-search me-2"></i>
                    Filter
                </button>
                <a href="{{ route('anggota.simpanan.history') }}" class="btn btn-secondary">
                    <i class="fas fa-undo me-2"></i>
                    Reset
                </a>
                <button type="button" class="btn btn-success" onclick="exportToExcel()">
                    <i class="fas fa-file-excel me-2"></i>
                    Export Excel
                </button>
            </div>
        </form>
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
        @if($transactions->count() > 0)
            <div class="table-responsive">
                <table class="table table-bordered" id="transactionTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Tanggal</th>
                            <th>Jenis Simpanan</th>
                            <th>Nominal</th>
                            <th>Keterangan</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($transactions as $index => $transaction)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ \Carbon\Carbon::parse($transaction->date)->format('d/m/Y') }}</td>
                            <td>
                                @switch($transaction->type)
                                    @case('simpanan_pokok')
                                        <span class="badge bg-success">Simpanan Pokok</span>
                                        @break
                                    @case('simpanan_wajib')
                                        <span class="badge bg-info">Simpanan Wajib</span>
                                        @break
                                    @case('simpanan_sukarela')
                                        <span class="badge bg-warning">Simpanan Sukarela</span>
                                        @break
                                @endswitch
                            </td>
                            <td class="text-end">
                                <strong>Rp {{ number_format($transaction->amount, 0, ',', '.') }}</strong>
                            </td>
                            <td>{{ $transaction->description }}</td>
                            <td>
                                @switch($transaction->status)
                                    @case('pending')
                                        <span class="badge bg-warning">
                                            <i class="fas fa-clock me-1"></i>
                                            Pending
                                        </span>
                                        @break
                                    @case('verified')
                                        <span class="badge bg-success">
                                            <i class="fas fa-check me-1"></i>
                                            Terverifikasi
                                        </span>
                                        @break
                                    @case('rejected')
                                        <span class="badge bg-danger">
                                            <i class="fas fa-times me-1"></i>
                                            Ditolak
                                        </span>
                                        @break
                                @endswitch
                            </td>
                            <td>
                                <div class="btn-group" role="group">
                                    <button type="button" class="btn btn-sm btn-outline-primary" 
                                            onclick="viewDetail({{ $transaction->id }})" 
                                            title="Lihat Detail">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    @if($transaction->status == 'pending')
                                        <button type="button" class="btn btn-sm btn-outline-warning" 
                                                onclick="editTransaction({{ $transaction->id }})" 
                                                title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button type="button" class="btn btn-sm btn-outline-danger" 
                                                onclick="cancelTransaction({{ $transaction->id }})" 
                                                title="Batalkan">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="d-flex justify-content-between align-items-center mt-3">
                <div class="text-muted">
                    Menampilkan {{ $transactions->count() }} dari {{ $transactions->count() }} transaksi
                </div>
                <nav aria-label="Transaction pagination">
                    <!-- Pagination links will be here -->
                </nav>
            </div>
        @else
            <div class="text-center py-5">
                <i class="fas fa-history fa-3x text-muted mb-3"></i>
                <h5 class="text-muted">Belum Ada Riwayat Transaksi</h5>
                <p class="text-muted">Anda belum memiliki transaksi simpanan.</p>
                <a href="{{ route('anggota.simpanan.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus me-2"></i>
                    Mulai Menabung
                </a>
            </div>
        @endif
    </div>
</div>

<!-- Detail Modal -->
<div class="modal fade" id="detailModal" tabindex="-1" aria-labelledby="detailModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="detailModalLabel">
                    <i class="fas fa-info-circle me-2"></i>
                    Detail Transaksi
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="detailContent">
                <!-- Detail content will be loaded here -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize DataTable if available
    if (typeof $.fn.DataTable !== 'undefined') {
        $('#transactionTable').DataTable({
            "pageLength": 25,
            "order": [[ 1, "desc" ]],
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.10.24/i18n/Indonesian.json"
            }
        });
    }
});

function viewDetail(transactionId) {
    // Simulate loading transaction detail
    const detailContent = `
        <div class="row">
            <div class="col-md-6">
                <table class="table table-borderless">
                    <tr>
                        <td><strong>ID Transaksi:</strong></td>
                        <td>TRX-${transactionId.toString().padStart(6, '0')}</td>
                    </tr>
                    <tr>
                        <td><strong>Tanggal:</strong></td>
                        <td>15 Januari 2024</td>
                    </tr>
                    <tr>
                        <td><strong>Jenis:</strong></td>
                        <td><span class="badge bg-success">Simpanan Pokok</span></td>
                    </tr>
                    <tr>
                        <td><strong>Nominal:</strong></td>
                        <td><strong>Rp 50.000</strong></td>
                    </tr>
                    <tr>
                        <td><strong>Status:</strong></td>
                        <td><span class="badge bg-success">Terverifikasi</span></td>
                    </tr>
                </table>
            </div>
            <div class="col-md-6">
                <table class="table table-borderless">
                    <tr>
                        <td><strong>Keterangan:</strong></td>
                        <td>Setoran simpanan pokok</td>
                    </tr>
                    <tr>
                        <td><strong>Diverifikasi oleh:</strong></td>
                        <td>Pelatih Ahmad</td>
                    </tr>
                    <tr>
                        <td><strong>Tanggal Verifikasi:</strong></td>
                        <td>15 Januari 2024 14:30</td>
                    </tr>
                    <tr>
                        <td><strong>Bukti Transfer:</strong></td>
                        <td>
                            <a href="#" class="btn btn-sm btn-outline-primary">
                                <i class="fas fa-image me-1"></i>
                                Lihat Bukti
                            </a>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    `;
    
    document.getElementById('detailContent').innerHTML = detailContent;
    new bootstrap.Modal(document.getElementById('detailModal')).show();
}

function editTransaction(transactionId) {
    // Redirect to edit page or show edit modal
    alert('Fitur edit transaksi akan segera tersedia');
}

function cancelTransaction(transactionId) {
    if (confirm('Apakah Anda yakin ingin membatalkan transaksi ini?')) {
        // Send cancel request
        alert('Transaksi berhasil dibatalkan');
        location.reload();
    }
}

function exportToExcel() {
    // Export table to Excel
    alert('Export Excel akan segera tersedia');
}
</script>
@endpush
@endsection
