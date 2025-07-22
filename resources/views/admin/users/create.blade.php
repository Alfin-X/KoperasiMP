@extends('layouts.app')

@section('title', 'Tambah Pengguna')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0">Tambah Pengguna Baru</h1>
    <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left me-2"></i>
        Kembali
    </a>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card shadow">
            <div class="card-header">
                <h6 class="m-0 font-weight-bold">
                    <i class="fas fa-user-plus me-2"></i>
                    Form Tambah Pengguna
                </h6>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.users.store') }}" method="POST">
                    @csrf
                    
                    <div class="row">
                        <!-- Basic Information -->
                        <div class="col-md-6 mb-3">
                            <label for="name" class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                   id="name" name="name" value="{{ old('name') }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                   id="email" name="email" value="{{ old('email') }}" required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="phone" class="form-label">Nomor Telepon</label>
                            <input type="text" class="form-control @error('phone') is-invalid @enderror" 
                                   id="phone" name="phone" value="{{ old('phone') }}">
                            @error('phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="birth_date" class="form-label">Tanggal Lahir</label>
                            <input type="date" class="form-control @error('birth_date') is-invalid @enderror" 
                                   id="birth_date" name="birth_date" value="{{ old('birth_date') }}">
                            @error('birth_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="gender" class="form-label">Jenis Kelamin</label>
                            <select class="form-select @error('gender') is-invalid @enderror" id="gender" name="gender">
                                <option value="">Pilih Jenis Kelamin</option>
                                <option value="L" {{ old('gender') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                                <option value="P" {{ old('gender') == 'P' ? 'selected' : '' }}>Perempuan</option>
                            </select>
                            @error('gender')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-12 mb-3">
                            <label for="address" class="form-label">Alamat</label>
                            <textarea class="form-control @error('address') is-invalid @enderror" 
                                      id="address" name="address" rows="3">{{ old('address') }}</textarea>
                            @error('address')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <!-- Role & Organization -->
                        <div class="col-md-6 mb-3">
                            <label for="role_id" class="form-label">Role <span class="text-danger">*</span></label>
                            <select class="form-select @error('role_id') is-invalid @enderror" id="role_id" name="role_id" required>
                                <option value="">Pilih Role</option>
                                @foreach($roles as $role)
                                    <option value="{{ $role->id }}" {{ old('role_id') == $role->id ? 'selected' : '' }}>
                                        {{ $role->display_name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('role_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="kolat_id" class="form-label">Kolat</label>
                            <select class="form-select @error('kolat_id') is-invalid @enderror" id="kolat_id" name="kolat_id">
                                <option value="">Pilih Kolat</option>
                                @foreach($kolats as $kolat)
                                    <option value="{{ $kolat->id }}" {{ old('kolat_id') == $kolat->id ? 'selected' : '' }}>
                                        {{ $kolat->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('kolat_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <!-- Member Specific -->
                        <div class="col-md-6 mb-3" id="member_id_field" style="display: none;">
                            <label for="member_id" class="form-label">ID Anggota</label>
                            <input type="text" class="form-control @error('member_id') is-invalid @enderror" 
                                   id="member_id" name="member_id" value="{{ old('member_id') }}">
                            @error('member_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-6 mb-3" id="tingkatan_field" style="display: none;">
                            <label for="tingkatan" class="form-label">Tingkatan</label>
                            <input type="text" class="form-control @error('tingkatan') is-invalid @enderror" 
                                   id="tingkatan" name="tingkatan" value="{{ old('tingkatan') }}" 
                                   placeholder="Contoh: Sabuk Putih, Sabuk Kuning">
                            @error('tingkatan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <!-- Password -->
                        <div class="col-md-6 mb-3">
                            <label for="password" class="form-label">Password <span class="text-danger">*</span></label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror" 
                                   id="password" name="password" required>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="password_confirmation" class="form-label">Konfirmasi Password <span class="text-danger">*</span></label>
                            <input type="password" class="form-control" 
                                   id="password_confirmation" name="password_confirmation" required>
                        </div>
                    </div>
                    
                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">
                            <i class="fas fa-times me-2"></i>
                            Batal
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i>
                            Simpan
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
                    Informasi
                </h6>
            </div>
            <div class="card-body">
                <h6>Role Pengguna:</h6>
                <ul class="list-unstyled">
                    <li><strong>Admin:</strong> Akses penuh ke seluruh sistem</li>
                    <li><strong>Pelatih:</strong> Mengelola absensi dan transaksi koperasi</li>
                    <li><strong>Anggota:</strong> Akses terbatas untuk melihat data pribadi</li>
                </ul>
                
                <hr>
                
                <h6>Catatan:</h6>
                <ul class="list-unstyled">
                    <li>• Field dengan tanda <span class="text-danger">*</span> wajib diisi</li>
                    <li>• ID Anggota dan Tingkatan hanya untuk role Anggota</li>
                    <li>• Password minimal 8 karakter</li>
                </ul>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const roleSelect = document.getElementById('role_id');
    const memberIdField = document.getElementById('member_id_field');
    const tingkatanField = document.getElementById('tingkatan_field');
    
    function toggleMemberFields() {
        const selectedRole = roleSelect.options[roleSelect.selectedIndex];
        const roleText = selectedRole.text;
        
        if (roleText === 'Anggota') {
            memberIdField.style.display = 'block';
            tingkatanField.style.display = 'block';
        } else {
            memberIdField.style.display = 'none';
            tingkatanField.style.display = 'none';
        }
    }
    
    roleSelect.addEventListener('change', toggleMemberFields);
    toggleMemberFields(); // Initial check
});
</script>
@endpush
@endsection
