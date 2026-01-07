@extends('Teacher.Layouts.master')

@section('content')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-9 col-md-11 col-12">

                <div class="d-flex align-items-center justify-content-between mb-4">
                    <div>
                        <h2 class="fw-bold text-dark mb-1">Teacher Workspace</h2>
                        <p class="text-muted small">Manage student submissions and course interactions</p>
                    </div>
                    <span class="badge bg-success-subtle text-success rounded-pill px-3 py-2">
                        <i class="bi bi-check2-all me-1"></i> All Caught Up
                    </span>
                </div>

                <div class="card shadow-sm border-0 rounded-4 overflow-hidden">
                    <div class="list-group list-group-flush">

                        @forelse ($notifications as $noti)
                            <div class="list-group-item p-4 border-start border-4 border-primary">
                                <div class="d-flex align-items-start">
                                    <div class="flex-shrink-0 me-3">
                                        <div class="rounded-circle bg-primary-subtle text-primary d-flex align-items-center justify-content-center"
                                            style="width: 48px; height: 48px;">
                                            <i class="bi bi-file-earmark-arrow-up-fill fs-5"></i>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1">
                                        <div class="d-flex justify-content-between align-items-center mb-1">
                                            <h6 class="mb-0 fw-bold text-dark">{{ $noti->title }}</h6>
                                            <span class="text-muted extra-small">
                                                <i class="bi bi-clock me-1"></i> {{ $noti->created_at->diffForHumans() }}
                                            </span>
                                        </div>

                                        <p class="text-muted small mb-3">
                                            {{ $noti->message }} Assignment-id
                                            <span class="badge bg-light text-primary border border-primary-subtle">
                                                {{ $noti->id }}
                                            </span>
                                        </p>

                                        <div class="d-flex gap-2">
                                            @if (is_null($noti->student_grade))
                                                {{-- Not graded yet --}}
                                                <a href="{{ route('teacher#Grade', $noti->reference_id) }}"
                                                    class="btn btn-sm btn-primary rounded-pill px-4 shadow-sm">
                                                    Grade Now
                                                </a>
                                            @else
                                                {{-- Already graded --}}
                                                <button class="btn btn-sm btn-outline-secondary rounded-pill px-4" disabled>
                                                    <i class="bi bi-check-all"></i> Graded ({{ $noti->student_grade }}/10)
                                                </button>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="p-5 text-center">
                                <div class="mb-3">
                                    <i class="bi bi-clipboard-check text-muted opacity-25" style="font-size: 3rem;"></i>
                                </div>
                                <h5 class="text-muted fw-normal">No new submissions to grade.</h5>
                                <p class="text-muted small">When students upload assignments, they will appear here.</p>
                            </div>
                        @endforelse

                    </div>
                </div>

                <div class="d-flex justify-content-center mt-4">
                    {{ $notifications->links() }}
                </div>

            </div>
        </div>
    </div>

    <style>
        .extra-small {
            font-size: 0.72rem;
        }

        .bg-primary-subtle {
            background-color: #e7f1ff !important;
        }

        .rounded-4 {
            border-radius: 1.25rem !important;
        }

        .list-group-item {
            transition: all 0.2s ease;
            border-bottom: 1px solid #f8f9fa !important;
        }

        .list-group-item:hover {
            background-color: #fcfcfc !important;
        }
    </style>
@endsection
