@extends('Teacher.Layouts.master')

@section('content')
    <div class="container py-4 py-xl-5">
        <div class="row justify-content-center">
            <div class="col-12">

                {{-- Back Link Section --}}
                <div class="mb-3">
                    <a href="{{ route('teacher#dashboard') }}"
                        class="btn btn-sm btn-link text-secondary fw-medium p-0 text-decoration-none">
                        <i class="bi bi-chevron-left me-1"></i> Back to Dashboard
                    </a>
                </div>

                {{-- Title and Upload Button Section --}}
                <div class="d-flex justify-content-between align-items-center mb-4 border-bottom pb-3">
                    <h2 class="fw-bold text-dark m-0 fs-4">Course Assignments</h2>
                    <a href="{{ route('teacher#createAssignmentPage') }}"
                        class="btn btn-sm btn-success rounded-3 px-4 shadow-sm fw-semibold">
                        <i class="bi bi-plus-lg me-1"></i> Upload New Task
                    </a>
                </div>

                <div class="card shadow-sm border-0 rounded-4">

                    {{-- Card Header with Search --}}
                    <div class="card-header bg-white border-bottom p-4">
                        <div class="row align-items-center">
                            {{-- Contextual Info --}}
                            {{-- Contextual Info --}}
                            <div class="col-md-4 mb-3 mb-md-0">
                                <span class="text-muted small fw-medium">
                                    Total Assignments: {{ $assignments->total() }}
                                </span>
                            </div>

                            {{-- Search Bar --}}
                            <div class="col-md-8">
                                <form action="{{ route('teacher#myAssignment') }}" method="GET" class="d-flex ms-auto">

                                    <div class="input-group input-group-sm ms-md-auto" style="max-width: 320px;">
                                        <input type="search" name="searchKey" value="{{ request('searchKey') }}"
                                            class="form-control rounded-start-pill ps-3"
                                            placeholder="Search by task title...">

                                        <button type="submit" class="btn btn-outline-secondary rounded-end-pill px-3">
                                            <i class="bi bi-search"></i>
                                        </button>
                                    </div>
                                </form>
                            </div>

                        </div>
                    </div>

                    {{-- Card Body for Table --}}
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th class="small fw-bold text-secondary ps-4 py-3" style="width: 10%;">ID</th>
                                        <th class="small fw-bold text-secondary py-3" style="width: 15%;">Course ID</th>
                                        <th class="small fw-bold text-secondary py-3" style="width: 15%;">Teacher ID</th>
                                        <th class="small fw-bold text-secondary py-3" style="width: 30%;">Task Title</th>
                                        <th class="small fw-bold text-secondary py-3" style="width: 15%;">Created At</th>
                                        <th class="small fw-bold text-secondary text-center pe-4 py-3" style="width: 15%;">
                                            Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($assignments->count() > 0)
                                        @foreach ($assignments as $assignment)
                                            <tr>
                                                <td class="ps-4 py-3 text-muted small">
                                                    {{ $assignment->id }}
                                                </td>

                                                <td>
                                                    <span
                                                        class="badge bg-secondary-subtle text-secondary fw-medium p-2 rounded-pill">
                                                        {{ $assignment->course_title }}
                                                    </span>
                                                </td>

                                                <td class="text-dark small">
                                                    {{ $assignment->teacher_id }}
                                                </td>

                                                <td class="fw-semibold text-dark">
                                                    {{ $assignment->task }}
                                                </td>

                                                <td class="text-muted small">
                                                    {{ $assignment->created_at }}
                                                </td>

                                                <td class="text-center pe-4">


                                                    <button class="btn btn-outline-danger btn-sm"
                                                        onclick="deleteProcess({{ $assignment->id }})">
                                                        <i class="bi bi-trash3"></i>
                                                    </button>

                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="6" class="text-center text-muted py-4">
                                                No assignments found.
                                            </td>
                                        </tr>
                                    @endif
                                </tbody>

                            </table>
                        </div>

                        {{-- Empty State --}}
                        <div class="p-5 text-center text-muted d-none">
                            <i class="bi bi-clipboard-x fs-2 mb-2 d-block"></i>
                            No assignments found.
                        </div>
                    </div>

                    {{-- Pagination Footer --}}
                    <div class="card-footer bg-white border-top p-3 d-flex justify-content-end">
                        {{ $assignments->links() }}
                    </div>

                </div>
            </div>
        </div>
    </div>

    <style>
        /* Styling to match your provided platform aesthetic */
        .table thead th {
            letter-spacing: 0.03rem;
            border-bottom: 1px solid #f0f0f0;
        }

        .badge.bg-secondary-subtle {
            background-color: #f8f9fa !important;
            border: 1px solid #e9ecef;
            color: #6c757d !important;
        }

        .btn-link:hover {
            color: #0d6efd !important;
        }

        .form-control:focus {
            border-color: #dee2e6;
            box-shadow: none;
        }
    </style>
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
                        location.href = '/teacher/assignment/deleteAssignment/' + $id
                    }, 1000);
                }
            });
        }
    </script>
@endsection
