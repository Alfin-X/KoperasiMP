@extends('layouts.app')

@section('title', 'Manajemen Koperasi')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0">Manajemen Koperasi</h1>
    <a href="{{ route('admin.koperasi.create') }}" class="btn btn-primary">
        <i class="fas fa-plus me-2"></i>
        Tambah Transaksi
    </a>
</div>

<!-- Statistics Cards -->
<div class="row mb-4">
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                            Total Simpanan
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            Rp {{ number_format($totalSimpanan, 0, ',', '.') }}
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-piggy-bank fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-info shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                            Total Pinjaman
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            Rp {{ number_format($totalPinjaman, 0, ',', '.') }}
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-hand-holding-usd fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-warning shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                            Menunggu Verifikasi
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $pendingApproval }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-clock fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                            Anggota Aktif
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $anggotaAktif }}</div>
                        <div class="mt-2">
                            <a href="#" class="text-xs text-primary text-decoration-none"
                               data-bs-toggle="modal"
                               data-bs-target="#kolatModal">
                                <i class="fas fa-eye fa-sm me-1"></i>
                                Lihat Detail Kolat
                            </a>
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-users fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Transactions Table -->
<div class="card shadow">
    <div class="card-header">
        <h6 class="m-0 font-weight-bold">
            <i class="fas fa-exchange-alt me-2"></i>
            Transaksi Koperasi Terbaru
        </h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>Anggota</th>
                        <th>Jenis</th>
                        <th>Nominal</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pendingTransactions as $transaction)
                    <tr>
                        <td>{{ $transaction->created_at->format('d/m/Y H:i') }}</td>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="mr-3">
                                    <div class="icon-circle bg-primary">
                                        <i class="fas fa-user text-white"></i>
                                    </div>
                                </div>
                                <div>
                                    <div class="small text-gray-500">{{ $transaction->user->member_id ?? 'N/A' }}</div>
                                    <div class="font-weight-bold">{{ $transaction->user->name }}</div>
                                </div>
                            </div>
                        </td>
                        <td>
                            <span class="badge badge-info">{{ $transaction->type_text }}</span>
                        </td>
                        <td class="font-weight-bold">{{ $transaction->formatted_amount }}</td>
                        <td>
                            <span class="badge {{ $transaction->status_badge_class }}">
                                {{ $transaction->status_text }}
                            </span>
                        </td>
                        <td>
                            <div class="btn-group" role="group">
                                <button type="button" class="btn btn-success btn-sm"
                                        onclick="approveTransaction({{ $transaction->id }})"
                                        title="Setujui">
                                    <i class="fas fa-check"></i>
                                </button>
                                <button type="button" class="btn btn-danger btn-sm"
                                        onclick="rejectTransaction({{ $transaction->id }})"
                                        title="Tolak">
                                    <i class="fas fa-times"></i>
                                </button>
                                @if($transaction->proof_image)
                                <button type="button" class="btn btn-info btn-sm"
                                        onclick="viewProof('{{
                                            str_starts_with($transaction->proof_image, 'http')
                                                ? $transaction->proof_image
                                                : asset('storage/' . $transaction->proof_image)
                                        }}')"
                                        title="Lihat Bukti">
                                    <i class="fas fa-image"></i>
                                </button>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-4">
                            <i class="fas fa-piggy-bank fa-3x text-muted mb-3"></i>
                            <p class="text-muted">Belum ada transaksi yang menunggu persetujuan.</p>
                            <a href="{{ route('admin.koperasi.pending') }}" class="btn btn-primary">
                                <i class="fas fa-list me-2"></i>
                                Lihat Semua Transaksi
                            </a>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Approve Modal -->
<div class="modal fade" id="approveModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Setujui Transaksi</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <form id="approveForm" method="POST">
                @csrf
                @method('PATCH')
                <div class="modal-body">
                    <p>Apakah Anda yakin ingin menyetujui transaksi ini?</p>
                    <div class="form-group">
                        <label for="notes">Catatan (Opsional)</label>
                        <textarea class="form-control" id="notes" name="notes" rows="3"
                                  placeholder="Tambahkan catatan jika diperlukan..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success">Setujui</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Reject Modal -->
<div class="modal fade" id="rejectModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tolak Transaksi</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <form id="rejectForm" method="POST">
                @csrf
                @method('PATCH')
                <div class="modal-body">
                    <p>Apakah Anda yakin ingin menolak transaksi ini?</p>
                    <div class="form-group">
                        <label for="rejection_reason">Alasan Penolakan <span class="text-danger">*</span></label>
                        <textarea class="form-control" id="rejection_reason" name="rejection_reason" rows="3"
                                  placeholder="Masukkan alasan penolakan..." required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-danger">Tolak</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Proof Image Modal -->
<div class="modal fade" id="proofModal" tabindex="-1" aria-labelledby="proofModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="proofModalLabel">Bukti Transfer</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <img id="proofImage" src="" class="img-fluid" alt="Bukti Transfer" style="max-height: 500px;">
                <div id="imageError" class="alert alert-warning mt-3" style="display: none;">
                    <i class="fas fa-exclamation-triangle"></i>
                    Gambar tidak dapat dimuat. Pastikan file gambar tersedia.
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
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
    .text-gray-500 {
        color: #858796 !important;
    }
    .icon-circle {
        height: 2.5rem;
        width: 2.5rem;
        border-radius: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
    }
</style>
@endpush

<!-- Kolat Detail Modal -->
<div class="modal fade" id="kolatModal" tabindex="-1" aria-labelledby="kolatModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="kolatModalLabel">
                    <i class="fas fa-home me-2"></i>
                    Detail Kolat
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="text-center mb-3">
                    <i class="fas fa-users fa-3x text-primary mb-2"></i>
                    <h6 class="text-muted">Daftar Kolat Aktif</h6>
                </div>
                <div class="list-group list-group-flush">
                    <a href="{{ route('admin.users.index', ['kolat' => 'matasa']) }}" class="list-group-item list-group-item-action d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-home text-primary me-3"></i>
                            <div>
                                <h6 class="mb-1">Matasa</h6>
                                <small class="text-muted">Kolat Matasa</small>
                            </div>
                        </div>
                        <div class="text-end">
                            <i class="fas fa-arrow-right text-muted"></i>
                            <small class="text-muted d-block">Lihat Anggota</small>
                        </div>
                    </a>
                    <a href="{{ route('admin.users.index', ['kolat' => 'polije']) }}" class="list-group-item list-group-item-action d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-home text-success me-3"></i>
                            <div>
                                <h6 class="mb-1">Polije</h6>
                                <small class="text-muted">Kolat Polije</small>
                            </div>
                        </div>
                        <div class="text-end">
                            <i class="fas fa-arrow-right text-muted"></i>
                            <small class="text-muted d-block">Lihat Anggota</small>
                        </div>
                    </a>
                    <a href="{{ route('admin.users.index', ['kolat' => 'unej']) }}" class="list-group-item list-group-item-action d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-home text-info me-3"></i>
                            <div>
                                <h6 class="mb-1">Unej</h6>
                                <small class="text-muted">Kolat Unej</small>
                            </div>
                        </div>
                        <div class="text-end">
                            <i class="fas fa-arrow-right text-muted"></i>
                            <small class="text-muted d-block">Lihat Anggota</small>
                        </div>
                    </a>
                    <a href="{{ route('admin.users.index', ['kolat' => 'rolasi']) }}" class="list-group-item list-group-item-action d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-home text-warning me-3"></i>
                            <div>
                                <h6 class="mb-1">Rolasi</h6>
                                <small class="text-muted">Kolat Rolasi</small>
                            </div>
                        </div>
                        <div class="text-end">
                            <i class="fas fa-arrow-right text-muted"></i>
                            <small class="text-muted d-block">Lihat Anggota</small>
                        </div>
                    </a>
                    <a href="{{ route('admin.users.index', ['kolat' => 'smasa']) }}" class="list-group-item list-group-item-action d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-home text-danger me-3"></i>
                            <div>
                                <h6 class="mb-1">Smasa</h6>
                                <small class="text-muted">Kolat Smasa</small>
                            </div>
                        </div>
                        <div class="text-end">
                            <i class="fas fa-arrow-right text-muted"></i>
                            <small class="text-muted d-block">Lihat Anggota</small>
                        </div>
                    </a>
                </div>
            </div>
            {{-- <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="fas fa-times me-1"></i>
                    Tutup
                </button>
            </div> --}}
        </div>
    </div>
</div>

@push('scripts')
<script>
function approveTransaction(transactionId) {
    const form = document.getElementById('approveForm');
    form.action = `{{ url('admin/koperasi/transactions') }}/${transactionId}/approve`;
    const modal = new bootstrap.Modal(document.getElementById('approveModal'));
    modal.show();
}

function rejectTransaction(transactionId) {
    const form = document.getElementById('rejectForm');
    form.action = `{{ url('admin/koperasi/transactions') }}/${transactionId}/reject`;
    const modal = new bootstrap.Modal(document.getElementById('rejectModal'));
    modal.show();
}

function viewProof(imageUrl) {
    const proofImage = document.getElementById('proofImage');
    const imageError = document.getElementById('imageError');

    console.log('Loading image:', imageUrl); // Debug log

    // Reset states
    imageError.style.display = 'none';
    proofImage.style.display = 'block';

    // Handle image load error
    proofImage.onerror = function() {
        console.error('Failed to load image:', imageUrl);
        imageError.innerHTML = `
            <i class="fas fa-exclamation-triangle"></i>
            Gambar tidak dapat dimuat.<br>
            <small class="text-muted">URL: ${imageUrl}</small>
        `;
        imageError.style.display = 'block';
        proofImage.style.display = 'none';
    };

    // Handle image load success
    proofImage.onload = function() {
        console.log('Image loaded successfully:', imageUrl);
        imageError.style.display = 'none';
        proofImage.style.display = 'block';
    };

    // Set image source (this should trigger onload or onerror)
    proofImage.src = imageUrl;

    // Show modal
    const modal = new bootstrap.Modal(document.getElementById('proofModal'));
    modal.show();
}
</script>
@endpush
@endsection
