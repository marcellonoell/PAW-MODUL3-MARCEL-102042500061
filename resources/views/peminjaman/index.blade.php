@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="fw-bold mb-1">Daftar Peminjaman</h2>
        <p class="text-muted mb-0">Kelola transaksi peminjaman dan pengembalian buku.</p>
    </div>
    <a href="{{ route('peminjaman.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-lg me-1"></i> Tambah Peminjaman
    </a>
</div>

<div class="card shadow-sm">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead>
                    <tr>
                        <th class="ps-3" style="width: 50px;">No</th>
                        <th>Nama Anggota</th>
                        <th>Judul Buku</th>
                        <th>Tanggal Pinjam</th>
                        <th>Tanggal Kembali</th>
                        <th class="text-center">Status</th>
                        <th class="text-end pe-3" style="width: 180px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    {{-- TODO:- Tampilkan daftar transaksi peminjaman menggunakan looping @forelse ($peminjaman as $index => $item) --}}
                    {{--      - Tampilkan data kolom: Nomor, Nama Anggota, Judul Buku, Tanggal Pinjam, Tanggal Kembali, Status, dan Tombol Aksi --}}
                    {{--      - Tampilkan pesan jika data peminjaman masih kosong pada blok @empty --}}
                    @forelse ($peminjaman as $index => $item)
        <tr>
            <td>{{ $peminjaman->firstItem() + $index }}</td>
            <td>{{ $item->anggota->nama ?? 'Anggota Dihapus' }}</td>
            <td>{{ $item->buku->judul ?? 'Buku Dihapus' }}</td>
            <td>{{ \Carbon\Carbon::parse($item->tanggal_pinjam)->translatedFormat('d F Y') }}</td>
            <td>
                {{ $item->tanggal_kembali ? \Carbon\Carbon::parse($item->tanggal_kembali)->translatedFormat('d F Y') : '-' }}
            </td>
            <td>
                <span class="badge {{ $item->status === 'Dipinjam' ? 'bg-warning text-dark' : 'bg-success' }}">
                    {{ $item->status }}
                </span>
            </td>
            <td>
                @if ($item->status === 'Dipinjam')
                    <form action="{{ route('peminjaman.kembali', $item->id) }}" method="POST" class="d-inline">
                        @csrf
                        @method('PUT')
                        <button type="submit" class="btn btn-sm btn-success" onclick="return confirm('Apakah Anda yakin buku ini sudah dikembalikan?')">
                            Kembalikan
                        </button>
                    </form>
                @else
                    <span class="text-muted small">Selesai</span>
                @endif
            </td>
        </tr>
    @empty
        <tr>
            <td colspan="7" class="text-center py-3 text-muted">Belum ada data peminjaman buku.</td>
        </tr>
    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($peminjaman->hasPages())
        <div class="card-footer bg-white py-3">
            {{ $peminjaman->links('pagination::bootstrap-5') }}
        </div>
    @endif
</div>
@endsection
