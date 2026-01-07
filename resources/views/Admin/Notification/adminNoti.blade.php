@extends('layouts.master')

@section('content')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-12 col-md-10 col-lg-7">

                <div class="text-center mb-5">
                    <div class="badge bg-warning text-dark rounded-pill px-3 py-2 mb-2 shadow-sm">Admin Control</div>
                    <h2 class="fw-bold text-dark">Payment Verifications</h2>
                    <p class="text-muted">You have {{ count($pendingPayments) }} pending transactions to review</p>
                </div>

                <div class="card border-0 shadow-lg rounded-4 overflow-hidden">
                    <div class="list-group list-group-flush">

                        @forelse ($pendingPayments as $payment)
                            <a href="{{ route('admin#paymentPage', $payment->id) }}"
                                class="list-group-item list-group-item-action p-4 border-0 mb-2 notification-card">

                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0 me-3">
                                        <div class="rounded-4 bg-warning bg-opacity-10 text-warning d-flex align-items-center justify-content-center shadow-sm"
                                            style="width: 55px; height: 55px; border: 1px solid rgba(255, 193, 7, 0.2);">
                                            <i class="bi bi-person-check-fill fs-3"></i>
                                        </div>
                                    </div>

                                    <div class="flex-grow-1">
                                        <div class="d-flex justify-content-between align-items-start">
                                            <div>
                                                <h6 class="mb-0 fw-bold text-dark text-capitalize">
                                                    {{ $payment->student_name ?? 'New Student' }}
                                                </h6>
                                                <small class="text-warning fw-bold mt-1 d-block">Pending Approval</small>
                                            </div>
                                            <span class="text-muted small">
                                                {{ $payment->created_at->diffForHumans() }}
                                            </span>
                                        </div>
                                        <p class="text-secondary small mb-0 mt-2">
                                            Enrollment payment received. Click to check the receipt.
                                        </p>
                                    </div>

                                    <div class="ms-3 opacity-25">
                                        <i class="bi bi-chevron-right fs-5"></i>
                                    </div>
                                </div>
                            </a>
                        @empty
                            <div class="p-5 text-center bg-white">
                                <img src="https://illustrations.popsy.co/amber/success.svg" alt="Success" class="mb-4"
                                    style="width: 150px;">
                                <h5 class="text-dark fw-bold">No Payments Pending</h5>
                                <p class="text-muted small px-lg-5">Everything is up to date. You'll see new enrollment
                                    requests here as students join.</p>
                            </div>
                        @endforelse

                    </div>
                </div>

                <div class="text-center mt-4">
                    <a href="#" class="btn btn-link text-muted text-decoration-none small">View All History</a>
                </div>

            </div>
        </div>
    </div>

    <style>
        /* Modern Dashboard Styling */
        body {
            background-color: #f8f9fa;
            /* Light grey background to make the card pop */
        }

        .rounded-4 {
            border-radius: 1.25rem !important;
        }

        .notification-card {
            background: white;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            border: 1px solid transparent !important;
            margin: 10px 15px;
            /* Adds space between notifications */
            border-radius: 1rem !important;
        }

        .notification-card:hover {
            background-color: #ffffff !important;
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.08);
            border-color: rgba(255, 193, 7, 0.3) !important;
        }

        .notification-card:hover .bi-chevron-right {
            opacity: 1;
            color: #ffc107;
            transform: translateX(3px);
        }

        /* Scrollbar Styling for cleaner look */
        .card::-webkit-scrollbar {
            width: 5px;
        }

        .card::-webkit-scrollbar-thumb {
            background: #eee;
            border-radius: 10px;
        }
    </style>
@endsection
