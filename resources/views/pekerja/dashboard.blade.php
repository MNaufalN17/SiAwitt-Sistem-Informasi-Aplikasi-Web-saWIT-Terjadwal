@extends('layouts.admin')

@section('title', 'Dashboard Pekerja')

@section('content')
<div class="mb-4">
    <h3 class="fw-bold text-primary"><i class="bi bi-person-workspace"></i> Dashboard Pekerja Lapangan</h3>
    <p class="text-muted">Selamat bekerja! Berikut adalah daftar tugas lapangan yang harus Anda selesaikan.</p>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
        <i class="bi bi-check-circle-fill"></i> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<div class="row">
    @forelse($tugas as $t)
        <div class="col-md-6 mb-4">
            <div class="card shadow-sm border-0 border-start border-primary border-5">
                <div class="card-body">
                    <h5 class="fw-bold text-primary mb-3">
                        <i class="bi bi-clipboard-data"></i> Tugas: {{ $t->jenis_kegiatan }}
                    </h5>
                    <p class="mb-1"><strong><i class="bi bi-geo-alt"></i> Lokasi Blok:</strong> {{ $t->blokKebun->nama_blok ?? 'Blok Tidak Diketahui' }}</p>
                    <p class="mb-4"><strong><i class="bi bi-calendar-event"></i> Tanggal:</strong> {{ \Carbon\Carbon::parse($t->tanggal_kegiatan)->format('d F Y') }}</p>
                    
                    <button class="btn btn-primary w-100 fw-bold shadow-sm" data-bs-toggle="modal" data-bs-target="#modalLapor{{ $t->id }}">
                        <i class="bi bi-send"></i> Kerjakan & Lapor Sekarang
                    </button>
                </div>
            </div>
        </div>

        <div class="modal fade" id="modalLapor{{ $t->id }}" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title fw-bold">Kirim Bukti Pekerjaan</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                    <form action="{{ route('laporan-pekerjaan.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="modal-body">
                            <input type="hidden" name="jadwal_kegiatan_id" value="{{ $t->id }}">
                            <input type="hidden" name="pekerja_id" value="{{ $t->pekerja_id }}">
                            <input type="hidden" name="tanggal_lapor" value="{{ date('Y-m-d') }}">
                            
                            <div class="alert alert-info py-2 shadow-sm border-0">
                                <small><i class="bi bi-info-circle"></i> Anda dapat mengirim laporan dengan atau tanpa foto.</small>
                            </div>
                            
                            <div class="mb-3">
                                <label class="fw-bold mb-1">Unggah Foto Bukti (Opsional)</label>
                                <input type="file" name="foto_bukti" class="form-control form-control-lg bg-light" accept="image/*" capture="environment">
                            </div>
                            
                            <div class="mb-3">
                                <label class="fw-bold mb-1">Catatan Laporan (*)</label>
                                <textarea name="catatan_pekerja" class="form-control bg-light" rows="3" placeholder="Tuliskan keterangan hasil kerja di sini..." required></textarea>
                            </div>
                        </div>
                        <div class="modal-footer d-flex justify-content-between">
                            <button type="button" class="btn btn-light border" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary fw-bold px-4 shadow-sm"><i class="bi bi-send"></i> Kirim Laporan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @empty
        <div class="col-12">
            <div class="alert alert-success text-center py-5 shadow-sm border-0">
                <i class="bi bi-cup-hot text-success" style="font-size: 3rem;"></i><br>
                <h5 class="fw-bold mt-3 text-dark">Tidak Ada Tugas Baru!</h5>
                <p class="mb-0 text-muted">Belum ada jadwal pekerjaan dari Mandor yang harus Anda kerjakan saat ini. Silakan beristirahat.</p>
            </div>
        </div>
    @endforelse
</div>
@endsection