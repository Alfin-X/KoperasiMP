@extends('layouts.app')

@section('title', 'Belanja')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0">Toko MP Jember</h1>
    <div class="btn-group">
        <a href="{{ route('anggota.belanja.cart') }}" class="btn btn-outline-primary">
            <i class="fas fa-shopping-cart me-2"></i>
            Keranjang <span class="badge bg-primary">0</span>
        </a>
        <button type="button" class="btn btn-primary dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown">
            <span class="sr-only">Toggle Dropdown</span>
        </button>
        <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="#">Riwayat Pesanan</a></li>
            <li><a class="dropdown-item" href="#">Wishlist</a></li>
        </ul>
    </div>
</div>

<!-- Categories -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card shadow">
            <div class="card-body">
                <h6 class="card-title mb-3">
                    <i class="fas fa-tags me-2"></i>
                    Kategori Produk
                </h6>
                <div class="row">
                    <div class="col-md-2 col-6 mb-2">
                        <button class="btn btn-outline-primary w-100">
                            <i class="fas fa-tshirt d-block mb-1"></i>
                            Seragam
                        </button>
                    </div>
                    <div class="col-md-2 col-6 mb-2">
                        <button class="btn btn-outline-success w-100">
                            <i class="fas fa-medal d-block mb-1"></i>
                            Sabuk
                        </button>
                    </div>
                    <div class="col-md-2 col-6 mb-2">
                        <button class="btn btn-outline-info w-100">
                            <i class="fas fa-dumbbell d-block mb-1"></i>
                            Peralatan
                        </button>
                    </div>
                    <div class="col-md-2 col-6 mb-2">
                        <button class="btn btn-outline-warning w-100">
                            <i class="fas fa-book d-block mb-1"></i>
                            Buku
                        </button>
                    </div>
                    <div class="col-md-2 col-6 mb-2">
                        <button class="btn btn-outline-danger w-100">
                            <i class="fas fa-gift d-block mb-1"></i>
                            Souvenir
                        </button>
                    </div>
                    <div class="col-md-2 col-6 mb-2">
                        <button class="btn btn-outline-secondary w-100">
                            <i class="fas fa-ellipsis-h d-block mb-1"></i>
                            Lainnya
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Products Grid -->
<div class="row">
    <div class="col-12">
        <div class="card shadow">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold">
                        <i class="fas fa-shopping-bag me-2"></i>
                        Produk Tersedia
                    </h6>
                    <div class="btn-group btn-group-sm">
                        <button type="button" class="btn btn-outline-secondary active">
                            <i class="fas fa-th"></i>
                        </button>
                        <button type="button" class="btn btn-outline-secondary">
                            <i class="fas fa-list"></i>
                        </button>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <!-- Empty State -->
                    <div class="col-12">
                        <div class="text-center py-5">
                            <i class="fas fa-shopping-bag fa-4x text-muted mb-4"></i>
                            <h5 class="text-muted">Toko Sedang Dalam Pengembangan</h5>
                            <p class="text-muted">Produk-produk menarik akan segera tersedia untuk anggota MP Jember.</p>
                            <div class="row justify-content-center mt-4">
                                <div class="col-md-8">
                                    <div class="alert alert-info">
                                        <i class="fas fa-info-circle me-2"></i>
                                        <strong>Coming Soon!</strong> Kami sedang menyiapkan berbagai produk berkualitas untuk mendukung latihan dan kebutuhan anggota.
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Quick Info -->
<div class="row mt-4">
    <div class="col-lg-4">
        <div class="card border-left-primary shadow h-100">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="mr-3">
                        <i class="fas fa-shipping-fast fa-2x text-primary"></i>
                    </div>
                    <div>
                        <h6 class="font-weight-bold">Pengiriman Cepat</h6>
                        <p class="text-muted small mb-0">Gratis ongkir untuk pembelian di atas Rp 100.000</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-lg-4">
        <div class="card border-left-success shadow h-100">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="mr-3">
                        <i class="fas fa-shield-alt fa-2x text-success"></i>
                    </div>
                    <div>
                        <h6 class="font-weight-bold">Kualitas Terjamin</h6>
                        <p class="text-muted small mb-0">Semua produk telah melalui quality control</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-lg-4">
        <div class="card border-left-info shadow h-100">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="mr-3">
                        <i class="fas fa-headset fa-2x text-info"></i>
                    </div>
                    <div>
                        <h6 class="font-weight-bold">Customer Service</h6>
                        <p class="text-muted small mb-0">Siap membantu 24/7 untuk anggota MP</p>
                    </div>
                </div>
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
</style>
@endpush
@endsection
