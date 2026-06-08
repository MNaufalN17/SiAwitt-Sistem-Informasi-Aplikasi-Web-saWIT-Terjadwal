@extends('layouts.admin')

@section('title', 'Dashboard Mandor')

@section('content')
<div class="mb-4">
    <h3 class="fw-bold text-success"><i class="bi bi-person-badge-fill"></i> Dashboard Mandor Lapangan</h3>
    <p class="text-muted">Tugas Anda: Memeriksa dan memverifikasi laporan hasil kerja dari pekerja lapangan.</p>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
        <i class="bi bi-check-circle-fill"></i> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<div class="card shadow-sm border-0 border-top border-warning border-4">
    <div class="card-header bg-white py-3">
        <h5 class="m-0 fw-bold"><i class="bi bi-hourglass-split text-warning"></i> Daftar Menunggu Verifikasi Anda</h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Tgl Kegiatan</th>
                        <th>Blok Kebun</th>
                        <th>Pekerja</th>
                        <th>Status</th>
                        <th class="text-center">Aksi Verifikasi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($jadwals as $j)
                    <tr>
                        <td>{{ \Carbon\Carbon::parse($j->tanggal_kegiatan)->format('d F Y') }}</td>
                        <td class="fw-bold">{{ $j->blokKebun->nama_blok ?? 'Blok Tidak Diketahui' }}</td>
                        <td>{{ $j->pekerja->nama_pekerja ?? 'Pekerja Tidak Diketahui' }}</td>
                        <td><span class="badge bg-warning text-dark px-3 py-2 shadow-sm">{{ $j->status }}</span></td>
                        <td class="text-center">
                            <button class="btn btn-sm btn-success fw-bold shadow-sm" data-bs-toggle="modal" data-bs-target="#modalVerifikasi{{ $j->id }}">
                                <i class="bi bi-search"></i> Periksa Bukti Laporan
                            </button>
                        </td>
                    </tr>

                    <div class="modal fade" id="modalVerifikasi{{ $j->id }}" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header bg-success text-white">
                                    <h5 class="modal-title fw-bold">Verifikasi Bukti Lapangan</h5>
                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body text-center">
                                    <div class="alert alert-light text-start border mb-3">
                                        <strong><i class="bi bi-chat-left-text"></i> Catatan Pekerja:</strong><br> 
                                        {{ $j->laporanPekerjaan->catatan_pekerja ?? 'Tidak ada catatan yang diberikan oleh pekerja.' }}
                                    </div>
                                    
                                    <p class="fw-bold mb-2 text-start">Foto Bukti:</p>
                                    @if($j->laporanPekerjaan && $j->laporanPekerjaan->foto_bukti)
                                        <img src="{{ asset('storage/' . $j->laporanPekerjaan->foto_bukti) }}" class="img-fluid rounded shadow-sm mb-4" style="max-height: 300px; object-fit: cover; width: 100%;">
                                    @else
                                        <div class="alert alert-danger">Pekerja belum mengunggah foto bukti.</div>
                                    @endif
                                    
                                    <form action="{{ route('jadwal-kegiatan.update', $j->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="status" value="Selesai">
                                        <input type="hidden" name="metode_verifikasi" value="Diverifikasi Mandor">
                                        
                                        <button type="submit" class="btn btn-success w-100 py-2 fw-bold shadow-sm fs-5">
                                            <i class="bi bi-check-circle-fill"></i> SAH! Tandai Selesai
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-5">
                            <i class="bi bi-emoji-smile text-success" style="font-size: 3rem;"></i><br>
                            <h5 class="fw-bold mt-3 text-muted">Hore! Belum ada tugas yang perlu diverifikasi.</h5>
                            <p class="text-muted">Anda bisa bersantai sambil ngopi dulu ☕</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection