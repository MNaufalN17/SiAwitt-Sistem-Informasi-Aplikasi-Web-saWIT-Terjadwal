@extends('layouts.admin')

@section('title', 'Data Blok Kebun')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="fw-bold">Manajemen Data Blok Kebun</h3>
    <!-- Tombol untuk memunculkan modal tambah data -->
    <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#tambahBlokModal">
        + Tambah Blok Baru
    </button>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<div class="card shadow-sm border-0">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>No</th>
                        <th>Nama Blok</th>
                        <th>Luas Lahan (Ha)</th>
                        <th>Lokasi</th>
                        <th>Keterangan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($blokKebuns as $key => $blok)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td class="fw-bold">{{ $blok->nama_blok }}</td>
                        <td>{{ $blok->luas_lahan }}</td>
                        <td>{{ $blok->lokasi }}</td>
                        <td>{{ $blok->keterangan ?? '-' }}</td>
                        <td>
                            <form action="{{ route('blok-kebun.destroy', $blok->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus blok ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted py-4">Belum ada data blok kebun.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Tambah Data -->
<div class="modal fade" id="tambahBlokModal" tabindex="-1" aria-labelledby="tambahBlokModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title" id="tambahBlokModalLabel">Tambah Blok Kebun Baru</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('blok-kebun.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label>Nama Blok</label>
                        <input type="text" name="nama_blok" class="form-control" required placeholder="Contoh: Blok A1">
                    </div>
                    <div class="mb-3">
                        <label>Luas Lahan (Hektar)</label>
                        <input type="number" step="0.01" name="luas_lahan" class="form-control" required placeholder="Contoh: 2.5">
                    </div>
                    <div class="mb-3">
                        <label>Lokasi</label>
                        <input type="text" name="lokasi" class="form-control" required placeholder="Contoh: Sektor Utara">
                    </div>
                    <div class="mb-3">
                        <label>Keterangan (Opsional)</label>
                        <textarea name="keterangan" class="form-control" rows="2"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success">Simpan Data</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection