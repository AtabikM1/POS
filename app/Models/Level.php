<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Level extends Model
{
    use HasFactory;

    protected $table = 'm_level'; // Sesuaikan jika tabel bernama 'm_level'
    protected $primaryKey = 'level_id'; // Primary key tabel
    public $timestamps = false; // Jika tabel tidak memiliki created_at & updated_at

    protected $fillable = [
        'level_kode',
        'level_nama',
    ];

    // Relasi dengan model User
    public function users()
    {
        return $this->hasMany(User::class, 'level_id', 'level_id');
    }
}
