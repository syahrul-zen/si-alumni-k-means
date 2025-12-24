<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NumberDataAlumni extends Model
{
    use HasFactory;


    protected $fillable = 
    [
        'nis_alumni',
        
        'value_jenis_pekerjaan',
        'value_jenjang_pendidikan',
        'value_tahun_lulus',
        'value_domisili',
        'value_jenis_keahlian'
    ];

}
