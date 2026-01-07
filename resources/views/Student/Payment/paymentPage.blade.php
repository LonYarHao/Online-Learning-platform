@extends('Student.Layouts.master')

@section('content')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-12 col-lg-8">

                <!-- Back Button -->
                <div class="mb-3">
                    <a href="{{ route('student#browselist') }}" class="btn btn-outline-secondary btn-sm">
                        <i class="bi bi-arrow-left me-1"></i> Back to Course
                    </a>
                </div>

                <!-- Payment Card -->
                <div class="card border-0 shadow-sm rounded-4">

                    <!-- Header -->
                    <div class="card-header bg-primary text-white py-4 rounded-top-4">
                        <h4 class="mb-1 fw-bold">
                            <i class="bi bi-credit-card me-2"></i>Complete Your Enrollment
                        </h4>
                        <p class="mb-0 opacity-75 small">Secure payment to access the course</p>
                    </div>

                    <div class="card-body p-4 p-md-5">

                        <form action="{{ route('student#createPayment') }}" method="POST" enctype="multipart/form-data">
                            {{-- Hidden Fields --}}
                            <input type="hidden" name="course_id" value="{{ $course->id }}">
                            <input type="hidden" name="student_id" value="{{ Auth::user()->id }}">
                            @csrf

                            <!-- Course Summary -->
                            <div class="bg-light rounded-3 p-4 mb-4">
                                <div class="row align-items-center">
                                    <div class="col-md-3 ">
                                        <img src="{{ asset('courseImage/' . $course->image) }}" class="w-100 h-100"
                                            style="object-fit: cover;" alt="Instructor">
                                    </div>
                                    <div class="col-md-9">
                                        <h5 class="fw-bold mb-2">{{ $course->title }}</h5>
                                        <p class="text-muted small mb-3">{{ $course->instructor_name }}</p>
                                        <div class="d-flex gap-3">
                                            <span class="badge bg-primary-subtle text-primary px-3 py-2 rounded-pill">
                                                <i class="bi bi-infinity me-1"></i> Lifetime Access
                                            </span>
                                            <span class="badge bg-success-subtle text-success px-3 py-2 rounded-pill">
                                                <i class="bi bi-award me-1"></i> Certificate
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Payment Method -->
                            <div class="mb-4">
                                <label class="form-label fw-bold">
                                    Payment Method <span class="text-danger">*</span>
                                </label>
                                <select name="payment_method"
                                    class="form-select @error('payment_method') is-invalid @enderror">
                                    <option value="" selected disabled>-- Select Payment Method --</option>
                                    <option value="kbz">KBZ</option>
                                    <option value="aya">AYA</option>
                                    <option value="wave">WAVE PAY</option>

                                </select>
                                @error('payment_method')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Amount (Read-only) -->
                            <div class="mb-4">
                                <label class="form-label fw-bold">Amount (USD)</label>
                                <div class="input-group input-group-lg">
                                    <span class="input-group-text bg-light">
                                        <i class="bi bi-currency-dollar"></i>
                                    </span>
                                    <input type="text" name="amount" value="{{ $course->price }}"
                                        class="form-control bg-light" readonly>
                                </div>
                                <small class="text-muted">This is the total amount for the course</small>
                            </div>

                            <!-- Payment Slip Upload -->
                            <div class="mb-4">
                                <label class="form-label fw-bold">
                                    Upload Payment Slip / Receipt <span class="text-danger">*</span>
                                </label>

                                <div class="row align-items-center g-3">
                                    <!-- Preview -->
                                    <div class="col-12 col-md-4">
                                        <div class="border rounded-3 bg-light p-2 text-center"
                                            style="height: 200px; display: flex; align-items: center; justify-content: center; overflow: hidden;">
                                            <img id="output" src=""
                                                style="max-width: 100%; max-height: 100%; object-fit: contain;">
                                        </div>
                                    </div>

                                    <!-- File Input -->
                                    <div class="col-12 col-md-8">
                                        <input type="file" name="paySlip" accept="image/*"
                                            class="form-control form-control-sm @error('paySlip') is-invalid @enderror"
                                            onchange="loadFile(event)">

                                        <small class="text-muted d-block mt-2">
                                            Recommended: JPG, PNG (Max 5MB)
                                        </small>

                                        @error('paySlip')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror

                                    </div>
                                </div>
                            </div>

                            <!-- Instructions Alert -->
                            <div class="alert alert-info border-0 rounded-3 mb-4">
                                <div class="d-flex gap-3">
                                    <i class="bi bi-info-circle-fill fs-4"></i>
                                    <div>
                                        <h6 class="fw-bold mb-2">Payment Instructions</h6>
                                        <ol class="mb-0 ps-3 small">
                                            <li>Complete the payment using your selected method</li>
                                            <li>Take a screenshot or photo of your payment receipt</li>
                                            <li>Upload the payment slip above</li>
                                            <li>Wait for admin verification (usually within 24 hours)</li>
                                            <li>You'll receive email confirmation once approved</li>
                                        </ol>
                                    </div>
                                </div>
                            </div>

                            <!-- Terms & Conditions -->
                            <div class="form-check mb-4">
                                <input class="form-check-input" type="checkbox" name="terms" id="terms" required>
                                <label class="form-check-label small" for="terms">
                                    I agree to the <a href="#" class="text-primary">Terms of Service</a> and
                                    <a href="#" class="text-primary">Refund Policy</a>
                                </label>
                            </div>

                            <hr class="my-4">

                            <!-- Action Buttons -->
                            <div class="d-flex gap-2 justify-content-end flex-wrap">
                                <a href="#" class="btn btn-outline-secondary px-4">
                                    <i class="bi bi-x-circle me-1"></i> Cancel
                                </a>
                                <button type="submit" class="btn btn-primary px-5 shadow-sm">
                                    <i class="bi bi-check-circle me-1"></i> Submit Payment
                                </button>
                            </div>

                        </form>

                    </div>
                </div>

                <!-- Help Section -->
                <div class="card border-0 shadow-sm rounded-4 mt-4">
                    <div class="card-body p-4">
                        <div class="d-flex gap-3">
                            <i class="bi bi-question-circle text-primary fs-3"></i>
                            <div>
                                <h6 class="fw-bold mb-2">Need Help?</h6>
                                <p class="text-muted small mb-2">If you're having trouble with payment, please contact our
                                    support team.</p>
                                <a href="#" class="btn btn-sm btn-outline-primary rounded-pill">
                                    <i class="bi bi-headset me-1"></i> Contact Support
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
