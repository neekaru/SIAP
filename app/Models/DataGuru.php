<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataGuru extends Model
{
    use HasFactory;

    protected $table = 'data_guru';

    protected $fillable = [
        'nip',
        'nama',
        'no_hp',
        'user_id',
        'is_wali',
    ];

    protected function casts(): array
    {
        return [
            'is_wali' => 'boolean',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function isGuru(): bool
    {
        return $this->user && $this->user->role === 'guru';
    }
}
