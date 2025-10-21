<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataAbsensi extends Model
{
    use HasFactory;

    protected $table = 'data_absensi';

    // hold created_at and updated_at
    public $timestamps = false;

    protected $fillable = [
        'siswa_id',
        'tanggal',
        'jenis',
        'lokasi_gps',
        'created_at',
        'updated_at',
    ];

    protected function casts(): array
    {
        return [
            'tanggal' => 'date',
            'lokasi_gps' => 'array',
        ];
    }

    public function siswa()
    {
        return $this->belongsTo(DataSiswa::class);
    }
}
