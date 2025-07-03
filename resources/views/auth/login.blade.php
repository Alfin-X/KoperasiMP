@extends('layouts.app')

@section('content')
<div class="container-fluid vh-100">
    <div class="row h-100">
        <!-- Left side - Login Form -->
        <div class="col-md-6 d-flex align-items-center justify-content-center">
            <div class="card shadow-lg" style="width: 100%; max-width: 400px;">
                <div class="card-header text-center">
                    <div class="mb-3">
                        <img src="{{ asset('assets/images/logo.svg') }}" alt="MP Jember Logo" style="width: 50px; height: 50px; object-fit: contain;">
                    </div>
                    <h4 class="mb-0">
                        <i class="fas fa-sign-in-alt me-2"></i>
                        Login
                    </h4>
                </div>
                <div class="card-body p-4">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        
                        <div class="mb-3">
                            <label for="email" class="form-label">
                                <i class="fas fa-envelope me-1"></i>
                                Email
                            </label>
                            <input type="email" 
                                   class="form-control @error('email') is-invalid @enderror" 
                                   id="email" 
                                   name="email" 
                                   value="{{ old('email') }}" 
                                   required 
                                   autofocus
                                   placeholder="Masukkan email Anda">
                            @error('email')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">
                                <i class="fas fa-lock me-1"></i>
                                Password
                            </label>
                            <input type="password" 
                                   class="form-control @error('password') is-invalid @enderror" 
                                   id="password" 
                                   name="password" 
                                   required
                                   placeholder="Masukkan password Anda">
                            @error('password')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" id="remember" name="remember">
                            <label class="form-check-label" for="remember">
                                Ingat saya
                            </label>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="fas fa-sign-in-alt me-2"></i>
                                Login
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
        <!-- Right side - Branding -->
        <div class="col-md-6 d-none d-md-flex align-items-center justify-content-center" 
             style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
            <div class="text-center text-white">
                <div class="mb-4">
                    <img src="{{ asset('assets/images/logo.svg') }}" alt="MP Jember Logo" style="width: 120px; height: 120px; object-fit: contain;">
                </div>
                <h1 class="display-4 fw-bold mb-3">MP Jember</h1>
                <h3 class="mb-4">PPS Betako Merpati Putih</h3>
                <p class="lead mb-4">
                    Sistem Informasi Perguruan Silat Multi-Lokasi
                </p>
                <div class="row text-center">
                    <div class="col-4">
                        <i class="fas fa-users fa-2x mb-2"></i>
                        <p class="small">Manajemen Anggota</p>
                    </div>
                    <div class="col-4">
                        <i class="fas fa-clipboard-check fa-2x mb-2"></i>
                        <p class="small">Sistem Absensi</p>
                    </div>
                    <div class="col-4">
                        <i class="fas fa-chart-line fa-2x mb-2"></i>
                        <p class="small">Laporan Lengkap</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    body {
        background-color: #f8f9fa;
    }
    .card {
        border-radius: 1rem;
        border: none;
    }
    .form-control:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
    }
</style>
@endpush
@endsection
