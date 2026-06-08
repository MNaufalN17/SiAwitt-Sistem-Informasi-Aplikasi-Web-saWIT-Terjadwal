@extends('layouts.admin')

@section('title', 'Kelola Blok Kebun')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="fw-bold">Manajemen Data Blok Kebun</h3>
    <button type="button" class="btn btn-success fw-bold shadow-sm" data-bs-toggle="modal" data-bs-target="#tambahBlokModal">
        + Tambah Blok Baru
    </button>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
        <i class="bi bi-check-circle-fill"></i> {{ session('success') }}
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
                        <th>Nama Blok</th>
                        <th>Luas Lahan (Ha)</th>
                        <th>Lokasi</th>
                        <th>Keterangan</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($bloks as $key => $b)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td class="fw-bold">{{ $b->nama_blok }}</td>
                        <td>{{ number_format($b->luas_lahan, 2) }}</td>
                        <td>{{ $b->lokasi }}</td>
                        <td>{{ $b->keterangan ?? '-' }}</td>
                        <td class="text-center">
                            <button class="btn btn-sm btn-warning fw-bold shadow-sm me-1" data-bs-toggle="modal" data-bs-target="#editBlokModal{{ $b->id }}">
                                Edit
                            </button>
                            
                            <form action="{{ route('blok-kebun.destroy', $b->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger fw-bold shadow-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus blok kebun ini? Data jadwal yang terikat mungkin akan ikut terhapus.')">
                                    Hapus
                                </button>
                            </form>
                        </td>
                    </tr>

                    <div class="modal fade" id="editBlokModal{{ $b->id }}" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header bg-warning text-dark">
                                    <h5 class="modal-title fw-bold">Edit Data Blok Kebun</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <form action="{{ route('blok-kebun.update', $b->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <label class="fw-bold mb-1">Nama Blok (*)</label>
                                            <input type="text" name="nama_blok" class="form-control" value="{{ $b->nama_blok }}" required>
                                        </div>
                                        <div class="mb-3">
                                            <label class="fw-bold mb-1">Luas Lahan (Hektar) (*)</label>
                                            <input type="number" step="0.01" name="luas_lahan" class="form-control" value="{{ $b->luas_lahan }}" required>
                                        </div>
                                        <div class="mb-3">
                                            <label class="fw-bold mb-1">Lokasi Sektor (*)</label>
                                            <input type="text" name="lokasi" class="form-control" value="{{ $b->lokasi }}" required>
                                        </div>
                                        <div class="mb-3">
                                            <label class="fw-bold mb-1">Keterangan (Opsional)</label>
                                            <textarea name="keterangan" class="form-control" rows="3">{{ $b->keterangan }}</textarea>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-light border" data-bs-dismiss="modal">Batal</button>
                                        <button type="submit" class="btn btn-warning fw-bold">Simpan Perubahan</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
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

<div class="modal fade" id="tambahBlokModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title fw-bold">Tambah Blok Kebun Baru</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('blok-kebun.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="fw-bold mb-1">Nama Blok (*)</label>
                        <input type="text" name="nama_blok" class="form-control" placeholder="Misal: Blok A1" required>
                    </div>
                    <div class="mb-3">
                        <label class="fw-bold mb-1">Luas Lahan (Hektar) (*)</label>
                        <input type="number" step="0.01" name="luas_lahan" class="form-control" placeholder="Misal: 5.50" required>
                    </div>
                    <div class="mb-3">
                        <label class="fw-bold mb-1">Lokasi Sektor (*)</label>
                        <input type="text" name="lokasi" class="form-control" placeholder="Misal: Sektor Utara" required>
                    </div>
                    <div class="mb-3">
                        <label class="fw-bold mb-1">Keterangan (Opsional)</label>
                        <textarea name="keterangan" class="form-control" rows="3" placeholder="Tambahkan catatan khusus jika ada..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light border" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success fw-bold">Simpan Data</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection