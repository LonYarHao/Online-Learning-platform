@extends('Student.Layouts.master')

@section('content')
    <div class="container py-4">
        <h4 class="fw-bold mb-4">My Academic Progress</h4>

        <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr class="small text-uppercase text-muted">
                            <th class="ps-4">Course & Assignment</th>
                            <th class="text-center">Score</th>
                            <th>Date Graded</th>
                            <th class="text-end pe-4">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($grades as $item)
                            <tr>
                                <td class="ps-4">
                                    <div class="fw-bold text-dark">{{ $item->assignment_title }}</div>
                                    <div class="text-muted small">{{ $item->course_title }}</div>
                                </td>
                                <td class="text-center">
                                    <span class="badge bg-primary-subtle text-primary rounded-pill px-3">
                                        {{ $item->grade }} / 10
                                    </span>
                                </td>
                                <td class="text-muted small">{{ $item->updated_at->format('M d, Y') }}</td>
                                <td class="text-end pe-4">
                                    <a href="{{ route('student#gradeDetail', $item->id) }}"
                                        class="btn btn-sm btn-outline-primary rounded-pill">
                                        View Feedback
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center py-5 text-muted">No grades recorded yet.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
