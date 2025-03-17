@extends('layouts.template')

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Data Level</h3>
            <div class="card-tools">
                <button onclick="modalAction('{{ url('/level/create_ajax') }}')" class="btn btn-primary btn-sm">Tambah
                    Level</button>
            </div>
        </div>
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <table class="table table-bordered table-striped" id="tbl-level">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Kode Level</th>
                        <th>Nama Level</th>
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

            </div>
        </div>
    </div>
@endsection

@push('js')
    <script>
        $(document).ready(function () {
            $('#tbl-level').DataTable({
                serverSide: true,
                processing: true,
                ajax: {
                    url: "{{ url('level/list') }}",
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
                    data: 'level_kode',
                    name: 'level_kode'
                },
                {
                    data: 'level_nama',
                    name: 'level_nama'
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                }
                ]
            });
        });

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
    </script>
@endpush