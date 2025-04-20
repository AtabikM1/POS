<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PenjualanModel extends Model{
    use HasFactory;
    protected $table = 't_penjualan';
    protected $primaryKey = 'penjualan_id';
 public $timestamps = false;
    protected $fillable = [
        'user_id', 'penjualan_kode', 'pembeli', 'penjualan_tanggal'
    ];
    public function user(){
        return $this->belongsTo(UserModel::class, "user_id");
    }
    public function detail()
{
    return $this->hasMany(PenjualanDetailModel::class, 'penjualan_id', 'penjualan_id');
}

}