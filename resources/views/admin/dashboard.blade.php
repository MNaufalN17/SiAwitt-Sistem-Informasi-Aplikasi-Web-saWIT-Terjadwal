@extends('layouts.admin')

@section('title', 'Dashboard Pemilik Kebun')

@section('content')
<div class="row mb-4">
    <div class="col-md-12">
        <h3 class="fw-bold">Dashboard Pemilik Kebun</h3>
        <p class="text-muted">Selamat datang di Sistem Informasi Agenda Waktu sawIT Terpadu.</p>
    </div>
</div>

<div class="row mb-4">
    <div class="col-md-3">
        <div class="card bg-primary text-white shadow-sm border-0 mb-3">
            <div class="card-body">
                <h6 class="card-title">Total Blok Kebun</h6>
                <h2 class="fw-bold mb-0">{{ $totalBlok }}</h2>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-success text-white shadow-sm border-0 mb-3">
            <div class="card-body">
                <h6 class="card-title">Total Pekerja</h6>
                <h2 class="fw-bold mb-0">{{ $totalPekerja }}</h2>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-warning text-dark shadow-sm border-0 mb-3">
            <div class="card-body">
                <h6 class="card-title">Menunggu Verifikasi</h6>
                <h2 class="fw-bold mb-0">{{ $menunggu }}</h2>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-danger text-white shadow-sm border-0 mb-3">
            <div class="card-body">
                <h6 class="card-title">Belum Dikerjakan</h6>
                <h2 class="fw-bold mb-0">{{ $belum }}</h2>
            </div>
        </div>
    </div>
</div>

<div class="card shadow-sm border-0">
    <div class="card-header bg-white fw-bold py-3">
        <i class="bi bi-calendar3"></i> Jadwal Kegiatan Terdekat (5 Terbaru)
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>No</th>
                        <th>Tanggal</th>
                        <th>Blok Kebun</th>
                        <th>Jenis Kegiatan</th>
                        <th>Pekerja</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($jadwalTerdekat as $key => $j)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ \Carbon\Carbon::parse($j->tanggal_kegiatan)->format('d/m/Y') }}</td>
                            <td class="fw-bold">{{ $j->blokKebun->nama_blok ?? '-' }}</td>
                            <td>{{ $j->jenis_kegiatan }}</td>
                            <td>{{ $j->pekerja->nama_pekerja ?? '-' }}</td>
                            <td>
                                <span class="badge bg-{{ $j->status == 'Belum Dikerjakan' ? 'danger' : ($j->status == 'Menunggu Verifikasi' ? 'warning text-dark' : 'success') }}">
                                    {{ $j->status }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted py-4">Belum ada jadwal kegiatan yang dibuat oleh Mandor.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection