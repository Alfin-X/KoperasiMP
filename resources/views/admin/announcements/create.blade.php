@extends('layouts.app')

@section('title', 'Buat Pengumuman')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Buat Pengumuman</h1>
        <a href="{{ route('admin.announcements.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-2"></i>
            Kembali
        </a>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card shadow">
                <div class="card-header">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-bullhorn me-2"></i>
                        Form Buat Pengumuman
                    </h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.announcements.store') }}" method="POST">
                        @csrf
                        
                        <div class="mb-3">
                            <label for="title" class="form-label">Judul Pengumuman <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror" 
                                   id="title" name="title" value="{{ old('title') }}" required
                                   placeholder="Masukkan judul pengumuman">
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="type" class="form-label">Tipe Pengumuman <span class="text-danger">*</span></label>
                                    <select class="form-select @error('type') is-invalid @enderror" 
                                            id="type" name="type" required>
                                        <option value="">Pilih Tipe</option>
                                        <option value="general" {{ old('type') == 'general' ? 'selected' : '' }}>Umum</option>
                                        <option value="urgent" {{ old('type') == 'urgent' ? 'selected' : '' }}>Penting</option>
                                        <option value="event" {{ old('type') == 'event' ? 'selected' : '' }}>Event</option>
                                        <option value="maintenance" {{ old('type') == 'maintenance' ? 'selected' : '' }}>Maintenance</option>
                                    </select>
                                    @error('type')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="target_audience" class="form-label">Target Audience <span class="text-danger">*</span></label>
                                    <select class="form-select @error('target_audience') is-invalid @enderror" 
                                            id="target_audience" name="target_audience" required>
                                        <option value="">Pilih Target</option>
                                        <option value="all" {{ old('target_audience') == 'all' ? 'selected' : '' }}>Semua</option>
                                        <option value="members" {{ old('target_audience') == 'members' ? 'selected' : '' }}>Anggota</option>
                                        <option value="staff" {{ old('target_audience') == 'staff' ? 'selected' : '' }}>Staff</option>
                                        <option value="location_specific" {{ old('target_audience') == 'location_specific' ? 'selected' : '' }}>Lokasi Tertentu</option>
                                    </select>
                                    @error('target_audience')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="mb-3" id="location-field" style="display: none;">
                            <label for="location_id" class="form-label">Lokasi Spesifik</label>
                            <select class="form-select @error('location_id') is-invalid @enderror" 
                                    id="location_id" name="location_id">
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

                        <div class="mb-3">
                            <label for="content" class="form-label">Isi Pengumuman <span class="text-danger">*</span></label>
                            <textarea class="form-control @error('content') is-invalid @enderror" 
                                      id="content" name="content" rows="8" required
                                      placeholder="Masukkan isi pengumuman">{{ old('content') }}</textarea>
                            @error('content')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="published_at" class="form-label">Tanggal Publikasi</label>
                                    <input type="datetime-local" class="form-control @error('published_at') is-invalid @enderror" 
                                           id="published_at" name="published_at" value="{{ old('published_at', now()->format('Y-m-d\TH:i')) }}">
                                    @error('published_at')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <div class="form-check mt-4">
                                        <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="is_active">
                                            Aktifkan Pengumuman
                                        </label>
                                    </div>
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
                    <h6>Tipe Pengumuman:</h6>
                    <ul class="list-unstyled">
                        <li><strong>Umum:</strong> Pengumuman biasa</li>
                        <li><strong>Penting:</strong> Pengumuman urgent</li>
                        <li><strong>Event:</strong> Pengumuman event/acara</li>
                        <li><strong>Maintenance:</strong> Pengumuman maintenance</li>
                    </ul>
                    
                    <hr>
                    
                    <h6>Target Audience:</h6>
                    <ul class="list-unstyled">
                        <li><strong>Semua:</strong> Semua pengguna</li>
                        <li><strong>Anggota:</strong> Hanya anggota</li>
                        <li><strong>Staff:</strong> Hanya staff</li>
                        <li><strong>Lokasi Tertentu:</strong> Pengguna di lokasi tertentu</li>
                    </ul>
                    
                    <hr>
                    
                    <h6>Catatan:</h6>
                    <ul class="list-unstyled">
                        <li>• Field dengan tanda <span class="text-danger">*</span> wajib diisi</li>
                        <li>• Pengumuman dapat dijadwalkan untuk publikasi nanti</li>
                        <li>• Pengumuman tidak aktif tidak akan ditampilkan</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const targetAudienceSelect = document.getElementById('target_audience');
    const locationField = document.getElementById('location-field');
    
    function toggleLocationField() {
        if (targetAudienceSelect.value === 'location_specific') {
            locationField.style.display = 'block';
            document.getElementById('location_id').required = true;
        } else {
            locationField.style.display = 'none';
            document.getElementById('location_id').required = false;
            document.getElementById('location_id').value = '';
        }
    }
    
    targetAudienceSelect.addEventListener('change', toggleLocationField);
    
    // Check on page load
    toggleLocationField();
});
</script>
@endpush
@endsection
