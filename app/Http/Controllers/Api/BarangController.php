<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\BarangModel;
use Illuminate\Http\Request;

class BarangController extends Controller
{
    public function index(){
        return BarangModel::all();
    }
    public function store(Request $request){
        $barang = BarangModel::create($request->all());
        return response()->json($barang, 201);
    }
    public function show(BarangModel $barang){
        return BarangModel::find($barang->barang_id);
    }
    public function update(Request $request, BarangModel $barang){
        $barang->update([
            'kategori_id' => $request->kategori_id ? $request->kategori_id : $barang->kategori_id,
            'barang_nama' => $request->barang_nama ? $request->barang_nama : $barang->barang_nama,
            'barang_kode' => $request->barang_kode ? $request->barang_kode : $barang->barang_kode,
            'harga_beli' => $request->harga_beli ? $request->harga_beli : $barang->harga_beli,
            'harga_jual' => $request->harga_jual ? $request->harga_jual : $barang->harga_jual,
        ]);
        return $barang;
    }
    public function destroy(BarangModel $barang){
        $barang->delete();
        return response()->json([
            'success' => true,
            'message' => 'Data terhapus'
        ]);
    }
}