<div class="modal-header">
    <h5 class="modal-title" id="exampleModalLabel">Tambah Stok</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>

<div class="modal-body">
    <form id="form-stok">
        @csrf

        <div class="form-group">
            <label for="supplier_id">Supplier</label>
            <select class="form-control" id="supplier_id" name="supplier_id">
                <option value="">- Pilih supplier -</option>
                @foreach($supplier as $k)
                    <option value="{{ $k->supplier_id }}">{{ $k->supplier_nama }}</option>
                @endforeach
            </select>
            <small class="text-danger" id="error-supplier_id"></small>
        </div>

        <div class="form-group">
            <label for="barang_id">Barang</label>
            <select class="form-control" id="barang_id" name="barang_id">
                <option value="">- Pilih barang -</option>
                @foreach($barang as $k)
                    <option value="{{ $k->barang_id }}">{{ $k->barang_nama }}</option>
                @endforeach
            </select>
            <small class="text-danger" id="error-barang_id"></small>
        </div>

        <div class="form-group">
            <label for="user_id">User</label>
            <select class="form-control" id="user_id" name="user_id">
                <option value="">- Pilih user -</option>
                @foreach($user as $k)
                    <option value="{{ $k->user_id }}">{{ $k->username }}</option>
                    {{ json_encode($k) }} {{-- debug --}}
                @endforeach
            </select>
            <small class="text-danger" id="error-user_id"></small>
        </div>

        <div class="form-group">
            <label for="stok_tanggal">Tanggal Stok</label>
            <input type="date" class="form-control" id="stok_tanggal" name="stok_tanggal" placeholder="Pilih Tanggal">
            <small class="text-danger" id="error-stok_tanggal"></small>
        </div>

        <div class="form-group">
            <label for="stok_jumlah">Jumlah Stok</label>
            <input type="number" class="form-control" id="stok_jumlah" name="stok_jumlah" placeholder="Masukkan Jumlah">
            <small class="text-danger" id="error-stok_jumlah"></small>
        </div>

        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            <button id="btn-submit-stok" type="submit" class="btn btn-primary">Simpan</button>
        </div>
    </form>
</div>

<script>
    $(document).ready(function () {
        $('#form-stok').on('submit', function (e) {
            e.preventDefault();

            $.ajax({
                url: "{{ url('stok/ajax') }}",
                method: "POST",
                data: $('#form-stok').serialize(),
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
                            $('#tbl-stok').DataTable().ajax.reload();
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
                        text: 'Terjadi kesalahan saat menyimpan data',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                }
            });
        });

        function resetErrorField() {
            $('#error-kategori_id').text('');
            $('#error-stok_kode').text('');
            $('#error-stok_nama').text('');
            $('#error-harga_beli').text('');
            $('#error-harga_jual').text('');
        }
    });
</script>