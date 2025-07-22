@extends('layouts.app')

@section('title', 'Edit Kolat')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0">Edit Kolat</h1>
    <div class="btn-group">
        <a href="{{ route('admin.kolats.show', 1) }}" class="btn btn-info">
            <i class="fas fa-eye me-2"></i>
            Lihat Detail
        </a>
        <a href="{{ route('admin.kolats.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-2"></i>
            Kembali
        </a>
    </div>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card shadow">
            <div class="card-header">
                <h6 class="m-0 font-weight-bold">
                    <i class="fas fa-edit me-2"></i>
                    Form Edit Kolat
                </h6>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.kolats.update', 1) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="name" class="form-label">Nama Kolat <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="name" name="name" value="Kolat Contoh" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="code" class="form-label">Kode Kolat <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="code" name="code" value="KOLAT-001" readonly>
                                <div class="form-text">Kode kolat tidak dapat diubah</div>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="address" class="form-label">Alamat Lengkap <span class="text-danger">*</span></label>
                        <textarea class="form-control" id="address" name="address" rows="3" required>Jl. Contoh No. 123, Jember</textarea>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="phone" class="form-label">Nomor Telepon</label>
                                <input type="text" class="form-control" id="phone" name="phone" value="0331-123456">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email" value="kolat@example.com">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="pelatih_id" class="form-label">Pelatih Utama</label>
                                <select class="form-select" id="pelatih_id" name="pelatih_id">
                                    <option value="">Pilih Pelatih</option>
                                    <option value="1" selected>Pelatih Contoh</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="capacity" class="form-label">Kapasitas Maksimal</label>
                                <input type="number" class="form-control" id="capacity" name="capacity" value="50" min="1">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="established_date" class="form-label">Tanggal Berdiri</label>
                                <input type="date" class="form-control" id="established_date" name="established_date" value="2024-01-01">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                                <select class="form-select" id="status" name="status" required>
                                    <option value="active" selected>Aktif</option>
                                    <option value="inactive">Tidak Aktif</option>
                                    <option value="pending">Pending</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Deskripsi</label>
                        <textarea class="form-control" id="description" name="description" rows="3">Deskripsi kolat contoh</textarea>
                    </div>

                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{ route('admin.kolats.index') }}" class="btn btn-secondary">
                            <i class="fas fa-times me-2"></i>
                            Batal
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i>
                            Update Kolat
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
                    Informasi Kolat
                </h6>
            </div>
            <div class="card-body">
                <table class="table table-sm">
                    <tr>
                        <td><strong>Dibuat:</strong></td>
                        <td>01 Jan 2024</td>
                    </tr>
                    <tr>
                        <td><strong>Diupdate:</strong></td>
                        <td>{{ now()->format('d M Y') }}</td>
                    </tr>
                    <tr>
                        <td><strong>Total Anggota:</strong></td>
                        <td><span class="badge bg-primary">0</span></td>
                    </tr>
                    <tr>
                        <td><strong>Anggota Aktif:</strong></td>
                        <td><span class="badge bg-success">0</span></td>
                    </tr>
                </table>
            </div>
        </div>

        <div class="card shadow mt-4">
            <div class="card-header">
                <h6 class="m-0 font-weight-bold">
                    <i class="fas fa-cog me-2"></i>
                    Aksi Lainnya
                </h6>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <a href="{{ route('admin.kolats.show', 1) }}" class="btn btn-info btn-sm">
                        <i class="fas fa-eye me-2"></i>
                        Lihat Detail
                    </a>
                    <button type="button" class="btn btn-warning btn-sm">
                        <i class="fas fa-users me-2"></i>
                        Kelola Anggota
                    </button>
                    <button type="button" class="btn btn-danger btn-sm" onclick="confirmDelete()">
                        <i class="fas fa-trash me-2"></i>
                        Hapus Kolat
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
function confirmDelete() {
    if (confirm('Yakin ingin menghapus kolat ini? Tindakan ini tidak dapat dibatalkan.')) {
        // Form delete logic here
        alert('Fitur hapus akan diimplementasi');
    }
}
</script>
@endpush
@endsection
