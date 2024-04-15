<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TransaksiModel extends Model
{
    use HasFactory;
    protected $table = 't_penjualan';
    protected $primaryKey = 'penjualan_id';

    protected $fillable = ['user_id', 'penjualan_kode', 'pembeli', 'penjualan_tanggal'];

    public function user(): BelongsTo
    {
        return $this->BelongsTo(UserModel::class, 'user_id', 'user_id');
    }
}