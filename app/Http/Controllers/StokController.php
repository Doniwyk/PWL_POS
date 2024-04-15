<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserModel;
use App\Models\BarangModel;
use App\Models\StokModel;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Database\QueryException;

class StokController extends Controller
{
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Daftar Stok',
            'list' => ['Home', 'Stok']
        ];
        $page = (object) [
            'title' => 'Daftar stok yang terdaftar dalam sistem'
        ];

        $activeMenu = 'stok'; // set menu yang sedang aktif

        $barang = BarangModel::all();

        return view('stok.index', ['breadcrumb' => $breadcrumb, 'page' => $page, 'barang' => $barang, 'activeMenu' => $activeMenu]);
    }
    public function list(Request $request)
    {
        $stoks = StokModel::select('stok_id', 'barang_id', 'user_id', 'stok_jumlah', 'stok_tanggal')
            ->with('barang', 'user');

        //Filter berdasarkan barang
        if ($request->barang_id) {
            $stoks->where('barang_id', $request->barang_id);
        }

        return DataTables::of($stoks)
            ->addIndexColumn()
            ->addColumn('aksi', function ($stok) { // menambahkan kolom aksi
                $btn = '<a href="' . url('/stok/' . $stok->stok_id) . '" class="btn btn-info btn-sm">Detail</a> ';
                $btn .= '<a href="' . url('/stok/' . $stok->stok_id . '/edit') . '" class="btn btn-warning btn-sm">Edit</a> ';
                $btn .= '<form class="d-inline-block" method="POST" action="' . url('/stok/' . $stok->stok_id) . '">'
                    . csrf_field() . method_field('DELETE') .
                    '<button type="submit" class="btn btn-danger btn-sm" onclick="return confirm(\'Apakah Anda yakin menghapus data ini?\');">Hapus</button></form>';
                return $btn;
            })
            ->rawColumns(['aksi']) // memberitahu bahwa kolom aksi adalah html
            ->make(true);
    }
    public function create()
    {
        $breadcrumb = (object) [
            'title' => 'Tambah Stok',
            'list' => ['Home', 'Stok', 'Tambah']
        ];
        $page = (object) [
            'title' => 'Tambah Stok baru'
        ];
        $barang = BarangModel::all(); // ambil data level untuk ditampilkan di form $activeMenu 'user'; // set menu yang sedang aktif
        $user = UserModel::all(); // ambil data level untuk ditampilkan di form $activeMenu 'user'; // set menu yang sedang aktif

        $activeMenu = 'stok';

        return view('stok.create', ['breadcrumb' => $breadcrumb, 'page' => $page, 'barang' => $barang, 'user' => $user, 'activeMenu' => $activeMenu]);
    }
    public function store(Request $request)
    {
        $request->validate([
            'stok_jumlah' => 'required|integer',
            'stok_tanggal' => 'required|date',
            'user_id' => 'required|integer',
            'barang_id' => 'required|integer|unique:t_stok,barang_id'
        ]);

        StokModel::create([
            'stok_jumlah' => $request->stok_jumlah,
            'stok_tanggal' => $request->stok_tanggal,
            'user_id' => $request->user_id,
            'barang_id' => $request->barang_id
        ]);

        return redirect('/stok')->with('success', 'Data stok berhasil disimpan');
    }
    public function show(string $id)
    {
        $stok = StokModel::with('user', 'barang')->find($id);

        $breadcrumb = (object) [
            'title' => 'Detail Stok',
            'list' => ['Home', 'Stok', 'Detail']
        ];

        $page = (object) [
            'title' => 'Detail Stok'
        ];

        $activeMenu = 'stok'; // set menu yang sedang aktif

        return view('stok.show', compact('breadcrumb', 'page', 'stok', 'activeMenu'));
    }
    // Menampilkan halaman form edit user
    public function edit(string $id)
    {
        $stok = StokModel::find($id);
        $barang = BarangModel::all();
        $user = UserModel::all();
        $breadcrumb = (object)[
            'title' => 'Edit Stok',
            'list' => ['Home', 'Stok', 'Edit']
        ];
        $page = (object)[
            'title' => 'Edit Stok'
        ];
        $activeMenu = 'stok'; // set menu yang sedang aktif
        return view('stok.edit', compact('breadcrumb', 'page', 'barang', 'user', 'stok', 'activeMenu'));
    }

    // Menyimpan perubahan data user
    public function update(Request $request, string $id)
    {
        $request->validate([
            'stok_jumlah' => 'required|integer',
            'stok_tanggal' => 'nullable|date',
            'user_id' => 'required|integer',
            'barang_id' => 'required|integer|'
        ]);

        $stok = StokModel::find($id);
        $stok->update([
            'stok_jumlah' => $request->stok_jumlah,
            'stok_tanggal' => $request->stok_tanggal ? $request->stok_tanggal : $stok->stok_tanggal,
            'user_id' => $request->user_id,
            'barang_id' => $request->barang_id
        ]);

        return redirect('/stok')->with('success', 'Data stok berhasil diubah');
    }
    public function destroy(string $id)
    {
        $check = StokModel::find($id);
        if (!$check) { // untuk mengecek apakah data user dengan id yang dimaksud ada atau tidak
            return redirect('/stok')->with('error', 'Data barang tidak ditemukan');
        }
        try {
            StokModel::destroy($id); // Hapus data level
            return redirect('/stok')->with('success', 'Data barang berhasil dihapus');
        } catch (QueryException $e) {
            // Jika terjadi error ketika menghapus data, redirect kembali ke halaman dengan membawa pesan error
            return redirect('/stok')->with('error', 'Data stok gagal dihapus karena masih terdapat tabel lain yang terkait dengan data ini');
        }
    }
}