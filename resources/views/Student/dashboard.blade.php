@extends('Student.Layouts.master')

@section('content')
    <!-- PAGE CONTENT -->
    <main class="p-4 bg-light min-vh-100">
        <div class="container-fluid">

            <div class="row mb-4">
                <div class="col-12">
                    <div class="card border-0 rounded-4 shadow-sm overflow-hidden"
                        style="background: linear-gradient(135deg, #0d6efd 0%, #0a58ca 100%);">
                        <div class="card-body p-4 p-md-5 text-white">
                            <div class="row align-items-center">
                                <div class="col-md-8">
                                    <h1 class="display-6 fw-bold mb-2">Welcome back, {{ Auth::user()->name }}! 👋</h1>
                                    <p class="lead opacity-75 mb-4">You have successfully enrolled in {{ $enrolledCount }}
                                        courses. Keep learning!</p>
                                    <a href="{{ route('student#browselist') }}"
                                        class="btn btn-light btn-lg rounded-3 fw-bold text-primary px-4 shadow-sm">
                                        <i class="fa-solid fa-magnifying-glass me-2"></i>Browse New Courses
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row g-4 mb-5">
                @php
                    $stats = [
                        [
                            'icon' => 'book',
                            'color' => 'primary',
                            'value' => $enrolledCount,
                            'label' => 'Enrolled Courses',
                        ],
                        [
                            'icon' => 'wallet',
                            'color' => 'success',
                            'value' => '$' . number_format($totalSpent, 2),
                            'label' => 'Total Spent',
                        ],
                        ['icon' => 'award', 'color' => 'warning', 'value' => '85%', 'label' => 'Avg. Grade'],
                        ['icon' => 'stopwatch', 'color' => 'info', 'value' => '24h', 'label' => 'Study Time'],
                    ];
                @endphp

                @foreach ($stats as $stat)
                    <div class="col-xl-3 col-sm-6">
                        <div class="card border-0 shadow-sm rounded-4 h-100">
                            <div class="card-body p-4">
                                <div class="d-flex align-items-center justify-content-between mb-3">
                                    <div class="bg-{{ $stat['color'] }} bg-opacity-10 p-3 rounded-3">
                                        <i class="fa-solid fa-{{ $stat['icon'] }} text-{{ $stat['color'] }} fs-4"></i>
                                    </div>
                                </div>
                                <h3 class="fw-bold mb-1">{{ $stat['value'] }}</h3>
                                <p class="text-muted small mb-0 fw-semibold">{{ $stat['label'] }}</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="row g-4">
                <div class="col-xl-8">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h4 class="fw-bold mb-0">Continue Learning</h4>
                    </div>

                    <div class="row g-4">
                        @forelse($recentCourses as $course)
                            <div class="col-md-6">
                                <div class="card border-0 shadow-sm rounded-4 overflow-hidden h-100 hvr-lift">
                                    @if ($course->image)
                                        <img src="{{ asset('courseImage/' . $course->image) }}" class="card-img-top"
                                            style="height: 180px; object-fit: cover;">
                                    @else
                                        <div class="bg-secondary text-white d-flex align-items-center justify-content-center"
                                            style="height: 180px;">No Image</div>
                                    @endif
                                    <div class="card-body p-4">
                                        <h5 class="fw-bold mb-3">{{ $course->title }}</h5>
                                        <p class="text-muted small">Instructor: {{ $course->teacher_name }}</p>
                                        <a href="#" class="btn btn-primary w-100 rounded-3 fw-bold">Continue Study</a>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-12">
                                <div class="card border-0 shadow-sm rounded-4 p-5 text-center">
                                    <p class="text-muted">You are not enrolled in any courses yet.</p>
                                </div>
                            </div>
                        @endforelse
                    </div>
                </div>

                <div class="col-xl-4">
                    <h4 class="fw-bold mb-4">Upcoming Deadlines</h4>

                    @forelse($upcomingAssignments as $task)
                        <div class="card border-0 shadow-sm rounded-4 mb-3 bg-white hvr-lift">
                            {{-- Change color to Green if submitted, Red if not --}}
                            <div
                                class="card-body p-4 border-start border-4 {{ $task->is_submitted ? 'border-success' : 'border-danger' }}">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <h6 class="fw-bold mb-0">Assignment #{{ $task->id }}</h6>

                                    @if ($task->is_submitted)
                                        <span class="badge bg-success rounded-pill px-2 small">Done</span>
                                    @else
                                        <span class="badge bg-danger rounded-pill px-2 small">Pending</span>
                                    @endif
                                </div>

                                <p class="text-muted small mb-3">
                                    {{ $task->is_submitted ? 'You have submitted this work.' : 'Please upload your file.' }}
                                </p>

                                @if ($task->is_submitted)
                                    {{-- Button is disabled or says Completed --}}
                                    <button class="btn btn-sm btn-outline-success w-100 rounded-2 fw-bold" disabled>
                                        <i class="fa-solid fa-check-double me-1"></i> Submitted
                                    </button>
                                @else
                                    {{-- Real link to submit page --}}
                                    <a href="{{ route('student#viewAssignment', $task->id) }}"
                                        class="btn btn-sm btn-primary w-100 rounded-2 fw-bold">
                                        Submit Now
                                    </a>
                                @endif
                            </div>
                        </div>
                    @empty
                        <div class="card border-0 shadow-sm rounded-4 mb-3 bg-white p-4 text-center">
                            <p class="text-muted small mb-0">No assignments found.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </main>

    <style>
        .hvr-lift {
            transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
        }

        .hvr-lift:hover {
            transform: translateY(-5px);
            box-shadow: 0 1rem 3rem rgba(0, 0, 0, .1) !important;
        }
    </style>
@endsection
