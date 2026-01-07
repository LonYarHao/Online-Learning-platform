@extends('layouts.master')

@section('content')
    <div class="container-fluid py-4">
        <div class="row g-4">
            <div class="col-lg-4">
                <div class="card border-0 shadow-sm rounded-4">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center mb-3">
                            <div class="bg-primary bg-opacity-10 text-primary px-3 py-2 rounded-3 me-2">
                                <i class="fa-solid fa-building-circle-plus"></i>
                            </div>
                            <h5 class="card-title mb-0 fw-bold">Department</h5>
                        </div>

                        <form action="{{ route('admin#departmentCreate') }}" method="POST">
                            @csrf
                            <div class="mb-4">
                                <label for="departmentName" class="form-label small fw-bold text-muted">Department
                                    Name</label>
                                <input type="text"
                                    class="form-control form-control-lg bg-light border-0 @error('name') is-invalid @enderror"
                                    id="departmentName" name="name" placeholder="e.g. Computer Science"
                                    value="{{ old('name') }}" @if (Auth::user()->role !== 'superadmin') disabled @endif>
                                @error('name')
                                    <small class="invalid-feedback">{{ $message }}</small>
                                @enderror
                            </div>

                            @if (Auth::user()->role === 'superadmin')
                                <button type="submit" class="btn btn-primary btn-lg w-100 rounded-3 shadow-sm">
                                    <i class="fa-solid fa-plus me-2"></i>Create Department
                                </button>
                            @else
                                <button type="button" class="btn btn-secondary btn-lg w-100 rounded-3" disabled>
                                    <i class="fa-solid fa-lock me-2"></i>Superadmin Only
                                </button>
                            @endif
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-lg-8">
                <div class="card border-0 shadow-sm rounded-4">
                    <div class="card-body p-4">
                        <h5 class="card-title mb-4 fw-bold">Existing Departments</h5>
                        <div class="table-responsive">
                            <table class="table table-hover align-middle">
                                <thead class="bg-light">
                                    <tr class="text-muted small uppercase">
                                        <th class="border-0 ps-3">ID</th>
                                        <th class="border-0">Department Name</th>
                                        <th class="border-0">Created Date</th>
                                        <th class="border-0 text-end pe-3">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($departments as $item)
                                        <tr>
                                            <td class="ps-3 text-muted">#{{ $item->id }}</td>
                                            <td><span class="fw-semibold text-dark">{{ $item->name }}</span></td>
                                            <td>
                                                <span class="text-muted small">
                                                    <i class="fa-regular fa-calendar-days me-1"></i>
                                                    {{ $item->created_at->format('j M Y') }}
                                                </span>
                                            </td>
                                            <td class="text-end pe-3">
                                                <div class="btn-group shadow-sm rounded-2">
                                                    <a href="{{ route('admin#departmentEdit', $item->id) }}"
                                                        class="btn btn-white btn-sm border-end" title="Edit">
                                                        <i class="fa-solid fa-pen-to-square text-primary"></i>
                                                    </a>
                                                    @if (Auth::user()->role === 'superadmin')
                                                        <button type="button" class="btn btn-white btn-sm"
                                                            onclick="deleteProcess({{ $item->id }})" title="Delete">
                                                            <i class="fa-solid fa-trash text-danger"></i>
                                                        </button>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="text-center py-5 text-muted">
                                                No departments found.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-4 d-flex justify-content-end">
                            {{ $departments->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        /* Add this to your CSS for the "transition-up" effect */
        .btn-white {
            background: #fff;
            border: 1px solid #eee;
        }

        .btn-white:hover {
            background: #f8f9fa;
        }

        .card {
            transition: transform 0.2s ease;
        }

        .table thead th {
            font-size: 0.75rem;
            letter-spacing: 0.05em;
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
                        location.href = '/admin/department/delete/' + $id
                    }, 1000);
                }
            });
        }
    </script>
@endsection
