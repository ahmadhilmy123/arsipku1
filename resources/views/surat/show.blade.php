@extends('layout.main')

@section('title', 'Detail Surat')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Detail Surat - {{ $surat->nomor_surat }}</h3>
                    <div class="card-tools">
                        <a href="{{ route('surat.index') }}" class="btn btn-secondary">Kembali</a>
                        <a href="{{ route('surat.edit', $surat) }}" class="btn btn-warning">Edit</a>
                        <a href="{{ route('surat.print', $surat) }}" class="btn btn-success" target="_blank">Print</a>
                    </div>
                </div>

                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr><td>Jenis Surat</td><td>: {{ ucfirst($surat->jenis_surat) }}</td></tr>
                                <tr><td>Status</td><td>:
                                    <span class="badge badge-{{
                                        $surat->status == 'draft' ? 'secondary' : (
                                        $surat->status == 'dikirim' ? 'primary' : (
                                        $surat->status == 'disetujui' ? 'success' : 'danger')) }}">
                                        {{ ucfirst($surat->status) }}
                                    </span>
                                </td></tr>
                                <tr><td>Dibuat oleh</td><td>: {{ $surat->user->name }}</td></tr>
                                <tr><td>Dibuat pada</td><td>: {{ $surat->created_at->format('d F Y H:i') }}</td></tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <form action="{{ route('surat.status', $surat) }}" method="POST">
                                @csrf
                                <div class="form-group">
                                    <label>Update Status:</label>
                                    <select name="status" class="form-control">
                                        @foreach(['draft','dikirim','disetujui','ditolak'] as $status)
                                            <option value="{{ $status }}" {{ $surat->status == $status ? 'selected' : '' }}>{{ ucfirst($status) }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Catatan:</label>
                                    <textarea name="catatan" class="form-control">{{ $surat->catatan }}</textarea>
                                </div>
                                <button type="submit" class="btn btn-primary">Update Status</button>
                            </form>
                        </div>
                    </div>

                    <div class="border p-4" style="background: #fff;">
                        <h5 class="text-center mb-3">{{ $surat->nama_instansi }}</h5>
                        <p><strong>Nomor:</strong> {{ $surat->nomor_surat }}</p>
                        <p><strong>Lampiran:</strong> {{ $surat->lampiran ?? '-' }}</p>
                        <p><strong>Hal:</strong> {{ $surat->perihal }}</p>
                        <p class="text-right">{{ $surat->tempat_tanggal ?? 'Jakarta' }}, {{ \Carbon\Carbon::parse($surat->tanggal_surat)->format('d F Y') }}</p>
                        <p><strong>Kepada Yth:</strong><br>{{ $surat->tujuan_surat }}<br>{{ $surat->alamat_tujuan }}</p>
                        <p>{{ $surat->salam_pembuka ?? 'Dengan hormat,' }}</p>
                        <div style="text-align: justify;">{!! nl2br(e($surat->isi_surat)) !!}</div>
                        <p>{{ $surat->salam_penutup ?? 'Demikian surat ini kami sampaikan. Atas perhatian dan kerjasamanya, kami ucapkan terima kasih.' }}</p>
                        <br><br>
                        <p class="text-right"><strong>{{ $surat->jabatan_penandatangan }}</strong><br><br><br><u>{{ $surat->nama_penandatangan }}</u><br>{{ $surat->nip_penandatangan }}</p>
                    </div>

                    @if($surat->catatan)
                    <div class="mt-4 alert alert-info">
                        <strong>Catatan:</strong> {{ $surat->catatan }}
                    </div>
                    @endif
                </div>

                <div class="card-footer text-right">
                    @can('delete', $surat)
                    <form action="{{ route('surat.destroy', $surat) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus surat ini?')">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger">Hapus</button>
                    </form>
                    @endcan
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
