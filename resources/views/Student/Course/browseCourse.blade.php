@extends('Student.Layouts.master')

@section('content')
    <div class="container-fluid py-4 py-lg-5 bg-light">

        <!-- Hero Section with Search -->
        <div class="container">
            <div class="row align-items-center mb-5 g-4">
                <div class="col-12 col-lg-6">
                    <h1 class="display-5 fw-bold mb-3">
                        Discover Your Next <span class="text-primary">Skill</span>
                    </h1>
                    <p class="lead text-muted mb-4">Expert-led courses to help you learn, grow, and succeed.</p>

                    <!-- Stats Row -->
                    <div class="d-flex gap-4 mb-3">
                        <div>
                            <h5 class="fw-bold text-primary mb-0">50+</h5>
                            <small class="text-muted">Courses</small>
                        </div>
                        <div>
                            <h5 class="fw-bold text-primary mb-0">10K+</h5>
                            <small class="text-muted">Students</small>
                        </div>
                        <div>
                            <h5 class="fw-bold text-primary mb-0">4.8★</h5>
                            <small class="text-muted">Rating</small>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-lg-6">
                    <div class="card border-0 shadow-sm rounded-4 p-1">
                        <form action="{{ route('student#browselist') }}" method="GET" class="d-flex gap-2">
                            <input type="search" name="searchKey" class="form-control border-0 shadow-none"
                                placeholder="Search courses...">
                            <button type="submit" class="btn btn-primary px-2 rounded-3">
                                <i class="bi bi-search me-2"></i> Search
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Category Filter Pills -->
            <div class="mb-5">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="fw-bold mb-0">Browse Categories</h5>
                    <a href="#" class="btn btn-sm btn-outline-primary rounded-pill">View All <i
                            class="bi bi-arrow-right ms-1"></i></a>
                </div>

                <div class="d-flex gap-2 overflow-auto pb-3">

                    {{-- All Courses --}}
                    <a href="{{ route('student#browselist') }}" class="btn btn-primary rounded-pill px-4 text-nowrap">
                        All Courses
                    </a>

                    @foreach ($departments as $dept)
                        <a href="{{ route('student#browselist', ['department' => $dept->id]) }}"
                            class="btn btn-outline-secondary rounded-pill px-4 text-nowrap
                            {{ request('department') == $dept->id ? 'active' : '' }}">
                            {{ $dept->name }}
                        </a>
                    @endforeach

                </div>

            </div>

            <!-- Course Cards Grid -->
            <div class="row g-4">

                @foreach ($courses as $course)
                    <div class="col-12 col-sm-6 col-lg-4 col-xl-3">
                        <a href="{{ route('student#courseDetail', $course->id) }}" class="text-decoration-none text-dark">
                            <div class="card h-100 border-0 shadow-sm rounded-4">

                                <!-- Course Image -->
                                <div class="position-relative">
                                    <div class="ratio ratio-16x9">
                                        <img src="{{ asset('courseImage/' . $course->image) }}"
                                            class="card-img-top rounded-top-4" style="object-fit: cover;" alt="course">
                                    </div>
                                </div>

                                <div class="card-body p-3">

                                    <!-- Department -->
                                    <div class="mb-2">
                                        <span
                                            class="badge bg-primary-subtle text-primary border border-primary-subtle px-3 py-2 rounded-pill">
                                            {{ $course->department_name }}
                                        </span>
                                    </div>

                                    <!-- Course Title -->
                                    <h6 class="fw-bold mb-2">
                                        {{ $course->title }}
                                    </h6>

                                    <!-- Description preview -->
                                    <p class="small text-muted mb-3">
                                        {{ Str::limit($course->description, 60) }}
                                    </p>

                                    <!-- Price -->
                                    <div class="d-flex justify-content-between align-items-center pt-2 border-top">
                                        <div>
                                            @if ($course->price == 0)
                                                <span class="fw-bold text-success">Free</span>
                                            @else
                                                <span class="fw-bold text-primary">
                                                    ${{ number_format($course->price, 2) }}
                                                </span>
                                            @endif
                                        </div>

                                        <span class="small text-primary fw-semibold">
                                            View Course →
                                        </span>
                                    </div>

                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach

            </div>


            <!-- Load More Button -->
            <div class="text-center mt-5">
                <button class="btn btn-outline-primary btn-lg rounded-pill px-5">
                    <i class="bi bi-arrow-down-circle me-2"></i> Load More Courses
                </button>
            </div>

        </div>
    </div>
@endsection
