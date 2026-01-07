@extends('Student.Layouts.master')

@section('content')
    <div class="container-fluid py-4 px-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4 class="fw-bold mb-0 text-dark">My Grade History</h4>
                <p class="text-muted small">Track your performance across all enrolled courses.</p>
            </div>

            <form action="{{ route('student#myGrade') }}" method="GET" class="d-flex">
                <div class="input-group shadow-sm">
                    <input type="text" name="searchKey" value="{{ request('searchKey') }}" class="form-control border-0"
                        placeholder="Search course or task...">
                    <button class="btn btn-primary px-3" type="submit">
                        <i class="bi bi-search"></i>
                    </button>
                </div>
            </form>
        </div>

        <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr class="text-secondary small text-uppercase fw-bold">
                            <th class="px-4 py-3">Assignment / Task</th>
                            <th class="py-3">Course</th>
                            <th class="py-3 text-center">Score</th>
                            <th class="py-3">Teacher's Feedback</th>
                            <th class="px-4 py-3 text-end">Details</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white">
                        @forelse($grades as $item)
                            <tr>
                                <td class="px-4">
                                    <div class="fw-bold text-dark">{{ $item->assignment_task }}</div>
                                    <div class="text-muted extra-small">Graded: {{ $item->updated_at->format('M d, Y') }}
                                    </div>
                                </td>
                                <td>
                                    <span class="badge bg-secondary-subtle text-secondary rounded-pill px-3 fw-normal">
                                        {{ $item->course_title }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    <div class="h5 mb-0 fw-bold {{ $item->grade >= 5 ? 'text-success' : 'text-danger' }}">
                                        {{ $item->grade }}<span class="small text-muted">/10</span>
                                    </div>
                                </td>
                                <td>
                                    <p class="text-muted small mb-0 italic">
                                        {{ Str::limit($item->feedback, 45, '...') }}
                                    </p>
                                </td>
                                <td class="px-4 text-end">
                                    <a href="{{ route('student#gradeDetail', $item->id) }}"
                                        class="btn btn-sm btn-light rounded-pill border shadow-sm px-3">
                                        View Full Report
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-5">
                                    <i class="bi bi-journal-x display-4 text-muted"></i>
                                    <p class="mt-3 text-muted">No graded assignments found.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if ($grades->hasPages())
                <div class="card-footer bg-white border-0 py-3">
                    {{ $grades->appends(request()->query())->links() }}
                </div>
            @endif
        </div>
    </div>

    <style>
        .extra-small {
            font-size: 0.75rem;
        }

        .italic {
            font-style: italic;
        }
    </style>
@endsection
