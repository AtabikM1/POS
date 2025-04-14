@extends('layouts.template')

@section('content')

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-primary card-outline shadow-lg"
                    style="border-top: 3px solid #007bff; background: linear-gradient(to right, #f8f9fa, #ffffff);">
                    <div class="card-body box-profile py-3">
                        <div class="row">
                            <div class="col-md-3 text-center d-flex align-items-center justify-content-center">
                                @if(auth()->check() && auth()->user()->profile_photo)
                                    <img class="profile-user-img img-fluid img-circle shadow"
                                        src="{{ asset(auth()->user()->profile_photo) }}" alt="User profile picture"
                                        style="width: 150px; height: 150px; border: 3px solid #fff; object-fit: cover;">
                                @else
                                    <img class="profile-user-img img-fluid img-circle shadow"
                                        src="{{ asset('adminlte/dist/img/default-user.png') }}" alt="User profile picture"
                                        style="width: 150px; height: 150px; border: 3px solid #fff;">
                                @endif
                            </div>

                            <div class="col-md-9">
                                <h3 class="profile-username mb-1">Admin POS</h3>
                                <p class="text-muted mb-3"><i class="fas fa-user-shield mr-1"></i> Administrator Sistem</p>

                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <strong><i class="fas fa-user text-primary mr-1"></i> Username</strong>
                                        <p class="text-muted mb-0">
                                            {{ auth()->check() ? auth()->user()->username : 'Tidak tersedia' }}
                                        </p>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <strong><i class="fas fa-calendar text-primary mr-1"></i> Bergabung</strong>
                                        <p class="text-muted mb-0">{{ date('d F Y') }}</p>
                                    </div>
                                </div>

                                <div class="mt-3">
                                    <button onclick="editProfilePhoto()" class="btn btn-primary btn-sm px-4 shadow-sm">
                                        <i class="fas fa-user-edit mr-1"></i> Edit Profil
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="modalAction" tabindex="-1" role="dialog" aria-labelledby="modalActionTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content" id="modalActionContent">
                <!-- Content will be loaded dynamically -->
            </div>
        </div>
    </div>

@endsection

@push('js')
    <script>
        function editProfilePhoto() {
            window.location.href = '{{ route("profile.photo.edit") }}';
        }
    </script>
@endpush