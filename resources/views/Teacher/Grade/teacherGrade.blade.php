@extends('Teacher.Layouts.master')

@section('content')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-10">

                <div class="mb-4">
                    <a href="{{ route('teacher#Noti') }}" class="btn btn-link text-muted p-0 text-decoration-none">
                        <i class="bi bi-arrow-left"></i> Back to Notifications
                    </a>
                </div>

                <div class="row g-4">
                    <div class="col-md-7">
                        <div class="card shadow-sm border-0 rounded-4 p-4 h-100">
                            <h5 class="fw-bold mb-4">Submission Details</h5>

                            <div class="mb-3">
                                <label class="text-muted small d-block">Student Name</label>
                                <span class="fw-bold text-dark fs-5">{{ $submission->student_name }}</span>
                            </div>

                            <div class="mb-4">
                                <label class="text-muted small d-block">Assignment Task</label>
                                <span
                                    class="badge bg-primary-subtle text-primary border border-primary-subtle px-3 py-2 mt-2">
                                    {{ $submission->assignment_title }}
                                </span>
                            </div>

                            <hr class="opacity-10">

                            <div class="mt-4">
                                <label class="text-muted small d-block mb-2">Attached File (PDF/Doc)</label>
                                <div class="p-4 border rounded-4 bg-light text-center">
                                    <i class="bi bi-file-earmark-pdf text-danger fs-1"></i>
                                    <p class="mt-2 mb-3 text-dark fw-bold small">{{ $submission->file_path }}</p>

                                    <a href="{{ asset('assignmentFile/' . $submission->file_path) }}" target="_blank"
                                        class="btn btn-outline-primary rounded-pill px-4">
                                        <i class="bi bi-eye me-2"></i>View Assignment
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-5">
                        <div class="card shadow-sm border-0 rounded-4 p-4">
                            <h5 class="fw-bold mb-4 text-dark">Grading Form</h5>

                            <form action="{{ route('teacher#submitGrade', $submission->id) }}" method="POST">
                                @csrf
                                <div class="mb-4">
                                    <label class="form-label fw-bold small">Score (0 - 10)</label>
                                    <input type="number" name="grade" class="form-control form-control-lg rounded-pill"
                                        placeholder="Enter score" {{-- This shows the existing grade --}}
                                        value="{{ old('grade', $submission->grade) }}" min="0" max="10"
                                        step="0.1" required>
                                </div>

                                <div class="mb-4">
                                    <label class="form-label fw-bold small">Feedback for Student</label>
                                    <textarea name="feedback" class="form-control rounded-4" rows="5" placeholder="Write your comments here..."
                                        required>{{ old('feedback', $submission->feedback) }}</textarea>
                                </div>

                                <button type="submit" class="btn btn-success btn-lg w-100 rounded-pill shadow-sm">
                                    {{ $submission->grade !== null ? 'Update Grade' : 'Submit Grade' }}
                                </button>
                            </form>
                        </div>
                    </div>
                    <div class="mb-3">
                        <a href="{{ route('teacher#myGrade') }}" class="text-decoration-none text-muted small">
                            <i class="bi bi-arrow-left"></i> Back to History
                        </a>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
