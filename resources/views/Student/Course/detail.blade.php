@extends('Student.Layouts.master')

@section('content')
    <div class="bg-light-subtle pb-5">

        {{-- Modern Header Section --}}
        <div class="bg-white border-bottom py-5 mb-5">
            <div class="container">
                <div class="row">
                    <div class="col-lg-8">
                        <nav aria-label="breadcrumb" class="mb-3">
                            <ol class="breadcrumb mb-0">
                                <li class="breadcrumb-item"><a href="{{ route('student#browselist') }}"
                                        class="text-decoration-none text-primary fw-medium small">Courses</a></li>
                                <li class="breadcrumb-item active small" aria-current="page">{{ $course->department_name }}
                                </li>
                            </ol>
                        </nav>
                        <h1 class="display-5 fw-extrabold text-dark mb-3">{{ $course->title }}</h1>
                        <p class="fs-5 text-muted mb-4" style="max-width: 600px;">
                            Master the essentials of {{ $course->department_name }} with our expert-led curriculum designed
                            for modern professionals.
                        </p>
                        <div class="d-flex align-items-center gap-4">
                            <div class="d-flex align-items-center">
                                <i class="bi bi-people-fill text-primary me-2"></i>
                                <span class="small fw-semibold">1,200+ Students</span>
                            </div>
                            <div class="d-flex align-items-center">
                                <i class="bi bi-translate text-primary me-2"></i>
                                <span class="small fw-semibold">English</span>
                                </li>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="container">
                <div class="row g-5">
                    <div class="col-lg-8">

                        {{-- About Section --}}
                        <section class="mb-5">
                            <h3 class="fw-bold mb-4">Course Description</h3>
                            <div class="card border-0 shadow-sm rounded-4">
                                <div class="card-body p-4 p-md-5">
                                    <div class="text-secondary lh-lg">
                                        {{ $course->description }}
                                    </div>
                                </div>
                            </div>
                        </section>

                        {{-- Future: Course Content Accordion --}}
                        <section class="mb-5">
                            <h4 class="fw-bold mb-4">What you'll learn</h4>
                            <div class="row g-3">
                                @foreach (range(1, 4) as $item)
                                    <div class="col-md-6">
                                        <div class="d-flex align-items-start gap-2">
                                            <i class="bi bi-check2-circle text-success fs-5"></i>
                                            <span class="text-muted">Module placeholder for future curriculum
                                                details.</span>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </section>

                        {{-- Ratings Placeholder --}}
                        <section class="mb-5 pt-4">
                            <h4 class="fw-bold mb-3">Student Reviews</h4>

                            {{-- Average Rating --}}
                            <div class="mb-3 text-muted">
                                Average Rating:
                                {{ number_format($avgRating ?? 0, 1) }} / 5
                                ({{ $totalRating }} students)
                            </div>

                            {{-- Stars --}}
                            <div class="mb-4">
                                @for ($i = 1; $i <= 5; $i++)
                                    <i
                                        class="fa fa-star {{ $i <= round($avgRating) ? 'text-warning' : 'text-secondary' }}"></i>
                                @endfor
                            </div>

                            {{-- Rating Form --}}
                            @if ($isEnrolled)
                                <form action="{{ route('student#saveRating') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="course_id" value="{{ $course->id }}">

                                    <div class="mb-3">
                                        <label class="fw-bold mb-2 d-block">Your Rating</label>

                                        @for ($i = 1; $i <= 5; $i++)
                                            <label class="me-2">
                                                <input type="radio" name="rating" value="{{ $i }}"
                                                    {{ optional($myRating)->rating == $i ? 'checked' : '' }}>
                                                <i class="fa fa-star text-warning"></i>
                                            </label>
                                        @endfor
                                    </div>

                                    <div class="mb-3">
                                        <textarea name="review" class="form-control" placeholder="Write a review (optional)">{{ $myRating->review ?? '' }}</textarea>
                                    </div>

                                    <button class="btn btn-primary">
                                        {{ $myRating ? 'Update Rating' : 'Submit Rating' }}
                                    </button>
                                </form>
                            @else
                                <p class="text-muted">
                                    Enroll in this course to give a rating.
                                </p>
                            @endif
                        </section>


                        {{-- Discussion Placeholder --}}
                        <section class="mb-5">
                            <h4 class="fw-bold mb-4">Community Discussion</h4>

                            {{-- Comment form --}}

                            @auth
                                @if ($isEnrolled)
                                    {{-- ONLY approved students --}}
                                    <form action="{{ route('comment#store') }}" method="POST" class="mb-4">
                                        @csrf
                                        <input type="hidden" name="course_id" value="{{ $course->id }}">

                                        <textarea name="comment" class="form-control mb-2" rows="3" placeholder="Write a comment..." required></textarea>

                                        <button class="btn btn-primary btn-sm">
                                            Post Comment
                                        </button>
                                    </form>
                                @elseif ($isPending)
                                    {{-- Pending students --}}
                                    <div class="alert alert-warning small rounded-3">
                                        <i class="bi bi-clock-history me-1"></i>
                                        You can comment after your enrollment is approved.
                                    </div>
                                @else
                                    {{-- Not enrolled --}}
                                    <div class="alert alert-info small rounded-3">
                                        <i class="bi bi-lock me-1"></i>
                                        Please enroll in this course to join the discussion.
                                    </div>
                                @endif
                            @else
                                <p class="text-muted">
                                    Please <a href="{{ route('login') }}">login</a> to comment.
                                </p>
                            @endauth


                            {{-- Comment list --}}
                            @forelse ($comments as $comment)
                                <div class="card border-0 shadow-sm rounded-4 mb-3">
                                    <div class="card-body p-3">
                                        <div class="d-flex justify-content-between align-items-center mb-2">

                                            <div class="d-flex align-items-center gap-2">
                                                <img src="{{ asset('profile/' . ($comment->profile ?? 'default.png')) }}"
                                                    class="rounded-circle border" width="28" height="28"
                                                    style="object-fit: cover;">

                                                <span class="fw-semibold small">
                                                    {{ $comment->name ?? 'Student' }}
                                                </span>
                                            </div>

                                            @if (Auth::user()->id === $comment->student_id)
                                                <form action="{{ route('comment#delete', $comment->id) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="btn btn-sm btn-outline-danger rounded-circle p-1">
                                                        <i class="fa-solid fa-trash fa-xs"></i>
                                                    </button>
                                                </form>
                                            @endif

                                        </div>

                                        <p class="small text-muted mb-1">
                                            {{ $comment->comment }}
                                        </p>

                                        <small class="text-muted">
                                            {{ \Carbon\Carbon::parse($comment->created_at)->diffForHumans() }}
                                        </small>

                                    </div>
                                </div>
                            @empty
                                <p class="text-muted">
                                    No comments yet.
                                </p>
                            @endforelse
                        </section>

                    </div>

                    <div class="col-lg-4">
                        <div class="sticky-top" style="top: 2rem;">
                            <div class="card border-0 shadow-lg rounded-4 overflow-hidden">
                                {{-- Image with Overlay --}}
                                <div class="position-relative">
                                    <div class="ratio ratio-16x9">
                                        <img src="{{ asset('courseImage/' . $course->image) }}" class="object-fit-cover"
                                            alt="Course Hero">
                                    </div>
                                    <div
                                        class="position-absolute top-0 start-0 w-100 h-100 d-flex align-items-center justify-content-center bg-dark bg-opacity-10">
                                        <a href="#"
                                            class="btn btn-white btn-sm rounded-pill shadow-sm fw-bold px-3">
                                            <i class="bi bi-play-fill me-1"></i> Preview
                                        </a>
                                    </div>
                                </div>

                                <div class="card-body p-4">
                                    <div class="mb-4">
                                        @if ($course->price == 0)
                                            <span class="display-6 fw-bold text-success">Free</span>
                                        @else
                                            <div class="d-flex align-items-baseline gap-2">
                                                <span
                                                    class="display-6 fw-bold text-dark">${{ number_format($course->price, 2) }}</span>
                                                <span class="text-muted text-decoration-line-through">$99.00</span>
                                            </div>
                                        @endif
                                    </div>

                                    <div class="d-grid gap-2 mb-4">

                                        @if ($isEnrolled)
                                            <button class="btn btn-success btn-lg py-3 fw-bold rounded-3" disabled>
                                                <i class="bi bi-check-circle-fill me-2"></i> Already Enrolled
                                            </button>
                                        @elseif ($isPending)
                                            <button class="btn btn-warning btn-lg py-3 fw-bold rounded-3 text-white"
                                                disabled>
                                                <i class="bi bi-clock-history me-2"></i> Waiting for Approval
                                            </button>

                                            <div class="text-center">
                                                <small class="text-muted">
                                                    We are verifying your payment receipt.
                                                </small>
                                            </div>
                                        @elseif ($isRejected)
                                            <a href="{{ route('student#paymentPage', $course->id) }}"
                                                class="btn btn-danger btn-lg py-3 fw-bold rounded-3">
                                                <i class="bi bi-arrow-repeat me-2"></i> Enroll Again
                                            </a>

                                            <div class="text-center">
                                                <small class="text-muted">
                                                    Your previous payment was rejected.
                                                </small>
                                            </div>
                                        @else
                                            <a href="{{ route('student#paymentPage', $course->id) }}"
                                                class="btn btn-primary btn-lg py-3 fw-bold rounded-3 shadow-sm">
                                                Enroll in Course
                                            </a>
                                        @endif

                                    </div>





                                    <div class="small">
                                        <p class="fw-bold text-dark mb-3">Course features:</p>
                                        <div class="d-flex align-items-center gap-3 mb-2 text-muted">
                                            <i class="bi bi-infinity fs-5 text-primary"></i>
                                            <span>Lifetime access</span>
                                        </div>
                                        <div class="d-flex align-items-center gap-3 mb-2 text-muted">
                                            <i class="bi bi-phone fs-5 text-primary"></i>
                                            <span>Mobile & TV access</span>
                                        </div>
                                        <div class="d-flex align-items-center gap-3 text-muted">
                                            <i class="bi bi-award fs-5 text-primary"></i>
                                            <span>Certification of completion</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- Mini Instructor Card --}}
                            <div class="card border-0 shadow-sm rounded-4 mt-4">
                                <div class="card-body p-3">
                                    <div class="d-flex align-items-center gap-3">

                                        <div class="rounded-circle overflow-hidden" style="width: 56px; height: 56px;">
                                            <img src="{{ asset('profile/' . $course->instructor_image) }}"
                                                class="w-100 h-100" style="object-fit: cover;" alt="Instructor">
                                        </div>

                                        <div>
                                            <p class="mb-0 small text-muted">Instructor</p>
                                            <h6 class="mb-0 fw-bold">{{ $course->instructor_name }}</h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <style>
            /* Custom styles to enhance Bootstrap */
            .fw-extrabold {
                font-weight: 800;
            }

            .border-dashed {
                border-style: dashed !important;
            }

            .transition-up:hover {
                transform: translateY(-2px);
                transition: all 0.2s ease;
            }

            .object-fit-cover {
                object-fit: cover;
            }

            .bg-light-subtle {
                background-color: #f8f9fa;
            }
        </style>
    @endsection
