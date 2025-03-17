@extends('layouts.template')

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Data Barang</h3>
            <div class="card-tools">
                <button onclick="modalAction('{{ url('/barang/create_ajax') }}')" class="btn btn-primary btn-sm">Tambah
                    Barang</button>
            </div>
        </div>
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <table class="table table-bordered table-striped" id="tbl-barang">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Kode Barang</th>
                        <th>Nama Barang</th>
                        <th>Kategori</th>
                        <th>Harga Beli</th>
                        <th>Harga Jual</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="myModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content" id="modal-content">
                <!-- Content will be loaded here -->
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script>
        function modalAction(url) {
            $.ajax({
                url: url,
                type: 'GET',
                success: function (data) {
                    $('#modal-content').html(data);
                    $('#myModal').modal('show');
                },
                error: function (xhr, status, error) {
                    console.error(error);
                }
            });
        }

        $(document).ready(function () {
            $('#tbl-barang').DataTable({
                serverSide: true,
                processing: true,
                ajax: {
                    url: "{{ url('barang/list') }}",
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
                    render: function (data) {
                        return 'Rp. ' + parseFloat(data).toLocaleString('id-ID');
                    }
                },
                {
                    data: 'harga_jual',
                    name: 'harga_jual',
                    render: function (data) {
                        return 'Rp. ' + parseFloat(data).toLocaleString('id-ID');
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
        });
    </script>
@endpush