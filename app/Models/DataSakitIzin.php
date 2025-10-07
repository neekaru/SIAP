<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataSakitIzin extends Model
{
    use HasFactory;

    protected $fillable = [
        'siswa_id',
        'tipe',
        'alasan',
        'document_path',
        'status',
        'durasi_hari',
        'divalidasi_oleh',
        'divalidasi_at',
    ];

    protected function casts(): array
    {
        return [
            'divalidasi_at' => 'datetime',
        ];
    }

    public function siswa()
    {
        return $this->belongsTo(User::class, 'siswa_id');
    }

    public function validator()
    {
        return $this->belongsTo(User::class, 'divalidasi_oleh');
    }
}
