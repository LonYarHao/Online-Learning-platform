@extends('Teacher.Layouts.master')

@section('content')
    <div class="container-fluid py-4">
        <div class="row justify-content-center">
            <div class="col-xl-6 col-lg-7 col-md-10">

                <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                    <div class="card-header bg-white border-bottom border-light py-3 px-4">
                        <h5 class="m-0 fw-bold text-primary">
                            <i class="fa-solid fa-chalkboard-user me-2"></i>My Profile Details
                        </h5>
                    </div>

                    <div class="card-body p-4">
                        <form action="{{ route('teacher#profileUpdate') }}" method="post" enctype="multipart/form-data">
                            @csrf

                            <div class="d-flex align-items-center gap-4 mb-5 flex-wrap">
                                <div class="position-relative">
                                    <img src="{{ Auth::user()->profile != null ? asset('profile/' . Auth::user()->profile) : asset('defaultPic/defProfile.jpg') }}"
                                        alt="Profile Image" class="rounded-4 border border-3 border-light shadow-sm"
                                        id="output" style="width: 120px; height: 120px; object-fit: cover;">
                                </div>

                                <div class="flex-grow-1">
                                    <p class="mb-2 fw-bold text-dark">Profile Photo</p>
                                    <label class="btn btn-primary btn-sm rounded-3 px-3">
                                        <i class="fa-solid fa-camera me-1"></i> Change Photo
                                        <input type="file" name="image"
                                            class="d-none form-control @error('image') is-invalid @enderror"
                                            accept="image/*" onchange="loadFile(event)">
                                    </label>
                                    @error('image')
                                        <div class="text-danger small mt-2">{{ $message }}</div>
                                    @enderror
                                    <p class="text-muted small mt-2 mb-0">Recommended: Square JPG or PNG (Max 2MB)</p>
                                </div>
                            </div>

                            <div class="row g-4">
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold small text-muted">Full Name</label>
                                    <input type="text" name="name"
                                        class="form-control bg-light border-0 py-2 rounded-3 @error('name') is-invalid @enderror"
                                        placeholder="Enter your name"
                                        value="{{ old('name', Auth::user()->name == 'null' ? Auth::user()->nickname : Auth::user()->name) }}">
                                    @error('name')
                                        <small class="invalid-feedback">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label fw-semibold small text-muted">Email Address</label>
                                    <input type="email" name="email"
                                        class="form-control bg-light border-0 py-2 rounded-3 @error('email') is-invalid @enderror"
                                        placeholder="example@mail.com" value="{{ old('email', Auth::user()->email) }}">
                                    @error('email')
                                        <small class="invalid-feedback">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label fw-semibold small text-muted">Phone Number</label>
                                    <input type="number" name="phone"
                                        class="form-control bg-light border-0 py-2 rounded-3 @error('phone') is-invalid @enderror"
                                        placeholder="Add phone number" value="{{ old('phone', Auth::user()->phone) }}">
                                    @error('phone')
                                        <small class="invalid-feedback">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label fw-semibold small text-muted">Role</label>
                                    <div class="form-control bg-light border-0 py-2 rounded-3 text-muted">
                                        <i class="fa-solid fa-user-shield me-2"></i>{{ ucfirst(Auth::user()->role) }}
                                    </div>
                                </div>

                                <div class="col-12">
                                    <label class="form-label fw-semibold small text-muted">Address</label>
                                    <textarea name="address" rows="3"
                                        class="form-control bg-light border-0 py-2 rounded-3 @error('address') is-invalid @enderror"
                                        placeholder="Enter your current address">{{ old('address', Auth::user()->address) }}</textarea>
                                    @error('address')
                                        <small class="invalid-feedback">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>

                            <div
                                class="d-flex flex-column flex-md-row justify-content-between align-items-center mt-5 gap-3">
                                <a href="{{ route('teacher#changePasswordPage') }}"
                                    class="btn btn-link text-decoration-none text-primary fw-bold small p-0">
                                    <i class="fa-solid fa-key me-1"></i> Update Password
                                </a>

                                <button type="submit" class="btn btn-primary px-5 py-2 fw-bold rounded-3 shadow-sm">
                                    Save Profile Changes
                                </button>
                            </div>

                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <style>
        /* Styling to match your established dashboard theme */
        .bg-light {
            background-color: #f8f9fa !important;
        }

        .form-control:focus {
            background-color: #fff !important;
            box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.08);
        }

        .btn-link:hover {
            color: #0a58ca !important;
        }
    </style>
@endsection
