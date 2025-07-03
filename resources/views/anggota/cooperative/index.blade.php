@extends('layouts.app')

@section('title', 'Koperasi Saya')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <h4 class="page-title">Koperasi Saya</h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('anggota.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Koperasi</li>
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
                                Status Koperasi: 
                                @if($memberSavings->sum('balance') > 0)
                                    <span class="badge bg-success">Aktif</span>
                                @else
                                    <span class="badge bg-warning">Belum Aktif</span>
                                @endif
                            </p>
                        </div>
                        <div class="col-md-4 text-end">
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#newSavingModal">
                                <i class="mdi mdi-plus me-1"></i>Buka Simpanan Baru
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Summary Cards -->
    <div class="row">
        <div class="col-xl-3 col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-6">
                            <h5 class="text-muted fw-normal mt-0 text-truncate">Total Simpanan</h5>
                            <h3 class="my-2 py-1">Rp {{ number_format($totalSavings, 0, ',', '.') }}</h3>
                            <p class="mb-0 text-muted">
                                <span class="text-success me-2"><i class="mdi mdi-trending-up"></i></span>
                                Saldo aktif
                            </p>
                        </div>
                        <div class="col-6">
                            <div class="text-end">
                                <i class="mdi mdi-bank h1 text-success"></i>
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
                            <h5 class="text-muted fw-normal mt-0 text-truncate">Total Pinjaman</h5>
                            <h3 class="my-2 py-1">Rp {{ number_format($totalLoans, 0, ',', '.') }}</h3>
                            <p class="mb-0 text-muted">
                                <span class="text-warning me-2"><i class="mdi mdi-cash-minus"></i></span>
                                Sisa hutang
                            </p>
                        </div>
                        <div class="col-6">
                            <div class="text-end">
                                <i class="mdi mdi-cash-minus h1 text-warning"></i>
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
                            <h5 class="text-muted fw-normal mt-0 text-truncate">Transaksi Bulan Ini</h5>
                            <h3 class="my-2 py-1">{{ $monthlyTransactions }}</h3>
                            <p class="mb-0 text-muted">
                                <span class="text-info me-2"><i class="mdi mdi-swap-horizontal"></i></span>
                                Aktivitas
                            </p>
                        </div>
                        <div class="col-6">
                            <div class="text-end">
                                <i class="mdi mdi-swap-horizontal h1 text-info"></i>
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
                            <h5 class="text-muted fw-normal mt-0 text-truncate">Bagi Hasil</h5>
                            <h3 class="my-2 py-1">Rp {{ number_format($totalDividends, 0, ',', '.') }}</h3>
                            <p class="mb-0 text-muted">
                                <span class="text-success me-2"><i class="mdi mdi-gift"></i></span>
                                Tahun ini
                            </p>
                        </div>
                        <div class="col-6">
                            <div class="text-end">
                                <i class="mdi mdi-gift h1 text-primary"></i>
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
                            <button type="button" class="btn btn-success btn-block" data-bs-toggle="modal" data-bs-target="#depositModal">
                                <i class="mdi mdi-plus-circle me-1"></i> Setor Simpanan
                            </button>
                        </div>
                        <div class="col-md-3 mb-3">
                            <button type="button" class="btn btn-info btn-block" data-bs-toggle="modal" data-bs-target="#withdrawModal">
                                <i class="mdi mdi-minus-circle me-1"></i> Tarik Simpanan
                            </button>
                        </div>
                        <div class="col-md-3 mb-3">
                            <button type="button" class="btn btn-warning btn-block" data-bs-toggle="modal" data-bs-target="#loanModal">
                                <i class="mdi mdi-cash me-1"></i> Ajukan Pinjaman
                            </button>
                        </div>
                        <div class="col-md-3 mb-3">
                            <a href="{{ route('anggota.cooperative.transactions') }}" class="btn btn-outline-primary btn-block">
                                <i class="mdi mdi-history me-1"></i> Riwayat Transaksi
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Savings Accounts -->
    <div class="row">
        <div class="col-xl-8">
            <div class="card">
                <div class="card-header">
                    <h4 class="header-title">Rekening Simpanan</h4>
                </div>
                <div class="card-body">
                    @if($memberSavings->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-centered table-nowrap mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>Jenis Simpanan</th>
                                        <th>Saldo</th>
                                        <th>Bunga</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($memberSavings as $saving)
                                    <tr>
                                        <td>
                                            <h5 class="mb-1">{{ $saving->saving_type }}</h5>
                                            <p class="mb-0 text-muted">Dibuka: {{ $saving->created_at->format('d M Y') }}</p>
                                        </td>
                                        <td>
                                            <strong>Rp {{ number_format($saving->balance, 0, ',', '.') }}</strong>
                                        </td>
                                        <td>{{ $saving->interest_rate }}% / tahun</td>
                                        <td>
                                            @if($saving->is_active)
                                                <span class="badge bg-success">Aktif</span>
                                            @else
                                                <span class="badge bg-secondary">Tidak Aktif</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <button type="button" class="btn btn-sm btn-outline-success" 
                                                        onclick="deposit({{ $saving->id }})">
                                                    <i class="mdi mdi-plus"></i>
                                                </button>
                                                <button type="button" class="btn btn-sm btn-outline-info" 
                                                        onclick="withdraw({{ $saving->id }})">
                                                    <i class="mdi mdi-minus"></i>
                                                </button>
                                                <a href="{{ route('anggota.cooperative.saving.detail', $saving) }}" 
                                                   class="btn btn-sm btn-outline-primary">
                                                    <i class="mdi mdi-eye"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="mdi mdi-bank-remove h1 text-muted"></i>
                            <h4>Belum ada simpanan</h4>
                            <p class="text-muted">Anda belum memiliki rekening simpanan. Buka simpanan baru untuk memulai.</p>
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#newSavingModal">
                                Buka Simpanan Baru
                            </button>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-xl-4">
            <div class="card">
                <div class="card-header">
                    <h4 class="header-title">Pinjaman Aktif</h4>
                </div>
                <div class="card-body">
                    @if($activeLoans->count() > 0)
                        @foreach($activeLoans as $loan)
                        <div class="border-bottom pb-2 mb-2">
                            <h5 class="mb-1">{{ $loan->loan_type }}</h5>
                            <p class="mb-1">
                                <strong>Sisa: Rp {{ number_format($loan->remaining_amount, 0, ',', '.') }}</strong><br>
                                <small class="text-muted">
                                    Dari Rp {{ number_format($loan->amount, 0, ',', '.') }} 
                                    ({{ $loan->interest_rate }}% bunga)
                                </small>
                            </p>
                            <div class="progress mb-2" style="height: 6px;">
                                <div class="progress-bar bg-warning" role="progressbar" 
                                     style="width: {{ ($loan->remaining_amount / $loan->amount) * 100 }}%"></div>
                            </div>
                            <small class="text-muted">
                                Jatuh tempo: {{ \Carbon\Carbon::parse($loan->due_date)->format('d M Y') }}
                            </small>
                        </div>
                        @endforeach
                        <div class="text-center mt-3">
                            <a href="{{ route('anggota.cooperative.loans') }}" class="btn btn-sm btn-outline-primary">
                                Lihat Semua Pinjaman
                            </a>
                        </div>
                    @else
                        <div class="text-center py-3">
                            <i class="mdi mdi-cash-remove h1 text-muted"></i>
                            <p class="text-muted">Tidak ada pinjaman aktif</p>
                            <button type="button" class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#loanModal">
                                Ajukan Pinjaman
                            </button>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Recent Transactions -->
            <div class="card">
                <div class="card-header">
                    <h4 class="header-title">Transaksi Terbaru</h4>
                </div>
                <div class="card-body">
                    @if(isset($recentTransactions) && $recentTransactions->count() > 0)
                        @foreach($recentTransactions->take(5) as $transaction)
                        <div class="d-flex align-items-center border-bottom pb-2 mb-2">
                            <div class="flex-shrink-0">
                                @if($transaction->type == 'deposit')
                                    <i class="mdi mdi-plus-circle h4 text-success"></i>
                                @elseif($transaction->type == 'withdrawal')
                                    <i class="mdi mdi-minus-circle h4 text-danger"></i>
                                @else
                                    <i class="mdi mdi-swap-horizontal h4 text-info"></i>
                                @endif
                            </div>
                            <div class="flex-grow-1 ms-2">
                                <h6 class="mb-1">{{ ucfirst($transaction->type) }}</h6>
                                <p class="mb-0 text-muted">
                                    Rp {{ number_format($transaction->amount, 0, ',', '.') }}
                                </p>
                                <small class="text-muted">{{ $transaction->created_at->diffForHumans() }}</small>
                            </div>
                        </div>
                        @endforeach
                        <div class="text-center mt-3">
                            <a href="{{ route('anggota.cooperative.transactions') }}" class="btn btn-sm btn-outline-primary">
                                Lihat Semua
                            </a>
                        </div>
                    @else
                        <div class="text-center py-3">
                            <i class="mdi mdi-history h1 text-muted"></i>
                            <p class="text-muted">Belum ada transaksi</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modals will be added here -->
<!-- New Saving Modal -->
<div class="modal fade" id="newSavingModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('anggota.cooperative.saving.create') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Buka Simpanan Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="saving_type" class="form-label">Jenis Simpanan</label>
                        <select class="form-select" id="saving_type" name="saving_type" required>
                            <option value="">Pilih jenis simpanan</option>
                            <option value="Simpanan Pokok">Simpanan Pokok</option>
                            <option value="Simpanan Wajib">Simpanan Wajib</option>
                            <option value="Simpanan Sukarela">Simpanan Sukarela</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="initial_deposit" class="form-label">Setoran Awal</label>
                        <input type="number" class="form-control" id="initial_deposit" name="initial_deposit" 
                               placeholder="50000" min="10000" required>
                        <small class="text-muted">Minimum setoran awal Rp 10.000</small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Buka Simpanan</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
