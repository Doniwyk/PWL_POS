@extends('layouts.template')

@section('content')
<div class="card card-outline card-primary">
    <div class="card-header">
        <h3 class="card-title">{{ $page->title }}</h3>
        <div class="card-tools"></div>
    </div>
    <div class="card-body">
        <form method="POST" action="{{  url('/stok/'.$stok->stok_id)  }}" class="form-horizontal">
            @csrf
            {{ method_field('PUT') }}
            <div class="form-group row">
                <label class="col-2 control-label col-form-label">Nama Barang</label>
                <div class="col-10">
                    <select class="form-control" id="barang_id" name="barang_id" required>
                        <option value="">- Pilih barang -</option>
                        @foreach($barang as $item)
                        <option value="{{ $item->barang_id }}" @if($item->barang_id == $stok->barang_id) selected @endif>{{ $item->barang_nama }}</option>
                        @endforeach
                    </select>
                    @error('barang_id')
                    <small class="form-text text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>
            <div class="form-group row">
                <label class="col-2 control-label col-form-label">Nama User</label>
                <div class="col-10">
                    <select class="form-control" id="user_id" name="user_id" required>
                        <option value="">- Pilih user -</option>
                        @foreach($user as $item)
                        <option value="{{ $item->user_id }}" @if($item->user_id == $stok->user_id) selected @endif>{{ $item->nama }}</option>
                        @endforeach
                    </select>
                    @error('user_id')
                    <small class="form-text text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>
            <div class="form-group row">
                <label class="col-2 control-label col-form-label">Stok Jumlah</label>
                <div class="col-10">
                    <input type="text" class="form-control" id="stok_jumlah" name="stok_jumlah" value="{{ old('stok_jumlah', $stok->stok_jumlah) }}" required>
                    @error('stok_jumlah')
                    <small class="form-text text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>
            <div class="form-group row">
                <label class="col-2 control-label col-form-label">Stok Tanggal</label>
                <div class="col-10">
                    <input type="date" class="form-control" id="stok_tanggal" name="stok_tanggal" value="{{ old('stok_tanggal', $stok->stok_tanggal) }}">
                    @error('stok_tanggal')
                    <small class="form-text text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>
            <div class="form-group row">
                <label class="col-2 control-label col-form-label"></label>
                <div class="col-10">
                    <button type="submit" class="btn btn-primary btn-sm">Simpan</button>
                    <a class="btn btn-sm btn-default ml-1" href="{{ url('stok') }}">Kembali</a>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@push('css')
@endpush

@push('js')
@endpush