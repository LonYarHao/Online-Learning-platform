@extends('layouts.master')

@section('content')
    <div class="container-fluid py-5 bg-light min-vh-100">
        <div class="row justify-content-center">
            <div class="col-xl-11 col-12">

                <div class="d-sm-flex align-items-center justify-content-between mb-4">
                    <div>
                        <h1 class="h3 mb-1 text-gray-800 fw-bold">Payment Approvals</h1>
                        <p class="text-muted small">Verify student enrollments and transaction receipts.</p>
                    </div>

                    <form action="{{ route('admin#paymentPage') }}" method="GET" class="d-flex gap-2">
                        <div class="input-group shadow-sm">
                            <span class="input-group-text bg-white border-0"><i class="bi bi-search text-muted"></i></span>
                            <input type="text" name="searchKey" value="{{ request('searchKey') }}"
                                class="form-control border-0 shadow-none"
                                placeholder="Search student, course or instructor...">
                            <button type="submit" class="btn btn-primary px-4">Search</button>
                        </div>
                    </form>
                </div>

                <div class="card shadow-sm border-0 rounded-4 overflow-hidden">
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="bg-light text-uppercase small fw-bold text-muted">
                                    <tr>
                                        <th class="ps-4 py-3">ID</th>
                                        <th class="py-3">Student Name</th> {{-- Added Student Column --}}
                                        <th class="py-3">Course & Instructor</th>
                                        <th class="py-3">Amount / Method</th>
                                        <th class="py-3 text-center">Payslip</th>
                                        <th class="py-3">Status</th>
                                        <th class="text-end pe-4 py-3">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($payments as $item)
                                        <tr @if ($item->status != 'pending') class="opacity-75 text-muted" @endif>
                                            <td class="ps-4 fw-medium">#{{ $item->payment_id }}</td>

                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="rounded-circle bg-primary-subtle text-primary d-flex align-items-center justify-content-center me-2"
                                                        style="width: 32px; height: 32px;">
                                                        <i class="bi bi-person-fill"></i>
                                                    </div>
                                                    <span class="fw-bold text-dark">{{ $item->student_name }}</span>
                                                </div>
                                            </td>

                                            <td>
                                                <div class="d-flex flex-column">
                                                    <span class="fw-bold text-dark">{{ $item->course_title }}</span>
                                                    <span class="text-muted small">
                                                        <i class="bi bi-person me-1"></i>{{ $item->instructor_name }}
                                                    </span>
                                                </div>
                                            </td>

                                            <td>
                                                <div class="d-flex flex-column">
                                                    <span
                                                        class="fw-bold text-dark">${{ number_format($item->amount, 2) }}</span>
                                                    <span
                                                        class="text-muted small">{{ $item->payment_method ?? 'Stripe' }}</span>
                                                </div>
                                            </td>

                                            <td class="text-center">
                                                @if ($item->payslip)
                                                    <a href="{{ asset('paySlip/' . $item->payslip) }}" target="_blank"
                                                        class="btn btn-sm btn-light border rounded-pill px-3 shadow-sm">
                                                        <i class="bi bi-file-earmark-image text-primary me-1"></i> View
                                                    </a>
                                                @else
                                                    <span class="badge bg-light text-muted border fw-normal">No Proof</span>
                                                @endif
                                            </td>

                                            <td>
                                                <span
                                                    class="badge px-3 py-2 rounded-pill border small
                                            @if ($item->status == 'pending') bg-warning-subtle text-warning border-warning-subtle
                                            @elseif($item->status == 'approved') bg-success-subtle text-success border-success-subtle
                                            @elseif($item->status == 'rejected') bg-danger-subtle text-danger border-danger-subtle
                                            @else bg-secondary-subtle text-secondary border-secondary-subtle @endif">
                                                    {{ ucfirst($item->status) }}
                                                </span>
                                            </td>

                                            <td class="text-end pe-4">
                                                @if ($item->status == 'pending')
                                                    <div class="d-flex justify-content-end gap-2">
                                                        <form
                                                            action="{{ route('admin#paymentUpdateStatus', $item->payment_id) }}"
                                                            method="POST">
                                                            @csrf
                                                            <input type="hidden" name="status" value="approved">
                                                            <button type="submit"
                                                                class="btn btn-sm btn-success rounded-3 px-3 shadow-sm">
                                                                <i class="bi bi-check-lg"></i>
                                                            </button>
                                                        </form>

                                                        <form
                                                            action="{{ route('admin#paymentUpdateStatus', $item->payment_id) }}"
                                                            method="POST">
                                                            @csrf
                                                            <input type="hidden" name="status" value="rejected">
                                                            <button type="submit"
                                                                class="btn btn-sm btn-outline-danger rounded-3 px-3">
                                                                <i class="bi bi-x-lg"></i>
                                                            </button>
                                                        </form>
                                                    </div>
                                                @else
                                                    <div class="text-muted small">
                                                        <i class="bi bi-lock-fill me-1"></i> Processed
                                                    </div>
                                                @endif
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7" class="text-center py-5 text-muted">
                                                <i class="bi bi-inbox fs-1 d-block mb-3 opacity-25"></i>
                                                No payment records found.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div
                        class="card-footer bg-white border-top py-4 px-4 d-flex justify-content-between align-items-center">
                        <div class="small text-muted">
                            Showing {{ $payments->firstItem() }} to {{ $payments->lastItem() }} of
                            {{ $payments->total() }} entries
                        </div>
                        <div>
                            {{ $payments->appends(['searchKey' => request('searchKey')])->links() }}
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
