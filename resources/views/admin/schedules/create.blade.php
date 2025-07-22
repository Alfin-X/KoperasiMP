@extends('layouts.app')

@section('title', 'Tambah Jadwal')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0">Tambah Jadwal Latihan</h1>
    <a href="{{ route('admin.schedules.index') }}" class="btn btn-secondary">
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
                    Form Tambah Jadwal
                </h6>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.schedules.store') }}" method="POST">
                    @csrf
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="kolat_id" class="form-label">Kolat <span class="text-danger">*</span></label>
                                <select class="form-select" id="kolat_id" name="kolat_id" required>
                                    <option value="">Pilih Kolat</option>
                                    <option value="1">Kolat Contoh</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="pelatih_id" class="form-label">Pelatih <span class="text-danger">*</span></label>
                                <select class="form-select" id="pelatih_id" name="pelatih_id" required>
                                    <option value="">Pilih Pelatih</option>
                                    <option value="1">Pelatih Contoh</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="date" class="form-label">Tanggal <span class="text-danger">*</span></label>
                                <input type="date" class="form-control" id="date" name="date" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="time" class="form-label">Waktu <span class="text-danger">*</span></label>
                                <input type="time" class="form-control" id="time" name="time" required>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="duration" class="form-label">Durasi (menit)</label>
                                <input type="number" class="form-control" id="duration" name="duration" value="120" min="30" max="300">
                                <div class="form-text">Durasi latihan dalam menit</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="type" class="form-label">Jenis Latihan <span class="text-danger">*</span></label>
                                <select class="form-select" id="type" name="type" required>
                                    <option value="">Pilih Jenis</option>
                                    <option value="rutin">Latihan Rutin</option>
                                    <option value="khusus">Latihan Khusus</option>
                                    <option value="ujian">Ujian Kenaikan Tingkat</option>
                                    <option value="event">Event/Pertandingan</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="topic" class="form-label">Topik/Materi <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="topic" name="topic" required>
                        <div class="form-text">Contoh: Teknik Dasar, Jurus 1-5, Sparring</div>
                    </div>

                    <div class="mb-3">
                        <label for="location" class="form-label">Lokasi</label>
                        <input type="text" class="form-control" id="location" name="location">
                        <div class="form-text">Lokasi spesifik jika berbeda dari alamat kolat</div>
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Deskripsi</label>
                        <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                        <div class="form-text">Deskripsi tambahan tentang jadwal latihan</div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="max_participants" class="form-label">Maksimal Peserta</label>
                                <input type="number" class="form-control" id="max_participants" name="max_participants" min="1">
                                <div class="form-text">Kosongkan jika tidak ada batasan</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                                <select class="form-select" id="status" name="status" required>
                                    <option value="scheduled">Terjadwal</option>
                                    <option value="cancelled">Dibatalkan</option>
                                    <option value="completed">Selesai</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{ route('admin.schedules.index') }}" class="btn btn-secondary">
                            <i class="fas fa-times me-2"></i>
                            Batal
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i>
                            Simpan Jadwal
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
                        <li>Pilih kolat dan pelatih yang sesuai</li>
                        <li>Pastikan waktu tidak bentrok dengan jadwal lain</li>
                        <li>Topik harus jelas dan spesifik</li>
                        <li>Durasi standar latihan adalah 2 jam</li>
                    </ul>
                </div>

                <div class="alert alert-warning">
                    <h6><i class="fas fa-exclamation-triangle me-2"></i>Perhatian:</h6>
                    <ul class="mb-0 small">
                        <li>Field bertanda (*) wajib diisi</li>
                        <li>Jadwal yang sudah dibuat dapat diubah</li>
                        <li>Notifikasi akan dikirim ke anggota</li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="card shadow mt-4">
            <div class="card-header">
                <h6 class="m-0 font-weight-bold">
                    <i class="fas fa-calendar me-2"></i>
                    Jadwal Minggu Ini
                </h6>
            </div>
            <div class="card-body">
                <div class="text-center">
                    <h4 class="text-primary">0</h4>
                    <small class="text-muted">Jadwal Terjadwal</small>
                    <hr>
                    <p class="text-muted small">Belum ada jadwal untuk minggu ini.</p>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Set default date to today
    const dateInput = document.getElementById('date');
    const today = new Date().toISOString().split('T')[0];
    dateInput.value = today;
    
    // Set default time
    const timeInput = document.getElementById('time');
    timeInput.value = '16:00'; // 4 PM default
});
</script>
@endpush
@endsection
