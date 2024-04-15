<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StokModel extends Model
{
    use HasFactory;

    protected $table = 't_stok';
    protected $primaryKey = 'stok_id';

    protected $fillable = ['barang_id', 'user_id', 'stok_jumlah', 'stok_tanggal'];

    public function user(): BelongsTo
    {
        return $this->BelongsTo(UserModel::class, 'user_id');
    }
    public function barang(): BelongsTo
    {
        return $this->BelongsTo(BarangModel::class, 'barang_id');
    }
}