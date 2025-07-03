@extends('layouts.app')

@section('title', 'SPP Saya')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <h4 class="page-title">SPP Saya</h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('anggota.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">SPP</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <!-- Member Info -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <h4 class="mb-1">{{ auth()->user()->name }}</h4>
                            <p class="text-muted mb-0">
                                Nomor Anggota: <strong>{{ auth()->user()->member->member_number ?? '-' }}</strong> |
                                Lokasi: <strong>{{ auth()->user()->location->name ?? '-' }}</strong>
                            </p>
                        </div>
                        <div class="col-md-4 text-end">
                            @if($pendingCount > 0)
                                <span class="badge bg-danger fs-6">{{ $pendingCount }} Tagihan Tertunggak</span>
                            @else
                                <span class="badge bg-success fs-6">Semua SPP Lunas</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row">
        <div class="col-xl-3 col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-6">
                            <h5 class="text-muted fw-normal mt-0 text-truncate">Total Tagihan</h5>
                            <h3 class="my-2 py-1">{{ $totalBills }}</h3>
                            <p class="mb-0 text-muted">
                                <span class="text-info me-2"><i class="mdi mdi-file-document"></i></span>
                                Semua periode
                            </p>
                        </div>
                        <div class="col-6">
                            <div class="text-end">
                                <i class="mdi mdi-file-document-multiple h1 text-primary"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-6">
                            <h5 class="text-muted fw-normal mt-0 text-truncate">Lunas</h5>
                            <h3 class="my-2 py-1">{{ $paidCount }}</h3>
                            <p class="mb-0 text-muted">
                                <span class="text-success me-2"><i class="mdi mdi-check-circle"></i></span>
                                Sudah dibayar
                            </p>
                        </div>
                        <div class="col-6">
                            <div class="text-end">
                                <i class="mdi mdi-check-circle h1 text-success"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-6">
                            <h5 class="text-muted fw-normal mt-0 text-truncate">Tertunggak</h5>
                            <h3 class="my-2 py-1">{{ $pendingCount }}</h3>
                            <p class="mb-0 text-muted">
                                <span class="text-warning me-2"><i class="mdi mdi-clock"></i></span>
                                Belum dibayar
                            </p>
                        </div>
                        <div class="col-6">
                            <div class="text-end">
                                <i class="mdi mdi-clock h1 text-warning"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-6">
                            <h5 class="text-muted fw-normal mt-0 text-truncate">Total Dibayar</h5>
                            <h3 class="my-2 py-1">Rp {{ number_format($totalPaid, 0, ',', '.') }}</h3>
                            <p class="mb-0 text-muted">
                                <span class="text-success me-2"><i class="mdi mdi-cash"></i></span>
                                Keseluruhan
                            </p>
                        </div>
                        <div class="col-6">
                            <div class="text-end">
                                <i class="mdi mdi-cash-multiple h1 text-success"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Pending SPP Alert -->
    @if($pendingCount > 0)
    <div class="row">
        <div class="col-12">
            <div class="alert alert-warning" role="alert">
                <h4 class="alert-heading"><i class="mdi mdi-alert-circle me-2"></i>Perhatian!</h4>
                <p>Anda memiliki <strong>{{ $pendingCount }}</strong> tagihan SPP yang belum dibayar dengan total 
                   <strong>Rp {{ number_format($totalPending, 0, ',', '.') }}</strong></p>
                <hr>
                <p class="mb-0">Silakan lakukan pembayaran sebelum jatuh tempo untuk menghindari denda.</p>
            </div>
        </div>
    </div>
    @endif

    <!-- SPP List -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="header-title">Riwayat SPP</h4>
                    <div class="card-header-actions">
                        <div class="btn-group" role="group">
                            <button type="button" class="btn btn-sm btn-outline-primary" onclick="filterSPP('all')">
                                Semua
                            </button>
                            <button type="button" class="btn btn-sm btn-outline-warning" onclick="filterSPP('pending')">
                                Tertunggak
                            </button>
                            <button type="button" class="btn btn-sm btn-outline-success" onclick="filterSPP('paid')">
                                Lunas
                            </button>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    @if($sppPayments->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-centered table-nowrap mb-0" id="sppTable">
                                <thead class="table-light">
                                    <tr>
                                        <th>Periode</th>
                                        <th>Jumlah</th>
                                        <th>Jatuh Tempo</th>
                                        <th>Status</th>
                                        <th>Tanggal Bayar</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($sppPayments as $spp)
                                    <tr data-status="{{ $spp->status }}">
                                        <td>
                                            <h5 class="mb-1">{{ \Carbon\Carbon::parse($spp->period)->format('F Y') }}</h5>
                                            <p class="mb-0 text-muted">{{ \Carbon\Carbon::parse($spp->period)->format('M Y') }}</p>
                                        </td>
                                        <td>
                                            <strong>Rp {{ number_format($spp->amount, 0, ',', '.') }}</strong>
                                            @if($spp->status == 'partial' && $spp->paid_amount > 0)
                                                <br><small class="text-muted">
                                                    Dibayar: Rp {{ number_format($spp->paid_amount, 0, ',', '.') }}
                                                </small>
                                            @endif
                                        </td>
                                        <td>
                                            {{ \Carbon\Carbon::parse($spp->due_date)->format('d M Y') }}
                                            @if($spp->status == 'pending' && \Carbon\Carbon::parse($spp->due_date)->isPast())
                                                <br><small class="text-danger">Terlambat</small>
                                            @endif
                                        </td>
                                        <td>
                                            @if($spp->status == 'paid')
                                                <span class="badge bg-success">Lunas</span>
                                            @elseif($spp->status == 'partial')
                                                <span class="badge bg-warning">Sebagian</span>
                                            @else
                                                @if(\Carbon\Carbon::parse($spp->due_date)->isPast())
                                                    <span class="badge bg-danger">Terlambat</span>
                                                @else
                                                    <span class="badge bg-warning">Belum Bayar</span>
                                                @endif
                                            @endif
                                        </td>
                                        <td>
                                            @if($spp->paid_at)
                                                {{ $spp->paid_at->format('d M Y') }}
                                                <br><small class="text-muted">{{ $spp->paid_at->format('H:i') }}</small>
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td>
                                            @if($spp->status != 'paid')
                                                <button type="button" class="btn btn-sm btn-success" 
                                                        onclick="payNow({{ $spp->id }})">
                                                    <i class="mdi mdi-cash me-1"></i>Bayar
                                                </button>
                                            @endif
                                            @if($spp->receipt_path)
                                                <a href="{{ asset('storage/' . $spp->receipt_path) }}" 
                                                   class="btn btn-sm btn-outline-info" target="_blank">
                                                    <i class="mdi mdi-receipt"></i>
                                                </a>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        
                        <!-- Pagination -->
                        <div class="d-flex justify-content-center mt-3">
                            {{ $sppPayments->links() }}
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="mdi mdi-cash-remove h1 text-muted"></i>
                            <h4>Belum ada tagihan SPP</h4>
                            <p class="text-muted">Anda belum memiliki tagihan SPP yang tercatat.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Payment Modal -->
<div class="modal fade" id="paymentModal" tabindex="-1" aria-labelledby="paymentModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="paymentForm" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="paymentModalLabel">Pembayaran SPP</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="payment_amount" class="form-label">Jumlah Pembayaran</label>
                        <input type="number" class="form-control" id="payment_amount" name="payment_amount" required>
                        <small class="text-muted">Masukkan jumlah yang akan dibayar</small>
                    </div>
                    <div class="mb-3">
                        <label for="payment_method" class="form-label">Metode Pembayaran</label>
                        <select class="form-select" id="payment_method" name="payment_method" required>
                            <option value="">Pilih metode pembayaran</option>
                            <option value="cash">Tunai</option>
                            <option value="transfer">Transfer Bank</option>
                            <option value="e_wallet">E-Wallet</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="receipt" class="form-label">Upload Bukti Pembayaran (Opsional)</label>
                        <input type="file" class="form-control" id="receipt" name="receipt" accept="image/*,.pdf">
                        <small class="text-muted">Format: JPG, PNG, PDF (Max: 2MB)</small>
                    </div>
                    <div class="mb-3">
                        <label for="notes" class="form-label">Catatan (Opsional)</label>
                        <textarea class="form-control" id="notes" name="notes" rows="3" 
                                  placeholder="Catatan tambahan untuk pembayaran ini"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success">Proses Pembayaran</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
function filterSPP(status) {
    const rows = document.querySelectorAll('#sppTable tbody tr');
    
    rows.forEach(row => {
        if (status === 'all') {
            row.style.display = '';
        } else {
            const rowStatus = row.getAttribute('data-status');
            if (status === 'pending' && (rowStatus === 'pending' || rowStatus === 'partial')) {
                row.style.display = '';
            } else if (status === rowStatus) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        }
    });
    
    // Update button states
    document.querySelectorAll('.btn-group button').forEach(btn => {
        btn.classList.remove('active');
    });
    event.target.classList.add('active');
}

function payNow(sppId) {
    // Set form action
    document.getElementById('paymentForm').action = `/anggota/spp/${sppId}/pay`;
    
    // Get SPP data from table row
    const row = document.querySelector(`tr[data-spp-id="${sppId}"]`);
    if (row) {
        const amount = row.querySelector('td:nth-child(2) strong').textContent.replace(/[^\d]/g, '');
        document.getElementById('payment_amount').value = amount;
    }
    
    // Show modal
    new bootstrap.Modal(document.getElementById('paymentModal')).show();
}

// Form submission
document.getElementById('paymentForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    const submitBtn = this.querySelector('button[type="submit"]');
    
    submitBtn.disabled = true;
    submitBtn.innerHTML = '<i class="mdi mdi-loading mdi-spin me-1"></i>Memproses...';
    
    fetch(this.action, {
        method: 'POST',
        body: formData,
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
        } else {
            alert('Terjadi kesalahan: ' + (data.message || 'Silakan coba lagi'));
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Terjadi kesalahan sistem. Silakan coba lagi.');
    })
    .finally(() => {
        submitBtn.disabled = false;
        submitBtn.innerHTML = 'Proses Pembayaran';
    });
});
</script>
@endsection
