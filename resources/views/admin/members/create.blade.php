@extends('layouts.app')

@section('title', 'Tambah Anggota')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Tambah Anggota</h1>
        <a href="{{ route('admin.members.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-2"></i>
            Kembali
        </a>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card shadow">
                <div class="card-header">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-user-plus me-2"></i>
                        Form Tambah Anggota
                    </h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.members.store') }}" method="POST">
                        @csrf
                        
                        <!-- Data Pribadi -->
                        <h6 class="text-primary mb-3">
                            <i class="fas fa-user me-2"></i>
                            Data Pribadi
                        </h6>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="name" class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                           id="name" name="name" value="{{ old('name') }}" required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                           id="email" name="email" value="{{ old('email') }}" required>
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="password" class="form-label">Password <span class="text-danger">*</span></label>
                                    <input type="password" class="form-control @error('password') is-invalid @enderror" 
                                           id="password" name="password" required>
                                    @error('password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="password_confirmation" class="form-label">Konfirmasi Password <span class="text-danger">*</span></label>
                                    <input type="password" class="form-control" 
                                           id="password_confirmation" name="password_confirmation" required>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="phone" class="form-label">Nomor Telepon</label>
                                    <input type="text" class="form-control @error('phone') is-invalid @enderror" 
                                           id="phone" name="phone" value="{{ old('phone') }}">
                                    @error('phone')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="birth_date" class="form-label">Tanggal Lahir</label>
                                    <input type="date" class="form-control @error('birth_date') is-invalid @enderror" 
                                           id="birth_date" name="birth_date" value="{{ old('birth_date') }}">
                                    @error('birth_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="gender" class="form-label">Jenis Kelamin</label>
                                    <select class="form-select @error('gender') is-invalid @enderror" 
                                            id="gender" name="gender">
                                        <option value="">Pilih Jenis Kelamin</option>
                                        <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>Laki-laki</option>
                                        <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Perempuan</option>
                                    </select>
                                    @error('gender')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="address" class="form-label">Alamat</label>
                            <textarea class="form-control @error('address') is-invalid @enderror" 
                                      id="address" name="address" rows="3">{{ old('address') }}</textarea>
                            @error('address')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <hr>

                        <!-- Data Keanggotaan -->
                        <h6 class="text-primary mb-3">
                            <i class="fas fa-id-card me-2"></i>
                            Data Keanggotaan
                        </h6>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="location_id" class="form-label">Lokasi <span class="text-danger">*</span></label>
                                    <select class="form-select @error('location_id') is-invalid @enderror" 
                                            id="location_id" name="location_id" required>
                                        <option value="">Pilih Lokasi</option>
                                        @foreach($locations as $location)
                                            <option value="{{ $location->id }}" {{ old('location_id') == $location->id ? 'selected' : '' }}>
                                                {{ $location->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('location_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="current_level_id" class="form-label">Level Awal <span class="text-danger">*</span></label>
                                    <select class="form-select @error('current_level_id') is-invalid @enderror" 
                                            id="current_level_id" name="current_level_id" required>
                                        <option value="">Pilih Level</option>
                                        @foreach($levels as $level)
                                            <option value="{{ $level->id }}" {{ old('current_level_id') == $level->id ? 'selected' : '' }}>
                                                {{ $level->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('current_level_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="join_date" class="form-label">Tanggal Bergabung <span class="text-danger">*</span></label>
                                    <input type="date" class="form-control @error('join_date') is-invalid @enderror" 
                                           id="join_date" name="join_date" value="{{ old('join_date', date('Y-m-d')) }}" required>
                                    @error('join_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="membership_type" class="form-label">Tipe Keanggotaan <span class="text-danger">*</span></label>
                                    <select class="form-select @error('membership_type') is-invalid @enderror" 
                                            id="membership_type" name="membership_type" required>
                                        <option value="">Pilih Tipe</option>
                                        <option value="regular" {{ old('membership_type') == 'regular' ? 'selected' : '' }}>Regular</option>
                                        <option value="student" {{ old('membership_type') == 'student' ? 'selected' : '' }}>Student</option>
                                        <option value="family" {{ old('membership_type') == 'family' ? 'selected' : '' }}>Family</option>
                                    </select>
                                    @error('membership_type')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="monthly_fee" class="form-label">Iuran Bulanan <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text">Rp</span>
                                        <input type="number" class="form-control @error('monthly_fee') is-invalid @enderror" 
                                               id="monthly_fee" name="monthly_fee" value="{{ old('monthly_fee') }}" required min="0">
                                    </div>
                                    @error('monthly_fee')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end">
                            <button type="reset" class="btn btn-secondary me-2">Reset</button>
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
                    <h6 class="m-0 font-weight-bold text-info">
                        <i class="fas fa-info-circle me-2"></i>
                        Informasi
                    </h6>
                </div>
                <div class="card-body">
                    <h6>Tipe Keanggotaan:</h6>
                    <ul class="list-unstyled">
                        <li><strong>Regular:</strong> Anggota dewasa biasa</li>
                        <li><strong>Student:</strong> Pelajar/mahasiswa (diskon)</li>
                        <li><strong>Family:</strong> Paket keluarga</li>
                    </ul>
                    
                    <hr>
                    
                    <h6>Catatan:</h6>
                    <ul class="list-unstyled">
                        <li>• Field dengan tanda <span class="text-danger">*</span> wajib diisi</li>
                        <li>• Nomor anggota akan dibuat otomatis</li>
                        <li>• Password minimal 8 karakter</li>
                        <li>• Email harus unik</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
