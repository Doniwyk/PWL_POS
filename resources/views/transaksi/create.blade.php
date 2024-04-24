@extends('layouts.template')

@section('content')
<div class="card card-outline card-primary">
    <div class="card-header">
        <h3 class="card-title">{{ $page->title }}</h3>
        <div class="card-tools"></div>
    </div>
    <div class="card-body">
        <form method="POST" action="{{ url('transaksi') }}" class="form-horizontal">
            @csrf
            <div class="form-group row">
                <label class="col-2 control-label col-form-label">User</label>
                <div class="col-10">
                    <select class="form-control" id="user_id" name="user_id" required>
                        <option value="">- Pilih user -</option>
                        @foreach($user as $item)
                        <option value="{{ $item->user_id }}">{{ $item->nama }}</option>
                        @endforeach
                    </select>
                    @error('user_id')
                    <small class="form-text text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>
            <div class="form-group row">
                <label class="col-2 control-label col-form-label">Kode Penjualan</label>
                <div class="col-10">
                    <input type="text" class="form-control" id="penjualan_kode" name="penjualan_kode" value="{{ old('penjualan_kode') }} {{ $lastID }}" required readonly>
                    @error('penjualan_kode')
                    <small class="form-text text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>
            <div class="form-group row">
                <label class="col-2 control-label col-form-label">Pembeli</label>
                <div class="col-10">
                    <input type="text" class="form-control" id="pembeli" name="pembeli" value="{{ old('pembeli') }}" required>
                    @error('pembeli')
                    <small class="form-text text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>
            <div class="form-group row">
                <label class="col-2 control-label col-form-label">Tanggal Penjualan</label>
                <div class="col-10">
                    <input type="date" class="form-control" id="penjualan_tanggal" name="penjualan_tanggal" value="{{ old('penjualan_tanggal') }}" required>
                    @error('penjualan_tanggal')
                    <small class="form-text text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>

            <div class="card-header">
                <h3 class="card-title">Tambah Detail Transaksi</h3>
                <div class="card-tools"></div>
            </div>
            <button type="button" class="btn btn-sm btn-info mb-4" id="btn-tambah-barang" onclick="addBarangRow()">
                Tambah Barang
            </button>
            <div class="form-group">
                <table class="table table-striped" id="">
                    <thead>
                        <tr>
                            <th scope="col">Barang</th>
                            <th scope="col">Harga</th>
                            <th scope="col">Jumlah</th>
                        </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>
                            <select class="form-control barang-select" name="barang_id[]" required>
                                <option value="">- Pilih Barang -</option>
                                @foreach ($barang as $item)
                                    <option value="{{ $item->barang_id }}" data-harga="{{ $item->harga_jual }}">
                                        {{ $item->barang_nama }}
                                    </option>
                                @endforeach
                            </select>
                            @error('barang_id')
                                <small class="form-text text-danger">{{ $message }}</small>
                            @enderror
                        </td>
                        <td>
                            <input type="number" class="form-control harga" name="harga[]" readonly>
                        </td>
                        <td>
                            <input type="number" class="form-control jumlah" name="jumlah[]" required>
                            @error('jumlah')
                                <small class="form-text text-danger">{{ $message }}</small>
                            @enderror
                        </td>
                    </tr>
                    </tbody>    
                </table>   
            </div>

            <div class="form-group row">
                <label class="col-2 control-label col-form-label"></label>
                <div class="col-10">
                    <button type="submit" class="btn btn-primary btn-sm">Simpan</button>
                    <a class="btn btn-sm btn-default ml-1" href="{{ url('transaksi') }}">Kembali</a>
                </div>
            </div>
        </form>
    </div>
</div>

    <script>
        document.querySelectorAll('.barang-select').forEach(select => {
            select.addEventListener('change', function() {
                console.log(select);
                const selectedOption = this.options[this.selectedIndex];
                const harga = selectedOption.getAttribute('data-harga');
                const hargaElement = this.closest('tr').querySelector('.harga');
                hargaElement.value = harga;
            });
        });

        function addBarangRow() {
            const tbody = document.querySelector('.table tbody');
            const lastRow = tbody.lastElementChild.cloneNode(true);

            const hargaElement = lastRow.querySelector('.harga');
            const jumlahInput = lastRow.querySelector('.jumlah');

            hargaElement.value = '';
            jumlahInput.value = '';

            // Tambah event listener ke setiap opsi barang
            lastRow.querySelector('.barang-select').addEventListener('change', function() {
                const selectedOption = this.options[this.selectedIndex];
                const harga = selectedOption.getAttribute('data-harga');
                // Dapatkan indeks baris terakhir
                const rowIndex = Array.from(tbody.children).indexOf(lastRow);
                // Atur nilai harga pada input harga yang sesuai
                document.querySelectorAll('.harga')[rowIndex].value = harga;
            });

            // Append baris baru
            tbody.appendChild(lastRow);
        }
    </script>
@endsection

@push('css')
@endpush

@push('js')
@endpush