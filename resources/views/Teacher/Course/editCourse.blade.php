@extends('Teacher.Layouts.master')
@section('content')
    <div class="container py-4">
        <div class="card border-0 shadow-sm mx-auto" style="max-width: 850px; border-radius: 12px;">
            <div class="card-body p-4">

                <form action="{{ route('teacher#updateCourse') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="course_id" value="{{ $course->id }}">
                    <div class="d-flex align-items-center gap-4 mb-4 flex-wrap border-bottom pb-4">
                        <div class="position-relative">
                            <img src="{{ $course->image ? asset('courseImage/' . $course->image) : asset('defaultPic/defCourse.jpg') }}"
                                alt="Course Image" class="rounded-3 shadow-sm" id="output"
                                style="width: 180px; height: 105px; object-fit: cover;">
                        </div>

                        <div class="flex-grow-1">
                            <p class="mb-1 fw-bold text-dark">Course Cover Image</p>
                            <p class="text-muted small mb-2">This image will appear on the course catalog.</p>

                            <label class="btn btn-primary btn-sm rounded-2 px-3">
                                <i class="bi bi-camera me-1"></i> Change Cover
                                <input type="file" name="image"
                                    class="d-none form-control @error('image') is-invalid @enderror" accept="image/*"
                                    onchange="loadFile(event)">
                            </label>

                            @error('image')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                            <p class="text-muted mb-0" style="font-size: 0.75rem;">JPG or PNG. Recommended ratio 16:9.
                            </p>
                        </div>
                    </div>

                    <div class="row">
                        {{-- Course Title --}}
                        <div class="col-12 mb-3">
                            <label class="form-label fw-bold text-secondary small">COURSE TITLE</label>
                            <input type="text" name="title" class="form-control @error('title') is-invalid @enderror"
                                value="{{ old('title', $course->title) }}">
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Department --}}
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold text-secondary small">DEPARTMENT</label>
                            <select name="department_id" class="form-select @error('department_id') is-invalid @enderror">
                                <option value="">Choose department</option>
                                @foreach ($departments as $dept)
                                    <option value="{{ $dept->id }}"
                                        {{ old('department_id', $course->department_id) == $dept->id ? 'selected' : '' }}>
                                        {{ $dept->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Price --}}
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold text-secondary small">PRICE ($)</label>
                            <input type="number" step="0.01" name="price"
                                class="form-control @error('price') is-invalid @enderror"
                                value="{{ old('price', $course->price) }}">
                        </div>

                        {{-- Description --}}
                        <div class="col-12 mb-4">
                            <label class="form-label fw-bold text-secondary small">DESCRIPTION</label>
                            <textarea name="description" rows="3" class="form-control @error('description') is-invalid @enderror">{{ old('description', $course->description) }}</textarea>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end gap-2 border-top pt-3">
                        <a href="{{ route('teacher#myCourses') }}" class="btn btn-light border px-4">Cancel</a>
                        <button type="submit" class="btn btn-primary px-4 fw-bold">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
