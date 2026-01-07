@extends('layouts.master')

@section('content')
    <div class="row">
        <div class="col-lg-4 col-md-6 offset-lg-4 offset-md-3 my-5">
            <div class="mb-3">
                <a href="{{ route('admin#departmentList') }}" class="text-decoration-none text-muted small fw-bold">
                    <i class="fa-solid fa-arrow-left me-1"></i> Back to List
                </a>
            </div>

            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center mb-4">
                        <div class="bg-primary bg-opacity-10 text-primary px-3 py-2 rounded-3 me-3">
                            <i class="fa-solid fa-pen-to-square"></i>
                        </div>
                        <h5 class="card-title mb-0 fw-bold">Edit Department</h5>
                    </div>

                    <form action="{{ route('admin#departmentUpdate', $department->id) }}" method="POST">
                        @csrf
                        <div class="mb-4">
                            <label for="departmentName" class="form-label small fw-bold text-muted">Department Name</label>
                            <input type="text"
                                class="form-control form-control-lg bg-light border-0 @error('name') is-invalid @enderror"
                                id="departmentName" name="name" placeholder="Enter name"
                                value="{{ old('name', $department->name) }}"
                                @if (Auth::user()->role !== 'superadmin') disabled readonly @endif>

                            @error('name')
                                <small class="invalid-feedback">{{ $message }}</small>
                            @enderror
                        </div>

                        @if (Auth::user()->role === 'superadmin')
                            <button type="submit" class="btn btn-primary btn-lg w-100 rounded-3 shadow-sm">
                                <i class="fa-solid fa-floppy-disk me-2"></i> Save Changes
                            </button>
                        @else
                            <div class="alert alert-secondary border-0 small rounded-3 mb-0">
                                <i class="fa-solid fa-lock me-2"></i>
                                You don't have permission to edit this department.
                            </div>
                        @endif
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
