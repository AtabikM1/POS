@extends('layouts.template')

@section('content')
    <div class="card">
        <div class="card-header">
            <div class="card-title">Tambah Barang</div>
        </div>
        <div class="card-body">
            <form action="{{ url('/barang') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="kategori_id">Kategori</label>
                    <select name="kategori_id" id="kategori_id"
                        class="form-control @error('kategori_id') is-invalid @enderror">
                        <option value="">-- Pilih Kategori --</option>
                        @foreach($kategori as $k)
                            <option value="{{ $k->kategori_id }}" {{ old('kategori_id') == $k->kategori_id ? 'selected' : '' }}>
                                {{ $k->kategori_nama }}
                            </option>
                        @endforeach
                    </select>
                    @error('kategori_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="barang_kode">Kode Barang</label>
                    <input type="text" name="barang_kode" id="barang_kode"
                        class="form-control @error('barang_kode') is-invalid @enderror" value="{{ old('barang_kode') }}"
                        placeholder="Masukkan kode barang">
                    @error('barang_kode')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="barang_nama">Nama Barang</label>
                    <input type="text" name="barang_nama" id="barang_nama"
                        class="form-control @error('barang_nama') is-invalid @enderror" value="{{ old('barang_nama') }}"
                        placeholder="Masukkan nama barang">
                    @error('barang_nama')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="harga_beli">Harga Beli</label>
                    <input type="number" name="harga_beli" id="harga_beli"
                        class="form-control @error('harga_beli') is-invalid @enderror" value="{{ old('harga_beli') }}"
                        placeholder="Masukkan harga beli">
                    @error('harga_beli')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="harga_jual">Harga Jual</label>
                    <input type="number" name="harga_jual" id="harga_jual"
                        class="form-control @error('harga_jual') is-invalid @enderror" value="{{ old('harga_jual') }}"
                        placeholder="Masukkan harga jual">
                    @error('harga_jual')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <a href="{{ url('/barang') }}" class="btn btn-danger">Batal</a>
                </div>
            </form>
        </div>
    </div>
@endsection