@extends('layouts.admin')

@section('title', 'Laporan Kegiatan Selesai')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4 d-print-none">
    <h3 class="fw-bold">Rekap Laporan Kegiatan Selesai</h3>
    <!-- Tombol Print bawaan browser -->
    <button onclick="window.print()" class="btn btn-secondary shadow-sm">
        🖨️ Cetak Laporan
    </button>
</div>

<div class="card shadow-sm border-0">
    <div class="card-body">
        
        <!-- Header khusus untuk cetak (Hanya tampil saat diprint) -->
        <div class="d-none d-print-block text-center mb-4">
            <h4 class="fw-bold m-0">LAPORAN KEGIATAN KEBUN KELAPA SAWIT</h4>
            <p class="text-muted m-0">Sistem Informasi Agenda Waktu sawIT Terpadu (SiAwitt)</p>
            <hr>
        </div>

        <div class="table-responsive">
            <table class="table table-bordered table-striped align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>No</th>
                        <th>Tgl Kegiatan</th>
                        <th>Nama Blok</th>
                        <th>Jenis Kegiatan</th>
                        <th>Nama Pekerja</th>
                        <th>Metode Verifikasi</th>
                        <th>Catatan Pekerjaan</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($laporans as $key => $lap)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td>{{ \Carbon\Carbon::parse($lap->tanggal_kegiatan)->format('d M Y') }}</td>
                        <td class="fw-bold">{{ $lap->blokKebun->nama_blok }}</td>
                        <td>{{ $lap->jenis_kegiatan }}</td>
                        <td>{{ $lap->pekerja->nama_pekerja }}</td>
                        <td>
                            <span class="badge bg-success">{{ $lap->metode_verifikasi }}</span>
                        </td>
                        <td>
                            @if($lap->metode_verifikasi == 'Upload Sistem')
                                {{ $lap->laporanPekerjaan->catatan_pekerja ?? 'Selesai (Ada Foto Bukti)' }}
                            @else
                                Admin: {{ $lap->catatan_admin ?? 'Laporan langsung di tempat' }}
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted py-4">Belum ada kegiatan yang diselesaikan.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <!-- Footer khusus untuk cetak -->
        <div class="d-none d-print-block mt-5 text-end">
            <p class="mb-5">Mengetahui,</p>
            <p class="fw-bold">Admin / Pemilik Kebun</p>
        </div>

    </div>
</div>

<style>
    /* Menyembunyikan elemen navigasi saat dicetak */
    @media print {
        nav, .navbar, .btn {
            display: none !important;
        }
        body {
            background-color: white !important;
        }
        .card {
            box-shadow: none !important;
            border: none !important;
        }
    }
</style>
@endsection