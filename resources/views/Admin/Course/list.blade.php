@extends('layouts.master')

@section('content')
    <div class="container py-4 py-xl-5">
        <div class="row justify-content-center">

            <div class="col-12">

                {{-- Back Link Section (Good as is) --}}
                <div class="mb-3">
                    <a href="{{ route('admin#dashboard') }}" class="btn btn-sm btn-link text-secondary fw-medium p-0">
                        <i class="bi bi-chevron-left me-1"></i> Back to Dashboard
                    </a>
                </div>

                {{-- Title and Create Button Section (More compact) --}}
                <div class="d-flex justify-content-between align-items-center mb-4 border-bottom pb-3">
                    <h2 class="fw-bold text-dark m-0 fs-4"> Courses Lists</h2>

                </div>

                <div class="card shadow-sm border-0 rounded-4">

                    {{-- Card Header for contextual info and Search (Focused layout) --}}
                    <div class="card-header bg-white border-bottom p-4">
                        <div class="row align-items-center">
                            {{-- Total Courses Info --}}
                            <div class="col-md-4 mb-3 mb-md-0">
                                <span class="text-muted small fw-medium">Total Courses:
                                    {{ $courses->count() ?? 'N/A' }}
                                </span>
                            </div>

                            {{-- Search Bar/Filter (Longer and Centered in the remaining space) --}}
                            <div class="col-md-8">
                                <form action="{{ route('admin#courseList') }}" method="GET" class="d-flex ms-auto">
                                    <div class="input-group input-group-sm" style="max-width: 320px;">
                                        <input type="search" name="searchKey" class="form-control rounded-start-pill ps-3"
                                            placeholder="Search courses by title..." aria-label="Search courses">

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
                            {{-- Changed to a cleaner, basic table style --}}
                            <table class="table table-hover align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th class="small fw-bold text-secondary ps-4 py-3" scope="col"
                                            style="width: 8%;">
                                            Photo</th>
                                        <th class="small fw-bold text-secondary py-3" scope="col" style="width: 25%;">
                                            Title</th>
                                        <th class="small fw-bold text-secondary py-3" scope="col" style="width: 15%;">
                                            Dept.
                                        </th>
                                        <th class="small fw-bold text-secondary py-3" scope="col" style="width: 15%;">
                                            Instructor
                                        </th>
                                        <th class="small fw-bold text-secondary py-3" scope="col" style="width: 25%;">
                                            Price</th>
                                        <th class="small fw-bold text-secondary py-3" scope="col" style="width: 42%;">
                                            Description
                                        </th>
                                        @if (Auth::user()->role == 'superadmin')
                                            <th class="small fw-bold text-secondary text-center pe-4 py-3" scope="col"
                                                style="width: 10%;">Actions</th>
                                        @endif
                                    </tr>
                                </thead>
                                <tbody>


                                    @foreach ($courses as $item)
                                        <tr>
                                            {{-- Thumbnail (Image size minimized) --}}
                                            <td class="ps-4 py-3">
                                                <img src="{{ asset('courseImage/' . $item->image) }}" alt="Course Thumbnail"
                                                    class="img-fluid rounded-1 border"
                                                    style="width: 90px; height: 70px; object-fit: cover;">
                                            </td>
                                            <td class="fw-semibold text-dark">{{ $item->title }} </td>
                                            <td>
                                                {{-- Department badge made simpler --}}
                                                <span
                                                    class="badge bg-secondary-subtle text-secondary fw-medium p-2 text-uppercase rounded-pill">
                                                    {{ $item->department_name }}
                                                </span>
                                            </td>
                                            <td><span
                                                    class="badge bg-secondary-subtle text-secondary fw-medium p-2 text-uppercase rounded-pill">
                                                    {{ $item->teacher_name }}</span>
                                            </td>
                                            <td><span
                                                    class="badge bg-secondary-subtle text-secondary fw-medium p-2 text-uppercase rounded-pill">
                                                    {{ $item->price }}$</span>
                                            </td>
                                            <td>
                                                {{-- Description remains truncated --}}
                                                <p class="text-muted small mb-0 text-truncate" style="max-width: 450px;">
                                                    {{ $item->description }}
                                                </p>
                                            </td>

                                            {{-- Actions (Minimalist buttons) --}}
                                            @if (Auth::user()->role == 'superadmin')
                                                <td class="text-center pe-4">
                                                    <div class="btn-group btn-group-sm" role="group">
                                                        <button type="submit" onclick="deleteProcess({{ $item->id }})"
                                                            class="btn btn-sm btn-danger">
                                                            <i class="bi bi-trash"></i>
                                                        </button>



                                                    </div>
                                                </td>
                                            @endif
                                        </tr>
                                    @endforeach


                                </tbody>
                            </table>
                        </div>

                        {{-- Empty State Check (If courses is empty) --}}
                        @if ($courses->isEmpty())
                            <div class="p-4 text-center text-muted">
                                <i class="bi bi-info-circle me-2"></i> No created courses found.
                            </div>
                        @endif
                    </div>

                    {{-- Pagination --}}
                    <div class="card-footer bg-white border-top p-3 d-flex justify-content-end">
                        {{ $courses->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
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
                        location.href = '/admin/course/delete/' + $id
                    }, 1000);
                }
            });
        }
    </script>
@endsection
