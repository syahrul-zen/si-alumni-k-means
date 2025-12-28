<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;


class Alumni extends Authenticatable
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
        'nama_pekerjaan',
        'nama_tempat_bekerja',
        'gambar',
        'password',
        
        'jenis_pekerjaan',
        'jenjang_pendidikan',
        'tahun_lulus',
        'domisili',
        'jenis_keahlian'
    ];

    protected $casts = [
        'password' => 'hashed',
    ];

    public function numberDataAlumni() {
        return $this->hasOne(NumberDataAlumni::class, 'nis_alumni', 'nis');
    }

}
