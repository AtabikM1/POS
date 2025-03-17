<div class="modal-header">
    <h5 class="modal-title" id="exampleModalLabel">Detail Kategori</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<div class="modal-body">
    <table class="table table-bordered">
        <tr>
            <th style="width: 30%">ID</th>
            <td>{{ $kategori->kategori_id }}</td>
        </tr>
        <tr>
            <th>Kode Kategori</th>
            <td>{{ $kategori->kategori_kode }}</td>
        </tr>
        <tr>
            <th>Nama Kategori</th>
            <td>{{ $kategori->kategori_nama }}</td>
        </tr>
        <tr>
            <th>Tanggal Dibuat</th>
            <td>{{ $kategori->created_at }}</td>
        </tr>
        <tr>
            <th>Terakhir Diupdate</th>
            <td>{{ $kategori->updated_at }}</td>
        </tr>
    </table>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
</div>