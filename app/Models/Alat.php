<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Alat extends Model
{
    use HasFactory;

    protected $primaryKey = 'alat_id';
    public $incrementing = true;
    public $timestamps = true;

    protected $fillable =
    [
        'alat_id',
        'alat_kode',
        'alat_nama',
        'alat_kondisi',
        'alat_jml',
        'alat_jenis',
        'status'
    ];

    public function suratdetail()
    {
        return $this->hasOne(SuratJalanDetail::class, 'alat_id');
    }

    public function controlalat()
    {
        return $this->hasOne(ControlAlat::class, 'alat_id');
    }
    
}
