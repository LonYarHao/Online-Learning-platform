@extends('Teacher.Layouts.master')

@section('content')
    <div class="container-fluid py-4 px-4">
        <div class="row mb-4">
            <div class="col-12 d-flex justify-content-between align-items-center">
                <h4 class="fw-bold text-dark">Grade History</h4>

                <form action="{{ route('teacher#myGrade') }}" method="GET" class="d-flex">
                    <div class="input-group shadow-sm">
                        <input type="text" name="searchKey" value="{{ request('searchKey') }}"
                            class="form-control border-0 px-3" placeholder="Search anything...">
                        <button type="submit" class="btn btn-primary px-3">
                            <i class="bi bi-search"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light">
                            <tr class="text-muted small">
                                <th class="ps-4">STUDENT</th>
                                <th>ASSIGNMENT</th>
                                <th class="text-center">GRADE</th>
                                <th>LAST UPDATED</th>
                                <th class="text-end pe-4">ACTIONS</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white">
                            @forelse($grades as $item)
                                <tr>
                                    <td class="px-4 py-3">
                                        <div class="fw-bold text-dark">{{ $item->student_name }}</div>
                                        <div class="text-muted" style="font-size: 0.75rem;">{{ $item->student_email }}</div>
                                    </td>
                                    <td>{{ $item->assignment_task }}</td>
                                    <td class="text-center">
                                        <div
                                            class="d-inline-block px-3 py-1 rounded-pill bg-success-subtle text-success fw-bold border border-success-subtle">
                                            {{ $item->grade }} / 10
                                        </div>
                                    </td>
                                    <td>
                                        <span class="text-muted small italic">"{{ Str::limit($item->feedback, 50) }}"</span>
                                    </td>
                                    <td class="px-4 text-end">
                                        <a href="{{ route('teacher#Grade', $item->id) }}"
                                            class="text-primary text-decoration-none small fw-bold">
                                            View Submission <i class="bi bi-arrow-right"></i>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="mt-4">
            {{ $grades->appends(request()->query())->links() }}
        </div>
    </div>
@endsection
