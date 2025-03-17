<div class="modal-header">
    <h5 class="modal-title" id="exampleModalLabel">Edit Kategori</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<div class="modal-body">
    <form id="form-kategori">
        @csrf
        <div class="form-group">
            <label for="kategori_kode">Kode Kategori</label>
            <input type="text" class="form-control" id="kategori_kode" name="kategori_kode"
                value="{{ $kategori->kategori_kode }}" placeholder="Masukkan kode kategori">
            <small class="text-danger" id="error-kategori_kode"></small>
        </div>
        <div class="form-group">
            <label for="kategori_nama">Nama Kategori</label>
            <input type="text" class="form-control" id="kategori_nama" name="kategori_nama"
                value="{{ $kategori->kategori_nama }}" placeholder="Masukkan nama kategori">
            <small class="text-danger" id="error-kategori_nama"></small>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button id="btn-submit-kategori" type="submit" class="btn btn-primary">Update</button>
        </div>
    </form>
</div>

<script>
    $(document).ready(function () {
        $('#form-kategori').on('submit', function (e) {
            e.preventDefault();

            $.ajax({
                url: "{{ url('kategori/' . $kategori->kategori_id . '/update_ajax') }}",
                method: "PUT",
                data: $('#form-kategori').serialize(),
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
                            $('#tbl-kategori').DataTable().ajax.reload();
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
                }
            });
        });

        function resetErrorField() {
            $('#error-kategori_kode').text('');
            $('#error-kategori_nama').text('');
        }
    });
</script>