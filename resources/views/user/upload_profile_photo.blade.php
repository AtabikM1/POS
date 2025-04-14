<div class="modal-header">
    <h4 class="modal-title">Upload Foto Profil</h4>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<div class="modal-body">
    <form id="formUploadProfilePhoto" enctype="multipart/form-data">
        <div class="form-group">
            <label for="profile_photo">Pilih Foto</label>
            <div class="input-group">
                <div class="custom-file">
                    <input type="file" class="custom-file-input" id="profile_photo" name="profile_photo"
                        accept="image/*">
                    <label class="custom-file-label" for="profile_photo">Pilih file</label>
                </div>
            </div>
            <small class="text-muted">Format: JPG, JPEG, PNG. Maksimal 2MB</small>
            <div class="invalid-feedback" id="error-profile_photo"></div>
        </div>

        <div class="form-group mt-3">
            <div id="imagePreview" class="text-center d-none">
                <img id="previewImg" src="" class="img-fluid img-circle"
                    style="max-height: 200px; max-width: 200px; border: 3px solid #fff;">
            </div>
        </div>
    </form>
</div>
<div class="modal-footer justify-content-between">
    <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
    <button type="button" class="btn btn-primary" id="btnSavePhoto">Simpan</button>
</div>

<script>
    $(function () {
        $('#profile_photo').on('change', function () {
            const file = this.files[0];
            if (file) {
                let reader = new FileReader();
                reader.onload = function (event) {
                    $('#previewImg').attr('src', event.target.result);
                    $('#imagePreview').removeClass('d-none');
                }
                reader.readAsDataURL(file);
                $(this).next('.custom-file-label').html(file.name);
            }
        });

        $('#btnSavePhoto').on('click', function () {
            const formData = new FormData();
            const photoFile = $('#profile_photo')[0].files[0];

            if (!photoFile) {
                $('#error-profile_photo').text('Silakan pilih file foto terlebih dahulu').show();
                return;
            }

            formData.append('profile_photo', photoFile);
            formData.append('_token', '{{ csrf_token() }}');

            $.ajax({
                url: '{{ url('/user/update-profile-photo') }}',
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                dataType: 'json',
                success: function (response) {
                    if (response.status) {
                        // Update only the profile image
                        $('.profile-user-img').attr('src', response.photoUrl);

                        // Close the modal
                        $('#modalAction').modal('hide');

                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            text: response.message
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal',
                            text: response.message
                        });

                        if (response.msgField && response.msgField.profile_photo) {
                            $('#error-profile_photo').text(response.msgField.profile_photo).show();
                        }
                    }
                },
                error: function (xhr, status, error) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Terjadi kesalahan pada server. Silakan coba lagi nanti.'
                    });
                }
            });
        });
    });
</script>