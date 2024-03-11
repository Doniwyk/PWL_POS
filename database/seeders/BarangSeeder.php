<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BarangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data =[
            [
                'kategori_id' => 1,
                'barang_kode' => 'BEV001',
                'barang_nama' => 'Mie instan',
                'harga_beli' => 3_000,
                'harga_jual' => 4_000,
            ],
            [
                'kategori_id' => 1,
                'barang_kode' => 'BEV002',
                'barang_nama' => 'Jus jeruk',
                'harga_beli' => 10_000,
                'harga_jual' => 15_000,
            ],
            [
                'kategori_id' => 2,
                'barang_kode' => 'HOM001',
                'barang_nama' => 'Rak buku',
                'harga_beli' => 200_000,
                'harga_jual' => 250_000,
            ],
            [
                'kategori_id' => 2,
                'barang_kode' => 'HOM002',
                'barang_nama' => 'Tempat sampah',
                'harga_beli' => 20_000,
                'harga_jual' => 25_000,
            ],
            [
                'kategori_id' => 3,
                'barang_kode' => 'FAS001',
                'barang_nama' => 'Kaos polos',
                'harga_beli' => 30_000,
                'harga_jual' => 40_000,
            ],
            [
                'kategori_id' => 3,
                'barang_kode' => 'FAS002',
                'barang_nama' => 'Jaket kulit',
                'harga_beli' => 200_000,
                'harga_jual' => 250_000,
            ],
            [
                'kategori_id' => 4,
                'barang_kode' => 'OLR001',
                'barang_nama' => 'Pull up bar',
                'harga_beli' => 110_000,
                'harga_jual' => 150_000,
            ],
            [
                'kategori_id' => 4,
                'barang_kode' => 'OLR002',
                'barang_nama' => 'Whey protein',
                'harga_beli' => 100_000,
                'harga_jual' => 130_000,
            ],
            [
                'kategori_id' => 5,
                'barang_kode' => 'ELT001',
                'barang_nama' => 'Kipas angin',
                'harga_beli' => 100_000,
                'harga_jual' => 120_000,
            ],
            [
                'kategori_id' => 5,
                'barang_kode' => 'ELT002',
                'barang_nama' => 'Speaker bluetooth',
                'harga_beli' => 140_000,
                'harga_jual' => 170_000,
            ]
        ];
        DB::table('m_barang')->insert($data);
    }
}
