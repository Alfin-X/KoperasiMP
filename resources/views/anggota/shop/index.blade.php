@extends('layouts.app')

@section('title', 'Toko MP Jember')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <h4 class="page-title">Toko MP Jember</h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('anggota.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Toko</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <!-- Shop Header -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <h4 class="mb-1">Selamat datang di Toko MP Jember</h4>
                            <p class="text-muted mb-0">
                                Temukan berbagai perlengkapan latihan dan merchandise resmi Merpati Putih
                            </p>
                        </div>
                        <div class="col-md-4 text-end">
                            <a href="{{ route('anggota.shop.cart') }}" class="btn btn-primary">
                                <i class="mdi mdi-cart me-1"></i>Keranjang 
                                <span class="badge bg-light text-dark ms-1">{{ $cartCount ?? 0 }}</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters and Search -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('anggota.shop.index') }}" method="GET" class="row g-3">
                        <div class="col-md-4">
                            <label for="search" class="form-label">Cari Produk</label>
                            <input type="text" class="form-control" id="search" name="search" 
                                   value="{{ request('search') }}" placeholder="Nama produk...">
                        </div>
                        <div class="col-md-3">
                            <label for="category" class="form-label">Kategori</label>
                            <select class="form-select" id="category" name="category">
                                <option value="">Semua Kategori</option>
                                <option value="Seragam" {{ request('category') == 'Seragam' ? 'selected' : '' }}>Seragam</option>
                                <option value="Sabuk" {{ request('category') == 'Sabuk' ? 'selected' : '' }}>Sabuk</option>
                                <option value="Perlengkapan" {{ request('category') == 'Perlengkapan' ? 'selected' : '' }}>Perlengkapan</option>
                                <option value="Merchandise" {{ request('category') == 'Merchandise' ? 'selected' : '' }}>Merchandise</option>
                                <option value="Buku" {{ request('category') == 'Buku' ? 'selected' : '' }}>Buku</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label for="price_range" class="form-label">Rentang Harga</label>
                            <select class="form-select" id="price_range" name="price_range">
                                <option value="">Semua Harga</option>
                                <option value="0-50000" {{ request('price_range') == '0-50000' ? 'selected' : '' }}>< Rp 50.000</option>
                                <option value="50000-100000" {{ request('price_range') == '50000-100000' ? 'selected' : '' }}>Rp 50.000 - 100.000</option>
                                <option value="100000-200000" {{ request('price_range') == '100000-200000' ? 'selected' : '' }}>Rp 100.000 - 200.000</option>
                                <option value="200000-500000" {{ request('price_range') == '200000-500000' ? 'selected' : '' }}>Rp 200.000 - 500.000</option>
                                <option value="500000+" {{ request('price_range') == '500000+' ? 'selected' : '' }}>> Rp 500.000</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">&nbsp;</label>
                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary">
                                    <i class="mdi mdi-magnify me-1"></i>Cari
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Featured Categories -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="header-title">Kategori Populer</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-2 col-6 mb-3">
                            <a href="{{ route('anggota.shop.index', ['category' => 'Seragam']) }}" 
                               class="text-decoration-none">
                                <div class="card text-center border">
                                    <div class="card-body py-3">
                                        <i class="mdi mdi-tshirt-crew h1 text-primary"></i>
                                        <h6 class="mb-0">Seragam</h6>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-md-2 col-6 mb-3">
                            <a href="{{ route('anggota.shop.index', ['category' => 'Sabuk']) }}" 
                               class="text-decoration-none">
                                <div class="card text-center border">
                                    <div class="card-body py-3">
                                        <i class="mdi mdi-karate h1 text-warning"></i>
                                        <h6 class="mb-0">Sabuk</h6>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-md-2 col-6 mb-3">
                            <a href="{{ route('anggota.shop.index', ['category' => 'Perlengkapan']) }}" 
                               class="text-decoration-none">
                                <div class="card text-center border">
                                    <div class="card-body py-3">
                                        <i class="mdi mdi-dumbbell h1 text-success"></i>
                                        <h6 class="mb-0">Perlengkapan</h6>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-md-2 col-6 mb-3">
                            <a href="{{ route('anggota.shop.index', ['category' => 'Merchandise']) }}" 
                               class="text-decoration-none">
                                <div class="card text-center border">
                                    <div class="card-body py-3">
                                        <i class="mdi mdi-gift h1 text-info"></i>
                                        <h6 class="mb-0">Merchandise</h6>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-md-2 col-6 mb-3">
                            <a href="{{ route('anggota.shop.index', ['category' => 'Buku']) }}" 
                               class="text-decoration-none">
                                <div class="card text-center border">
                                    <div class="card-body py-3">
                                        <i class="mdi mdi-book-open h1 text-danger"></i>
                                        <h6 class="mb-0">Buku</h6>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-md-2 col-6 mb-3">
                            <a href="{{ route('anggota.shop.index') }}" 
                               class="text-decoration-none">
                                <div class="card text-center border">
                                    <div class="card-body py-3">
                                        <i class="mdi mdi-view-grid h1 text-secondary"></i>
                                        <h6 class="mb-0">Semua</h6>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Products Grid -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="header-title">
                        Produk 
                        @if(request('category'))
                            - {{ request('category') }}
                        @endif
                        @if(request('search'))
                            - "{{ request('search') }}"
                        @endif
                    </h4>
                    <div class="card-header-actions">
                        <div class="btn-group" role="group">
                            <button type="button" class="btn btn-sm btn-outline-primary" onclick="sortProducts('name')">
                                Nama
                            </button>
                            <button type="button" class="btn btn-sm btn-outline-primary" onclick="sortProducts('price_low')">
                                Harga ↑
                            </button>
                            <button type="button" class="btn btn-sm btn-outline-primary" onclick="sortProducts('price_high')">
                                Harga ↓
                            </button>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    @if(isset($products) && $products->count() > 0)
                        <div class="row" id="productsGrid">
                            @foreach($products as $product)
                            <div class="col-xl-3 col-lg-4 col-md-6 mb-4">
                                <div class="card product-card h-100">
                                    <div class="position-relative">
                                        @if($product->image_path)
                                            <img src="{{ asset('storage/' . $product->image_path) }}" 
                                                 class="card-img-top" alt="{{ $product->name }}" 
                                                 style="height: 200px; object-fit: cover;">
                                        @else
                                            <div class="card-img-top d-flex align-items-center justify-content-center bg-light" 
                                                 style="height: 200px;">
                                                <i class="mdi mdi-image h1 text-muted"></i>
                                            </div>
                                        @endif
                                        
                                        @if($product->stock <= 5 && $product->stock > 0)
                                            <span class="position-absolute top-0 end-0 badge bg-warning m-2">
                                                Stok Terbatas
                                            </span>
                                        @elseif($product->stock <= 0)
                                            <span class="position-absolute top-0 end-0 badge bg-danger m-2">
                                                Habis
                                            </span>
                                        @endif
                                    </div>
                                    
                                    <div class="card-body d-flex flex-column">
                                        <h5 class="card-title">{{ $product->name }}</h5>
                                        <p class="card-text text-muted flex-grow-1">
                                            {{ Str::limit($product->description, 80) }}
                                        </p>
                                        <div class="mb-2">
                                            <span class="badge bg-secondary">{{ $product->category }}</span>
                                            @if($product->stock > 0)
                                                <span class="badge bg-success">Stok: {{ $product->stock }}</span>
                                            @endif
                                        </div>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <h4 class="text-primary mb-0">
                                                Rp {{ number_format($product->price, 0, ',', '.') }}
                                            </h4>
                                            @if($product->stock > 0)
                                                <button type="button" class="btn btn-primary btn-sm" 
                                                        onclick="addToCart({{ $product->id }})">
                                                    <i class="mdi mdi-cart-plus"></i>
                                                </button>
                                            @else
                                                <button type="button" class="btn btn-secondary btn-sm" disabled>
                                                    Habis
                                                </button>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        
                        <!-- Pagination -->
                        <div class="d-flex justify-content-center">
                            {{ $products->appends(request()->query())->links() }}
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="mdi mdi-package-variant-closed h1 text-muted"></i>
                            <h4>Produk tidak ditemukan</h4>
                            <p class="text-muted">
                                @if(request()->hasAny(['search', 'category', 'price_range']))
                                    Tidak ada produk yang sesuai dengan filter yang dipilih.
                                @else
                                    Belum ada produk yang tersedia di toko.
                                @endif
                            </p>
                            @if(request()->hasAny(['search', 'category', 'price_range']))
                                <a href="{{ route('anggota.shop.index') }}" class="btn btn-primary">
                                    Lihat Semua Produk
                                </a>
                            @endif
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
function addToCart(productId) {
    fetch(`/anggota/shop/cart/add/${productId}`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({
            quantity: 1
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Update cart count
            const cartBadge = document.querySelector('.badge');
            if (cartBadge) {
                cartBadge.textContent = data.cartCount;
            }
            
            // Show success message
            showToast('Produk berhasil ditambahkan ke keranjang!', 'success');
        } else {
            showToast(data.message || 'Terjadi kesalahan', 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showToast('Terjadi kesalahan sistem', 'error');
    });
}

function sortProducts(sortBy) {
    const url = new URL(window.location);
    url.searchParams.set('sort', sortBy);
    window.location.href = url.toString();
}

function showToast(message, type) {
    // Simple toast implementation
    const toast = document.createElement('div');
    toast.className = `alert alert-${type === 'success' ? 'success' : 'danger'} position-fixed`;
    toast.style.cssText = 'top: 20px; right: 20px; z-index: 9999; min-width: 300px;';
    toast.innerHTML = `
        ${message}
        <button type="button" class="btn-close" onclick="this.parentElement.remove()"></button>
    `;
    document.body.appendChild(toast);
    
    setTimeout(() => {
        if (toast.parentElement) {
            toast.remove();
        }
    }, 5000);
}
</script>
@endsection
