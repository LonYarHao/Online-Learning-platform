@extends('Student.Layouts.master')

@section('content')
    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card border-0 shadow-sm rounded-4 p-4">
                    <div class="text-center mb-4">
                        <div class="display-4 fw-bold text-primary">{{ $grade->grade }}<span class="h3 text-muted">/10</span>
                        </div>
                        <p class="text-muted uppercase small fw-bold">Result for {{ $grade->task }}</p>
                    </div>

                    <hr class="text-muted opacity-25">

                    <div class="mb-4">
                        <h6 class="fw-bold"><i class="bi bi-chat-left-text me-2"></i>Teacher's Feedback</h6>
                        <div class="p-3 bg-light rounded-3 italic text-secondary">
                            "{{ $grade->feedback ?? 'No feedback provided.' }}"
                        </div>
                    </div>

                    <div class="row g-3 mb-4">
                        <div class="col-6">
                            <div class="p-2 border rounded-3">
                                <small class="d-block text-muted">Course</small>
                                <span class="fw-bold">{{ $grade->course_name }}</span>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="p-2 border rounded-3">
                                <small class="d-block text-muted">Graded On</small>
                                <span class="fw-bold">{{ $grade->updated_at->format('M d, Y') }}</span>
                            </div>
                        </div>
                    </div>

                    <a href="{{ route('student#gradePage') }}" class="btn btn-light w-100 rounded-pill">Back to All
                        Grades</a>
                </div>
            </div>
        </div>
    </div>
@endsection
