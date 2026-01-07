@extends('Teacher.Layouts.master')

@section('content')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-12 col-md-10 col-lg-8">

                <div class="mb-4">
                    <a href="{{ route('teacher#myAssignment') }}"
                        class="btn btn-sm btn-link text-muted fw-semibold p-0 text-decoration-none">
                        <i class="bi bi-chevron-left me-1"></i> Back to Dashboard
                    </a>
                </div>

                {{-- Validation Error --}}
                @if ($errors->any())
                    <div class="alert alert-danger border-0 shadow-sm rounded-4 p-3 mb-4 d-flex align-items-center">
                        <i class="bi bi-exclamation-circle-fill me-3 fs-5"></i>
                        <div class="small fw-medium">
                            Please fill in all required fields before submitting.
                        </div>
                    </div>
                @endif

                <div class="card shadow-lg border-0 rounded-4 overflow-hidden">
                    <div class="row g-0">

                        {{-- Left Info --}}
                        <div
                            class="col-md-4 bg-light p-4 d-flex flex-column justify-content-center align-items-center text-center border-end">
                            <div class="text-primary mb-3">
                                <i class="bi bi-clipboard-plus" style="font-size: 3.5rem;"></i>
                            </div>
                            <h4 class="fw-bolder text-dark mb-2">New Task</h4>
                            <p class="text-muted small px-2">
                                Assign a new task to your students for a specific course.
                            </p>
                        </div>

                        {{-- Form --}}
                        <div class="col-md-8 p-4 p-md-5">
                            <h5 class="fw-bold mb-4 text-dark">Assignment Details</h5>

                            <form method="POST" action="{{ route('teacher#createAssignment') }}">
                                @csrf

                                {{-- Teacher ID (display only) --}}
                                <div class="mb-3">
                                    <label class="form-label small fw-semibold text-muted">Teacher ID</label>
                                    <input type="text" class="form-control bg-light border-0"
                                        value="{{ Auth::user()->id }}" readonly>
                                </div>

                                {{-- Course --}}
                                <div class="mb-3">
                                    <label class="form-label small fw-semibold text-muted">Course</label>
                                    <select class="form-select border-1" name="course_id" required>
                                        <option selected disabled>-- Select Course --</option>
                                        @foreach ($courses as $course)
                                            <option value="{{ $course->id }}">
                                                {{ $course->title }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                {{-- Task --}}
                                <div class="mb-4">
                                    <label class="form-label small fw-semibold text-muted">Task Description</label>
                                    <textarea name="task" class="form-control" rows="4" required placeholder="Describe the assignment task...">{{ old('task') }}</textarea>
                                </div>

                                <hr class="my-4">

                                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                    <a href="{{ route('teacher#myAssignment') }}"
                                        class="btn btn-outline-secondary px-4 rounded-pill">
                                        Cancel
                                    </a>

                                    <button type="submit" class="btn btn-success px-4 rounded-pill shadow-sm">
                                        <i class="bi bi-check-lg me-1"></i> Create Task
                                    </button>
                                </div>
                            </form>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>


    <style>
        /* Keeps the look clean and simple */
        .form-control:focus,
        .form-select:focus {
            border-color: #198754;
            box-shadow: none;
        }

        textarea {
            resize: none;
        }

        .card {
            border: 1px solid #eee !important;
        }
    </style>
@endsection
