<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataKelas extends Model
{
    use HasFactory;

    protected $fillable = [
        'kode',
        'nama',
        'walikelas_id',
    ];

    public function walikelas()
    {
        return $this->belongsTo(DataGuru::class, 'walikelas_id');
    }
}
