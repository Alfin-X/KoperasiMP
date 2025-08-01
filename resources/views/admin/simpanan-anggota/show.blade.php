@extends('layouts.app')

@section('title', 'Detail Simpanan - ' . $user->name)

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0">Detail Simpanan - {{ $user->name }}</h1>
    <div class="d-flex gap-2">
        <a href="{{ route('admin.simpanan-anggota.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-2"></i>
            Kembali
        </a>
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addTransactionModal">
            <i class="fas fa-plus me-2"></i>
            Tambah Transaksi
        </button>
    </div>
</div>

<!-- Member Info Card -->
<div class="row mb-4">
    <div class="col-lg-4">
        <div class="card shadow">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Informasi Anggota</h6>
            </div>
            <div class="card-body">
                <div class="text-center mb-3">
                    <div class="avatar avatar-xl mx-auto mb-3">
                        <div class="avatar-initial rounded-circle bg-primary">
                            {{ strtoupper(substr($user->name, 0, 2)) }}
                        </div>
                    </div>
                    <h5 class="mb-1">{{ $user->name }}</h5>
                    <p class="text-muted mb-0">{{ $user->email }}</p>
                </div>
                
                <hr>
                
                <div class="row text-center">
                    <div class="col-6">
                        <div class="border-end">
                            <h6 class="text-muted mb-1">Member ID</h6>
                            <span class="badge badge-secondary">{{ $user->member_id ?? 'N/A' }}</span>
                        </div>
                    </div>
                    <div class="col-6">
                        <h6 class="text-muted mb-1">Status</h6>
                        @if($user->is_active)
                            <span class="badge badge-success">Aktif</span>
                        @else
                            <span class="badge badge-danger">Tidak Aktif</span>
                        @endif
                    </div>
                </div>
                
                <hr>
                
                <div class="mb-2">
                    <small class="text-muted">Kolat:</small>
                    <div>{{ $user->kolat->name ?? 'N/A' }}</div>
                </div>
                <div class="mb-2">
                    <small class="text-muted">Tingkatan:</small>
                    <div>
                        @if($user->tingkatan)
                            <span class="badge badge-info">{{ $user->tingkatan }}</span>
                        @else
                            N/A
                        @endif
                    </div>
                </div>
                <div class="mb-2">
                    <small class="text-muted">Bergabung:</small>
                    <div>{{ $user->join_date ? $user->join_date->format('d M Y') : 'N/A' }}</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Savings Summary -->
    <div class="col-lg-8">
        <div class="row">
            <div class="col-md-6 mb-4">
                <div class="card border-left-success shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                    Total Simpanan
                                </div>
                                <div class="h4 mb-0 font-weight-bold text-gray-800">
                                    Rp {{ number_format($savings->total_balance ?? 0, 0, ',', '.') }}
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-piggy-bank fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6 mb-4">
                <div class="card border-left-info shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                    Total Transaksi
                                </div>
                                <div class="h4 mb-0 font-weight-bold text-gray-800">
                                    {{ $transactions->total() }}
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-exchange-alt fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Savings Breakdown -->
        <div class="card shadow">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Rincian Simpanan</h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4 text-center">
                        <div class="mb-3">
                            <h6 class="text-success">Simpanan Pokok</h6>
                            <h4 class="text-gray-800">Rp {{ number_format($savings->simpanan_pokok ?? 0, 0, ',', '.') }}</h4>
                            @if($savings->simpanan_pokok_paid ?? false)
                                <span class="badge badge-success">Lunas</span>
                            @else
                                <span class="badge badge-warning">Belum Lunas</span>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-4 text-center">
                        <div class="mb-3">
                            <h6 class="text-info">Simpanan Wajib</h6>
                            <h4 class="text-gray-800">Rp {{ number_format($savings->simpanan_wajib ?? 0, 0, ',', '.') }}</h4>
                        </div>
                    </div>
                    <div class="col-md-4 text-center">
                        <div class="mb-3">
                            <h6 class="text-warning">Simpanan Sukarela</h6>
                            <h4 class="text-gray-800">Rp {{ number_format($savings->simpanan_sukarela ?? 0, 0, ',', '.') }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Transactions Table -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Riwayat Transaksi</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>Jenis</th>
                        <th>Nominal</th>
                        <th>Deskripsi</th>
                        <th>Status</th>
                        <th>Bukti</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($transactions as $transaction)
                    <tr>
                        <td>{{ $transaction->created_at->format('d/m/Y H:i') }}</td>
                        <td>
                            @if($transaction->type === 'simpanan_pokok')
                                <span class="badge badge-success">Simpanan Pokok</span>
                            @elseif($transaction->type === 'simpanan_wajib')
                                <span class="badge badge-info">Simpanan Wajib</span>
                            @else
                                <span class="badge badge-warning">Simpanan Sukarela</span>
                            @endif
                        </td>
                        <td class="text-end">
                            <strong>Rp {{ number_format($transaction->amount, 0, ',', '.') }}</strong>
                        </td>
                        <td>{{ $transaction->description ?? '-' }}</td>
                        <td>
                            @if($transaction->status === 'verified')
                                <span class="badge badge-success">Verified</span>
                            @elseif($transaction->status === 'pending')
                                <span class="badge badge-warning">Pending</span>
                            @else
                                <span class="badge badge-danger">Rejected</span>
                            @endif
                        </td>
                        <td>
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
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                        <td>
                            <div class="btn-group" role="group">
                                <button type="button" class="btn btn-warning btn-sm" 
                                        onclick="editTransaction({{ $transaction->id }}, '{{ $transaction->type }}', {{ $transaction->amount }}, '{{ $transaction->description }}', '{{ $transaction->status }}')"
                                        title="Edit">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button type="button" class="btn btn-danger btn-sm" 
                                        onclick="deleteTransaction({{ $transaction->id }})"
                                        title="Hapus">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-4">
                            <i class="fas fa-exchange-alt fa-3x text-gray-300 mb-3"></i>
                            <p class="text-muted">Belum ada transaksi.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($transactions->hasPages())
        <div class="d-flex justify-content-between align-items-center mt-3">
            <div class="text-muted">
                Menampilkan {{ $transactions->firstItem() ?? 0 }} sampai {{ $transactions->lastItem() ?? 0 }} 
                dari {{ $transactions->total() }} transaksi
            </div>
            {{ $transactions->links() }}
        </div>
        @endif
    </div>
</div>
<!-- Add Transaction Modal -->
<div class="modal fade" id="addTransactionModal" tabindex="-1" aria-labelledby="addTransactionModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('admin.simpanan-anggota.store-transaction', $user) }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="addTransactionModalLabel">Tambah Transaksi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="type" class="form-label">Jenis Simpanan</label>
                        <select class="form-select" id="type" name="type" required>
                            <option value="">Pilih jenis simpanan</option>
                            <option value="simpanan_pokok">Simpanan Pokok</option>
                            <option value="simpanan_wajib">Simpanan Wajib</option>
                            <option value="simpanan_sukarela">Simpanan Sukarela</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="amount" class="form-label">Nominal</label>
                        <input type="number" class="form-control" id="amount" name="amount" min="1000" step="1000" required>
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Deskripsi</label>
                        <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="status" class="form-label">Status</label>
                        <select class="form-select" id="status" name="status" required>
                            <option value="pending">Pending</option>
                            <option value="verified">Verified</option>
                            <option value="rejected">Rejected</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Transaction Modal -->
<div class="modal fade" id="editTransactionModal" tabindex="-1" aria-labelledby="editTransactionModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="editTransactionForm" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title" id="editTransactionModalLabel">Edit Transaksi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="edit_type" class="form-label">Jenis Simpanan</label>
                        <select class="form-select" id="edit_type" name="type" required>
                            <option value="simpanan_pokok">Simpanan Pokok</option>
                            <option value="simpanan_wajib">Simpanan Wajib</option>
                            <option value="simpanan_sukarela">Simpanan Sukarela</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="edit_amount" class="form-label">Nominal</label>
                        <input type="number" class="form-control" id="edit_amount" name="amount" min="1000" step="1000" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_description" class="form-label">Deskripsi</label>
                        <textarea class="form-control" id="edit_description" name="description" rows="3"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="edit_status" class="form-label">Status</label>
                        <select class="form-select" id="edit_status" name="status" required>
                            <option value="pending">Pending</option>
                            <option value="verified">Verified</option>
                            <option value="rejected">Rejected</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteTransactionModal" tabindex="-1" aria-labelledby="deleteTransactionModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="deleteTransactionForm" method="POST">
                @csrf
                @method('DELETE')
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteTransactionModalLabel">Konfirmasi Hapus</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Apakah Anda yakin ingin menghapus transaksi ini?</p>
                    <div class="alert alert-warning">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        <strong>Peringatan:</strong> Jika transaksi sudah verified, saldo anggota akan dikurangi sesuai nominal transaksi.
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-danger">Hapus</button>
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
.avatar {
    width: 40px;
    height: 40px;
}

.avatar-xl {
    width: 80px;
    height: 80px;
}

.avatar-initial {
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 600;
    color: white;
}

.border-left-success {
    border-left: 0.25rem solid #1cc88a !important;
}

.border-left-info {
    border-left: 0.25rem solid #36b9cc !important;
}

.border-end {
    border-right: 1px solid #e3e6f0 !important;
}
</style>
@endpush

@push('scripts')
<script>
function editTransaction(id, type, amount, description, status) {
    document.getElementById('edit_type').value = type;
    document.getElementById('edit_amount').value = amount;
    document.getElementById('edit_description').value = description || '';
    document.getElementById('edit_status').value = status;

    const form = document.getElementById('editTransactionForm');
    form.action = `{{ url('admin/simpanan-anggota/transactions') }}/${id}`;

    const modal = new bootstrap.Modal(document.getElementById('editTransactionModal'));
    modal.show();
}

function deleteTransaction(id) {
    const form = document.getElementById('deleteTransactionForm');
    form.action = `{{ url('admin/simpanan-anggota/transactions') }}/${id}`;

    const modal = new bootstrap.Modal(document.getElementById('deleteTransactionModal'));
    modal.show();
}

function viewProof(imageUrl) {
    const proofImage = document.getElementById('proofImage');
    const imageError = document.getElementById('imageError');

    console.log('Loading image:', imageUrl);

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

    // Set image source
    proofImage.src = imageUrl;

    // Show modal
    const modal = new bootstrap.Modal(document.getElementById('proofModal'));
    modal.show();
}

// Format currency input
document.addEventListener('DOMContentLoaded', function() {
    const amountInputs = document.querySelectorAll('input[name="amount"]');
    amountInputs.forEach(input => {
        input.addEventListener('input', function() {
            // Remove non-numeric characters except for decimal point
            this.value = this.value.replace(/[^0-9]/g, '');
        });
    });
});
</script>
@endpush

@endsection
