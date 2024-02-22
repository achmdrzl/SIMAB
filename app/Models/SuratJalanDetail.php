<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SuratJalanDetail extends Model
{
    use HasFactory;

    protected $primaryKey = 'detailsuratjalan_id';
    public $incrementing = true;
    public $timestamps = true;

    protected $fillable =
    [
        'suratjalan_id',
        'alat_id',
        'alat_jml',
    ];

    public function surat()
    {
        return $this->belongsTo(SuratJalan::class, 'suratjalan_id');
    }

    public function alat()
    {
        return $this->belongsTo(Alat::class, 'alat_id');
    }
}
