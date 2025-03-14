@extends('layouts.template')

@section('content')
    <div class="card">
        <div class="card-header">
            <div class="card-tools">
                <a href="{{ url('barang/create') }}" class="btn btn-success">
                    <i class="fas fa-plus-circle"></i> Tambah
                </a>
            </div>
        </div>
        <div class="card-body">
            <div class="mb-3">
                <label for="kategori-filter">Filter Kategori:</label>
                <select id="kategori-filter" class="form-control">
                    <option value="">Semua Kategori</option>
                    @foreach ($kategori as $kat)
                        <option value="{{ $kat->kategori_id }}">{{ $kat->kategori_nama }}</option>
                    @endforeach
                </select>
            </div>
            <table class="table table-bordered table-striped" id="data-table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Kode</th>
                        <th>Nama</th>
                        <th>Kategori</th>
                        <th>Harga Beli</th>
                        <th>Harga Jual</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
@endsection

@push('js')
    <script>
        $(function () {
            let table = $('#data-table').DataTable({
                serverSide: true,
                processing: true,
                ajax: {
                    url: "{{ url('barang/list') }}",
                    type: "POST",
                    data: function (d) {
                        d._token = "{{ csrf_token() }}";
                        d.kategori_id = $('#kategori-filter').val();
                    }
                },
                columns: [
                    {
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        searchable: false,
                        sortable: false
                    },
                    {
                        data: 'barang_kode',
                        name: 'barang_kode'
                    },
                    {
                        data: 'barang_nama',
                        name: 'barang_nama'
                    },
                    {
                        data: 'kategori.kategori_nama',
                        name: 'kategori.kategori_nama'
                    },
                    {
                        data: 'harga_beli',
                        name: 'harga_beli',
                        render: function (data, type, row) {
                            return 'Rp ' + Number(data).toLocaleString('id-ID');
                        }
                    },
                    {
                        data: 'harga_jual',
                        name: 'harga_jual',
                        render: function (data, type, row) {
                            return 'Rp ' + Number(data).toLocaleString('id-ID');
                        }
                    },
                    {
                        data: 'action',
                        name: 'action',
                        searchable: false,
                        sortable: false
                    }
                ]
            });

            // Event listener untuk filter kategori
            $('#kategori-filter').change(function () {
                table.ajax.reload();
            });
        });
    </script>
@endpush