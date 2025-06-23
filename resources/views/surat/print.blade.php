<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Print Surat - {{ $surat->nomor_surat }}</title>
    <style>
        @media print {
            body { margin: 0; }
            .no-print { display: none; }
            .page-break { page-break-before: always; }
        }

        body {
            font-family: 'Times New Roman', serif;
            font-size: 12pt;
            line-height: 1.6;
            margin: 20px;
            color: #000;
        }

        .kop-surat {
            text-align: center;
            border-bottom: 3px solid #000;
            margin-bottom: 30px;
            padding-bottom: 20px;
        }

        .kop-surat h1 {
            font-size: 18pt;
            font-weight: bold;
            margin: 0;
            text-transform: uppercase;
        }

        .kop-surat h2 {
            font-size: 14pt;
            font-weight: normal;
            margin: 5px 0;
        }

        .kop-surat p {
            font-size: 10pt;
            margin: 2px 0;
        }

        .nomor-surat {
            text-align: center;
            margin: 30px 0;
            text-decoration: underline;
            font-weight: bold;
            font-size: 14pt;
        }

        .detail-surat {
            margin: 20px 0;
        }

        .detail-surat table {
            width: 100%;
            border-collapse: collapse;
        }

        .detail-surat td {
            padding: 5px 0;
            vertical-align: top;
        }

        .detail-surat td:first-child {
            width: 120px;
        }

        .detail-surat td:nth-child(2) {
            width: 20px;
            text-align: center;
        }

        .isi-surat {
            margin: 30px 0;
            text-align: justify;
            text-indent: 50px;
        }

        .ttd-section {
            margin-top: 50px;
            float: right;
            width: 250px;
            text-align: center;
        }

        .ttd-tempat {
            margin-bottom: 80px;
        }

        .ttd-nama {
            text-decoration: underline;
            font-weight: bold;
        }

        .status-badge {
            position: absolute;
            top: 20px;
            right: 20px;
            padding: 5px 15px;
            border: 2px solid;
            border-radius: 20px;
            font-weight: bold;
            text-transform: uppercase;
        }

        .status-draft {
            color: #ffc107;
            border-color: #ffc107;
            background-color: rgba(255, 193, 7, 0.1);
        }

        .status-dikirim {
            color: #007bff;
            border-color: #007bff;
            background-color: rgba(0, 123, 255, 0.1);
        }

        .status-disetujui {
            color: #28a745;
            border-color: #28a745;
            background-color: rgba(40, 167, 69, 0.1);
        }

        .status-ditolak {
            color: #dc3545;
            border-color: #dc3545;
            background-color: rgba(220, 53, 69, 0.1);
        }

        .catatan {
            margin-top: 30px;
            padding: 15px;
            background-color: #f8f9fa;
            border-left: 4px solid #007bff;
        }

        .print-button {
            position: fixed;
            top: 20px;
            left: 20px;
            background-color: #007bff;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
            z-index: 1000;
        }

        .print-button:hover {
            background-color: #0056b3;
        }

        .back-button {
            position: fixed;
            top: 20px;
            left: 150px;
            background-color: #6c757d;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
            z-index: 1000;
            text-decoration: none;
            display: inline-block;
        }

        .back-button:hover {
            background-color: #545b62;
            color: white;
            text-decoration: none;
        }

        @media screen {
            .container {
                max-width: 21cm;
                margin: 0 auto;
                background: white;
                box-shadow: 0 0 10px rgba(0,0,0,0.1);
                padding: 2cm;
            }
        }

        .clearfix::after {
            content: "";
            display: table;
            clear: both;
        }
    </style>
</head>
<body>
    <!-- Tombol Print & Back (tidak akan terprint) -->
    <button class="print-button no-print" onclick="window.print()">
        🖨️ Print Surat
    </button>
    <a href="{{ route('surat.show', $surat->id) }}" class="back-button no-print">
        ← Kembali
    </a>

    <!-- Status Badge -->
    <div class="status-badge status-{{ $surat->status }} no-print">
        {{ ucfirst($surat->status) }}
    </div>

    <div class="container">
        <!-- Kop Surat -->
       <!-- Kop Surat Modern -->
<div class="kop-surat">
    <table width="100%">
        <tr>
            <td width="15%" style="text-align: center;">
                <img src="{{ asset('arsipku.png') }}" alt="Logo Arsipku" style="max-height: 150px;">
            </td>
            <td width="85%" style="text-align: center; padding-right: 100px;">
                <h1 style="margin: 0; font-size: 22pt; font-weight: 700;">ARSIPKU</h1>
                <h2 style="margin: 0; font-size: 14pt; font-weight: normal;">Sistem Manajemen Surat Digital</h2>
                <p style="margin: 4px 0; font-size: 10pt;">
                    Jl. Digital No. 1, Jakarta | Telp: (021) 12345678 | Email: info@arsipku.id
                </p>
                <p style="margin: 0; font-size: 10pt;">Website: www.arsipku.id</p>
            </td>
        </tr>
    </table>
    <hr style="border: 2px solid black; margin-top: 10px;">
</div>


        <!-- Nomor Surat -->
        <div class="nomor-surat">
            SURAT {{ strtoupper($surat->jenis_surat) }}<br>
            Nomor: {{ $surat->nomor_surat }}
        </div>

        <!-- Detail Surat -->
        <div class="detail-surat">
            <table>
                <tr>
                    <td>Perihal</td>
                    <td>:</td>
                    <td><strong>{{ $surat->perihal }}</strong></td>
                </tr>
                <tr>
                    <td>Kepada</td>
                    <td>:</td>
                    <td>{{ $surat->kepada }}</td>
                </tr>
                <tr>
                    <td>Tanggal</td>
                    <td>:</td>
                    <td>{{ \Carbon\Carbon::parse($surat->tanggal_surat)->locale('id')->isoFormat('DD MMMM YYYY') }}</td>
                </tr>
            </table>
        </div>

        <!-- Isi Surat -->
        <div class="isi-surat">
            {!! nl2br(e($surat->isi_surat)) !!}
        </div>

        <!-- Tanda Tangan -->
        <div class="clearfix">
            <div class="ttd-section">
                <div class="ttd-tempat">
                    {{ \Carbon\Carbon::parse($surat->tanggal_surat)->locale('id')->isoFormat('DD MMMM YYYY') }}
                </div>
                <div class="ttd-nama">
                    {{ $surat->nama_penandatangan }}
                </div>
                <div>
                    {{ $surat->jabatan_penandatangan }}
                </div>
            </div>
        </div>

        <!-- Catatan (jika ada) -->
        @if($surat->catatan)
        <div class="catatan">
            <strong>Catatan:</strong><br>
            {{ $surat->catatan }}
        </div>
        @endif

        <!-- Info Footer -->
        <div style="margin-top: 50px; font-size: 9pt; color: #666; border-top: 1px solid #eee; padding-top: 10px;">
            <table width="100%">
                <tr>
                    <td>Dibuat oleh: {{ $surat->user->name }}</td>
                    <td style="text-align: right;">Dicetak: {{ now()->locale('id')->isoFormat('DD MMMM YYYY, HH:mm') }} WIB</td>
                </tr>
            </table>
        </div>
    </div>

    <script>
        // Auto print saat halaman dimuat (opsional)
        // window.onload = function() { window.print(); }

        // Fungsi untuk print ulang
        function printSurat() {
            window.print();
        }

        // Keyboard shortcut
        document.addEventListener('keydown', function(e) {
            if (e.ctrlKey && e.key === 'p') {
                e.preventDefault();
                window.print();
            }
        });
    </script>
</body>
</html>
