@extends('layouts.app')

@section('content')
<div class="login-wrapper">
    <div class="login-container">
        <div class="card shadow-lg">
            <div class="card-header text-center">
                <h4 class="mb-0">
                    <i class="fas fa-fist-raised me-2"></i>
                    Login
                </h4>
                <small class="text-white-50">PPS Betako Merpati Putih Jember</small>
            </div>
            <div class="card-body p-4">
                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <div class="mb-3">
                        <label for="email" class="form-label">
                            <i class="fas fa-envelope me-1"></i>
                            Email
                        </label>
                        <input
                            type="email"
                            class="form-control @error('email') is-invalid @enderror"
                            id="email"
                            name="email"
                            value="{{ old('email') }}"
                            required
                            autofocus
                            placeholder="Masukkan email Anda"
                        >
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
                        <input
                            type="password"
                            class="form-control @error('password') is-invalid @enderror"
                            id="password"
                            name="password"
                            required
                            placeholder="Masukkan password Anda"
                        >
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

                <div class="text-center mt-4">
                    <small class="text-muted">
                        Belum punya akun? Hubungi administrator untuk pendaftaran.
                    </small>
                </div>
            </div>
        </div>

        <div class="text-center mt-4">
            <small class="text-muted">
                © {{ date('Y') }} PPS Betako Merpati Putih Cabang Jember
            </small>
        </div>
    </div>
</div>

@push('styles')
<style>
    body {
        background-color: #f8f9fa !important;
        margin: 0 !important;
        padding: 0 !important;
        overflow-x: hidden;
    }

    .main-content {
        margin-left: 0 !important;
        background-color: #f8f9fa !important;
    }

    .login-wrapper {
        position: fixed;
        top: 0;
        left: 0;
        width: 100vw;
        height: 100vh;
        display: flex;
        justify-content: center;
        align-items: center;
        background-color: #f8f9fa;
        z-index: 9999;
    }

    .login-container {
        width: 100%;
        max-width: 400px;
        padding: 20px;
    }

    .card {
        border: none !important;
        border-radius: 15px !important;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1) !important;
        width: 100%;
    }

    /* Hide sidebar for login page */
    .sidebar {
        display: none !important;
    }
</style>
@endpush
@endsection
