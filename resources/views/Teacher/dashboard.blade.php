@extends('Teacher.Layouts.master')

@section('content')
    <main class="p-4 bg-light min-vh-100">
        <div class="container-fluid">

            <div class="row mb-4">
                <div class="col-12">
                    <div class="card border-0 rounded-4 shadow-sm text-white"
                        style="background: linear-gradient(135deg, #6610f2 0%, #4b0db8 100%);">
                        <div class="card-body p-4 p-md-5">
                            <h1 class="display-6 fw-bold mb-2">Hello, Professor {{ Auth::user()->name }}! 🎓</h1>
                            <p class="lead opacity-75 mb-4">Manage your classes and review student progress from here.</p>
                            <a href="{{ route('teacher#createCoursePage') }}"
                                class="btn btn-light btn-lg rounded-3 fw-bold text-primary shadow-sm">
                                <i class="fa-solid fa-plus me-2"></i>Create New Course
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row g-4 mb-5">
                <div class="col-xl-4 col-sm-6">
                    <div class="card border-0 shadow-sm rounded-4 p-3">
                        <div class="d-flex align-items-center">
                            <div class="bg-primary bg-opacity-10 p-3 rounded-3 me-3">
                                <i class="fa-solid fa-book-open text-primary fs-4"></i>
                            </div>
                            <div>
                                <h3 class="fw-bold mb-0">{{ $courseCount }}</h3>
                                <p class="text-muted small mb-0">Active Courses</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 col-sm-6">
                    <div class="card border-0 shadow-sm rounded-4 p-3">
                        <div class="d-flex align-items-center">
                            <div class="bg-success bg-opacity-10 p-3 rounded-3 me-3">
                                <i class="fa-solid fa-users text-success fs-4"></i>
                            </div>
                            <div>
                                <h3 class="fw-bold mb-0">{{ $totalStudents }}</h3>
                                <p class="text-muted small mb-0">Total Students</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 col-sm-6">
                    <div class="card border-0 shadow-sm rounded-4 p-3">
                        <div class="d-flex align-items-center">
                            <div class="bg-warning bg-opacity-10 p-3 rounded-3 me-3">
                                <i class="fa-solid fa-clock-rotate-left text-warning fs-4"></i>
                            </div>
                            <div>
                                <h3 class="fw-bold mb-0">{{ $pendingReviewsCount }}</h3>
                                <p class="text-muted small mb-0">Pending Grades</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row g-4">
                <div class="col-xl-8">
                    <h4 class="fw-bold mb-4">My Courses</h4>
                    <div class="row g-3">
                        @forelse($myCourses as $course)
                            <div class="col-md-6">
                                <div class="card border-0 shadow-sm rounded-4 h-100 hvr-lift">
                                    <div class="card-body p-4">
                                        <h5 class="fw-bold text-primary">{{ $course->title }}</h5>
                                        <hr class="text-muted opacity-25">
                                        <div class="d-flex justify-content-between mb-3">
                                            <span class="small text-muted"><i class="fa-solid fa-user-graduate me-1"></i>
                                                {{ \App\Models\Payment::where('course_id', $course->id)->where('status', 'approved')->count() }}
                                                Students</span>
                                            <span class="small text-muted"><i class="fa-solid fa-calendar me-1"></i>
                                                {{ $course->created_at->format('M Y') }}</span>
                                        </div>
                                        <a href="#"
                                            class="btn btn-outline-primary w-100 rounded-3 btn-sm fw-bold">Manage Course</a>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-12 text-center p-5 bg-white rounded-4 shadow-sm">
                                <p class="text-muted mb-0">No courses created yet.</p>
                            </div>
                        @endforelse
                    </div>
                </div>

                <div class="col-xl-4">
                    <h4 class="fw-bold mb-4">Submissions to Grade</h4>
                    @forelse($pendingSubmissions as $sub)
                        <div class="card border-0 shadow-sm rounded-4 mb-3">
                            <div class="card-body p-3">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div>
                                        <h6 class="fw-bold mb-1">{{ $sub->student_name }}</h6>
                                        <p class="text-muted small mb-2">{{ $sub->course_name }}</p>
                                    </div>
                                    <span class="badge bg-warning text-dark small">New</span>
                                </div>
                                <a href="#" class="btn btn-sm btn-primary w-100 rounded-2">Review & Grade</a>
                            </div>
                        </div>
                    @empty
                        <div class="card border-0 shadow-sm rounded-4 p-4 text-center">
                            <p class="text-muted small mb-0">All clear! No pending work.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </main>

    <style>
        .hvr-lift {
            transition: all 0.3s ease;
            border: 1px solid transparent !important;
        }

        .hvr-lift:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1) !important;
            border-color: #6610f2 !important;
        }
    </style>
@endsection
