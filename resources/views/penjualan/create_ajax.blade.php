<div class="modal-header">
    <h5 class="modal-title">Tambah Penjualan</h5>
    <button type="button" class="close" data-dismiss="modal">
        <span>&times;</span>
    </button>
</div>

<div class="modal-body">
    <form id="form-penjualan">
        @csrf

        {{-- User --}}
        <div class="form-group">
            <label for="user_id">User</label>
            <select class="form-control" id="user_id" name="user_id">
                <option value="">- Pilih user -</option>
                @foreach($user as $u)
                    <option value="{{ $u->user_id }}">{{ $u->username }}</option>
                @endforeach
            </select>
            <small class="text-danger" id="error-user_id"></small>
        </div>

        {{-- Nama Pembeli --}}
        <div class="form-group">
            <label for="pembeli">Nama Pembeli</label>
            <input type="text" class="form-control" name="pembeli" id="pembeli" placeholder="Masukkan nama pembeli">
            <small class="text-danger" id="error-pembeli"></small>
        </div>
        <div class="form-group">
            <label for="pembeli">Penjualan Kode</label>
            <input type="text" class="form-control" name="penjualan_kode" id="penjualan_kode"
                placeholder="Masukkan nama penjualan_kode">
            <small class="text-danger" id="error-penjualan_kode"></small>
        </div>

        {{-- Tanggal Penjualan --}}
        <div class="form-group">
            <label for="penjualan_tanggal">Tanggal Penjualan</label>
            <input type="date" class="form-control" id="penjualan_tanggal" name="penjualan_tanggal">
            <small class="text-danger" id="error-penjualan_tanggal"></small>
        </div>

        {{-- Modal Footer --}}
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            <button type="submit" class="btn btn-primary">Simpan</button>
        </div>
    </form>
</div>

<script>
    $(document).ready(function () {
        $('#form-penjualan').on('submit', function (e) {
            e.preventDefault();

            $.ajax({
                url: "{{ url('penjualan/ajax') }}",
                method: "POST",
                data: $(this).serialize(),
                dataType: 'json',
                success: function (response) {
                    resetErrorField();

                    if (response.status) {
                        Swal.fire({
                            title: 'Sukses!',
                            text: response.message,
                            icon: 'success',
                            confirmButtonText: 'OK'
                        }).then(() => {
                            $('#myModal').modal('hide');
                            $('#tbl-penjualan').DataTable().ajax.reload();

                            // Menampilkan modal input detail penjualan setelah penjualan utama disimpan
                            modalAction('/penjualan/' + response.penjualan_id + '/create_detail_ajax');
                        });
                    } else {
                        if (response.msgField) {
                            $.each(response.msgField, function (index, value) {
                                $('#error-' + index).text(value[0]);
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
                error: function (xhr) {
                    console.error(xhr.responseText);
                    Swal.fire({
                        title: 'Error!',
                        text: 'Terjadi kesalahan saat menyimpan data.',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                }
            });
        });

        function resetErrorField() {
            $('#error-user_id').text('');
            $('#error-pembeli').text('');
            $('#error-penjualan_tanggal').text('');
        }
    });

</script>