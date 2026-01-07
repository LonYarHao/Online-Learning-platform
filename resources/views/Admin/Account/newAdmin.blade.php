@extends('layouts.master')

@section('content')
    <div class="container-fluid py-5">
        <div class="row justify-content-center">
            <div class="col-xl-4 col-lg-5 col-md-7">

                <div class="mb-3">
                    <a href="{{ route('account#adminList') }}" class="text-decoration-none text-muted small fw-bold">
                        <i class="fa-solid fa-arrow-left me-1"></i> Back to Admin List
                    </a>
                </div>

                <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                    <div class="bg-primary bg-gradient text-white px-4 py-4">
                        <div class="d-flex align-items-center">
                            <div class="bg-white bg-opacity-20 rounded-circle p-2 me-3">
                                <i class="fa-solid fa-user-shield fs-4"></i>
                            </div>
                            <div>
                                <h5 class="mb-0 fw-bold">New Admin Account</h5>
                                <p class="mb-0 small opacity-75">Fill in the details to create a system administrator.</p>
                            </div>
                        </div>
                    </div>

                    <form action="{{ route('account#createAdmin') }}" method="post">
                        @csrf
                        <div class="card-body p-4">

                            <div class="mb-3">
                                <label class="form-label small fw-bold text-muted">Full Name</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-0"><i
                                            class="fa-solid fa-user text-muted"></i></span>
                                    <input type="text" name="name" value="{{ old('name') }}"
                                        class="form-control bg-light border-0 @error('name') is-invalid @enderror"
                                        placeholder="e.g. John Doe">
                                </div>
                                @error('name')
                                    <small class="text-danger small ms-1">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label small fw-bold text-muted">Email Address</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-0"><i
                                            class="fa-solid fa-envelope text-muted"></i></span>
                                    <input type="email" name="email" value="{{ old('email') }}"
                                        class="form-control bg-light border-0 @error('email') is-invalid @enderror"
                                        placeholder="john@example.com">
                                </div>
                                @error('email')
                                    <small class="text-danger small ms-1">{{ $message }}</small>
                                @enderror
                            </div>

                            <hr class="my-4 text-muted opacity-25">

                            <div class="mb-3">
                                <label class="form-label small fw-bold text-muted">Password</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-0"><i
                                            class="fa-solid fa-lock text-muted"></i></span>
                                    <input type="password" name="password"
                                        class="form-control bg-light border-0 @error('password') is-invalid @enderror"
                                        placeholder="Min. 8 characters">
                                </div>
                                @error('password')
                                    <small class="text-danger small ms-1">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label class="form-label small fw-bold text-muted">Confirm Password</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-0"><i
                                            class="fa-solid fa-shield-check text-muted"></i></span>
                                    <input type="password" name="confirmPassword"
                                        class="form-control bg-light border-0 @error('confirmPassword') is-invalid @enderror"
                                        placeholder="Repeat password">
                                </div>
                                @error('confirmPassword')
                                    <small class="text-danger small ms-1">{{ $message }}</small>
                                @enderror
                            </div>

                            <button type="submit" class="btn btn-primary w-100 rounded-3 shadow-sm py-2 fw-bold mb-2">
                                <i class="fa-solid fa-user-plus me-2"></i> Create Admin Account
                            </button>

                            <p class="text-center text-muted extra-small mb-0">
                                The user will be able to log in immediately after creation.
                            </p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <style>
        .extra-small {
            font-size: 0.75rem;
        }

        .input-group-text {
            border-top-left-radius: 0.5rem !important;
            border-bottom-left-radius: 0.5rem !important;
        }

        .form-control {
            border-top-right-radius: 0.5rem !important;
            border-bottom-right-radius: 0.5rem !important;
        }
    </style>
@endsection
