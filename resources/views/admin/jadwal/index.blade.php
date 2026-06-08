@extends('layouts.admin')

@section('title', auth()->user()->role == 'admin' ? 'Monitoring Jadwal' : 'Manajemen Jadwal Kerja')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="fw-bold">
        @if(auth()->user()->role == 'admin')
            <i class="bi bi-display"></i> Monitoring Progres Lapangan
        @else
            <i class="bi bi-calendar-plus"></i> Manajemen Jadwal Kerja
        @endif
    </h3>
    
    @if(auth()->user()->role == 'mandor')
        <button type="button" class="btn btn-success shadow-sm fw-bold" data-bs-toggle="modal" data-bs-target="#tambahJadwalModal">
            + Buat Jadwal Baru
        </button>
    @endif
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<div class="card shadow-sm border-0">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>No</th>
                        <th>Tanggal Pelaksanaan</th>
                        <th>Blok Kebun</th>
                        <th>Jenis Kegiatan</th>
                        <th>Pekerja Lapangan</th>
                        <th>Status Sistem</th>
                        <th>Progres Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($jadwals as $key => $j)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td>{{ \Carbon\Carbon::parse($j->tanggal_kegiatan)->format('d F Y') }}</td>
                        <td class="fw-bold text-success">{{ $j->blokKebun->nama_blok ?? 'Blok Dihapus' }}</td>
                        <td><span class="badge bg-light text-dark border">{{ $j->jenis_kegiatan }}</span></td>
                        <td>{{ $j->pekerja->nama_pekerja ?? 'Pekerja Dihapus' }}</td>
                        <td>
                            <span class="badge bg-{{ $j->status == 'Belum Dikerjakan' ? 'danger' : ($j->status == 'Menunggu Verifikasi' ? 'warning text-dark' : 'success') }}">
                                {{ $j->status }}
                            </span>
                        </td>
                        <td>
                            @if($j->status == 'Menunggu Verifikasi')
                                <small class="text-warning fw-bold"><i class="bi bi-clock-history"></i> Menunggu Verifikasi Anda/Mandor</small>
                            @elseif($j->status == 'Belum Dikerjakan')
                                <small class="text-muted"><i class="bi bi-dash-circle"></i> Sedang proses di lapangan</small>
                            @else
                                <small class="text-success fw-bold"><i class="bi bi-check-circle-fill"></i> Selesai & Telah Disahkan</small>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted py-4">Belum ada agenda jadwal kegiatan yang dirilis ke lapangan.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@if(auth()->user()->role == 'mandor')
<div class="modal fade" id="tambahJadwalModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title fw-bold">Buat Jadwal Kegiatan Baru</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('jadwal-kegiatan.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="fw-bold mb-1">Pilih Blok Kebun</label>
                        <select name="blok_kebun_id" class="form-select" required>
                            <option value="">-- Pilih Area --</option>
                            @foreach($bloks as $b)
                                <option value="{{ $b->id }}">{{ $b->nama_blok }} ({{ $b->lokasi }})</option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="mb-3">
                        <label class="fw-bold mb-1">Tugaskan Kepada Pekerja</label>
                        <select name="pekerja_id" class="form-select" required>
                            <option value="">-- Pilih Pekerja --</option>
                            @foreach($pekerjas as $p)
                                <option value="{{ $p->id }}">{{ $p->nama_pekerja }}</option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="mb-3">
                        <label class="fw-bold mb-1">Jenis Kegiatan Kerja</label>
                        <div class="mt-1">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="jenis_kegiatan" value="Panen" id="panen" checked>
                                <label class="form-check-label" for="panen">Panen Buah Sawit</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="jenis_kegiatan" value="Pemupukan" id="pupuk">
                                <label class="form-check-label" for="pupuk">Pemupukan Lahan</label>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label class="fw-bold mb-1">Tanggal Pelaksanaan</label>
                        <input type="date" name="tanggal_kegiatan" class="form-control" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light border" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success fw-bold">Rilis Jadwal Kerja</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endif
@endsection