@extends('Student.Layouts.master')

@section('content')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-8 col-md-10 col-12">

                <div class="text-center mb-5">
                    <h2 class="fw-bold text-dark mb-1">Learning Updates</h2>
                    <p class="text-muted small">Stay updated with your latest academic and enrollment status</p>
                </div>

                <div class="card shadow-sm border-0 rounded-4 overflow-hidden mb-4">
                    <div class="list-group list-group-flush">

                        @forelse ($notifications as $noti)
                            <a href="{{ $noti->type == 'payment' ? route('student#myCourse') : route('student#gradePage') }}"
                                class="list-group-item list-group-item-action p-4 border-start border-4 {{ $noti->type == 'payment' ? 'border-success' : 'border-info' }}">

                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0 me-3">
                                        <div class="rounded-circle {{ $noti->type == 'payment' ? 'bg-success-subtle text-success' : 'bg-info-subtle text-info' }} d-flex align-items-center justify-content-center shadow-sm"
                                            style="width: 50px; height: 50px;">
                                            <i
                                                class="bi {{ $noti->type == 'payment' ? 'bi-check-circle-fill' : 'bi-star-fill' }} fs-4"></i>
                                        </div>
                                    </div>

                                    <div class="flex-grow-1">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <h6 class="mb-0 fw-bold text-dark">{{ $noti->title }}</h6>
                                            <span class="text-muted extra-small">
                                                <i class="bi bi-clock me-1"></i> {{ $noti->created_at->diffForHumans() }}
                                            </span>
                                        </div>
                                        <p class="text-muted small mb-0 mt-1">
                                            {{ $noti->message }}
                                        </p>
                                    </div>

                                    <div class="ms-3 opacity-25">
                                        <i class="bi bi-chevron-right fs-5"></i>
                                    </div>
                                </div>
                            </a>

                        @empty
                            <div class="p-5 text-center">
                                <h6 class="text-muted">No notifications yet!</h6>
                            </div>
                        @endforelse


                    </div>

                    <div class="card-footer bg-light border-top-0 py-3 text-center">
                        <button class="btn btn-link text-decoration-none small fw-bold text-primary p-0">Mark all as
                            read</button>
                    </div>
                </div>

                <div class="d-flex justify-content-center mt-4">
                    {{-- $notifications->links() --}}
                </div>

            </div>
        </div>
    </div>

    <style>
        .extra-small {
            font-size: 0.72rem;
        }

        .bg-success-subtle {
            background-color: #e6fcf5 !important;
        }

        .bg-info-subtle {
            background-color: #e7fafc !important;
        }

        .rounded-4 {
            border-radius: 1.25rem !important;
        }

        .list-group-item-action {
            transition: all 0.3s ease;
            border-bottom: 1px solid #f8f9fa !important;
            background-color: #fff;
        }

        .list-group-item-action:hover {
            background-color: #fff !important;
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.06);
            z-index: 2;
        }

        .bi-chevron-right {
            transition: transform 0.2s;
        }

        .list-group-item-action:hover .bi-chevron-right {
            transform: translateX(5px);
            color: #0d6efd;
        }
    </style>
@endsection
