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
        Schema::create('number_data_alumnis', function (Blueprint $table) {
            $table->id();

            $table->string('nis_alumni', 20)->unique();

            $table->foreign('nis_alumni')->references('nis')->on('alumnis')->cascadeOnDelete()->cascadeOnUpdate();

            
            $table->float('value_jenis_pekerjaan');
            $table->float('value_jenjang_pendidikan');
            $table->float('value_tahun_lulus');
            $table->float('value_domisili');
            $table->float('value_jenis_keahlian');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('number_data_alumnis');
    }
};
