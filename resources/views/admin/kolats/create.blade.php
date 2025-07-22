@extends('layouts.app')

@section('title', 'Tambah Kolat')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0">Tambah Kolat Baru</h1>
    <a href="{{ route('admin.kolats.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left me-2"></i>
        Kembali
    </a>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card shadow">
            <div class="card-header">
                <h6 class="m-0 font-weight-bold">
                    <i class="fas fa-plus me-2"></i>
                    Form Tambah Kolat
                </h6>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.kolats.store') }}" method="POST">
                    @csrf
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="name" class="form-label">Nama Kolat <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="name" name="name" required>
                                <div class="form-text">Contoh: Kolat Jember Timur</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="code" class="form-label">Kode Kolat <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="code" name="code" required>
                                <div class="form-text">Contoh: JBR-TIM-001</div>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="address" class="form-label">Alamat Lengkap <span class="text-danger">*</span></label>
                        <textarea class="form-control" id="address" name="address" rows="3" required></textarea>
                        <div class="form-text">Masukkan alamat lengkap kolat</div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="pelatih_id" class="form-label">Pelatih Utama</label>
                                <select class="form-select" id="pelatih_id" name="pelatih_id">
                                    <option value="">Pilih Pelatih</option>
                                    <!-- Options akan diisi dari database -->
                                </select>
                                <div class="form-text">Pilih pelatih yang bertanggung jawab</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="capacity" class="form-label">Kapasitas Maksimal</label>
                                <input type="number" class="form-control" id="capacity" name="capacity" min="1">
                                <div class="form-text">Jumlah maksimal anggota</div>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Deskripsi</label>
                        <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                        <div class="form-text">Deskripsi singkat tentang kolat (opsional)</div>
                    </div>

                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{ route('admin.kolats.index') }}" class="btn btn-secondary">
                            <i class="fas fa-times me-2"></i>
                            Batal
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i>
                            Simpan Kolat
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
                        <li>Nama kolat harus unik dan mudah diingat</li>
                        <li>Kode kolat digunakan untuk identifikasi sistem</li>
                        <li>Alamat harus lengkap untuk memudahkan navigasi</li>
                        <li>Pelatih dapat diubah setelah kolat dibuat</li>
                        <li>Kapasitas dapat disesuaikan dengan fasilitas</li>
                    </ul>
                </div>

                <div class="alert alert-warning">
                    <h6><i class="fas fa-exclamation-triangle me-2"></i>Perhatian:</h6>
                    <ul class="mb-0 small">
                        <li>Field bertanda (*) wajib diisi</li>
                        <li>Kode kolat tidak dapat diubah setelah disimpan</li>
                        <li>Kolat baru akan aktif secara otomatis</li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="card shadow mt-4">
            <div class="card-header">
                <h6 class="m-0 font-weight-bold">
                    <i class="fas fa-chart-bar me-2"></i>
                    Statistik Kolat
                </h6>
            </div>
            <div class="card-body">
                <div class="text-center">
                    <div class="row">
                        <div class="col-6">
                            <h4 class="text-primary">0</h4>
                            <small class="text-muted">Total Kolat</small>
                        </div>
                        <div class="col-6">
                            <h4 class="text-success">0</h4>
                            <small class="text-muted">Kolat Aktif</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Auto-generate code from name
    const nameInput = document.getElementById('name');
    const codeInput = document.getElementById('code');
    
    nameInput.addEventListener('input', function() {
        if (!codeInput.value) {
            const name = this.value.toUpperCase()
                .replace(/[^A-Z\s]/g, '')
                .replace(/\s+/g, '-')
                .substring(0, 10);
            if (name) {
                codeInput.value = name + '-001';
            }
        }
    });
});
</script>
@endpush
@endsection
