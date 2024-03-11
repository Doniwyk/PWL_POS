<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PenjualanDetailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $penjualanIds = DB::table('t_penjualan')->pluck('penjualan_id')->toArray();
        $barangIds = DB::table('m_barang')->pluck('barang_id')->toArray();

        $data = [];
        $count = 0;

        for ($i = 0; $i < 2; $i++) {
            foreach ($penjualanIds as $penjualanId) {
                $randomBarangIds = array_rand($barangIds, 3);

                foreach ($randomBarangIds as $randomBarangId) {
                    $barangId = $barangIds[$randomBarangId];
                    $hargaJual = DB::table('m_barang')->where('barang_id', $barangId)->value('harga_jual');
                    $jumlah = rand(1, 10);

                    $data[] = [
                        'barang_id' => $barangId,
                        'penjualan_id' => $penjualanId,
                        'harga' => $hargaJual * $jumlah,
                        'jumlah' => $jumlah,
                    ];

                    $count++;
                    if ($count >= 30) {
                        break 3;
                    }
                }
            }
        }

        DB::table('t_penjualan_detail')->insert($data);
    }
}
