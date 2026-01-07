@extends('layouts.master')

@section('content')
    <div class="container-fluid py-4 px-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4 class="fw-bold text-dark mb-0">System Administrators</h4>
                <p class="text-muted small">Manage administrative privileges and system access.</p>
            </div>

            <div class="d-flex gap-3">
                <form action="{{ route('account#adminList') }}" method="GET" class="d-none d-sm-flex">
                    <div class="input-group shadow-sm">
                        <span class="input-group-text bg-white border-0"><i class="bi bi-search text-muted"></i></span>
                        <input type="text" name="searchKey" value="{{ request('searchKey') }}"
                            class="form-control border-0 ps-0" placeholder="Search admins..." style="width: 200px;">
                        <button type="submit" class="btn btn-dark px-3">Find</button>
                    </div>
                </form>

                <a href="{{ route('account#createAdminPage') }}"
                    class="btn btn-dark shadow-sm rounded-3 px-4 d-flex align-items-center">
                    <i class="bi bi-shield-plus me-2"></i> Add Admin
                </a>
            </div>
        </div>

        <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr class="text-secondary small text-uppercase">
                            <th class="ps-4 py-3" style="width: 100px;">ID</th>
                            <th>Administrator</th>
                            <th>Contact info</th>
                            <th>Role</th>
                            <th class="text-end pe-4">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white">
                        @forelse ($adminList as $item)
                            <tr>
                                <td class="ps-4 text-muted fw-medium">#{{ $item->id }}</td>

                                <td>
                                    <div class="d-flex align-items-center">
                                        <img src="{{ $item->profile ? asset('profile/' . $item->profile) : asset('defaultPic/defProfile.jpg') }}"
                                            class="rounded-circle border border-2 border-white shadow-sm"
                                            style="width: 45px; height: 45px; object-fit: cover;" alt="profile">
                                        <div class="ms-3">
                                            <div class="fw-bold text-dark">{{ $item->name ?? $item->user_name }}</div>
                                            <div class="text-muted extra-small">{{ $item->email }}</div>
                                        </div>
                                    </div>
                                </td>

                                <td>
                                    <div class="small"><i
                                            class="bi bi-telephone me-2 text-muted"></i>{{ $item->phone ?? '---' }}</div>
                                    <div class="extra-small text-muted mt-1">
                                        <i
                                            class="bi bi-geo-alt me-2"></i>{{ Str::limit($item->address ?? 'No address', 30) }}
                                    </div>
                                </td>

                                <td>
                                    @if ($item->role == 'superadmin')
                                        <span class="badge bg-primary rounded-pill px-3 py-2 fw-normal">
                                            <i class="bi bi-patch-check-fill me-1"></i> Superadmin
                                        </span>
                                    @else
                                        <span class="badge bg-light text-dark border rounded-pill px-3 py-2 fw-normal">
                                            Admin
                                        </span>
                                    @endif
                                </td>

                                <td class="text-end pe-4">
                                    <div class="btn-group shadow-sm rounded-3">


                                        @if ($item->role != 'superadmin')
                                            <button type="button" onclick="deleteProcess({{ $item->id }})"
                                                class="btn btn-white btn-sm text-danger" title="Remove Admin">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        @else
                                            <button type="button" class="btn btn-white btn-sm" disabled
                                                title="Cannot delete Superadmin">
                                                <i class="bi bi-lock text-muted"></i>
                                            </button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-5 text-muted">
                                    <i class="bi bi-shield-slash fs-1 d-block mb-3"></i>
                                    No admin accounts found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if ($adminList->hasPages())
                <div class="card-footer bg-white border-0 py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <small class="text-muted">Total Admins: {{ $adminList->total() }}</small>
                        {{ $adminList->appends(request()->query())->links() }}
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
            font-size: 0.75rem;
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
                        location.href = '/admin/account/adminDelete/' + $id
                    }, 1000);
                }
            });
        }
    </script>
@endsection
