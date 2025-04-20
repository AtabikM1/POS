<form id="formDetailPenjualan">
    @csrf
    <input type="hidden" name="penjualan_id" value="{{ $penjualan->penjualan_id }}">

    <div class="mb-3">
        <label for="barang_id" class="form-label">Pilih Barang</label>
        <select class="form-control" name="barang_id" id="barang_id">
            <option value="">-- Pilih Barang --</option>
            @foreach ($barang as $b)
                <option value="{{ $b->barang_id }}">{{ $b->barang_nama }}</option>
            @endforeach
        </select>
        <div class="text-danger error-field" id="error-barang_id"></div>
    </div>

    <div class="mb-3">
        <label for="harga" class="form-label">Harga</label>
        <input type="number" class="form-control" name="harga" id="harga">
        <div class="text-danger error-field" id="error-harga"></div>
    </div>

    <div class="mb-3">
        <label for="jumlah" class="form-label">Jumlah</label>
        <input type="number" class="form-control" name="jumlah" id="jumlah" min="1">
        <div class="text-danger error-field" id="error-jumlah"></div>
    </div>

    <div class="text-end">
        <button type="submit" class="btn btn-primary">Simpan Detail</button>
    </div>
</form>

<script>
    $('#formDetailPenjualan').submit(function (e) {
        e.preventDefault();

        $.ajax({
            url: "{{ url('/penjualan/' + penjualan_id + '/create_detail_ajax') }}",
            method: "POST",
            data: $(this).serialize(),
            success: function (res) {
                if (res.status) {
                    Swal.fire('Berhasil!', res.message, 'success');
                    $('#modal-detail').modal('hide');
                    // Bisa reload table atau lanjut tambah detail lain
                } else {
                    if (res.msgField) {
                        $.each(res.msgField, function (key, val) {
                            $('#error-' + key).text(val[0]);
                        });
                    } else {
                        Swal.fire('Gagal!', res.message, 'error');
                    }
                }
            }
        });
    });

</script>