<div class="modal-header">
    <h5 class="modal-title" id="exampleModalLabel">Detail Level</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<div class="modal-body">
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
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
</div>