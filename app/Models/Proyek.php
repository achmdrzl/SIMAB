<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proyek extends Model
{
    use HasFactory;

    protected $primaryKey = 'proyek_id';
    public $incrementing = true;
    public $timestamps = true;

    protected $fillable =
    [
        'proyek_nama',
        'proyek_pelaksana',
        'proyek_lokasi',
        'proyek_tglMulai',
        'proyek_tglAkhir',
        'proyek_pic',
        'fk_user',
        'status'
    ];

    public function surat()
    {
        return $this->hasMany(SuratJalan::class, 'proyek_id');
    }
}
