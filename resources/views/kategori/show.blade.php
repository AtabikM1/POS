@extends('layouts.template')

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Detail Kategori</h3>
            <div class="card-tools">
                <a href="{{ url('/kategori/' . $kategori->kategori_id . '/edit') }}" class="btn btn-warning btn-sm">Edit</a>
            </div>
        </div>
        <div class="card-body">
            <table class="table table-bordered">
                <tr>
                    <th style="width: 200px">ID</th>
                    <td>{{ $kategori->kategori_id }}</td>
                </tr>
                <tr>
                    <th>Kode Kategori</th>
                    <td>{{ $kategori->kategori_kode }}</td>
                </tr>
                <tr>
                    <th>Nama Kategori</th>
                    <td>{{ $kategori->kategori_nama }}</td>
                </tr>
                <tr>
                    <th>Tanggal Dibuat</th>
                    <td>{{ $kategori->created_at }}</td>
                </tr>
                <tr>
                    <th>Terakhir Diupdate</th>
                    <td>{{ $kategori->updated_at }}</td>
                </tr>
            </table>
            <div class="mt-3">
                <a href="{{ url('/kategori') }}" class="btn btn-secondary">Kembali</a>
            </div>
        </div>
    </div>
@endsection