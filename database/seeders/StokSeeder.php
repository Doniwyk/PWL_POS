<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StokSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'barang_id' => 1,
                'user_id' => 1,
                'stok_jumlah' => 100,
                'stok_tanggal' => Carbon::now()
            ],
            [
                'barang_id' => 2,
                'user_id' => 2,
                'stok_jumlah' => 90,
                'stok_tanggal' => Carbon::now()
            ],
            [
                'barang_id' => 3,
                'user_id' => 3,
                'stok_jumlah' => 110,
                'stok_tanggal' => Carbon::now()
            ],
            [
                'barang_id' => 4,
                'user_id' => 1,
                'stok_jumlah' => 200,
                'stok_tanggal' => Carbon::now()
            ],
            [
                'barang_id' => 5,
                'user_id' => 2,
                'stok_jumlah' => 300,
                'stok_tanggal' => Carbon::now()
            ],
            [
                'barang_id' => 6,
                'user_id' => 3,
                'stok_jumlah' => 60,
                'stok_tanggal' => Carbon::now()
            ],
            [
                'barang_id' => 7,
                'user_id' => 1,
                'stok_jumlah' => 99,
                'stok_tanggal' => Carbon::now()
            ],
            [
                'barang_id' => 8,
                'user_id' => 2,
                'stok_jumlah' => 76,
                'stok_tanggal' => Carbon::now()
            ],
            [
                'barang_id' => 9,
                'user_id' => 3,
                'stok_jumlah' => 80,
                'stok_tanggal' => Carbon::now()
            ],
            [
                'barang_id' => 10,
                'user_id' => 1,
                'stok_jumlah' => 344,
                'stok_tanggal' => Carbon::now()
            ],
        ];
        DB::table('t_stok')->insert($data);
    }
}
