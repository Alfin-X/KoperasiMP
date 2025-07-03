@extends('layouts.app')

@section('title', 'Dashboard SPP')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <h4 class="page-title">Dashboard SPP</h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">SPP</li>
                    </ol>
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
                            <h3 class="my-2 py-1">{{ $stats['total_bills'] ?? 0 }}</h3>
                            <p class="mb-0 text-muted">
                                <span class="text-info me-2"><i class="mdi mdi-file-document"></i></span>
                                Semua tagihan
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
                            <h3 class="my-2 py-1">{{ $stats['paid_bills'] ?? 0 }}</h3>
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
                            <h3 class="my-2 py-1">{{ $stats['pending_bills'] ?? 0 }}</h3>
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
                            <h5 class="text-muted fw-normal mt-0 text-truncate">Terlambat</h5>
                            <h3 class="my-2 py-1">{{ $stats['overdue_bills'] ?? 0 }}</h3>
                            <p class="mb-0 text-muted">
                                <span class="text-danger me-2"><i class="mdi mdi-alert-circle"></i></span>
                                Lewat jatuh tempo
                            </p>
                        </div>
                        <div class="col-6">
                            <div class="text-end">
                                <i class="mdi mdi-alert-circle h1 text-danger"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="header-title">Aksi Cepat</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3 mb-3">
                            <button type="button" class="btn btn-primary btn-block" data-bs-toggle="modal" data-bs-target="#generateBulkModal">
                                <i class="mdi mdi-plus-circle me-1"></i> Generate SPP Massal
                            </button>
                        </div>
                        <div class="col-md-3 mb-3">
                            <a href="{{ route('admin.spp.payments') }}" class="btn btn-success btn-block">
                                <i class="mdi mdi-cash me-1"></i> Kelola Pembayaran
                            </a>
                        </div>
                        <div class="col-md-3 mb-3">
                            <a href="{{ route('admin.spp.reports') }}" class="btn btn-info btn-block">
                                <i class="mdi mdi-chart-line me-1"></i> Laporan
                            </a>
                        </div>
                        <div class="col-md-3 mb-3">
                            <a href="{{ route('admin.spp.create') }}" class="btn btn-warning btn-block">
                                <i class="mdi mdi-file-plus me-1"></i> Buat SPP Manual
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent SPP Payments -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="header-title">Pembayaran SPP Terbaru</h4>
                    <div class="card-header-actions">
                        <a href="{{ route('admin.spp.payments') }}" class="btn btn-sm btn-outline-primary">
                            Lihat Semua
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    @if(isset($recentPayments) && $recentPayments->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-centered table-nowrap mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>Anggota</th>
                                        <th>Periode</th>
                                        <th>Jumlah</th>
                                        <th>Status</th>
                                        <th>Tanggal Bayar</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($recentPayments as $payment)
                                    <tr>
                                        <td>
                                            <h5 class="mb-1">{{ $payment->member->user->name }}</h5>
                                            <p class="mb-0 text-muted">{{ $payment->member->member_number }}</p>
                                        </td>
                                        <td>{{ \Carbon\Carbon::parse($payment->period)->format('M Y') }}</td>
                                        <td>Rp {{ number_format($payment->amount, 0, ',', '.') }}</td>
                                        <td>
                                            @if($payment->status == 'paid')
                                                <span class="badge bg-success">Lunas</span>
                                            @elseif($payment->status == 'partial')
                                                <span class="badge bg-warning">Sebagian</span>
                                            @else
                                                <span class="badge bg-danger">Belum Bayar</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($payment->paid_at)
                                                {{ $payment->paid_at->format('d M Y') }}
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('admin.spp.edit', $payment) }}" 
                                                   class="btn btn-sm btn-outline-primary">
                                                    <i class="mdi mdi-pencil"></i>
                                                </a>
                                                @if($payment->status == 'pending')
                                                <button type="button" 
                                                        class="btn btn-sm btn-outline-success"
                                                        onclick="processPayment({{ $payment->id }})">
                                                    <i class="mdi mdi-cash"></i>
                                                </button>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="mdi mdi-cash-remove h1 text-muted"></i>
                            <h4>Belum ada pembayaran</h4>
                            <p class="text-muted">Belum ada pembayaran SPP yang tercatat.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Generate Bulk SPP Modal -->
<div class="modal fade" id="generateBulkModal" tabindex="-1" aria-labelledby="generateBulkModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('admin.spp.generate-bulk') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="generateBulkModalLabel">Generate SPP Massal</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="period" class="form-label">Periode</label>
                        <input type="month" class="form-control" id="period" name="period" 
                               value="{{ now()->format('Y-m') }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="amount" class="form-label">Jumlah SPP</label>
                        <input type="number" class="form-control" id="amount" name="amount" 
                               placeholder="100000" required>
                    </div>
                    <div class="mb-3">
                        <label for="due_date" class="form-label">Jatuh Tempo</label>
                        <input type="date" class="form-control" id="due_date" name="due_date" 
                               value="{{ now()->addDays(30)->format('Y-m-d') }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="location_id" class="form-label">Lokasi (Opsional)</label>
                        <select class="form-select" id="location_id" name="location_id">
                            <option value="">Semua Lokasi</option>
                            @if(isset($locations))
                                @foreach($locations as $location)
                                    <option value="{{ $location->id }}">{{ $location->name }}</option>
                                @endforeach
                            @endif
                        </select>
                        <small class="text-muted">Kosongkan untuk generate SPP untuk semua anggota</small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Generate SPP</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
function processPayment(sppId) {
    if (confirm('Konfirmasi pembayaran SPP ini?')) {
        // In real implementation, this would open a payment processing modal
        // For now, we'll just redirect to edit page
        window.location.href = `/admin/spp/${sppId}/edit`;
    }
}
</script>
@endsection
