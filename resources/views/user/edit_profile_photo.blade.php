@extends('layouts.template')

@section('content')
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title">{{ $page->title }}</h3>
        </div>
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <h5><i class="icon fas fa-check"></i> Berhasil!</h5>
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <h5><i class="icon fas fa-ban"></i> Error!</h5>
                    {{ session('error') }}
                </div>
            @endif

            <div class="row">
                <div class="col-md-6">
                    <form action="{{ route('profile.photo.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="profile_photo">Pilih Foto Profil Baru</label>
                            <div class="input-group">
                                <div class="custom-file">
                                    <input type="file"
                                        class="custom-file-input @error('profile_photo') is-invalid @enderror"
                                        id="profile_photo" name="profile_photo" accept="image/*">
                                    <label class="custom-file-label" for="profile_photo">Pilih file</label>
                                </div>
                            </div>
                            <small class="text-muted">Format: JPG, JPEG, PNG. Maksimal 2MB</small>
                            @error('profile_photo')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group mt-3">
                            <div id="imagePreview" class="d-none text-center">
                                <img id="previewImg" src="" class="img-fluid img-circle"
                                    style="max-height: 200px; max-width: 200px; border: 3px solid #fff;">
                            </div>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Simpan Foto</button>
                            <a href="{{ url('/') }}" class="btn btn-default ml-1">Kembali</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('css')
@endpush

@push('js')
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
        });
    </script>
@endpush