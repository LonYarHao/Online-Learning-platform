@extends('Student.Layouts.master')

@section('content')
    <div class="container-fluid py-5 bg-light min-vh-100">
        <div class="row justify-content-center">
            <div class="col-xl-10 col-12">

                {{-- Header --}}
                <div class="d-sm-flex align-items-center justify-content-between mb-4">
                    <div>
                        <h1 class="h3 mb-1 text-gray-800 fw-bold">Payment History</h1>
                        <p class="text-muted small">Track your course enrollments and transaction receipts.</p>
                    </div>

                    <div class="bg-white p-3 rounded-4 shadow-sm border d-flex align-items-center">
                        <div class="bg-success-subtle p-2 rounded-3 me-3 text-success">
                            <i class="bi bi-wallet2 fs-4"></i>
                        </div>
                        <div>
                            <small class="text-muted d-block">Total Spent</small>
                            <span class="fw-bold text-dark">
                                ${{ number_format($totalSpent, 2) }}
                            </span>
                        </div>
                    </div>
                </div>

                <div class="card shadow-sm border-0 rounded-4 overflow-hidden">

                    {{-- Filter --}}
                    <div class="card-header bg-white border-bottom py-4 px-4">
                        <div class="row g-3 align-items-center">
                            <div class="col-12 col-md-6">
                                <h5 class="mb-0 fw-bold d-flex align-items-center">
                                    <span class="bg-primary-subtle p-2 rounded-3 me-3 text-primary">
                                        <i class="bi bi-credit-card"></i>
                                    </span>
                                    Transactions
                                </h5>
                            </div>

                            <div class="col-12 col-md-6">
                                <form method="GET" action="{{ route('student#paymentHistory') }}">
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-0">
                                            <i class="bi bi-funnel text-muted"></i>
                                        </span>
                                        <select name="status" class="form-select bg-light border-0 shadow-none"
                                            onchange="this.form.submit()">
                                            <option value="">All Statuses</option>
                                            <option value="approved"
                                                {{ request('status') == 'approved' ? 'selected' : '' }}>
                                                Completed
                                            </option>
                                            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>
                                                Pending
                                            </option>
                                            <option value="failed" {{ request('status') == 'failed' ? 'selected' : '' }}>
                                                Failed
                                            </option>
                                        </select>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    {{-- Table --}}
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="bg-light text-uppercase small fw-bold text-muted">
                                    <tr>
                                        <th class="ps-4 py-3">Transaction ID</th>
                                        <th class="py-3">Course</th>
                                        <th class="py-3">Method</th>
                                        <th class="py-3">Amount</th>
                                        <th class="py-3">Payslip</th>
                                        <th class="py-3">Status</th>
                                        <th class="text-end pe-4 py-3">Actions</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @forelse ($payments as $payment)
                                        <tr>
                                            <td class="ps-4">
                                                <span class="text-dark fw-medium">
                                                    #PAY-{{ $payment->payment_id }}
                                                </span>
                                                <div class="text-muted" style="font-size: 0.75rem;">
                                                    {{ \Carbon\Carbon::parse($payment->created_at)->format('M d, Y') }}
                                                </div>
                                            </td>

                                            <td>
                                                <div class="fw-semibold text-dark text-truncate" style="max-width: 200px;">
                                                    {{ $payment->course_title }}
                                                </div>
                                                <small class="text-muted">
                                                    {{ $payment->instructor_name }}
                                                </small>
                                            </td>

                                            <td>
                                                <span class="small">
                                                    {{ ucfirst($payment->payment_method) }}
                                                </span>
                                            </td>

                                            <td>
                                                <span class="fw-bold text-dark">
                                                    ${{ number_format($payment->amount, 2) }}
                                                </span>
                                            </td>

                                            <td>
                                                @if ($payment->payslip)
                                                    <a href="{{ asset('paySlip/' . $payment->payslip) }}"
                                                        class="btn btn-sm btn-light border rounded-pill px-3 shadow-sm"
                                                        target="_blank">
                                                        <i class="bi bi-file-earmark-pdf text-danger me-1"></i> View
                                                    </a>
                                                @else
                                                    <span class="text-muted small">N/A</span>
                                                @endif
                                            </td>

                                            <td>
                                                @if ($payment->status == 'approved')
                                                    <span
                                                        class="badge bg-success-subtle text-success rounded-pill px-3 py-2">
                                                        Completed
                                                    </span>
                                                @elseif ($payment->status == 'pending')
                                                    <span
                                                        class="badge bg-warning-subtle text-warning rounded-pill px-3 py-2">
                                                        Pending
                                                    </span>
                                                @else
                                                    <span class="badge bg-danger-subtle text-danger rounded-pill px-3 py-2">
                                                        Failed
                                                    </span>
                                                @endif
                                            </td>

                                            <td class="text-end pe-4">
                                                <button type="submit" onclick="deleteProcess({{ $payment->payment_id }})"
                                                    class="btn btn-sm btn-danger">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7" class="text-center py-5 text-muted">
                                                No payment history found.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>

                            </table>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
@section('js-script')
    <script>
        function deleteProcess($id) {
            Swal.fire({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, delete it!"
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: "Deleted!",
                        text: "Your file has been deleted.",
                        icon: "success"
                    });

                    setInterval(() => {
                        location.href = '/student/payment/deleteHistory/' + $id
                    }, 1000);
                }
            });
        }
    </script>
@endsection
