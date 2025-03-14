@extends('layouts.template')

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Tambah Kategori</h3>
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
            <form action="{{ url('/kategori') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="kategori_kode">Kode Kategori</label>
                    <input type="text" name="kategori_kode" id="kategori_kode" class="form-control"
                        value="{{ old('kategori_kode') }}" placeholder="Masukkan kode kategori">
                </div>
                <div class="form-group">
                    <label for="kategori_nama">Nama Kategori</label>
                    <input type="text" name="kategori_nama" id="kategori_nama" class="form-control"
                        value="{{ old('kategori_nama') }}" placeholder="Masukkan nama kategori">
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <a href="{{ url('/kategori') }}" class="btn btn-secondary">Batal</a>
                </div>
            </form>
        </div>
    </div>
@endsection