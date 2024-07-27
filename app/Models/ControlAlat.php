<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ControlAlat extends Model
{
    use HasFactory;

    protected $primaryKey = 'controlAlat_id';

    protected $fillable = [
        'alat_id',
        'alat_jml',
        'alat_kondisi',
    ];

    public function alat()
    {
        return $this->belongsTo(Alat::class, 'alat_id');
    }
}
