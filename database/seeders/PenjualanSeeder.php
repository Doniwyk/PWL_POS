<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PenjualanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [];
        $userIds = [1, 2, 3];
        $pembelis = ['Doni', 'Wahyu', 'Kurniawan', 'Wayak', 'Yan', 'Cha', 'Putri', 'Nad', 'Daffa', 'Ihza'];
        $penjualanKodes = ['PJL001', 'PJL002', 'PJL003', 'PJL004', 'PJL005', 'PJL006', 'PJL007', 'PJL008', 'PJL009', 'PJL010'];
        $penjualanTanggal = Carbon::now();

        foreach ($userIds as $index => $userId) {
            $data[] = [
                'user_id' => $userId,
                'pembeli' => $pembelis[$index],
                'penjualan_kode' => $penjualanKodes[$index],
                'penjualan_tanggal' => $penjualanTanggal
            ];
        }

        DB::table('t_penjualan')->insert($data);
    }
}
