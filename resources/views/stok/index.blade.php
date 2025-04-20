@extends('layouts.template')

@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3 class="card-title">Data Stok</h3>
            <div class="card-tools">
                <button onclick="modalAction('{{ url('/stok/import') }}')" class="btn btn-info btn-sm">
                    <i class="fa fa-upload"></i> Import
                </button>
                {{--
                <a href="{{ route('stok.export_excel') }}" class="btn btn-primary btn-sm">
                    <i class="fa fa-file-excel"></i> Export Excel
                </a>
                <a href="{{ route('stok.export_pdf') }}" class="btn btn-danger btn-sm">
                    <i class="fa fa-file-pdf"></i> Export PDF
                </a>
                --}}
                <button onclick="modalAction('{{ url('/stok/create_ajax') }}')" class="btn btn-success btn-sm">
                    <i class="fa fa-plus"></i> Tambah
                </button>
            </div>
        </div>

        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="barang_filter">Filter Barang:</label>
                    <select id="barang_filter" class="form-control">
                        <option value="">Semua barang</option>
                        @foreach(\App\Models\BarangModel::all() as $barang)
                            <option value="{{ $barang->barang_id }}">{{ $barang->barang_nama }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <table class="table table-bordered table-striped" id="tbl-stok" width="100%">
                <thead class="thead-dark">
                    <tr>
                        <th>No</th>
                        <th>Supplier</th>
                        <th>Barang</th>
                        <th>User</th>
                        <th>Tanggal Stok</th>
                        <th>Jumlah Stok</th>
                        {{-- <th>Aksi</th> --}}
                    </tr>
                </thead>
            </table>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="myModal" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
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
            var table = $('#tbl-stok').DataTable({
                serverSide: true,
                processing: true,
                ajax: {
                    url: "{{ url('stok/list') }}",
                    type: "POST",
                    data: function (d) {
                        d._token = "{{ csrf_token() }}";
                        d.barang_id = $('#barang_filter').val();
                    }
                },
                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex', searchable: false, orderable: false },
                    { data: 'supplier.supplier_nama', name: 'supplier.supplier_nama' },
                    { data: 'barang.barang_nama', name: 'barang.barang_nama' },
                    { data: 'user.username', name: 'user.username' }, // atau sesuaikan dengan kolom di tabel user kamu
                    { data: 'stok_tanggal', name: 'stok_tanggal' },
                    { data: 'stok_jumlah', name: 'stok_jumlah', searchable: false },
                    // { data: 'action', name: 'action', orderable: false, searchable: false }
                ]

            });

            $('#barang_filter').on('change', function () {
                table.ajax.reload();
            });
        });
    </script>
    <style>
        .content-wrapper {
            min-height: 100vh !important;
        }
    </style>

@endpush