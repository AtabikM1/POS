@extends('layouts.template')

@section('content')
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title">{{ $page->title ?? 'Daftar Level' }}</h3>
            <a class="btn btn-sm btn-primary mt-1" href="{{ url('level/create') }}">TAMBAH</a>
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
                    <select class="form-control" id="filter_level_id" name="filter_level_id">
                        <option value="">- Semua -</option>
                        @foreach ($levels as $item)
                            <option value="{{ $item->id }}">{{ $item->nama_level }}</option>
                        @endforeach
                    </select>
                    <small class="form-text text-muted">Filter Level</small>
                </div>
            </div>
            <table class="table table-bordered table-striped table-hover table-sm" id="table_level">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Kode</th>
                        <th>Nama</th>
                        <th>AKSI</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
@endsection

@push('css')
@endpush

@push('js')
    <script>
        $(document).ready(function () {
            var dataLevel = $('#table_level').DataTable({
                serverSide: true,
                ajax: {
                    "url": "{{ url('level/list') }}",
                    'dataType': 'json',
                    'type': 'POST',
                    'headers': {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    "data": function (d) {
                        d.level_id = $('#filter_level_id').val();
                    }
                },
                columns: [
                    {
                        data: "DT_RowIndex",
                        className: 'text-center',
                        orderable: false,
                        searchable: false,
                    }, {
                        data: 'level_kode',
                        className: "",
                        orderable: true,
                        searchable: true,
                    }, {
                        data: 'level_nama',
                        className: "",
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

            $('#filter_level_id').on('change', function () {
                dataLevel.ajax.reload();
            });
        });
    </script>
@endpush