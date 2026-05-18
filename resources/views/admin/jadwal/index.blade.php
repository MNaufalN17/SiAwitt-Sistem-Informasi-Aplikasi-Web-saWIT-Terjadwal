@extends('layouts.admin')

@section('title', 'Jadwal & Verifikasi')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="fw-bold">Agenda Jadwal & Verifikasi Kerja</h3>
    <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#tambahJadwalModal">
        + Buat Jadwal Baru
    </button>
</div>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<div class="card shadow-sm border-0">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>No</th>
                        <th>Tanggal</th>
                        <th>Blok</th>
                        <th>Kegiatan</th>
                        <th>Pekerja</th>
                        <th>Status</th>
                        <th>Verifikasi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($jadwals as $key => $j)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td>{{ \Carbon\Carbon::parse($j->tanggal_kegiatan)->format('d/m/Y') }}</td>
                        <td>{{ $j->blokKebun->nama_blok }}</td>
                        <td><span class="badge bg-outline-dark text-dark border">{{ $j->jenis_kegiatan }}</span></td>
                        <td>{{ $j->pekerja->nama_pekerja }}</td>
                        <td>
                            <span class="badge bg-{{ $j->status == 'Belum Dikerjakan' ? 'danger' : ($j->status == 'Menunggu Verifikasi' ? 'warning text-dark' : 'success') }}">
                                {{ $j->status }}
                            </span>
                        </td>
                        <td>
                            @if($j->status == 'Menunggu Verifikasi')
                                <!-- Tombol Verifikasi Sistem (Jika Ada Upload Foto) -->
                                <button class="btn btn-sm btn-warning fw-bold" data-bs-toggle="modal" data-bs-target="#modalVerifikasi{{ $j->id }}">
                                    Periksa Laporan
                                </button>
                            @elseif($j->status == 'Belum Dikerjakan')
                                <!-- Tombol Verifikasi Manual Langsung jika pekerja kendala jaringan -->
                                <button class="btn btn-sm btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#modalManual{{ $j->id }}">
                                    Lapor Langsung
                                </button>
                            @else
                                <small class="text-success fw-bold">✓ Selesai ({{ $j->metode_verifikasi }})</small>
                            @endif
                        </td>
                    </tr>

                    <!-- Modal Verifikasi Laporan Sistem -->
                    <div class="modal fade" id="modalVerifikasi{{ $j->id }}" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header bg-warning text-dark">
                                    <h5 class="modal-title fw-bold">Verifikasi Bukti Lapangan</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body text-center">
                                    <p class="text-start"><strong>Catatan Pekerja:</strong> {{ $j->laporanPekerjaan->catatan_pekerja ?? '-' }}</p>
                                    <label class="fw-bold d-block text-start mb-2">Foto Bukti:</label>
                                    @if($j->laporanPekerjaan && $j->laporanPekerjaan->foto_bukti)
                                        <img src="{{ asset('storage/' . $j->laporanPekerjaan->foto_bukti) }}" class="img-fluid rounded mb-3 shadow-sm" style="max-height: 300px;">
                                    @endif
                                    <form action="{{ route('jadwal-kegiatan.update', $j->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="metode" value="Upload Sistem">
                                        <button type="submit" class="btn btn-success w-100">Nyatakan Sah & Selesai</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Modal Verifikasi Manual / Laporan Langsung -->
                    <div class="modal fade" id="modalManual{{ $j->id }}" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header bg-secondary text-white">
                                    <h5 class="modal-title">Verifikasi Laporan Langsung (Manual)</h5>
                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                </div>
                                <form action="{{ route('jadwal-kegiatan.update', $j->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="metode" value="Laporan Langsung">
                                    <div class="modal-body">
                                        <p class="text-muted text-sm">Gunakan ini jika pekerja melapor langsung ke rumah/kantor karena tidak ada kuota internet.</p>
                                        <div class="mb-3">
                                            <label>Catatan Verifikasi Admin</label>
                                            <textarea name="catatan_admin" class="form-control" rows="3" required placeholder="Sebutkan alasan, misal: Pekerja melapor langsung ke rumah, buah sudah di TPH."></textarea>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-success w-100">Selesaikan Tugas</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted py-4">Belum ada agenda kegiatan.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Tambah Jadwal -->
<div class="modal fade" id="tambahJadwalModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title">Buat Jadwal Kegiatan Baru</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('jadwal-kegiatan.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label>Pilih Blok Kebun</label>
                        <select name="blok_kebun_id" class="form-select" required>
                            @foreach($bloks as $b)
                                <option value="{{ $b->id }}">{{ $b->nama_blok }} ({{ $b->lokasi }})</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label>Pilih Pekerja Lapangan</label>
                        <select name="pekerja_id" class="form-select" required>
                            @foreach($pekerjas as $p)
                                <option value="{{ $p->id }}">{{ $p->nama_pekerja }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label>Jenis Kegiatan</label>
                        <div class="mt-1">
                            <input type="radio" name="jenis_kegiatan" value="Panen" id="panen" checked> <label for="panen" class="me-3">Panen Buah</label>
                            <input type="radio" name="jenis_kegiatan" value="Pemupukan" id="pupuk"> <label for="pupuk">Pemupukan</label>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label>Tanggal Pelaksanaan</label>
                        <input type="date" name="tanggal_kegiatan" class="form-control" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success">Rilis Jadwal Kerja</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection