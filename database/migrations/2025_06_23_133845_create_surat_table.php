<?php


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('surat', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('jenis_surat'); // permohonan, pemberitahuan, undangan, dll
            $table->string('nomor_surat')->unique();
            $table->string('perihal');
            $table->string('kepada');
            $table->text('isi_surat');
            $table->string('nama_instansi');
            $table->text('alamat_instansi');
            $table->string('kontak_instansi');
            $table->string('nama_penandatangan');
            $table->string('jabatan_penandatangan');
            $table->enum('status', ['draft', 'dikirim', 'disetujui', 'ditolak'])->default('draft');
            $table->date('tanggal_surat');
            $table->text('catatan')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('surat');
    }
};
