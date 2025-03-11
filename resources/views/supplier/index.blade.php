@extends('layouts.template')

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Data Supplier</h3>
            <div class="card-tools">
                <a href="{{ url('/supplier/create') }}" class="btn btn-primary btn-sm">Tambah Supplier</a>
            </div>
        </div>
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <table class="table table-bordered table-striped" id="tbl-supplier">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Kode Supplier</th>
                        <th>Nama Supplier</th>
                        <th>Alamat</th>
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
            $('#tbl-supplier').DataTable({
                serverSide: true,
                processing: true,
                ajax: {
                    url: "{{ url('supplier/list') }}",
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
                    data: 'supplier_kode',
                    name: 'supplier_kode'
                },
                {
                    data: 'supplier_nama',
                    name: 'supplier_nama'
                },
                {
                    data: 'supplier_alamat',
                    name: 'supplier_alamat'
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