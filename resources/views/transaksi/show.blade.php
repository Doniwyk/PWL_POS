@extends('layouts.template')

@section('content')
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title">{{ $page->title }}</h3>
            <div class="card-tools"></div>
        </div>
        <div class="card-body">
            @empty($transaksi)
                <div class="alert alert-danger alert-dismissible">
                    <h5><i class="icon fas fa-ban"></i> Kesalahan!</h5>
                    Data yang Anda cari tidak ditemukan.
                </div>
            @else
                <table class="table table-bordered table-striped table-hover table-sm">
                    <tr>
                        <th>ID</th>
                        <td>{{ $transaksi->penjualan_id }}</td>
                    </tr>
                    <tr>
                        <th>Kode Penjualan</th>
                        <td>{{ $transaksi->penjualan_kode }}</td>
                    </tr>
                    <tr>
                        <th>Nama User</th>
                        <td>{{ $transaksi->user->nama }}</td>
                    </tr>
                    <tr>
                        <th>Pembeli</th>
                        <td>{{ $transaksi->pembeli }}</td>
                    </tr>
                    <tr>
                        <th>Tanggal Penjualan</th>
                        <td>{{ $transaksi->penjualan_tanggal }}</td>
                    </tr>
                </table> <br><br>
                @if ($detail)
                <h2 class="card-title">Detail:</h2>
                <table class="table table-bordered table-striped table-hover table-sm" id="table_penjualan">
                    <thead>
                        <tr>
                            <th>Nama Barang</th>
                            <th>Image</th>
                            <th>Harga</th>
                            <th>Jumlah</th>
                            <th>Total Harga</th>
                        </tr>
                    </thead>
                    <tbody>
                    @php
                    $total = 0;
                    @endphp
                    @forelse ($detail as $item)
                    @php
                    $totalHargaBarang = $item->harga * $item->jumlah;
                    $total += $totalHargaBarang;
                    @endphp
                            <tr>
                                <td>{{ $item->barang->barang_nama }}</td>
                                <td>
                                    <img src="{{ asset($item->barang->image) }}" alt="{{ $item->barang->barang_nama }}" class="img-thumbnail" width="100">
                                </td>
                                <td>{{ $item->harga }}</td>
                                <td>{{ $item->jumlah }}</td>
                                <td>{{ $item->harga * $item->jumlah }}</td>
                            </tr>
                        @endforeach
                        <tfoot>
                            <tr>
                                <td colspan="3" align="center"><strong>Total Harga</strong></td>
                                <td><strong></strong>{{ $total }}</td>
                            </tr>
                        </tfoot>
                    @else
                        <tr>
                            <td colspan="5">No data available</td>
                        </tr>
                    @endif
                </tbody>
                </table>
            @endempty
            <a href="{{ url('transaksi') }}" class="btn btn-sm btn-default mt-2">Kembali</a>
        </div>
    </div>
@endsection

@push('css')
@endpush

@push('js')
@endpush