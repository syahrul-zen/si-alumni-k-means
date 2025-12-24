<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('alumnis', function (Blueprint $table) {
            $table->id();

            $table->string('nis', 20)->unique();
            $table->string('nama_lengkap');
            $table->date('tanggal_lahir');
            $table->enum('jenis_kelamin', ['laki_laki', 'perempuan']);
            $table->string('alamat');
            $table->string('no_telepon', 15)->nullable();
            $table->string('email')->nullable();

            // Data untuk k-means
            $table->enum('jenis_pekerjaan', ['mahasiswa(belum_bekerja)', 'profesional', 'wirausaha']);
            $table->enum('jenjang_pendidikan', ['SMA', 'D3', 'S1', 'S2', 'S3']);
            $table->year('tahun_lulus');
            $table->string('domisili');
            $table->enum('jenis_keahlian', ['kewirausahan', 'teknologi', 'administrasi/manajemen', 'akademik/riset', 'lain_lain']);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('alumnis');
    }
};
