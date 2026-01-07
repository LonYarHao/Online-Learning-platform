@extends('Student.Layouts.master')

@section('content')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-12 col-lg-10">

                {{-- Back --}}
                <div class="mb-3">
                    <a href="{{ route('student#dashboard') }}"
                        class="btn btn-sm btn-link text-secondary fw-semibold p-0 text-decoration-none">
                        <i class="bi bi-chevron-left"></i> Back to Dashboard
                    </a>
                </div>

                <div class="card shadow border-0 rounded-4 overflow-hidden">
                    <div class="row g-0">

                        {{-- LEFT SIDE --}}
                        <div class="col-md-4 bg-light p-4 border-end">

                            {{-- Teacher --}}
                            <div class="mb-4 text-center">
                                <div class="bg-white rounded-circle shadow-sm d-inline-flex align-items-center justify-content-center mb-2"
                                    style="width: 60px; height: 60px;">
                                    <i class="bi bi-person-badge text-primary fs-2"></i>
                                </div>
                                <h6 class="fw-bold mb-0">{{ $assignment->teacher_name }}</h6>
                                <p class="text-muted small">Course Instructor</p>
                            </div>

                            <hr class="my-3 text-muted opacity-25">

                            {{-- Deadline --}}
                            <div class="mb-3 p-3 bg-white border-start border-danger border-4 rounded shadow-sm">
                                <label class="d-block small fw-bold text-muted text-uppercase">Deadline Day</label>
                                <span class="fw-bold text-danger">
                                    {{ $assignment->created_at->addDays(3)->format('d M Y') }}
                                </span>
                            </div>

                            {{-- Grade (placeholder for now) --}}
                            <div class="mb-3 p-3 bg-white border-start border-success border-4 rounded shadow-sm">
                                <label class="d-block small fw-bold text-muted text-uppercase">Grade</label>
                                <span class="h4 fw-bold text-dark mb-0">
                                    -- <small class="text-muted fs-6">/ 100</small>
                                </span>
                            </div>

                            {{-- Feedback (placeholder) --}}
                            <div class="mt-4">
                                <label class="small fw-bold text-secondary text-uppercase mb-2 d-block">
                                    Teacher Feedback
                                </label>
                                <div class="p-3 bg-white border rounded shadow-sm small text-muted fst-italic">
                                    <i class="bi bi-chat-dots me-2"></i>
                                    No feedback yet.
                                </div>
                            </div>
                        </div>

                        {{-- RIGHT SIDE --}}
                        <div class="col-md-8 p-4 p-md-5 bg-white">

                            {{-- Task --}}
                            <div class="mb-5">
                                <div class="d-flex justify-content-between align-items-start mb-3">
                                    <h5 class="fw-bold text-dark">Task Instructions</h5>
                                    <span class="badge bg-light text-dark border fw-medium">
                                        ID: {{ $assignment->id }}
                                    </span>
                                </div>
                                <div class="p-4 bg-light rounded-3 border">
                                    <p class="mb-0 text-secondary">
                                        {{ $assignment->task }}
                                    </p>
                                </div>
                            </div>

                            {{-- Upload Section (UI only) --}}
                            <div class="pt-4 border-top">
                                <h5 class="fw-bold mb-4">Submit Your Work</h5>
                                @if ($errors->any())
                                    <div class="alert alert-danger border-0 shadow-sm rounded-4 mb-3">
                                        <div class="d-flex">
                                            <i class="bi bi-exclamation-circle-fill me-2"></i>
                                            <ul class="mb-0 small fw-bold">
                                                @foreach ($errors->all() as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                @endif
                                <form action="{{ route('student#submitAssignment') }}" method="POST"
                                    enctype="multipart/form-data">
                                    @csrf

                                    <input type="hidden" name="assignment_id" value="{{ $assignment->id }}">

                                    <div class="row g-3">

                                        <div class="col-md-12">
                                            <label class="form-label small fw-bold text-muted">Your Student ID</label>
                                            <input type="text" class="form-control bg-light border-0"
                                                value="#STU-{{ Auth::user()->id }}" readonly>
                                        </div>

                                        <div class="col-12">
                                            <label class="form-label small fw-bold text-muted">Upload File</label>
                                            <div class="input-group">
                                                <input type="file" name="file"
                                                    class="form-control border-secondary-subtle shadow-none" required>
                                                <button class="btn btn-success px-4 fw-bold" type="submit">
                                                    Upload
                                                </button>
                                            </div>
                                        </div>

                                    </div>
                                </form>

                            </div>

                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>


    <style>
        /* Minimal CSS for crucial UI fixes */
        .form-control:focus {
            border-color: #198754;
        }

        .leading-relaxed {
            line-height: 1.6;
        }

        @media (max-width: 768px) {
            .border-end {
                border-end: none !important;
                border-bottom: 1px solid #dee2e6;
            }
        }
    </style>
@endsection
