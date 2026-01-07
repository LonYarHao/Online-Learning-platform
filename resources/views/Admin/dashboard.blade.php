@extends('layouts.master')

@section('content')
    <main class="p-4 bg-light min-vh-100">
        <div class="container-fluid">

            <h2 class="fw-bold mb-4">Platform Overview</h2>

            <div class="row g-4 mb-5">
                <div class="col-xl-3 col-md-6">
                    <div class="card border-0 shadow-sm rounded-4 p-3">
                        <div class="d-flex align-items-center">
                            <div class="bg-primary bg-opacity-10 p-3 rounded-3 me-3">
                                <i class="fa-solid fa-user-graduate text-primary fs-4"></i>
                            </div>
                            <div>
                                <h3 class="fw-bold mb-0">{{ number_format($studentCount) }}</h3>
                                <p class="text-muted small mb-0">Total Students</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6">
                    <div class="card border-0 shadow-sm rounded-4 p-3">
                        <div class="d-flex align-items-center">
                            <div class="bg-success bg-opacity-10 p-3 rounded-3 me-3">
                                <i class="fa-solid fa-book text-success fs-4"></i>
                            </div>
                            <div>
                                <h3 class="fw-bold mb-0">{{ $courseCount }}</h3>
                                <p class="text-muted small mb-0">Active Courses</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6">
                    <div class="card border-0 shadow-sm rounded-4 p-3">
                        <div class="d-flex align-items-center">
                            <div class="bg-warning bg-opacity-10 p-3 rounded-3 me-3">
                                <i class="fa-solid fa-chalkboard-user text-warning fs-4"></i>
                            </div>
                            <div>
                                <h3 class="fw-bold mb-0">{{ $teacherCount }}</h3>
                                <p class="text-muted small mb-0">Total Teachers</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6">
                    <div class="card border-0 shadow-sm rounded-4 p-3">
                        <div class="d-flex align-items-center">
                            <div class="bg-danger bg-opacity-10 p-3 rounded-3 me-3">
                                <i class="fa-solid fa-sack-dollar text-danger fs-4"></i>
                            </div>
                            <div>
                                <h3 class="fw-bold mb-0">${{ number_format($totalRevenue, 2) }}</h3>
                                <p class="text-muted small mb-0">Total Revenue</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card border-0 shadow-sm rounded-4">
                        <div class="card-header bg-white border-0 p-4">
                            <h5 class="fw-bold mb-0">Recent Enrollments</h5>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-hover align-middle mb-0">
                                    <thead class="bg-light">
                                        <tr>
                                            <th class="ps-4">Student</th>
                                            <th>Course</th>
                                            <th>Date</th>
                                            <th>Amount</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($recentEnrollments as $enroll)
                                            <tr>
                                                <td class="ps-4">
                                                    <div class="d-flex align-items-center">
                                                        <img src="https://ui-avatars.com/api/?name={{ urlencode($enroll->student_name) }}&background=random"
                                                            class="rounded-circle me-2" width="35">
                                                        <span class="fw-semibold">{{ $enroll->student_name }}</span>
                                                    </div>
                                                </td>
                                                <td>{{ $enroll->course_title }}</td>
                                                <td>{{ $enroll->created_at->diffForHumans() }}</td>
                                                <td>${{ number_format($enroll->amount, 2) }}</td>
                                                <td>
                                                    @if ($enroll->status == 'approved')
                                                        <span class="badge bg-success-subtle text-success px-3">
                                                            Approved
                                                        </span>
                                                    @elseif ($enroll->status == 'rejected')
                                                        <span class="badge bg-danger-subtle text-danger px-3">
                                                            Rejected
                                                        </span>
                                                    @else
                                                        <span class="badge bg-warning-subtle text-warning px-3">
                                                            Pending
                                                        </span>
                                                    @endif
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="5" class="text-center p-4 text-muted">No recent enrollments
                                                    found.</td>
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
    </main>
@endsection
