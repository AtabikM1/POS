<div class="modal-header">
    <h5 class="modal-title" id="exampleModalLabel">Detail Supplier</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<div class="modal-body">
    <table class="table table-bordered">
        <tr>
            <th style="width: 200px">ID</th>
            <td>{{ $supplier->supplier_id }}</td>
        </tr>
        <tr>
            <th>Kode Supplier</th>
            <td>{{ $supplier->supplier_kode }}</td>
        </tr>
        <tr>
            <th>Nama Supplier</th>
            <td>{{ $supplier->supplier_nama }}</td>
        </tr>
        <tr>
            <th>Alamat</th>
            <td>{{ $supplier->supplier_alamat }}</td>
        </tr>
        <tr>
            <th>Tanggal Dibuat</th>
            <td>{{ $supplier->created_at }}</td>
        </tr>
        <tr>
            <th>Terakhir Diupdate</th>
            <td>{{ $supplier->updated_at }}</td>
        </tr>
    </table>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
    </div>
</div>