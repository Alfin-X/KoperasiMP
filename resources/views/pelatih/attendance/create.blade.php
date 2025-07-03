@extends('layouts.app')

@section('title', 'Catat Absensi')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <h4 class="page-title">Catat Absensi</h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('pelatih.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('pelatih.attendance.index') }}">Absensi</a></li>
                        <li class="breadcrumb-item active">Catat Absensi</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <!-- Schedule Selection -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="header-title">Pilih Jadwal Latihan</h4>
                </div>
                <div class="card-body">
                    @if(isset($schedules) && $schedules->count() > 0)
                        <div class="row">
                            @foreach($schedules as $schedule)
                            <div class="col-md-6 col-lg-4 mb-3">
                                <div class="card border {{ $schedule->date == now()->format('Y-m-d') ? 'border-primary' : '' }}">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-start mb-2">
                                            <h5 class="card-title mb-1">{{ $schedule->activity_type }}</h5>
                                            @if($schedule->date == now()->format('Y-m-d'))
                                                <span class="badge bg-primary">Hari Ini</span>
                                            @endif
                                        </div>
                                        <p class="card-text">
                                            <i class="mdi mdi-calendar me-1"></i>{{ \Carbon\Carbon::parse($schedule->date)->format('d M Y') }}<br>
                                            <i class="mdi mdi-clock me-1"></i>{{ $schedule->start_time }} - {{ $schedule->end_time }}<br>
                                            @if($schedule->description)
                                                <i class="mdi mdi-information me-1"></i>{{ Str::limit($schedule->description, 50) }}
                                            @endif
                                        </p>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <small class="text-muted">
                                                {{ $schedule->attendances->count() }} peserta terdaftar
                                            </small>
                                            <a href="{{ route('pelatih.attendance.schedule.attendance', $schedule) }}" 
                                               class="btn btn-primary btn-sm">
                                                Catat Absensi
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        
                        <!-- Pagination -->
                        @if(method_exists($schedules, 'links'))
                            <div class="d-flex justify-content-center">
                                {{ $schedules->links() }}
                            </div>
                        @endif
                    @else
                        <div class="text-center py-4">
                            <i class="mdi mdi-calendar-remove h1 text-muted"></i>
                            <h4>Tidak ada jadwal tersedia</h4>
                            <p class="text-muted">Belum ada jadwal latihan yang dapat digunakan untuk mencatat absensi.</p>
                            <a href="{{ route('pelatih.dashboard') }}" class="btn btn-primary">
                                Kembali ke Dashboard
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Attendance (if schedule is selected) -->
    @if(isset($selectedSchedule))
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="header-title">
                        Absensi: {{ $selectedSchedule->activity_type }}
                        <small class="text-muted">{{ \Carbon\Carbon::parse($selectedSchedule->date)->format('d M Y') }}</small>
                    </h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('pelatih.attendance.store') }}" method="POST" id="attendanceForm">
                        @csrf
                        <input type="hidden" name="schedule_id" value="{{ $selectedSchedule->id }}">
                        
                        <!-- Bulk Actions -->
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <div class="btn-group" role="group">
                                    <button type="button" class="btn btn-success btn-sm" onclick="markAll('present')">
                                        <i class="mdi mdi-check-all me-1"></i>Semua Hadir
                                    </button>
                                    <button type="button" class="btn btn-warning btn-sm" onclick="markAll('absent')">
                                        <i class="mdi mdi-close-circle me-1"></i>Semua Tidak Hadir
                                    </button>
                                </div>
                            </div>
                            <div class="col-md-6 text-end">
                                <button type="submit" class="btn btn-primary">
                                    <i class="mdi mdi-content-save me-1"></i>Simpan Absensi
                                </button>
                            </div>
                        </div>

                        <!-- Members List -->
                        <div class="table-responsive">
                            <table class="table table-centered table-nowrap">
                                <thead class="table-light">
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Anggota</th>
                                        <th>Nomor Anggota</th>
                                        <th>Status Kehadiran</th>
                                        <th>Catatan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(isset($members) && $members->count() > 0)
                                        @foreach($members as $index => $member)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>
                                                <h5 class="mb-1">{{ $member->user->name }}</h5>
                                                <p class="mb-0 text-muted">{{ $member->user->email }}</p>
                                            </td>
                                            <td>{{ $member->member_number }}</td>
                                            <td>
                                                <input type="hidden" name="attendances[{{ $member->id }}][member_id]" value="{{ $member->id }}">
                                                <select name="attendances[{{ $member->id }}][status]" 
                                                        class="form-select form-select-sm attendance-status" 
                                                        data-member-id="{{ $member->id }}">
                                                    <option value="present">Hadir</option>
                                                    <option value="late">Terlambat</option>
                                                    <option value="absent" selected>Tidak Hadir</option>
                                                    <option value="excused">Izin</option>
                                                </select>
                                            </td>
                                            <td>
                                                <input type="text" 
                                                       name="attendances[{{ $member->id }}][notes]" 
                                                       class="form-control form-control-sm" 
                                                       placeholder="Catatan (opsional)">
                                            </td>
                                        </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="5" class="text-center py-4">
                                                <i class="mdi mdi-account-remove h1 text-muted"></i>
                                                <h4>Tidak ada anggota</h4>
                                                <p class="text-muted">Belum ada anggota yang terdaftar di lokasi ini.</p>
                                            </td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- Today's Summary -->
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h4 class="header-title">Ringkasan Hari Ini</h4>
                </div>
                <div class="card-body">
                    @if(isset($todaySummary))
                        <div class="row text-center">
                            <div class="col-6">
                                <h3 class="text-success">{{ $todaySummary['present'] ?? 0 }}</h3>
                                <p class="text-muted mb-0">Hadir</p>
                            </div>
                            <div class="col-6">
                                <h3 class="text-danger">{{ $todaySummary['absent'] ?? 0 }}</h3>
                                <p class="text-muted mb-0">Tidak Hadir</p>
                            </div>
                        </div>
                        <hr>
                        <div class="row text-center">
                            <div class="col-6">
                                <h3 class="text-warning">{{ $todaySummary['late'] ?? 0 }}</h3>
                                <p class="text-muted mb-0">Terlambat</p>
                            </div>
                            <div class="col-6">
                                <h3 class="text-info">{{ $todaySummary['excused'] ?? 0 }}</h3>
                                <p class="text-muted mb-0">Izin</p>
                            </div>
                        </div>
                    @else
                        <div class="text-center py-3">
                            <i class="mdi mdi-chart-pie h1 text-muted"></i>
                            <p class="text-muted">Belum ada data absensi hari ini</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h4 class="header-title">Aksi Cepat</h4>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('pelatih.attendance.attendances') }}" class="btn btn-outline-primary">
                            <i class="mdi mdi-format-list-bulleted me-1"></i>Lihat Semua Absensi
                        </a>
                        <a href="{{ route('pelatih.attendance.reports') }}" class="btn btn-outline-info">
                            <i class="mdi mdi-chart-line me-1"></i>Laporan Absensi
                        </a>
                        <a href="{{ route('pelatih.attendance.schedules') }}" class="btn btn-outline-success">
                            <i class="mdi mdi-calendar me-1"></i>Lihat Jadwal
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
function markAll(status) {
    const selects = document.querySelectorAll('.attendance-status');
    selects.forEach(select => {
        select.value = status;
    });
}

// Form validation
document.getElementById('attendanceForm')?.addEventListener('submit', function(e) {
    const submitBtn = this.querySelector('button[type="submit"]');
    submitBtn.disabled = true;
    submitBtn.innerHTML = '<i class="mdi mdi-loading mdi-spin me-1"></i>Menyimpan...';
});

// Auto-save functionality (optional)
let autoSaveTimeout;
document.querySelectorAll('.attendance-status, input[name*="[notes]"]').forEach(input => {
    input.addEventListener('change', function() {
        clearTimeout(autoSaveTimeout);
        autoSaveTimeout = setTimeout(() => {
            // Auto-save logic can be implemented here
            console.log('Auto-saving attendance data...');
        }, 2000);
    });
});
</script>
@endsection
