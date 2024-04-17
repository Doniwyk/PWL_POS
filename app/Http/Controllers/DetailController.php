<?php

namespace App\Http\Controllers;

use App\Models\BarangModel;
use Illuminate\Http\Request;
use App\Models\DetailTransaksiModel;
use App\Models\TransaksiModel;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Database\QueryException;

class DetailController extends Controller
{
    public function index(){
        $breadcrumb = (object) [ 
            'title' => 'Daftar Detail Transaksi', 
            'list' => ['Home', 'Detail Transaksi']
        ];
        $page = (object) [ 
            'title' => 'Daftar detail transaksi yang terdaftar dalam sistem' 
        ];

        $activeMenu = 'detail'; // set menu yang sedang aktif

        $trans = TransaksiModel::all();
        $detail = DetailTransaksiModel::all();

        return view('detailtransaksi.index', ['breadcrumb' => $breadcrumb, 'page' => $page, 'transaksi' => $trans, 'detail'=>$detail, 'activeMenu' => $activeMenu]);
    }
    public function list(Request $request){
        $detail = DetailTransaksiModel::select('detail_id', 'barang_id', 'penjualan_id', 'harga','jumlah')
                ->with('transaksi', 'barang');

        //Filter berdasarkan user
        if($request->penjualan_id){
            $detail->where('penjualan_id', $request->penjualan_id);
        }

        return DataTables::of($detail)
        ->addIndexColumn()
        ->addColumn('aksi', function ($details) { // menambahkan kolom aksi
            $btn = '<a href="'.url('/detailtransaksi/' . $details->detail_id).'" class="btn btn-info btn-sm">Detail</a> ';
            $btn .= '<a href="'.url('/detailtransaksi/' . $details->detail_id . '/edit').'" class="btn btn-warning btn-sm">Edit</a> ';
            $btn .= '<form class="d-inline-block" method="POST" action="'.url('/detailtransaksi/'.$details->detail_id).'">'
                    . csrf_field() . method_field('DELETE') .
                    '<button type="submit" class="btn btn-danger btn-sm" onclick="return confirm(\'Apakah Anda yakin menghapus data ini?\');">Hapus</button></form>';
            return $btn;
        })
        ->rawColumns(['aksi']) // memberitahu bahwa kolom aksi adalah html
        ->make(true);
    }
    public function create(){
        $breadcrumb = (object) [
        'title' => 'Tambah Detail Transaksi',
        'list' => ['Home', 'Detail Transaksi', 'Tambah']];
        $page = (object) [
            'title' => 'Tambah detail transaksi baru'
        ];
        $detail = DetailTransaksiModel::all(); // ambil data level untuk ditampilkan di form $activeMenu 'user'; // set menu yang sedang aktif
        
        $activeMenu = 'detail';
        
        return view('detailtransaksi.create', ['breadcrumb' => $breadcrumb, 'page' => $page, 'detail' => $detail, 'activeMenu' => $activeMenu]);
    }
    public function store(Request $request){
        $request->validate([
            'penjualan_id' => 'required|integer',
            'barang_id' => 'required|integer',
            'jumlah' => 'required|integer',
        ]);
        
        $barang = BarangModel::find($request->barang_id);
        if($barang) {
            // Mengisi data transaksi, termasuk harga dari barang yang dipilih
            DetailTransaksiModel::create([
                'penjualan_id' => $request->penjualan_id,
                'barang_id' => $request->barang_id,
                'jumlah' => $request->jumlah,
                'harga' => $barang->harga // Mengambil harga dari objek barang yang dipilih
            ]);
        }
        return redirect('/transaksi')->with('success', 'Data transaksi berhasil disimpan');
    }
    public function show(string $id)
    {
        $detail = DetailTransaksiModel::with('transaksi')->find($id);
        
        $breadcrumb = (object) [
            'title' => 'Detail Transaksi',
            'list' => ['Home', 'Transaksi', 'Detail']
        ];

        $page = (object) [
            'title' => 'Detail Transaksi'
        ];

        $activeMenu = 'penjualan'; // set menu yang sedang aktif
        
        return view('transaksi.show', compact('breadcrumb', 'page', 'activeMenu', 'detail'));
    }
}