@extends('layouts.master')

@section('content')
    <div class="container-fluid py-4 px-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4 class="fw-bold text-dark mb-0">Student Directory</h4>
                <p class="text-muted small">Overview of all registered students and their details.</p>
            </div>

            <div class="d-flex gap-3">
                <form action="{{ route('account#studentList') }}" method="GET" class="d-none d-sm-flex">
                    <div class="input-group shadow-sm">
                        <span class="input-group-text bg-white border-0"><i class="bi bi-search text-muted"></i></span>
                        <input type="text" name="searchKey" value="{{ request('searchKey') }}"
                            class="form-control border-0 ps-0" placeholder="Search students..." style="width: 200px;">
                        <button type="submit" class="btn btn-dark px-3">Find</button>
                    </div>
                </form>

                @if (Auth::user()->role == 'superadmin')
                    <a href="{{ route('account#createStudentPage') }}"
                        class="btn btn-primary shadow-sm rounded-3 px-4 d-flex align-items-center">
                        <i class="bi bi-person-plus me-2"></i> Add New Student
                    </a>
                @endif
            </div>
        </div>

        <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr class="text-secondary small text-uppercase">
                            <th class="ps-4 py-3">Student</th>
                            <th>Contact</th>
                            <th>Address</th>
                            <th class="text-center">Role</th>
                            @if (Auth::user()->role == 'superadmin')
                                <th class="text-end pe-4">Actions</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody class="bg-white">
                        @forelse ($studentList as $item)
                            <tr>
                                <td class="ps-4 py-3">
                                    <div class="d-flex align-items-center">
                                        @php
                                            // Simple logic to pick the right image source
                                            $imageSrc = $item->profile
                                                ? ($item->provider == 'simple'
                                                    ? asset('profile/' . $item->profile)
                                                    : $item->profile)
                                                : asset('defaultPic/defProfile.jpg');
                                        @endphp
                                        <img src="{{ $imageSrc }}"
                                            class="rounded-circle border border-2 border-white shadow-sm"
                                            style="width: 45px; height: 45px; object-fit: cover;" alt="profile">
                                        <div class="ms-3">
                                            <div class="fw-bold text-dark">{{ $item->name ?? $item->user_name }}</div>
                                            <div class="text-muted extra-small">ID: #{{ $item->id }}</div>
                                        </div>
                                    </div>
                                </td>

                                <td>
                                    <div class="small text-dark"><i
                                            class="bi bi-envelope me-2 text-muted"></i>{{ $item->email }}</div>
                                    <div class="small text-muted mt-1">
                                        <i class="bi bi-telephone me-2 text-muted"></i>{{ $item->phone ?? 'Not provided' }}
                                    </div>
                                </td>

                                <td>
                                    <span class="text-muted small">
                                        <i class="bi bi-geo-alt me-1"></i>
                                        {{ Str::limit($item->address ?? 'Not registered', 20) }}
                                    </span>
                                </td>

                                <td class="text-center">
                                    <span
                                        class="badge bg-secondary-subtle text-secondary rounded-pill px-3 py-2 fw-normal text-capitalize">
                                        {{ $item->role }}
                                    </span>
                                </td>

                                @if (Auth::user()->role === 'superadmin')
                                    <td class="text-end pe-4">
                                        <div class="btn-group shadow-sm rounded-3">

                                            <button type="button" onclick="deleteProcess({{ $item->id }})"
                                                class="btn btn-white btn-sm text-danger" title="Delete">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                @endif
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-5">
                                    <div class="text-muted">
                                        <i class="bi bi-search fs-1 d-block mb-3"></i>
                                        <p>No students found matches your criteria.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if ($studentList->hasPages())
                <div class="card-footer bg-white border-0 py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <small class="text-muted">Showing {{ $studentList->firstItem() }} to
                            {{ $studentList->lastItem() }} of {{ $studentList->total() }}</small>
                        {{ $studentList->appends(request()->query())->links() }}
                    </div>
                </div>
            @endif
        </div>
    </div>

    <style>
        .btn-white {
            background: #fff;
            border: 1px solid #eee;
        }

        .btn-white:hover {
            background: #f8f9fa;
        }

        .table thead th {
            font-size: 0.75rem;
            letter-spacing: 0.05em;
            font-weight: 600;
        }

        .rounded-4 {
            border-radius: 0.85rem !important;
        }

        .extra-small {
            font-size: 0.7rem;
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
                        location.href = '/admin/account/studentDelete/' + $id
                    }, 1000);
                }
            });
        }
    </script>
@endsection
