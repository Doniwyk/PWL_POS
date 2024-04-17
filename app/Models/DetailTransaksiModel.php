<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class DetailTransaksiModel extends Model
{
    use HasFactory;
    protected $table = 't_penjualan_detail';
    protected $primaryKey = 'detail_id';

    protected $fillable = ['barang_id', 'penjualan_id', 'harga', 'jumlah'];

    public function barang(): BelongsTo{
        return $this->BelongsTo(BarangModel::class, 'barang_id', 'barang_id');
    }
    public function transaksi(): BelongsTo{
        return $this->BelongsTo(TransaksiModel::class, 'penjualan_id', 'penjualan_id');
    }
}