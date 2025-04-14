<div class="modal-header">
    <h5 class="modal-title" id="exampleModalLabel">Tambah Level</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<div class="modal-body">
    <form id="form-level">
        @csrf
        <div class="form-group">
            <label for="level_kode">Kode Level</label>
            <input type="text" class="form-control" id="level_kode" name="level_kode" placeholder="Masukkan kode level">
            <small class="text-danger" id="error-level_kode"></small>
        </div>
        <div class="form-group">
            <label for="level_nama">Nama Level</label>
            <input type="text" class="form-control" id="level_nama" name="level_nama" placeholder="Masukkan nama level">
            <small class="text-danger" id="error-level_nama"></small>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button id="btn-submit-level" type="submit" class="btn btn-primary">Simpan</button>
        </div>
    </form>
</div>

<script>
    $(document).ready(function () {
        $('#form-level').on('submit', function (e) {
            e.preventDefault();

            $.ajax({
                url: "{{ url('level/ajax') }}",
                method: "POST",
                data: $('#form-level').serialize(),
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
                            $('#tbl-level').DataTable().ajax.reload();
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
            $('#error-level_kode').text('');
            $('#error-level_nama').text('');
        }
    });
</script>