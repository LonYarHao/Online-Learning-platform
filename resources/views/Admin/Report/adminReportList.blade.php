@extends('layouts.master')

@section('content')
    <main class="p-4 bg-light min-vh-100">

        <div class="container-fluid">

            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h4 class="fw-bold mb-0 text-dark">System Reports</h4>
                    <p class="text-muted small mb-0">
                        Reports submitted by Teachers and Students to Departments
                    </p>
                </div>

                <div class="text-end">
                    <span class="badge bg-white text-dark shadow-sm border px-3 py-2 rounded-pill">
                        <i class="fa-solid fa-layer-group me-1 text-primary"></i> All Reports
                    </span>
                </div>
            </div>

            <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                <div class="card-body p-0">

                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="bg-light">
                                <tr class="text-muted small text-uppercase">
                                    <th class="ps-4 border-0 py-3">Sender & Department</th>
                                    <th class="border-0 py-3">Issue Title</th>
                                    <th class="border-0 py-3">Message</th>
                                    <th class="border-0 py-3">Date</th>
                                    <th class="pe-4 border-0 py-3 text-end">Action</th>
                                </tr>
                            </thead>

                            <tbody>
                                @forelse($reports as $report)
                                    <tr>
                                        {{-- Sender --}}
                                        <td class="ps-4">
                                            <div class="d-flex align-items-center">

                                                <div class="rounded-circle p-2 me-3 text-center
                                                {{ $report->user_role === 'teacher' ? 'bg-primary bg-opacity-10' : 'bg-success bg-opacity-10' }}"
                                                    style="width: 38px; height: 38px;">
                                                    <i
                                                        class="fa-solid {{ $report->user_role === 'teacher' ? 'fa-user-tie text-primary' : 'fa-user-graduate text-success' }}"></i>
                                                </div>

                                                <div>
                                                    <div class="fw-bold text-dark" style="font-size: 0.9rem;">
                                                        {{ $report->user_name }}
                                                    </div>

                                                    <div class="d-flex gap-1 mt-1">
                                                        <span class="badge bg-light text-muted border fw-normal"
                                                            style="font-size: 0.65rem;">
                                                            {{ strtoupper($report->user_role) }}
                                                        </span>

                                                        <span
                                                            class="badge bg-info bg-opacity-10 text-info border border-info border-opacity-25 fw-normal"
                                                            style="font-size: 0.65rem;">
                                                            <i class="fa-solid fa-tag me-1"></i>
                                                            {{ $report->department_name ?? 'No Dept' }}
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>

                                        {{-- Title --}}
                                        <td>
                                            <span class="fw-semibold text-dark" style="font-size: 0.9rem;">
                                                {{ $report->title }}
                                            </span>
                                        </td>

                                        {{-- Message --}}
                                        <td>
                                            <p class="text-muted small mb-0">
                                                {{ Str::limit($report->message, 45) }}
                                            </p>
                                        </td>

                                        {{-- Date --}}
                                        <td>
                                            <div class="text-muted small">
                                                {{ $report->created_at->format('d M Y') }}
                                                <div class="extra-small opacity-75">
                                                    {{ $report->created_at->diffForHumans() }}
                                                </div>
                                            </div>
                                        </td>

                                        {{-- Action --}}
                                        <td class="pe-4 text-end">
                                            <button class="btn btn-sm btn-white border shadow-sm rounded-2"
                                                data-bs-toggle="modal" data-bs-target="#reportModal{{ $report->id }}">
                                                <i class="fa-solid fa-eye text-primary"></i>
                                            </button>


                                            <button class="btn btn-sm btn-white border shadow-sm rounded-2 ms-1"
                                                onclick="deleteProcess({{ $report->id }})">
                                                <i class="fa-solid fa-trash text-danger"></i>
                                            </button>
                                        </td>
                                    </tr>

                                    {{-- MODAL --}}
                                    <div class="modal fade" id="reportModal{{ $report->id }}" tabindex="-1">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content border-0 rounded-4 shadow-lg">

                                                <div class="modal-body p-4">

                                                    <div class="d-flex justify-content-between align-items-start mb-3">
                                                        <div>
                                                            <span class="badge bg-primary mb-2">Detailed Report</span>
                                                            <h5 class="fw-bold">{{ $report->title }}</h5>
                                                        </div>
                                                        <button type="button" class="btn-close"
                                                            data-bs-dismiss="modal"></button>
                                                    </div>

                                                    <hr class="opacity-25">

                                                    <div class="mb-3">
                                                        <label class="small text-muted fw-bold text-uppercase">
                                                            From {{ ucfirst($report->user_role) }}
                                                        </label>
                                                        <p class="mb-0">
                                                            {{ $report->user_name }}
                                                            <span class="text-muted">
                                                                ({{ $report->department_name ?? 'No Dept' }})
                                                            </span>
                                                        </p>
                                                    </div>

                                                    <div>
                                                        <label class="small text-muted fw-bold text-uppercase">
                                                            Description
                                                        </label>
                                                        <div class="bg-light p-3 rounded-3 mt-1 small text-dark">
                                                            {{ $report->message }}
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center py-5">
                                            <img src="https://cdn-icons-png.flaticon.com/512/7486/7486744.png"
                                                width="60" class="opacity-25 mb-3">
                                            <p class="text-muted">No reports found.</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </main>
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
                        location.href = '/admin/report/deleteReport/' + $id
                    }, 1000);
                }
            });
        }
    </script>
@endsection
