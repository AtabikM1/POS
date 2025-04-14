@extends('layouts.template')

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Detail Level</h3>
            <div class="card-tools">
                <a href="{{ url('/level/' . $level->level_id . '/edit') }}" class="btn btn-warning btn-sm">Edit</a>
            </div>
        </div>
        <div class="card-body">
            <table class="table table-bordered">
                <tr>
                    <th style="width: 200px">ID</th>
                    <td>{{ $level->level_id }}</td>
                </tr>
                <tr>
                    <th>Kode Level</th>
                    <td>{{ $level->level_kode }}</td>
                </tr>
                <tr>
                    <th>Nama Level</th>
                    <td>{{ $level->level_nama }}</td>
                </tr>
                <tr>
                    <th>Tanggal Dibuat</th>
                    <td>{{ $level->created_at }}</td>
                </tr>
                <tr>
                    <th>Terakhir Diupdate</th>
                    <td>{{ $level->updated_at }}</td>
                </tr>
            </table>
            <div class="mt-3">
                <a href="{{ url('/level') }}" class="btn btn-secondary">Kembali</a>
            </div>
        </div>
    </div>
@endsection