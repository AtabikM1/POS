<div class="modal-header">
    <h5 class="modal-title" id="exampleModalLabel">Edit Barang</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<div class="modal-body">
    <form id="form-barang">
        @csrf
        <div class="form-group">
            <label for="kategori_id">Kategori</label>
            <select class="form-control" id="kategori_id" name="kategori_id">
                <option value="">- Pilih Kategori -</option>
                @foreach($kategori as $k)
                    <option value="{{ $k->kategori_id }}" {{ ($k->kategori_id == $barang->kategori_id) ? 'selected' : '' }}>
                        {{ $k->kategori_nama }}
                    </option>
                @endforeach
            </select>
            <small class="text-danger" id="error-kategori_id"></small>
        </div>
        <div class="form-group">
            <label for="barang_kode">Kode Barang</label>
            <input type="text" class="form-control" id="barang_kode" name="barang_kode"
                value="{{ $barang->barang_kode }}" placeholder="Masukkan kode barang">
            <small class="text-danger" id="error-barang_kode"></small>
        </div>
        <div class="form-group">
            <label for="barang_nama">Nama Barang</label>
            <input type="text" class="form-control" id="barang_nama" name="barang_nama"
                value="{{ $barang->barang_nama }}" placeholder="Masukkan nama barang">
            <small class="text-danger" id="error-barang_nama"></small>
        </div>
        <div class="form-group">
            <label for="harga_beli">Harga Beli</label>
            <input type="number" class="form-control" id="harga_beli" name="harga_beli"
                value="{{ $barang->harga_beli }}" placeholder="Masukkan harga beli">
            <small class="text-danger" id="error-harga_beli"></small>
        </div>
        <div class="form-group">
            <label for="harga_jual">Harga Jual</label>
            <input type="number" class="form-control" id="harga_jual" name="harga_jual"
                value="{{ $barang->harga_jual }}" placeholder="Masukkan harga jual">
            <small class="text-danger" id="error-harga_jual"></small>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button id="btn-submit-barang" type="submit" class="btn btn-primary">Update</button>
        </div>
    </form>
</div>

<script>
    $(document).ready(function () {
        $('#form-barang').on('submit', function (e) {
            e.preventDefault();

            $.ajax({
                url: "{{ url('barang/' . $barang->barang_id . '/update_ajax') }}",
                method: "PUT",
                data: $('#form-barang').serialize(),
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
                            $('#tbl-barang').DataTable().ajax.reload();
                        });
                    } else {
                        if (response.msgField) {
                            resetErrorField();
                            $.each(response.msgField, function (index, value) {
                                $('#error-' + index).text(value);
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
                    console.error(xhr.responseText);
                    Swal.fire({
                        title: 'Error!',
                        text: 'Terjadi kesalahan saat mengupdate data',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                }
            });
        });

        function resetErrorField() {
            $('#error-kategori_id').text('');
            $('#error-barang_kode').text('');
            $('#error-barang_nama').text('');
            $('#error-harga_beli').text('');
            $('#error-harga_jual').text('');
        }
    });
</script>