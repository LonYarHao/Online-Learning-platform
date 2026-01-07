@extends('layouts.master')

@section('content')
    <div class="container-fluid py-4 px-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4 class="fw-bold text-dark mb-0">Teacher Directory</h4>
                <p class="text-muted small">Manage and view all registered instructors.</p>
            </div>

            <div class="d-flex gap-3">
                <form action="{{ route('account#teacherList') }}" method="GET" class="d-none d-sm-flex">
                    <div class="input-group shadow-sm">
                        <span class="input-group-text bg-white border-0"><i class="bi bi-search text-muted"></i></span>
                        <input type="text" name="searchKey" value="{{ request('searchKey') }}"
                            class="form-control border-0 ps-0" placeholder="Search teacher..." style="width: 200px;">
                        <button type="submit" class="btn btn-dark px-3">Find</button>
                    </div>
                </form>

                @if (Auth::user()->role == 'superadmin')
                    <a href="{{ route('account#createTeacherPage') }}"
                        class="btn btn-primary shadow-sm rounded-3 px-4 d-flex align-items-center">
                        <i class="bi bi-plus-lg me-2"></i> Add New Teacher
                    </a>
                @endif
            </div>
        </div>

        <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr class="text-secondary small text-uppercase">
                            <th class="ps-4 py-3">Instructor</th>
                            <th>Contact Info</th>
                            <th>Address</th>
                            <th class="text-center">Role</th>
                            @if (Auth::user()->role == 'superadmin')
                                <th class="text-end pe-4">Actions</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody class="bg-white">
                        @forelse ($teacherList as $item)
                            <tr>
                                <td class="ps-4 py-3">
                                    <div class="d-flex align-items-center">
                                        <div class="position-relative">
                                            <img src="{{ $item->profile ? asset('profile/' . $item->profile) : asset('defaultPic/defProfile.jpg') }}"
                                                class="rounded-circle border border-2 border-white shadow-sm"
                                                style="width: 48px; height: 48px; object-fit: cover;" alt="profile">
                                        </div>
                                        <div class="ms-3">
                                            <div class="fw-bold text-dark">{{ $item->name ?? $item->user_name }}</div>
                                            <div class="text-muted small">ID: #{{ $item->id }}</div>
                                        </div>
                                    </div>
                                </td>

                                <td>
                                    <div class="text-dark small"><i
                                            class="bi bi-envelope me-2 text-muted"></i>{{ $item->email }}</div>
                                    <div class="text-muted small mt-1">
                                        <i class="bi bi-telephone me-2 text-muted"></i>{{ $item->phone ?? 'No phone' }}
                                    </div>
                                </td>

                                <td>
                                    <span class="text-muted small">
                                        <i class="bi bi-geo-alt me-1"></i>
                                        {{ Str::limit($item->address ?? 'Not registered yet', 25) }}
                                    </span>
                                </td>

                                <td class="text-center">
                                    <span
                                        class="badge bg-dark-subtle text-dark rounded-pill px-3 py-2 fw-normal text-capitalize">
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
                                        <i class="bi bi-people fs-1 d-block mb-3"></i>
                                        <p>No teachers found in the records.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if ($teacherList->hasPages())
                <div class="card-footer bg-white border-0 py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <small class="text-muted">Showing {{ $teacherList->firstItem() }} to
                            {{ $teacherList->lastItem() }}</small>
                        {{ $teacherList->appends(request()->query())->links() }}
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
        }

        .rounded-4 {
            border-radius: 1rem !important;
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
                        location.href = '/admin/account/teacherDelete/' + $id
                    }, 1000);
                }
            });
        }
    </script>
@endsection
