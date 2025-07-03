@extends('layouts.app')

@section('title', 'Tambah Lokasi')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Tambah Lokasi</h1>
        <a href="{{ route('admin.locations.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-2"></i>
            Kembali
        </a>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card shadow">
                <div class="card-header">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-map-marker-alt me-2"></i>
                        Form Tambah Lokasi
                    </h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.locations.store') }}" method="POST">
                        @csrf
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="name" class="form-label">Nama Lokasi <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                           id="name" name="name" value="{{ old('name') }}" required
                                           placeholder="Contoh: Dojo Pusat Jember">
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="code" class="form-label">Kode Lokasi <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('code') is-invalid @enderror" 
                                           id="code" name="code" value="{{ old('code') }}" required
                                           placeholder="Contoh: JMB001" maxlength="10">
                                    @error('code')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="address" class="form-label">Alamat <span class="text-danger">*</span></label>
                            <textarea class="form-control @error('address') is-invalid @enderror" 
                                      id="address" name="address" rows="3" required
                                      placeholder="Masukkan alamat lengkap lokasi">{{ old('address') }}</textarea>
                            @error('address')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="phone" class="form-label">Nomor Telepon</label>
                                    <input type="text" class="form-control @error('phone') is-invalid @enderror" 
                                           id="phone" name="phone" value="{{ old('phone') }}"
                                           placeholder="Contoh: 0331-123456">
                                    @error('phone')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="capacity" class="form-label">Kapasitas <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control @error('capacity') is-invalid @enderror" 
                                           id="capacity" name="capacity" value="{{ old('capacity') }}" required min="1"
                                           placeholder="Jumlah maksimal peserta">
                                    @error('capacity')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="facilities" class="form-label">Fasilitas</label>
                            <textarea class="form-control @error('facilities') is-invalid @enderror" 
                                      id="facilities" name="facilities" rows="3"
                                      placeholder="Contoh: Ruang latihan utama, ruang ganti, toilet, parkir luas">{{ old('facilities') }}</textarea>
                            @error('facilities')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="latitude" class="form-label">Latitude</label>
                                    <input type="number" step="any" class="form-control @error('latitude') is-invalid @enderror" 
                                           id="latitude" name="latitude" value="{{ old('latitude') }}"
                                           placeholder="Contoh: -8.1689">
                                    @error('latitude')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="longitude" class="form-label">Longitude</label>
                                    <input type="number" step="any" class="form-control @error('longitude') is-invalid @enderror" 
                                           id="longitude" name="longitude" value="{{ old('longitude') }}"
                                           placeholder="Contoh: 113.7006">
                                    @error('longitude')
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
                    <h6>Panduan Pengisian:</h6>
                    <ul class="list-unstyled">
                        <li><strong>Kode Lokasi:</strong> Gunakan format singkat dan unik (max 10 karakter)</li>
                        <li><strong>Kapasitas:</strong> Jumlah maksimal peserta yang dapat menampung</li>
                        <li><strong>Koordinat:</strong> Opsional, untuk integrasi dengan maps</li>
                    </ul>
                    
                    <hr>
                    
                    <h6>Contoh Kode Lokasi:</h6>
                    <ul class="list-unstyled">
                        <li>• JMB001 (Jember 001)</li>
                        <li>• JMB002 (Jember 002)</li>
                        <li>• SBY001 (Surabaya 001)</li>
                    </ul>
                    
                    <hr>
                    
                    <h6>Catatan:</h6>
                    <ul class="list-unstyled">
                        <li>• Field dengan tanda <span class="text-danger">*</span> wajib diisi</li>
                        <li>• Kode lokasi harus unik</li>
                        <li>• Koordinat dapat dicari di Google Maps</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
