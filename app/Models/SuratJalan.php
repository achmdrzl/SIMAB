<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SuratJalan extends Model
{
    use HasFactory;

    protected $primaryKey = 'suratjalan_id';
    public $incrementing = true;
    public $timestamps = true;

    protected $fillable =
    [
        'proyek_id',
        'suratjalan_tgl',
        'suratjalan_driver',
        'suratjalan_pengirim',
        'suratjalan_pengawaslapangan',
        'suratjalan_jmlalat',
        'suratjalan_platno',
        'suratjalan_jenis',
        'suratjalan_ket',
        'status'
    ];

    public function proyek()
    {
        return $this->belongsTo(Proyek::class, 'proyek_id');
    }

    public function detailsurat()
    {
        return $this->hasMany(SuratJalanDetail::class, 'suratjalan_id');
    }
}
