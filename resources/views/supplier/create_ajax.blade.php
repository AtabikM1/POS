<div class="modal-header">
    <h5 class="modal-title" id="exampleModalLabel">Tambah Supplier</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<div class="modal-body">
    <form id="form-supplier">
        @csrf
        <div class="form-group">
            <label for="supplier_kode">Kode Supplier</label>
            <input type="text" class="form-control" id="supplier_kode" name="supplier_kode"
                placeholder="Masukkan kode supplier">
            <small class="text-danger" id="error-supplier_kode"></small>
        </div>
        <div class="form-group">
            <label for="supplier_nama">Nama Supplier</label>
            <input type="text" class="form-control" id="supplier_nama" name="supplier_nama"
                placeholder="Masukkan nama supplier">
            <small class="text-danger" id="error-supplier_nama"></small>
        </div>
        <div class="form-group">
            <label for="supplier_alamat">Alamat Supplier</label>
            <input type="text" class="form-control" id="supplier_alamat" name="supplier_alamat"
                placeholder="Masukkan alamat supplier">
            <small class="text-danger" id="error-supplier_alamat"></small>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button id="btn-submit-supplier" type="submit" class="btn btn-primary">Simpan</button>
        </div>
    </form>
</div>

<script>
    $(document).ready(function () {
        $('#form-supplier').on('submit', function (e) {
            e.preventDefault();

            $.ajax({
                url: "{{ url('supplier/ajax') }}",
                method: "POST",
                data: $('#form-supplier').serialize(),
                dataType: 'json',
                success: function (response) {
                    if (response.status) {
                        Swal.fire({
                            title: 'Sukses!',
                            text: response.message,
                            icon: 'success',
                            confirmButtonText: 'OK'
                        }).then((result) => {
                            $('#myModal').modal('hide');
                            $('#tbl-supplier').DataTable().ajax.reload();
                        });
                    } else {
                        if (response.msgField) {
                            resetErrorField();
                            $.each(response.msgField, function (field, message) {
                                $('#error-' + field).text(message[0]);
                            });
                        }
                        Swal.fire({
                            title: 'Gagal!',
                            text: response.message,
                            icon: 'error',
                            confirmButtonText: 'OK'
                        });
                    }
                },
                error: function (xhr, status, error) {
                    console.error(error);
                    Swal.fire({
                        title: 'Error!',
                        text: 'Terjadi kesalahan saat memproses permintaan.',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                }
            });
        });

        function resetErrorField() {
            $('#error-supplier_kode').text('');
            $('#error-supplier_nama').text('');
            $('#error-supplier_alamat').text('');
        }
    });
</script>