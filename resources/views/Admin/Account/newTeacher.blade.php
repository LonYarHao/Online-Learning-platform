@extends('layouts.master')

@section('content')
    <div class="container-fluid py-5">
        <div class="row justify-content-center">
            <div class="col-xl-4 col-lg-5 col-md-7">

                <div class="mb-3">
                    <a href="{{ route('account#teacherList') }}" class="text-decoration-none text-muted small fw-bold">
                        <i class="fa-solid fa-arrow-left me-1"></i> Back to Teacher Directory
                    </a>
                </div>

                <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                    <div class="bg-primary bg-gradient text-white px-4 py-4">
                        <div class="d-flex align-items-center">
                            <div class="bg-white bg-opacity-20 rounded-circle p-2 me-3">
                                <i class="fa-solid fa-chalkboard-user fs-4"></i>
                            </div>
                            <div>
                                <h5 class="mb-0 fw-bold">New Teacher Account</h5>
                                <p class="mb-0 small opacity-75">Register a new educator to the system.</p>
                            </div>
                        </div>
                    </div>

                    <form action="{{ route('account#createTeacher') }}" method="post">
                        @csrf
                        <div class="card-body p-4">

                            <div class="mb-3">
                                <label class="form-label small fw-bold text-muted">Teacher Name</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-0"><i
                                            class="fa-solid fa-user text-muted"></i></span>
                                    <input type="text" name="name" value="{{ old('name') }}"
                                        class="form-control bg-light border-0 @error('name') is-invalid @enderror"
                                        placeholder="Full Name">
                                </div>
                                @error('name')
                                    <small class="text-danger small ms-1">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label small fw-bold text-muted">Official Email</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-0"><i
                                            class="fa-solid fa-envelope text-muted"></i></span>
                                    <input type="email" name="email" value="{{ old('email') }}"
                                        class="form-control bg-light border-0 @error('email') is-invalid @enderror"
                                        placeholder="teacher@school.com">
                                </div>
                                @error('email')
                                    <small class="text-danger small ms-1">{{ $message }}</small>
                                @enderror
                            </div>

                            <hr class="my-4 text-muted opacity-25">

                            <div class="mb-3">
                                <label class="form-label small fw-bold text-muted">Temporary Password</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-0"><i
                                            class="fa-solid fa-key text-muted"></i></span>
                                    <input type="password" name="password"
                                        class="form-control bg-light border-0 @error('password') is-invalid @enderror"
                                        placeholder="Create password">
                                </div>
                                @error('password')
                                    <small class="text-danger small ms-1">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label class="form-label small fw-bold text-muted">Verify Password</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-0"><i
                                            class="fa-solid fa-check-double text-muted"></i></span>
                                    <input type="password" name="confirmPassword"
                                        class="form-control bg-light border-0 @error('confirmPassword') is-invalid @enderror"
                                        placeholder="Confirm password">
                                </div>
                                @error('confirmPassword')
                                    <small class="text-danger small ms-1">{{ $message }}</small>
                                @enderror
                            </div>

                            <button type="submit" class="btn btn-primary w-100 rounded-3 shadow-sm py-2 fw-bold mb-3">
                                <i class="fa-solid fa-user-plus me-2"></i> Register Teacher
                            </button>

                            <div class="alert alert-info border-0 rounded-3 py-2 mb-0">
                                <p class="extra-small mb-0 text-center">
                                    <i class="fa-solid fa-circle-info me-1"></i>
                                    An invitation will be sent to the registered email address.
                                </p>
                            </div>
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
            min-width: 45px;
            justify-content: center;
        }

        .form-control {
            border-top-right-radius: 0.5rem !important;
            border-bottom-right-radius: 0.5rem !important;
            padding: 0.6rem 0.75rem;
        }

        .form-control:focus {
            background-color: #fdfdfd;
            box-shadow: none;
        }
    </style>
@endsection
