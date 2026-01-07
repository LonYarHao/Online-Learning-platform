@extends('Student.Layouts.master')

@section('content')
    <div class="container-fluid py-5 bg-light min-vh-100">
        <div class="row justify-content-center">
            <div class="col-xl-10 col-12">

                <div class="mb-4">
                    <h1 class="h3 mb-1 text-gray-800 fw-bold">Course Catalog</h1>
                    <p class="text-muted small">Manage and monitor all available educational content.</p>
                </div>

                <div class="card shadow-sm border-0 rounded-4 overflow-hidden">

                    <div class="card-header bg-white border-bottom py-4 px-4">
                        <div class="row g-3 align-items-center">
                            <div class="col-12 col-md-4">
                                <h5 class="mb-0 fw-bold d-flex align-items-center">
                                    <span class="bg-primary-subtle p-2 rounded-3 me-3 text-primary">
                                        <i class="bi bi-book-half"></i>
                                    </span>
                                    All Courses
                                </h5>
                            </div>

                            <div class="col-12 col-md-8">
                                <form class="d-flex gap-2">
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-0"><i
                                                class="bi bi-search text-muted"></i></span>
                                        <input type="text" name="searchKey"
                                            class="form-control bg-light border-0 border-start-0 shadow-none"
                                            placeholder="Search courses...">
                                    </div>
                                    <button type="submit" class="btn btn-primary px-4">Search</button>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="bg-light text-uppercase small fw-bold text-muted">
                                    <tr>
                                        <th class="ps-4 py-3" style="width: 80px;">ID</th>
                                        <th class="py-3" style="width: 120px;">Preview</th>
                                        <th class="py-3">Course Title</th>
                                        <th class="py-3">Instructor</th>
                                        <th class="py-3">Status</th>
                                        <th class="text-end pe-4 py-3">action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($courses as $course)
                                        <tr>
                                            <!-- ID -->
                                            <td class="ps-4 fw-bold text-muted">
                                                {{ $course->payment_id }}
                                            </td>

                                            <!-- Preview -->
                                            <td>
                                                <img src="{{ asset('courseImage/' . $course->image) }}"
                                                    class="rounded-3 shadow-sm"
                                                    style="width: 80px; height: 55px; object-fit: cover;">
                                            </td>

                                            <!-- Course Title -->
                                            <td>
                                                <div class="fw-bold text-dark text-truncate" style="max-width: 250px;">
                                                    {{ $course->title }}
                                                </div>
                                                <div class="text-muted small">
                                                    ${{ $course->amount }}
                                                </div>
                                            </td>

                                            <!-- Instructor -->
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="rounded-circle bg-light border d-flex align-items-center justify-content-center me-2"
                                                        style="width: 32px; height: 32px;">
                                                        <i class="bi bi-person text-muted small"></i>
                                                    </div>
                                                    <span class="small fw-medium">
                                                        {{ $course->instructor_name }}
                                                    </span>
                                                </div>
                                            </td>

                                            <!-- Status -->
                                            <td>
                                                @if ($course->status === 'pending')
                                                    <span
                                                        class="badge bg-warning-subtle text-warning px-3 py-2 rounded-pill small">
                                                        Pending
                                                    </span>
                                                @elseif ($course->status === 'approved')
                                                    <span
                                                        class="badge bg-success-subtle text-success px-3 py-2 rounded-pill small">
                                                        Approved
                                                    </span>
                                                @elseif ($course->status === 'rejected')
                                                    <span
                                                        class="badge bg-danger-subtle text-danger px-3 py-2 rounded-pill small">
                                                        Rejected
                                                    </span>
                                                @endif
                                            </td>

                                            <!-- Action -->
                                            <td class="text-end pe-4">
                                                @if ($course->status === 'approved')
                                                    <a href="{{ route('student#courseDetail', $course->course_id) }}"
                                                        class="btn btn-sm btn-primary">
                                                        View
                                                    </a>
                                                @elseif ($course->status === 'rejected')
                                                    <span class="badge bg-danger">
                                                        Rejected
                                                    </span>
                                                @else
                                                    <span class="badge bg-warning text-dark">
                                                        Pending
                                                    </span>
                                                @endif
                                            </td>

                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="text-center py-5 text-muted">
                                                You haven’t enrolled in any courses yet.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>

                            </table>
                        </div>
                    </div>

                    <div class="card-footer bg-white border-top py-4 px-4">
                        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                            <div class="text-muted small">
                                Total Courses: <span class="fw-bold text-dark">{{ $courses->count() }}</span>
                            </div>
                            <div class="d-flex justify-content-end mt-3">
                                {{ $courses->appends(['searchKey' => request('searchKey')])->links() }}
                            </div>

                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
