@extends('Teacher.Layouts.master')

@section('content')
    <div class="container py-5">
        <div class="row justify-content-center">

            <div class="col-12 col-md-10 col-lg-8">
                <div class="mb-4">
                    <a href="{{ route('teacher#dashboard') }}" class="btn btn-sm btn-link text-muted fw-semibold p-0">
                        <i class="bi bi-chevron-left me-1"></i> Back to Dashboard
                    </a>
                </div>

                <div class="card shadow-lg border-0 rounded-4 overflow-hidden">
                    <div class="row g-0">

                        <div
                            class="col-md-4 bg-light p-4 d-flex flex-column justify-content-start align-items-center text-center">
                            <div class="text-primary mb-3">
                                <i class="bi bi-journal-plus" style="font-size: 3rem;"></i>
                            </div>
                            <h4 class="fw-bolder text-dark mb-2">Course Setup</h4>
                            <p class="text-muted small mb-4">
                                Upload a visually engaging course thumbnail.
                            </p>

                            <div class="w-100 mb-3">
                                <label class="form-label small fw-semibold d-block">Course Thumbnail Preview</label>
                                <img class="img-fluid rounded-3 shadow-sm border border-3 border-white" id="output"
                                    style="width: 100%; max-height: 150px; object-fit: cover;">
                            </div>
                            <form action="{{ route('teacher#createCourse') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="w-100">
                                    <input type="file" name="image" accept="image/*"
                                        class="form-control form-control-sm @error('image') is-invalid @enderror"
                                        onchange="loadFile(event)">

                                    <small class="text-muted d-block mt-2">Recommended: 800x600px (JPG, PNG)</small>
                                    @error('image')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>

                        </div>

                        <div class="col-md-8 p-4 p-md-5">

                            <h5 class="fw-bold mb-4 text-dark">Course Details</h5>



                            <div class="row g-3">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label small fw-semibold text-muted">Course Title <span
                                                class="text-danger">*</span></label>
                                        <input type="text" name="title" value="{{ old('title') }}"
                                            class="form-control @error('title') is-invalid @enderror"
                                            placeholder="Web Development Bootcamp">
                                        @error('title')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label small fw-semibold text-muted">Department <span
                                                class="text-danger">*</span></label>
                                        <select name="departmentId"
                                            class="form-select @error('departmentId') is-invalid @enderror">
                                            <option value="" selected>-- Select Department --</option>
                                            {{-- Options from database --}}
                                            @foreach ($departments as $item)
                                                <option value="{{ $item->id }}"
                                                    {{ old('departmentId') == $item->id ? 'selected' : '' }}>
                                                    {{ $item->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('departmentId')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label small fw-semibold text-muted">Price (USD) <span
                                        class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text bg-white border-end-0 text-primary fw-bold">$</span>
                                    <input type="number" name="price" value="{{ old('price') }}"
                                        class="form-control @error('price') is-invalid @enderror" placeholder="0.00"
                                        step="0.01" min="0">
                                    @error('price')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-4">
                                <label class="form-label small fw-semibold text-muted">Course Description <span
                                        class="text-danger">*</span></label>
                                <textarea name="description" rows="5" class="form-control @error('description') is-invalid @enderror"
                                    placeholder="Describe what students will learn in this course...">{{ old('description') }}</textarea>
                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <hr class="my-4">

                            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                <a href="{{ route('teacher#dashboard') }}" class="btn btn-outline-secondary px-4">
                                    <i class="bi bi-x-circle me-1"></i> Cancel
                                </a>
                                <button type="submit" class="btn btn-success px-4">
                                    <i class="bi bi-check-circle me-1"></i> Create Course
                                </button>
                            </div>

                            </form>

                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
