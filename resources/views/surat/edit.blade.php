@extends('layout.main')

@section('title', 'Edit Surat')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <form action="{{ route('surat.update', $surat) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">✏️ Edit Surat - {{ $surat->nomor_surat }}</h3>
                        <div class="card-tools">
                            <a href="{{ route('surat.show', $surat) }}" class="btn btn-secondary">Batal</a>
                            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="row">
                            <!-- Kiri -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Jenis Surat</label>
                                    <select name="jenis_surat" class="form-control">
                                        @foreach(['permohonan','pemberitahuan','undangan','keterangan','pengantar','izin'] as $jenis)
                                            <option value="{{ $jenis }}" {{ $surat->jenis_surat == $jenis ? 'selected' : '' }}>{{ ucfirst($jenis) }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Perihal</label>
                                    <input type="text" name="perihal" class="form-control" value="{{ old('perihal', $surat->perihal) }}" required>
                                </div>
                                <div class="form-group">
                                    <label>Kepada</label>
                                    <input type="text" name="kepada" class="form-control" value="{{ old('kepada', $surat->kepada) }}" required>
                                </div>
                                <div class="form-group">
                                    <label>Isi Surat</label>
                                    <textarea name="isi_surat" class="form-control" rows="6">{{ old('isi_surat', $surat->isi_surat) }}</textarea>
                                </div>
                            </div>

                            <!-- Kanan -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Nama Instansi</label>
                                    <input type="text" name="nama_instansi" class="form-control" value="{{ old('nama_instansi', $surat->nama_instansi) }}" required>
                                </div>
                                <div class="form-group">
                                    <label>Alamat Instansi</label>
                                    <textarea name="alamat_instansi" class="form-control">{{ old('alamat_instansi', $surat->alamat_instansi) }}</textarea>
                                </div>
                                <div class="form-group">
                                    <label>Kontak Instansi</label>
                                    <input type="text" name="kontak_instansi" class="form-control" value="{{ old('kontak_instansi', $surat->kontak_instansi) }}">
                                </div>
                                <div class="form-group">
                                    <label>Nama Penandatangan</label>
                                    <input type="text" name="nama_penandatangan" class="form-control" value="{{ old('nama_penandatangan', $surat->nama_penandatangan) }}" required>
                                </div>
                                <div class="form-group">
                                    <label>Jabatan Penandatangan</label>
                                    <input type="text" name="jabatan_penandatangan" class="form-control" value="{{ old('jabatan_penandatangan', $surat->jabatan_penandatangan) }}">
                                </div>
                                <div class="form-group">
                                    <label>Tanggal Surat</label>
                                    <input type="date" name="tanggal_surat" class="form-control" value="{{ old('tanggal_surat', $surat->tanggal_surat ? $surat->tanggal_surat->format('Y-m-d') : '') }}" required>
                                </div>
                                <div class="form-group">
                                    <label>Catatan</label>
                                    <textarea name="catatan" class="form-control">{{ old('catatan', $surat->catatan) }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-footer text-right">
                        <button type="submit" class="btn btn-primary">💾 Simpan</button>
                        <a href="{{ route('surat.show', $surat) }}" class="btn btn-secondary">❌ Batal</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
