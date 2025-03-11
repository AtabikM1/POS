@extends('layouts.template')

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Data Kategori</h3>
            <div class="card-tools">
                <a href="{{ url('/kategori/create') }}" class="btn btn-primary btn-sm">Tambah Kategori</a>
            </div>
        </div>
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <table class="table table-bordered table-striped" id="tbl-kategori">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Kode Kategori</th>
                        <th>Nama Kategori</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
@endsection

@push('js')
    <script>
        $(document).ready(function () {
            $('#tbl-kategori').DataTable({
                serverSide: true,
                ajax: {
                    url: "{{ url('kategori/list') }}",
                    type: "POST",
                    data: function (d) {
                        d._token = "{{ csrf_token() }}"
                    }
                },
                columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    searchable: false,
                    sortable: false
                },
                {
                    data: 'kategori_kode',
                    name: 'kategori_kode'
                },
                {
                    data: 'kategori_nama',
                    name: 'kategori_nama'
                },
                {
                    data: 'action',
                    name: 'action',
                    searchable: false,
                    sortable: false
                }
                ]
            });
        });
    </script>
@endpush