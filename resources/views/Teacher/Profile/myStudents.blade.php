@extends('Teacher.Layouts.master')

@section('content')
    <div class="container-fluid py-4 px-4" style="background-color: #f8f9fa; min-height: 100vh;">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h3 class="fw-bold text-dark mb-0">Student Directory</h3>
                <p class="text-muted small">Viewing all students enrolled in your courses.</p>
            </div>

            <form action="{{ route('teacher#myStudents') }}" method="GET" class="d-flex">
                <div class="input-group shadow-sm">
                    <span class="input-group-text bg-white border-0"><i class="bi bi-search text-muted"></i></span>
                    <input type="text" name="searchKey" value="{{ request('searchKey') }}"
                        class="form-control border-0 ps-0" placeholder="Name, Email, or Course..." style="width: 250px;">
                    <button type="submit" class="btn btn-primary px-4">Search</button>
                </div>
            </form>
        </div>

        <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr class="text-secondary small text-uppercase">
                            <th class="px-4 py-3">Student Details</th>
                            <th class="py-3">Course</th>
                            <th class="py-3">Roll Call</th>
                            <th class="py-3">Payment</th>
                            <th class="px-4 py-3 text-end">Contact</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white">
                        @forelse($students as $student)
                            <tr>
                                {{-- Student --}}
                                <td class="px-4">
                                    <div class="d-flex align-items-center">
                                        <div class="avatar-sm me-3 bg-primary-subtle text-primary rounded-circle d-flex align-items-center justify-content-center fw-bold"
                                            style="width: 40px; height: 40px;">
                                            {{ strtoupper(substr($student->name, 0, 1)) }}
                                        </div>
                                        <div>
                                            <div class="fw-bold text-dark">{{ $student->name }}</div>
                                            <div class="text-muted" style="font-size: 0.75rem;">
                                                {{ $student->email }}
                                            </div>
                                        </div>
                                    </div>
                                </td>

                                {{-- Course --}}
                                <td>
                                    <span class="fw-medium text-dark">
                                        {{ $student->course_title }}
                                    </span>
                                </td>

                                {{-- Roll Call --}}
                                <td>
                                    <span class="badge bg-dark-subtle text-dark rounded-pill px-3">
                                        #{{ $student->roll_call ?? '-' }}
                                    </span>
                                </td>

                                {{-- Payment Status (Approved Only) --}}
                                <td>
                                    <span
                                        class="badge bg-success-subtle text-success border border-success-subtle px-3 py-2 rounded-pill">
                                        <i class="bi bi-check-circle-fill me-1"></i> Paid
                                    </span>
                                </td>

                                {{-- Contact --}}
                                <td class="px-4 text-end">
                                    <a href="mailto:{{ $student->email }}"
                                        class="btn btn-sm btn-outline-primary rounded-pill px-3">
                                        <i class="bi bi-envelope-at me-1"></i> Email
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-5">
                                    <div class="text-muted">
                                        <i class="bi bi-people fs-1 d-block mb-3"></i>
                                        <p>No students enrolled in your courses yet.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>

                </table>
            </div>

            @if ($students->hasPages())
                <div class="card-footer bg-white border-0 py-3">
                    {{ $students->appends(request()->query())->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection
