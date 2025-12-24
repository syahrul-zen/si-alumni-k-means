<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Alumni extends Model
{
    use HasFactory;

    protected $fillable = [
        'nis',
        'nama_lengkap',
        'tanggal_lahir',
        'jenis_kelamin',
        'alamat',
        'no_telepon',
        'email',

        'jenis_pekerjaan',
        'jenjang_pendidikan',
        'tahun_lulus',
        'domisili',
        'jenis_keahlian'
    ];



    public function numberDataAlumni() {
        return $this->hasOne(NumberDataAlumni::class, 'nis_alumni', 'nis');
    }

}
