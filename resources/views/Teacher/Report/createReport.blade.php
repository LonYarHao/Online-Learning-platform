@extends('Teacher.Layouts.master')

@section('content')
    <main class="p-4 bg-light min-vh-100">
        <div class="container-fluid">
            <div class="mb-3">
                <a href="{{ route('teacher#viewReport') }}" class="text-decoration-none text-muted small fw-bold">
                    <i class="fa-solid fa-arrow-left me-1"></i> Back to History
                </a>
            </div>

            <div class="row justify-content-center">
                <div class="col-lg-6">
                    <div class="card border-0 shadow-sm rounded-4">
                        <div class="card-header bg-white border-0 pt-4 px-4">
                            <h5 class="fw-bold mb-0"><i class="fa-solid fa-circle-exclamation text-primary me-2"></i>Report
                                a Problem</h5>
                            <p class="text-muted small mb-0 mt-1">Please provide clear details about the issue you're
                                facing.</p>
                        </div>

                        <div class="card-body p-4">
                            <div class="mb-4 p-3 bg-light rounded-3 d-flex align-items-center border">
                                <div class="bg-white rounded-circle p-2 me-3 shadow-sm">
                                    <i class="fa-solid fa-building-user text-primary"></i>
                                </div>
                                <div>
                                    <small class="text-muted d-block fw-bold text-uppercase"
                                        style="font-size: 0.65rem;">Detected Department</small>
                                    <span
                                        class="fw-bold text-dark">{{ $teacherData->department_name ?? 'General Staff' }}</span>
                                </div>
                            </div>

                            <form action="{{ route('teacher#sendReport') }}" method="POST">
                                @csrf

                                <div class="mb-3">
                                    <label class="form-label small fw-bold text-muted">Subject Title</label>
                                    <input type="text" name="title"
                                        class="form-control bg-light border-0 py-2 @error('title') is-invalid @enderror"
                                        placeholder="Briefly describe the issue (e.g., Payment missing, Course bug)"
                                        value="{{ old('title') }}">
                                    @error('title')
                                        <small class="text-danger small">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="mb-4">
                                    <label class="form-label small fw-bold text-muted">Detailed Description</label>
                                    <textarea name="message" rows="6"
                                        class="form-control bg-light border-0 py-2 @error('message') is-invalid @enderror"
                                        placeholder="Explain the problem in detail so the Admin can help you faster...">{{ old('message') }}</textarea>
                                    @error('message')
                                        <small class="text-danger small">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="d-grid">
                                    <button type="submit" class="btn btn-primary btn-lg rounded-3 fw-bold shadow-sm">
                                        <i class="fa-solid fa-upload me-2"></i>Upload Report
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="mt-4 p-3 bg-white rounded-4 border-0 shadow-sm d-flex align-items-center">
                        <div class="bg-info bg-opacity-10 p-2 rounded-3 me-3">
                            <i class="fa-solid fa-lightbulb text-info"></i>
                        </div>
                        <p class="small text-muted mb-0">
                            <strong>Tip:</strong> Admins usually respond within 24 hours. Check your "Report History" for
                            updates.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
