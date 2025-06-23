@extends('layout.main')

@section('title', 'Daftar Surat')

@section('content')
<!-- Tambahkan di <head> layout -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">📋 Daftar Surat</h3>
                    <div class="card-tools">
                        <a href="{{ route('surat.template') }}" class="btn btn-primary">
                            <i class="fas fa-plus"></i> Buat Surat Baru
                        </a>
                    </div>
                </div>

                <div class="card-body">
                    <!-- Filter -->
                    <form method="GET" class="mb-3">
                        <div class="row">
                            <div class="col-md-3">
                                <select name="jenis" class="form-control">
                                    <option value="">Semua Jenis</option>
                                    <option value="permohonan" {{ request('jenis') == 'permohonan' ? 'selected' : '' }}>Permohonan</option>
                                    <option value="pemberitahuan" {{ request('jenis') == 'pemberitahuan' ? 'selected' : '' }}>Pemberitahuan</option>
                                    <option value="undangan" {{ request('jenis') == 'undangan' ? 'selected' : '' }}>Undangan</option>
                                    <option value="keterangan" {{ request('jenis') == 'keterangan' ? 'selected' : '' }}>Keterangan</option>
                                    <option value="pengantar" {{ request('jenis') == 'pengantar' ? 'selected' : '' }}>Pengantar</option>
                                    <option value="izin" {{ request('jenis') == 'izin' ? 'selected' : '' }}>Izin</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <select name="status" class="form-control">
                                    <option value="">Semua Status</option>
                                    <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                                    <option value="dikirim" {{ request('status') == 'dikirim' ? 'selected' : '' }}>Dikirim</option>
                                    <option value="disetujui" {{ request('status') == 'disetujui' ? 'selected' : '' }}>Disetujui</option>
                                    <option value="ditolak" {{ request('status') == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <button type="submit" class="btn btn-info">Filter</button>
                            </div>
                        </div>
                    </form>

                    <!-- Tabel Surat -->
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nomor Surat</th>
                                    <th>Jenis</th>
                                    <th>Perihal</th>
                                    <th>Tanggal</th>
                                    <th>Status</th>
                                    <th>Pembuat</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($surat as $index => $item)
                                <tr>
                                    <td>{{ $surat->firstItem() + $index }}</td>
                                    <td>{{ $item->nomor_surat }}</td>
                                    <td>
                                    {{ ucfirst($item->jenis_surat) }}</span>
                                    </td>
                                    <td>{{ Str::limit($item->perihal, 30) }}</td>
                                    <td>{{ $item->tanggal_indonesia }}</td>
                                    <td> {{ $item->status }} </td>
                                    <td>{{ $item->user->name }}</td>
                                    <td>
                                        <div class="btn-group">
                                            <a href="{{ route('surat.show', $item) }}" class="btn btn-sm btn-info">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('surat.edit', $item) }}" class="btn btn-sm btn-warning">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <a href="{{ route('surat.print', $item) }}" class="btn btn-sm btn-success" target="_blank">
                                                <i class="fas fa-print"></i>
                                            </a>
                                            <form action="{{ route('surat.destroy', $item) }}" method="POST" style="display: inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger"
                                                        onclick="return confirm('Yakin hapus surat ini?')">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="8" class="text-center">Belum ada surat</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    {{ $surat->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
