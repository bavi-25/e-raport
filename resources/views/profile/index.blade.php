@extends('layouts.admin')
@section('title', 'E-Raport | Profile')

@section('content')

<div class="row">
    <!-- Profile Card -->
    <div class="col-md-4">
        <div class="card card-primary card-outline">
            <div class="card-body box-profile">
                {{-- <div class="text-center">
                    <img class="profile-user-img img-fluid img-circle" src="{{ asset('dist/img/user4-128x128.jpg') }}"
                        alt="User profile picture">
                </div> --}}

                <h3 class="profile-username text-center">{{ $profile->name ?? $user->name }}</h3>
                <p class="text-muted text-center">{{ $roles }}</p>

                <ul class="list-group list-group-unbordered mb-3">
                    <li class="list-group-item">
                        <b>ID Number</b>
                        <a class="float-right">{{ $profile->nip_nis ?? '-' }}</a>
                    </li>
                    <li class="list-group-item">
                        <b>Status</b>
                        <a class="float-right">
                            <span class="badge badge-success">Active</span>
                        </a>
                    </li>
                    <li class="list-group-item">
                        <b>Member Since</b>
                        <a class="float-right">{{ $memberSince }}</a>
                    </li>
                </ul>

                <button type="button" class="btn btn-warning btn-block" data-toggle="modal"
                    data-target="#changePasswordModal">
                    <i class="fas fa-key"></i> <b>Change Password</b>
                </button>
            </div>
        </div>
    </div>

    <!-- Profile Details -->
    <div class="col-md-8">
        <div class="card card-primary card-outline">
            <div class="card-header">
                <h3 class="card-title"><i class="fas fa-user-circle"></i> Profile Information</h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label><i class="fas fa-envelope"></i> Email Address</label>
                            <p class="form-control-static">{{ $user->email }}</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label><i class="fas fa-phone"></i> Phone Number</label>
                            <p class="form-control-static">{{ $profile->phone ?? '-' }}</p>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label><i class="fas fa-birthday-cake"></i> Birth Date</label>
                            <p class="form-control-static">
                                {{ $profile->birth_date ? \Carbon\Carbon::parse($profile->birth_date)->format('d F Y') : '-' }}
                            </p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label><i class="fas fa-venus-mars"></i> Gender</label>
                            <p class="form-control-static">{{ $profile->gender ? ucfirst($profile->gender) : '-' }}</p>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label><i class="fas fa-praying-hands"></i> Religion</label>
                            <p class="form-control-static">{{ $profile->religion ?? '-' }}</p>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label><i class="fas fa-map-marker-alt"></i> Address</label>
                    <p class="form-control-static">{{ $profile->address ?? '-' }}</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Change Password Modal -->
<div class="modal fade" id="changePasswordModal" tabindex="-1" role="dialog" aria-labelledby="changePasswordModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="{{ route('profile.change-password') }}" method="POST" id="changePasswordForm">
                @csrf
                <div class="modal-header bg-warning">
                    <h5 class="modal-title" id="changePasswordModalLabel">
                        <i class="fas fa-key"></i> Change Password
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="current_password">Current Password <span class="text-danger">*</span></label>
                        <input type="password" class="form-control @error('current_password') is-invalid @enderror"
                            id="current_password" name="current_password" required>
                        @error('current_password')
                        <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="new_password">New Password <span class="text-danger">*</span></label>
                        <input type="password" class="form-control @error('new_password') is-invalid @enderror"
                            id="new_password" name="new_password" required minlength="8">
                        <small class="form-text text-muted">Minimum 8 characters</small>
                        @error('new_password')
                        <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="new_password_confirmation">Confirm New Password <span
                                class="text-danger">*</span></label>
                        <input type="password" class="form-control" id="new_password_confirmation"
                            name="new_password_confirmation" required minlength="8">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-warning">
                        <i class="fas fa-save"></i> Change Password
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@push('styles')
<style>
    .form-control-static {
        padding: 7px 0;
        font-weight: 500;
        color: #333;
    }

    .form-group label {
        font-weight: 600;
        color: #666;
        margin-bottom: 5px;
    }

    .form-group label i {
        margin-right: 5px;
        color: #007bff;
    }
</style>
@endpush

@push('scripts')
<script>
    $(document).ready(function() {
        @if($errors->any())
            $('#changePasswordModal').modal('show');
        @endif
    });
</script>
@endpush