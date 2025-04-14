<div class="modal-header">
    <h5 class="modal-title" id="exampleModalLabel">Konfirmasi Hapus Kategori</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<div class="modal-body">
    <form id="form-delete" action="{{ url('kategori/' . $kategori->kategori_id . '/delete_ajax') }}" method="POST">
        @csrf
        @method('DELETE')
        <p>Apakah Anda yakin ingin menghapus kategori ini?</p>
        <div class="alert alert-warning">
            <h5>Detail Kategori:</h5>
            <p><strong>Kode:</strong> {{ $kategori->kategori_kode }}</p>
            <p><strong>Nama:</strong> {{ $kategori->kategori_nama }}</p>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
            <button id="btn-delete" type="submit" class="btn btn-danger">Hapus</button>
        </div>
    </form>
</div>

<script>
    $(document).ready(function () {
        $('#form-delete').on('submit', function (e) {
            e.preventDefault();

            $.ajax({
                url: $(this).attr('action'),
                type: 'DELETE',
                data: $(this).serialize(),
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
    });
</script>