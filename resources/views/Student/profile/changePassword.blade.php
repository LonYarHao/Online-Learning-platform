@extends('Student.Layouts.master')

@section('content')
    <div class="container-fluid py-5">
        <div class="row justify-content-center">
            <div class="col-xl-4 col-lg-5 col-md-7">

                <div class="mb-3">
                    <a href="{{ route('student#dashboard') }}" class="text-decoration-none text-muted small fw-bold">
                        <i class="fa-solid fa-arrow-left me-1"></i> Back to Dashboard
                    </a>
                </div>

                <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                    <div class="card-header bg-white border-bottom border-light py-4 px-4">
                        <div class="d-flex align-items-center">
                            <div class="bg-primary bg-opacity-10 rounded-3 p-2 me-3">
                                <i class="fa-solid fa-shield-keyhole text-primary fs-5"></i>
                            </div>
                            <h5 class="mb-0 fw-bold text-dark">Change Password</h5>
                        </div>
                    </div>

                    <div class="card-body p-4">
                        <form action="{{ route('student#changePassword') }}" method="POST">
                            @csrf

                            @if (Auth::user()->password)
                                <div class="mb-3">
                                    <label class="form-label small fw-bold text-muted">Current Password</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-0"><i
                                                class="fa-solid fa-lock-open text-muted"></i></span>
                                        <input type="password" name="oldPassword"
                                            class="form-control bg-light border-0 py-2 @error('oldPassword') is-invalid @enderror"
                                            placeholder="Enter current password">
                                    </div>
                                    @error('oldPassword')
                                        <small class="text-danger small ms-1">{{ $message }}</small>
                                    @enderror
                                </div>
                            @else
                                <div class="alert alert-primary border-0 rounded-4 py-3 mb-4">
                                    <div class="d-flex">
                                        <i class="fa-solid fa-circle-info mt-1 me-3"></i>
                                        <div>
                                            <h6 class="fw-bold mb-1">Social Account Detected</h6>
                                            <p class="small mb-0 opacity-75">You haven't set a password yet. Create one
                                                below to enable direct email login.</p>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            <hr class="my-4 text-muted opacity-25">

                            <div class="mb-3">
                                <label class="form-label small fw-bold text-muted">New Password</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-0"><i
                                            class="fa-solid fa-lock text-muted"></i></span>
                                    <input type="password" name="newPassword"
                                        class="form-control bg-light border-0 py-2 @error('newPassword') is-invalid @enderror"
                                        placeholder="Min. 8 characters">
                                </div>
                                @error('newPassword')
                                    <small class="text-danger small ms-1">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label class="form-label small fw-bold text-muted">Repeat New Password</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-0"><i
                                            class="fa-solid fa-user-check text-muted"></i></span>
                                    <input type="password" name="confirmPassword"
                                        class="form-control bg-light border-0 py-2 @error('confirmPassword') is-invalid @enderror"
                                        placeholder="Confirm new password">
                                </div>
                                @error('confirmPassword')
                                    <small class="text-danger small ms-1">{{ $message }}</small>
                                @enderror
                            </div>

                            <button type="submit" class="btn btn-primary w-100 py-2 rounded-3 fw-bold shadow-sm">
                                {{ Auth::user()->password ? 'Update Password' : 'Set Account Password' }}
                            </button>
                        </form>
                    </div>
                </div>

                <p class="text-center text-muted small mt-4">
                    Forgot your current password? <br>
                    <span class="text-primary fw-semibold">Contact your administrator</span>
                </p>
            </div>
        </div>
    </div>

    <style>
        .bg-light {
            background-color: #f8f9fa !important;
        }

        .input-group-text {
            border-top-left-radius: 0.5rem !important;
            border-bottom-left-radius: 0.5rem !important;
            min-width: 45px;
            justify-content: center;
        }

        .form-control {
            border-top-right-radius: 0.5rem !important;
            border-bottom-right-radius: 0.5rem !important;
        }

        .form-control:focus {
            background-color: #fff !important;
            box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.08);
        }
    </style>
@endsection
