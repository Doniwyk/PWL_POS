<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\KategoriModel;
use Illuminate\Http\Request;

class KategoriController extends Controller
{
    public function index(){
        return KategoriModel::all();
    }
    public function store(Request $request){
        $kategori = KategoriModel::create([
            'kategori_kode' => $request->kategori_kode,
            'kategori_nama' => $request->kategori_nama
        ]);
        return response()->json($kategori, 201);
    }
    public function show(KategoriModel $kategori){
        return KategoriModel::find($kategori->kategori_id);
    }
    public function update(Request $request, KategoriModel $kategori){
        $kategori->update([
            'kategori_kode' => $request->kategori_kode ? $request->kategori_kode : $kategori->kategori_kode,
            'kategori_nama' => $request->kategori_nama ? $request->kategori_nama : $kategori->kategori_nama,
        ]);
        return $kategori;
    }
    public function destroy(KategoriModel $kategori){
        $kategori->delete();
        return response()->json([
            'success' => true,
            'message' => 'Data terhapus'
        ]);
    }
}