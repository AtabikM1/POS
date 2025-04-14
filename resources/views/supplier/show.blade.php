@extends('layouts.template')

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Detail Supplier</h3>
            <div class="card-tools">
                <a href="{{ url('/supplier/' . $supplier->supplier_id . '/edit') }}" class="btn btn-warning btn-sm">Edit</a>
            </div>
        </div>
        <div class="card-body">
            <table class="table table-bordered">
                <tr>
                    <th style="width: 200px">ID</th>
                    <td>{{ $supplier->supplier_id }}</td>
                </tr>
                <tr>
                    <th>Kode Supplier</th>
                    <td>{{ $supplier->supplier_kode }}</td>
                </tr>
                <tr>
                    <th>Nama Supplier</th>
                    <td>{{ $supplier->supplier_nama }}</td>
                </tr>
                <tr>
                    <th>Alamat</th>
                    <td>{{ $supplier->supplier_alamat }}</td>
                </tr>
                <tr>
                    <th>Tanggal Dibuat</th>
                    <td>{{ $supplier->created_at }}</td>
                </tr>
                <tr>
                    <th>Terakhir Diupdate</th>
                    <td>{{ $supplier->updated_at }}</td>
                </tr>
            </table>
            <div class="mt-3">
                <a href="{{ url('/supplier') }}" class="btn btn-secondary">Kembali</a>
            </div>
        </div>
    </div>
@endsection