<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Surat extends Model
{
    use HasFactory;

    protected $table = 'surat';

    protected $fillable = [
        'user_id',
        'jenis_surat',
        'nomor_surat',
        'perihal',
        'kepada',
        'isi_surat',
        'nama_instansi',
        'alamat_instansi',
        'kontak_instansi',
        'nama_penandatangan',
        'jabatan_penandatangan',
        'status',
        'tanggal_surat',
        'catatan'
    ];

    protected $casts = [
        'tanggal_surat' => 'date',
    ];

    // Relationship
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // Accessor untuk format nomor surat
    public function getFormattedNomorSuratAttribute()
    {
        return $this->nomor_surat;
    }

    // Accessor untuk format tanggal Indonesia
    public function getTanggalIndonesiaAttribute()
    {
        return $this->tanggal_surat->format('d F Y');
    }

    // Scope untuk filter berdasarkan jenis surat
    public function scopeByJenis($query, $jenis)
    {
        return $query->where('jenis_surat', $jenis);
    }

    // Scope untuk filter berdasarkan status
    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    // Method untuk generate nomor surat otomatis
    public static function generateNomorSurat($jenis = 'UMUM')
    {
        $year = date('Y');
        $month = date('m');

        // Ambil nomor terakhir untuk tahun ini
        $lastSurat = self::whereYear('created_at', $year)
                         ->whereMonth('created_at', $month)
                         ->orderBy('id', 'desc')
                         ->first();

        $nextNumber = $lastSurat ? (intval(substr($lastSurat->nomor_surat, 0, 3)) + 1) : 1;

        return sprintf('%03d/%s/%s/%s', $nextNumber, strtoupper($jenis), $month, $year);
    }

    // Method untuk template isi surat berdasarkan jenis
    public static function getTemplateIsi($jenis)
    {
        $templates = [
            'permohonan' => 'Sehubungan dengan hal tersebut di atas, bersama ini kami mengajukan permohonan kepada Bapak/Ibu untuk dapat mempertimbangkan hal-hal sebagai berikut:

1. [Isi permohonan pertama]
2. [Isi permohonan kedua]

Demikian surat permohonan ini kami sampaikan. Atas perhatian dan kerjasamanya, kami ucapkan terima kasih.',

            'pemberitahuan' => 'Dengan ini kami beritahukan kepada Bapak/Ibu mengenai hal-hal sebagai berikut:

1. [Informasi yang diberitahukan]
2. [Detail tambahan]

Demikian pemberitahuan ini kami sampaikan untuk dapat diperhatikan sebagaimana mestinya.',

            'undangan' => 'Dengan hormat kami mengundang Bapak/Ibu untuk menghadiri:

Acara        : [Nama Acara]
Hari/Tanggal : [Hari, Tanggal]
Waktu        : [Jam]
Tempat       : [Lokasi]

Demikian undangan ini kami sampaikan. Atas kehadiran Bapak/Ibu, kami ucapkan terima kasih.',

            'keterangan' => 'Yang bertanda tangan di bawah ini menerangkan bahwa:

Nama     : [Nama Lengkap]
Jabatan  : [Jabatan]
NIP/NIK  : [Nomor Identitas]

Adalah benar-benar [keterangan yang diberikan].

Demikian surat keterangan ini dibuat untuk dapat dipergunakan sebagaimana mestinya.',

            'pengantar' => 'Bersama ini kami sampaikan bahwa:

Nama      : [Nama]
Jabatan   : [Jabatan]
Keperluan : [Tujuan]

Mohon Bapak/Ibu dapat menerima dan memberikan bantuan seperlunya.

Atas perhatian dan kerjasamanya, kami ucapkan terima kasih.',

            'izin' => 'Dengan ini kami mohon izin untuk:

Keperluan : [Alasan izin]
Waktu     : [Tanggal/Jam]
Durasi    : [Lama waktu]

Demikian permohonan izin ini kami sampaikan. Atas perhatian dan persetujuannya, kami ucapkan terima kasih.'
        ];

        return $templates[$jenis] ?? $templates['permohonan'];
    }
}
