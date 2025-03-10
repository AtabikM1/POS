@extends('layouts.template')

@section('content')
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title">{{ $page->title ?? 'Daftar Kategori' }}</h3>
            <a class="btn btn-sm btn-primary mt-1" href="{{ url('kategori/create') }}">TAMBAH</a>
        </div>
        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif
            <div class="row">
                <label class="col-1 control-label col-form-label">Filter:</label>
                <div class="col-3">
                    <select class="form-control" id="filter_kategori_id" name="filter_kategori_id">
                        <option value="">- Semua -</option>
                        @foreach ($kategori as $item)
                            <option value="{{ $item->kategori_id }}">{{ $item->kategori_nama }}</option>
                        @endforeach
                    </select>
                    <small class="form-text text-muted">Filter Kategori</small>
                </div>
            </div>
            <table class="table table-bordered table-striped table-hover table-sm" id="table_kategori">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Kode</th>
                        <th>Nama</th>
                        <th>AKSI</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
@endsection

@push('js')
    <script>
        $(document).ready(function () {
            var dataKategori = $('#table_kategori').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    "url": "{{ url('kategori/list') }}",
                    'type': 'GET',
                    'dataType': 'json',
                    "data": function (d) {
                        d.kategori_id = $('#filter_kategori_id').val();
                    }
                },
                columns: [
                    {
                        data: "DT_RowIndex",
                        className: 'text-center',
                        orderable: false,
                        searchable: false,
                    }, {
                        data: 'kategori_kode',
                        orderable: true,
                        searchable: true,
                    }, {
                        data: 'kategori_nama',
                        orderable: true,
                        searchable: true,
                    }, {
                        data: 'aksi',
                        className: "text-center",
                        orderable: false,
                        searchable: false,
                    }
                ]
            });

            $('#filter_kategori_id').on('change', function () {
                dataKategori.ajax.reload();
            });
        });
    </script>
@endpush