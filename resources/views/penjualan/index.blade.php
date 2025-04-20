@extends('layouts.template')

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Data Penjualan</h3>
            <div class="card-tools">
                {{-- <button onclick="modalAction('{{ url('/penjualan/import') }}')" class="btn btn-info btn-sm"><i
                        class="fa fa-upload"></i> Import</button>
                <a href="{{ route('penjualan.export_excel') }}" class="btn btn-primary btn-sm"><i
                        class="fa fa-file-excel"></i>
                    Export Excel</a>
                <a href="{{ route('penjualan.export_pdf') }}" class="btn btn-danger btn-sm"><i class="fa fa-file-pdf"></i>
                    Export PDF</a> --}}
                <button onclick="modalAction('{{ url('/penjualan/create') }}')" class="btn btn-success btn-sm"><i
                        class="fa fa-plus"></i> Tambah</button>
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
                    {{-- <div class="form-group">
                        <label for="kategori_filter">Filter Kategori:</label>
                        <select id="kategori_filter" class="form-control">
                            <option value="">Semua Kategori</option>
                            @foreach(\App\Models\KategoriModel::all() as $kategori)
                            <option value="{{ $kategori->kategori_id }}">{{ $kategori->kategori_nama }}</option>
                            @endforeach
                        </select>
                    </div> --}}
                </div>
            </div>

            <table class="table table-bordered table-striped" id="tbl-penjualan">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>User</th>
                        <th>Pembeli</th>
                        <th>Penjualan Kode</th>
                        <th>tanggal</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="myModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
            var table = $('#tbl-penjualan').DataTable({
                serverSide: true,
                processing: true,
                ajax: {
                    url: "{{ url('penjualan/list') }}",
                    type: "POST",
                    data: function (d) {
                        d._token = "{{ csrf_token() }}";
                        d.kategori_id = $('#kategori_filter').val();
                    }
                },
                columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    searchable: false,
                    sortable: false
                },
                {
                    data: 'user.user_id',
                    name: 'user.user_id'
                },
                {
                    data: 'pembeli',
                    name: 'pembeli'
                },
                {
                    data: 'penjualan_kode',
                    name: 'penjualan_kode'
                },
                {
                    data: 'penjualan_tanggal',
                    name: 'penjualan_tanggal',

                },
                {
                        data: null,
                        name: 'aksi',
                        searchable: false,
                        sortable: false,
                        render: function (data, type, row) {
                            // Add the 'Detail' button
                            return '<button onclick="modalAction(\'{{ url("penjualan/show/' + row.penjualan_kode + '") }}\')" class="btn btn-info btn-sm"><i class="fa"></i> Detail</button>';
                        }
                    }
                ]
            });


        });
    </script>
@endpush