@extends('Student.Layouts.master')

@section('content')
    <div class="container py-4 py-xl-5">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center mb-4 border-bottom pb-3">
                    <div>
                        <h2 class="fw-bold text-dark m-0 fs-4">My Assignments</h2>
                        <p class="text-muted small mb-0">Manage and submit tasks for your enrolled courses.</p>
                    </div>
                </div>

                <div class="card shadow-sm border-0 rounded-4">
                    <div class="card-header bg-white border-bottom p-4">
                        <div class="row align-items-center">
                            <div class="col-md-4 mb-3 mb-md-0">
                                <span class="text-muted small fw-medium">Active Tasks: {{ $assignments->total() }} </span>
                            </div>
                            <div class="col-md-8">
                                <form method="GET" class="d-flex ms-auto">
                                    <div class="input-group input-group-sm ms-md-auto" style="max-width: 320px;">
                                        <input type="search" name="searchKey" value="{{ request('searchKey') }}"
                                            class="form-control rounded-start-pill ps-3" placeholder="Search...">
                                        <button class="btn btn-outline-secondary rounded-end-pill px-3">
                                            <i class="bi bi-search"></i>
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th class="ps-4 py-3 small fw-bold text-secondary">COURSE</th>
                                        <th class="py-3 small fw-bold text-secondary">TEACHER</th>
                                        <th class="py-3 small fw-bold text-secondary">TASK TITLE</th>
                                        <th class="py-3 small fw-bold text-secondary">STATUS</th>
                                        <th class="text-center pe-4 py-3 small fw-bold text-secondary">ACTION</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($assignments as $assignment)
                                        <tr>
                                            <td class="ps-4">
                                                <span class="badge bg-primary-subtle text-primary rounded-pill px-3">
                                                    {{ $assignment->course_title }}
                                                </span>
                                            </td>
                                            <td class="small fw-semibold text-dark">{{ $assignment->teacher_name }}</td>
                                            <td class="text-dark">{{ $assignment->task }}</td>

                                            {{-- STATUS --}}
                                            <td>
                                                @if ($assignment->file_path)
                                                    <span
                                                        class="badge bg-success-subtle text-success rounded-pill px-2">Submitted</span>
                                                @else
                                                    <span class="badge bg-warning-subtle text-warning rounded-pill px-2">Not
                                                        Submitted</span>
                                                @endif
                                            </td>

                                            {{-- ACTION --}}
                                            <td class="text-center pe-4">
                                                @if ($assignment->file_path)
                                                    <button class="btn btn-sm btn-secondary rounded-pill px-3 fw-bold"
                                                        disabled>Completed</button>
                                                @else
                                                    <a href="{{ route('student#viewAssignment', $assignment->assignment_id) }}"
                                                        class="btn btn-sm btn-primary rounded-pill px-3 shadow-sm fw-bold">View
                                                        Task</a>
                                                @endif
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center text-muted py-4">No assignments available.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer bg-white border-top p-3 d-flex justify-content-end">
                        {{ $assignments->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        /* Minimal CSS for badges and table hover */
        .bg-primary-subtle {
            background-color: #e7f1ff !important;
            color: #0d6efd !important;
        }

        .bg-success-subtle {
            background-color: #d1e7dd !important;
            color: #0f5132 !important;
        }

        .bg-warning-subtle {
            background-color: #fff3cd !important;
            color: #664d03 !important;
        }

        .bg-info-subtle {
            background-color: #cff4fc !important;
            color: #055160 !important;
        }

        .table-hover tbody tr:hover {
            background-color: #f8f9fa;
        }
    </style>
@endsection
