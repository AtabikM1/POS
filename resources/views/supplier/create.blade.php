@extends('layouts.template')

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Tambah Supplier</h3>
        </div>
        <div class="card-body">
            @if($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <form action="{{ url('/supplier') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="supplier_kode">Kode Supplier</label>
                    <input type="text" name="supplier_kode" id="supplier_kode" class="form-control"
                        value="{{ old('supplier_kode') }}" placeholder="Masukkan kode supplier">
                </div>
                <div class="form-group">
                    <label for="supplier_nama">Nama Supplier</label>
                    <input type="text" name="supplier_nama" id="supplier_nama" class="form-control"
                        value="{{ old('supplier_nama') }}" placeholder="Masukkan nama supplier">
                </div>
                <div class="form-group">
                    <label for="supplier_alamat">Alamat</label>
                    <textarea name="supplier_alamat" id="supplier_alamat" class="form-control" rows="3"
                        placeholder="Masukkan alamat supplier">{{ old('supplier_alamat') }}</textarea>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <a href="{{ url('/supplier') }}" class="btn btn-secondary">Batal</a>
                </div>
            </form>
        </div>
    </div>
@endsection