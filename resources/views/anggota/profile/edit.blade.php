@extends('layouts.app')

@section('title', 'Edit Profil')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0">Edit Profil</h1>
    <a href="{{ route('anggota.profile.show') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left me-2"></i>
        Kembali
    </a>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card shadow">
            <div class="card-header">
                <h6 class="m-0 font-weight-bold">
                    <i class="fas fa-edit me-2"></i>
                    Form Edit Profil
                </h6>
            </div>
            <div class="card-body">
                <form action="{{ route('anggota.profile.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PATCH')
                    
                    <!-- Profile Photo -->
                    <div class="text-center mb-4">
                        <div class="position-relative d-inline-block">
                            <img src="https://via.placeholder.com/120x120/6c757d/ffffff?text=A" 
                                 class="rounded-circle border" 
                                 width="120" 
                                 height="120" 
                                 alt="Profile Photo"
                                 id="profilePreview">
                            <label for="photo" class="position-absolute bottom-0 end-0 btn btn-primary btn-sm rounded-circle">
                                <i class="fas fa-camera"></i>
                            </label>
                            <input type="file" id="photo" name="photo" class="d-none" accept="image/*">
                        </div>
                        <p class="text-muted small mt-2">Klik ikon kamera untuk mengubah foto</p>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="name" class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="name" name="name" value="{{ auth()->user()->name ?? 'Anggota Contoh' }}" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                                <input type="email" class="form-control" id="email" name="email" value="{{ auth()->user()->email ?? 'anggota@example.com' }}" required>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="phone" class="form-label">Nomor Telepon</label>
                                <input type="text" class="form-control" id="phone" name="phone" value="081234567890">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="birth_date" class="form-label">Tanggal Lahir</label>
                                <input type="date" class="form-control" id="birth_date" name="birth_date" value="1995-01-01">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="gender" class="form-label">Jenis Kelamin</label>
                                <select class="form-select" id="gender" name="gender">
                                    <option value="">Pilih Jenis Kelamin</option>
                                    <option value="L" selected>Laki-laki</option>
                                    <option value="P">Perempuan</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="tingkat" class="form-label">Tingkat/Sabuk</label>
                                <select class="form-select" id="tingkat" name="tingkat">
                                    <option value="">Pilih Tingkat</option>
                                    <option value="Putih" selected>Putih</option>
                                    <option value="Kuning">Kuning</option>
                                    <option value="Hijau">Hijau</option>
                                    <option value="Biru">Biru</option>
                                    <option value="Coklat">Coklat</option>
                                    <option value="Hitam">Hitam</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="address" class="form-label">Alamat Lengkap</label>
                        <textarea class="form-control" id="address" name="address" rows="3">Jl. Contoh No. 123, Jember, Jawa Timur</textarea>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="emergency_contact_name" class="form-label">Kontak Darurat (Nama)</label>
                                <input type="text" class="form-control" id="emergency_contact_name" name="emergency_contact_name" value="Orang Tua">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="emergency_contact_phone" class="form-label">Kontak Darurat (Telepon)</label>
                                <input type="text" class="form-control" id="emergency_contact_phone" name="emergency_contact_phone" value="081234567891">
                            </div>
                        </div>
                    </div>

                    <hr>
                    <h6 class="mb-3">Ubah Password (Opsional)</h6>
                    
                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="current_password" class="form-label">Password Saat Ini</label>
                                <input type="password" class="form-control" id="current_password" name="current_password">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="password" class="form-label">Password Baru</label>
                                <input type="password" class="form-control" id="password" name="password">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="password_confirmation" class="form-label">Konfirmasi Password Baru</label>
                                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation">
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{ route('anggota.profile.show') }}" class="btn btn-secondary">
                            <i class="fas fa-times me-2"></i>
                            Batal
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i>
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card shadow">
            <div class="card-header">
                <h6 class="m-0 font-weight-bold">
                    <i class="fas fa-info-circle me-2"></i>
                    Panduan
                </h6>
            </div>
            <div class="card-body">
                <div class="alert alert-info">
                    <h6><i class="fas fa-lightbulb me-2"></i>Tips:</h6>
                    <ul class="mb-0 small">
                        <li>Pastikan data yang diisi akurat</li>
                        <li>Email digunakan untuk notifikasi</li>
                        <li>Kontak darurat penting untuk keamanan</li>
                        <li>Foto profil maksimal 2MB</li>
                    </ul>
                </div>

                <div class="alert alert-warning">
                    <h6><i class="fas fa-exclamation-triangle me-2"></i>Perhatian:</h6>
                    <ul class="mb-0 small">
                        <li>Field bertanda (*) wajib diisi</li>
                        <li>Email harus unik</li>
                        <li>Password minimal 8 karakter</li>
                        <li>Perubahan akan tersimpan otomatis</li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="card shadow mt-4">
            <div class="card-header">
                <h6 class="m-0 font-weight-bold">
                    <i class="fas fa-shield-alt me-2"></i>
                    Keamanan Akun
                </h6>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <button type="button" class="btn btn-outline-primary btn-sm">
                        <i class="fas fa-key me-2"></i>
                        Ubah Password
                    </button>
                    <button type="button" class="btn btn-outline-warning btn-sm">
                        <i class="fas fa-mobile-alt me-2"></i>
                        Verifikasi 2FA
                    </button>
                    <button type="button" class="btn btn-outline-info btn-sm">
                        <i class="fas fa-history me-2"></i>
                        Riwayat Login
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Preview foto profil
    const photoInput = document.getElementById('photo');
    const profilePreview = document.getElementById('profilePreview');
    
    photoInput.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                profilePreview.src = e.target.result;
            };
            reader.readAsDataURL(file);
        }
    });
    
    // Validasi password
    const password = document.getElementById('password');
    const confirmPassword = document.getElementById('password_confirmation');
    
    function validatePassword() {
        if (password.value !== confirmPassword.value) {
            confirmPassword.setCustomValidity('Password tidak cocok');
        } else {
            confirmPassword.setCustomValidity('');
        }
    }
    
    password.addEventListener('input', validatePassword);
    confirmPassword.addEventListener('input', validatePassword);
});
</script>
@endpush
@endsection
