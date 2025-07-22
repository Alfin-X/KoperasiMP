@extends('layouts.app')

@section('title', 'Tambah Simpanan')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0">Tambah Simpanan</h1>
    <a href="{{ route('anggota.simpanan.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left me-2"></i>
        Kembali
    </a>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card shadow">
            <div class="card-header">
                <h6 class="m-0 font-weight-bold">
                    <i class="fas fa-piggy-bank me-2"></i>
                    Form Setoran Simpanan
                </h6>
            </div>
            <div class="card-body">
                <form action="{{ route('anggota.simpanan.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="type" class="form-label">Jenis Simpanan <span class="text-danger">*</span></label>
                                <select class="form-select" id="type" name="type" required>
                                    <option value="">Pilih Jenis Simpanan</option>
                                    <option value="simpanan_pokok" {{ old('type') == 'simpanan_pokok' ? 'selected' : '' }}>
                                        Simpanan Pokok (Rp 50.000)
                                    </option>
                                    <option value="simpanan_wajib" {{ old('type') == 'simpanan_wajib' ? 'selected' : '' }}>
                                        Simpanan Wajib (Rp 3.000/hari)
                                    </option>
                                    <option value="simpanan_sukarela" {{ old('type') == 'simpanan_sukarela' ? 'selected' : '' }}>
                                        Simpanan Sukarela
                                    </option>
                                </select>
                                @error('type')
                                    <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="amount" class="form-label">Nominal Setoran <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text">Rp</span>
                                    <input type="number" class="form-control" id="amount" name="amount" 
                                           value="{{ old('amount') }}" min="1000" step="1000" required>
                                </div>
                                @error('amount')
                                    <div class="text-danger small">{{ $message }}</div>
                                @enderror
                                <div class="form-text" id="amountHelp">Minimal setoran Rp 1.000</div>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Keterangan</label>
                        <textarea class="form-control" id="description" name="description" rows="3" 
                                  placeholder="Catatan tambahan (opsional)">{{ old('description') }}</textarea>
                        @error('description')
                            <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="proof_image" class="form-label">Bukti Transfer</label>
                        <input type="file" class="form-control" id="proof_image" name="proof_image" 
                               accept="image/jpeg,image/png,image/jpg">
                        @error('proof_image')
                            <div class="text-danger small">{{ $message }}</div>
                        @enderror
                        <div class="form-text">Upload bukti transfer (JPG, PNG, maksimal 2MB)</div>
                        
                        <!-- Preview Image -->
                        <div id="imagePreview" class="mt-3" style="display: none;">
                            <img id="previewImg" src="" alt="Preview" class="img-thumbnail" style="max-width: 200px;">
                        </div>
                    </div>

                    <hr>
                    
                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{ route('anggota.simpanan.index') }}" class="btn btn-secondary">
                            <i class="fas fa-times me-2"></i>
                            Batal
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i>
                            Ajukan Setoran
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <!-- Info Simpanan -->
        <div class="card shadow">
            <div class="card-header">
                <h6 class="m-0 font-weight-bold">
                    <i class="fas fa-info-circle me-2"></i>
                    Informasi Simpanan
                </h6>
            </div>
            <div class="card-body">
                <div class="alert alert-info">
                    <h6><i class="fas fa-lightbulb me-2"></i>Jenis Simpanan:</h6>
                    <ul class="mb-0 small">
                        <li><strong>Simpanan Pokok:</strong> Rp 50.000 (sekali bayar, nominal tetap)</li>
                        <li><strong>Simpanan Wajib:</strong> Minimal Rp 3.000 per hari latihan (bisa lebih)</li>
                        <li><strong>Simpanan Sukarela:</strong> Nominal bebas (minimal Rp 1.000)</li>
                    </ul>
                </div>

                <div class="alert alert-warning">
                    <h6><i class="fas fa-exclamation-triangle me-2"></i>Catatan:</h6>
                    <ul class="mb-0 small">
                        <li>Setoran akan diverifikasi oleh pelatih</li>
                        <li>Upload bukti transfer untuk mempercepat verifikasi</li>
                        <li>Simpanan dapat ditarik sesuai ketentuan</li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Rekening Tujuan -->
        <div class="card shadow mt-4">
            <div class="card-header">
                <h6 class="m-0 font-weight-bold">
                    <i class="fas fa-university me-2"></i>
                    Rekening Tujuan Transfer
                </h6>
            </div>
            <div class="card-body">
                <div class="text-center">
                    <img src="https://via.placeholder.com/80x40/007bff/ffffff?text=BCA" 
                         alt="Bank BCA" class="mb-3">
                    <h6 class="mb-1">Bank BCA</h6>
                    <h5 class="text-primary mb-2">1234567890</h5>
                    <p class="text-muted mb-3">a.n. PPS Betako Merpati Putih Jember</p>
                    
                    <button type="button" class="btn btn-outline-primary btn-sm" onclick="copyToClipboard('1234567890')">
                        <i class="fas fa-copy me-2"></i>
                        Salin Nomor Rekening
                    </button>
                </div>
                
                <hr>
                
                <div class="text-center">
                    <img src="https://via.placeholder.com/80x40/ff6b35/ffffff?text=BRI" 
                         alt="Bank BRI" class="mb-3">
                    <h6 class="mb-1">Bank BRI</h6>
                    <h5 class="text-primary mb-2">0987654321</h5>
                    <p class="text-muted mb-3">a.n. PPS Betako Merpati Putih Jember</p>
                    
                    <button type="button" class="btn btn-outline-primary btn-sm" onclick="copyToClipboard('0987654321')">
                        <i class="fas fa-copy me-2"></i>
                        Salin Nomor Rekening
                    </button>
                </div>
            </div>
        </div>

        <!-- Panduan -->
        <div class="card shadow mt-4">
            <div class="card-header">
                <h6 class="m-0 font-weight-bold">
                    <i class="fas fa-question-circle me-2"></i>
                    Panduan Setoran
                </h6>
            </div>
            <div class="card-body">
                <ol class="small">
                    <li>Pilih jenis simpanan yang akan disetor</li>
                    <li>Masukkan nominal sesuai ketentuan</li>
                    <li>Transfer ke rekening yang tersedia</li>
                    <li>Upload bukti transfer</li>
                    <li>Klik "Ajukan Setoran"</li>
                    <li>Tunggu verifikasi dari pelatih</li>
                </ol>
                
                <div class="alert alert-success mt-3">
                    <small>
                        <i class="fas fa-check-circle me-2"></i>
                        Setoran yang sudah diverifikasi akan otomatis masuk ke saldo simpanan Anda.
                    </small>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Preview gambar bukti transfer
    const proofInput = document.getElementById('proof_image');
    const imagePreview = document.getElementById('imagePreview');
    const previewImg = document.getElementById('previewImg');
    
    proofInput.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                previewImg.src = e.target.result;
                imagePreview.style.display = 'block';
            };
            reader.readAsDataURL(file);
        } else {
            imagePreview.style.display = 'none';
        }
    });
    
    // Auto-fill nominal berdasarkan jenis simpanan
    const typeSelect = document.getElementById('type');
    const amountInput = document.getElementById('amount');
    const amountHelp = document.getElementById('amountHelp');

    typeSelect.addEventListener('change', function() {
        switch(this.value) {
            case 'simpanan_pokok':
                amountInput.value = 50000;
                amountInput.readOnly = true;
                amountInput.setAttribute('placeholder', 'Nominal tetap Rp 50.000');
                amountHelp.textContent = 'Simpanan pokok harus tepat Rp 50.000 (sekali bayar)';
                amountHelp.className = 'form-text text-info';
                break;
            case 'simpanan_wajib':
                amountInput.value = 3000;
                amountInput.readOnly = false;
                amountInput.setAttribute('placeholder', 'Minimal Rp 3.000 per hari latihan');
                amountInput.setAttribute('min', '3000');
                amountHelp.textContent = 'Minimal Rp 3.000 per hari latihan (bisa lebih dari 3.000)';
                amountHelp.className = 'form-text text-warning';
                break;
            case 'simpanan_sukarela':
                amountInput.value = '';
                amountInput.readOnly = false;
                amountInput.setAttribute('placeholder', 'Masukkan nominal sesuai keinginan');
                amountInput.setAttribute('min', '1000');
                amountHelp.textContent = 'Minimal setoran Rp 1.000 (nominal bebas)';
                amountHelp.className = 'form-text text-success';
                break;
            default:
                amountInput.value = '';
                amountInput.readOnly = false;
                amountInput.setAttribute('placeholder', 'Masukkan nominal');
                amountInput.setAttribute('min', '1000');
                amountHelp.textContent = 'Minimal setoran Rp 1.000';
                amountHelp.className = 'form-text';
        }
    });
    
    // Format number input
    amountInput.addEventListener('input', function() {
        if (!this.readOnly) {
            // Remove non-numeric characters
            this.value = this.value.replace(/[^0-9]/g, '');
        }
    });
});

// Copy to clipboard function
function copyToClipboard(text) {
    navigator.clipboard.writeText(text).then(function() {
        // Show success message
        const toast = document.createElement('div');
        toast.className = 'toast align-items-center text-white bg-success border-0 position-fixed';
        toast.style.cssText = 'top: 20px; right: 20px; z-index: 9999;';
        toast.innerHTML = `
            <div class="d-flex">
                <div class="toast-body">
                    <i class="fas fa-check me-2"></i>
                    Nomor rekening berhasil disalin!
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" onclick="this.parentElement.parentElement.remove()"></button>
            </div>
        `;
        document.body.appendChild(toast);
        
        // Auto remove after 3 seconds
        setTimeout(() => {
            if (toast.parentElement) {
                toast.remove();
            }
        }, 3000);
    }).catch(function(err) {
        console.error('Could not copy text: ', err);
        alert('Gagal menyalin nomor rekening');
    });
}
</script>
@endpush
@endsection
