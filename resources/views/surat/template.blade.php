@extends('layout.main')

@section('title', 'Template Surat')

@section('content')
<div class="container-fluid">
    <div class="row">
        <!-- Form Input -->
        <div class="col-md-4">
            <form id="formSurat" action="{{ route('surat.store') }}" method="POST">
                @csrf
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">📝 Form Input Surat</h5>

                        <div class="form-group">
                            <label>Jenis Surat:</label>
                            <select name="jenis_surat" id="jenisSurat" class="form-control" required>
                                <option value="permohonan">Permohonan</option>
                                <option value="pemberitahuan">Pemberitahuan</option>
                                <option value="undangan">Undangan</option>
                                <option value="keterangan">Keterangan</option>
                                <option value="pengantar">Pengantar</option>
                                <option value="izin">Izin</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Nomor Surat:</label>
                            <input type="text" name="nomor_surat" id="nomorSurat" class="form-control" required>
                            <small class="text-muted">Klik tombol di bawah untuk membuat otomatis</small>
                            <button type="button" class="btn btn-sm btn-info mt-2" onclick="generateNomor()">🔄 Generate</button>
                        </div>

                        <div class="form-group">
                            <label>Perihal:</label>
                            <input type="text" name="perihal" id="perihalSurat" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label>Tujuan Surat:</label>
                            <input type="text" name="kepada" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label>Isi Surat:</label>
                            <textarea name="isi_surat" class="form-control" rows="4" required></textarea>
                        </div>

                        <div class="form-group">
                            <label>Nama Instansi:</label>
                            <input type="text" name="nama_instansi" class="form-control" value="PT. Contoh Sejahtera" required>
                        </div>

                        <div class="form-group">
                            <label>Alamat Instansi:</label>
                            <textarea name="alamat_instansi" class="form-control" rows="2" required>Jl. Mawar No. 1, Jakarta</textarea>
                        </div>

                        <div class="form-group">
                            <label>Kontak Instansi:</label>
                            <input type="text" name="kontak_instansi" class="form-control" value="021-12345678" required>
                        </div>

                        <div class="form-group">
                            <label>Penandatangan:</label>
                            <input type="text" name="nama_penandatangan" class="form-control" value="{{ Auth::user()->name }}" required>
                        </div>

                        <div class="form-group">
                            <label>Jabatan Penandatangan:</label>
                            <input type="text" name="jabatan_penandatangan" class="form-control" value="Kepala Divisi" required>
                        </div>

                        <div class="form-group">
                            <label>Tanggal Surat:</label>
                            <input type="date" name="tanggal_surat" class="form-control" value="{{ date('Y-m-d') }}" required>
                        </div>

                        <div class="form-group">
                            <label>Catatan (Opsional):</label>
                            <textarea name="catatan" class="form-control" rows="2"></textarea>
                        </div>

                        <button type="submit" class="btn btn-success btn-block">💾 Simpan Surat</button>
                    </div>
                </div>
            </form>
        </div>

        <!-- Preview Kop Surat -->
      <div class="col-md-8">
    <div class="card border border-dark">
        <div class="card-body" id="previewArea">
            <div class="d-flex align-items-center mb-3">
                <div style="width: 80px;">
                    <img src="{{ asset('arsipku.png') }}" alt="Logo Arsipku" style="width: 80px; height: auto;">
                </div>
                <div class="text-center flex-grow-1">
                    <h5 class="m-0 text-uppercase font-weight-bold">ARSIPKU</h5>
                    <div style="font-size: 14px;">
                        Jl. Melati No. 123, Jakarta Selatan, DKI Jakarta 12150<br>
                        Telp: (021) 5678-1234 | Email: info@arsipku.id | Website: www.arsipku.id
                    </div>
                </div>
            </div>
            <hr style="border-top: 3px solid black; margin-top: 0; margin-bottom: 20px;">

            <p><strong>Nomor:</strong> <span id="previewNomor">-</span></p>
            <p><strong>Perihal:</strong> <span id="previewPerihal">-</span></p>
            <p><strong>Kepada:</strong> <span id="previewKepada">-</span></p>
            <p><strong>Isi Surat:</strong></p>
            <p id="previewIsi" style="text-align: justify;">-</p>

            <br><br>
            <p class="text-right">
                Jakarta, <span id="previewTanggal">{{ date('d F Y') }}</span><br>
                <strong><span id="previewNama">{{ Auth::user()->name }}</span></strong><br>
                <em id="previewJabatan">Kepala Divisi</em>
            </p>
        </div>
    </div>
</div>
</div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function generateNomor() {
    const d = new Date();
    const rand = Math.floor(100 + Math.random() * 900); // 3 digit angka acak
    const nomor = `${rand}/SR/${d.getMonth()+1}/${d.getFullYear()}`;
    document.getElementById('nomorSurat').value = nomor;
    updatePreview();
}

function updatePreview() {
    document.getElementById('previewNomor').innerText = document.getElementById('nomorSurat').value;
    document.getElementById('previewPerihal').innerText = document.getElementById('perihalSurat').value;
    document.getElementById('previewKepada').innerText = document.querySelector('input[name="kepada"]').value;
    document.getElementById('previewIsi').innerText = document.querySelector('textarea[name="isi_surat"]').value;
    document.getElementById('previewNama').innerText = document.querySelector('input[name="nama_penandatangan"]').value;
    document.getElementById('previewJabatan').innerText = document.querySelector('input[name="jabatan_penandatangan"]').value;
}

document.addEventListener('DOMContentLoaded', () => {
    const inputElements = document.querySelectorAll('input, textarea, select');
    inputElements.forEach(el => {
        el.addEventListener('input', updatePreview);
    });
});
</script>
@endpush
