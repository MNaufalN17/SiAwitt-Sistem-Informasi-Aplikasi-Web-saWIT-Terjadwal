@extends('layouts.admin')

@section('title', 'Manajemen Pekerja')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="fw-bold">Manajemen Data Pekerja</h3>
    <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#tambahPekerjaModal">
        + Tambah Pekerja Baru
    </button>
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
                        <th>Nama Pekerja</th>
                        <th>Email Login</th>
                        <th>No HP</th>
                        <th>Alamat</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pekerjas as $key => $p)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td class="fw-bold">{{ $p->nama_pekerja }}</td>
                        <td>{{ $p->user->email ?? '-' }}</td>
                        <td>{{ $p->no_hp }}</td>
                        <td>{{ $p->alamat }}</td>
                        <td><span class="badge bg-success">{{ $p->status }}</span></td>
                        <td>
                            <form action="{{ route('pekerja.destroy', $p->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus pekerja ini juga akan menghapus akun loginnya. Yakin?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted py-4">Belum ada data pekerja.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Tambah Pekerja -->
<div class="modal fade" id="tambahPekerjaModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title">Tambah Pekerja Lapangan</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('pekerja.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label>Nama Lengkap Pekerja</label>
                        <input type="text" name="nama_pekerja" class="form-control" required placeholder="Nama lengkap">
                    </div>
                    <div class="mb-3">
                        <label>Email (Untuk Login)</label>
                        <input type="email" name="email" class="form-control" required placeholder="pekerja@siawitt.com">
                    </div>
                    <div class="mb-3">
                        <label>Password Akun</label>
                        <input type="password" name="password" class="form-control" required placeholder="Minimal 6 karakter">
                    </div>
                    <div class="mb-3">
                        <label>No. HP / WhatsApp</label>
                        <input type="text" name="no_hp" class="form-control" required placeholder="08xxxx">
                    </div>
                    <div class="mb-3">
                        <label>Alamat Tinggal</label>
                        <textarea name="alamat" class="form-control" rows="2" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success">Simpan & Buat Akun</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection