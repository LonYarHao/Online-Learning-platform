@extends('Student.Layouts.master')
@section('content')
    <main class="p-4 bg-light min-vh-100">
        <div class="container-fluid">
            <div class="d-flex justify-content-between mb-4">
                <h4 class="fw-bold">My Report History</h4>
                <a href="{{ route('student#createReportPage') }}" class="btn btn-primary btn-sm rounded-pill px-3">+ New
                    Report</a>
            </div>

            <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                <div class="table-responsive">
                    <table class="table align-middle mb-0">
                        <thead class="bg-light">
                            <tr class="small text-muted">
                                <th class="ps-4">Date</th>
                                <th>Subject</th>
                                <th>Message</th>
                                <th class="text-end pe-4">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($reports as $report)
                                <tr>
                                    <td class="ps-4 small">{{ $report->created_at->format('M d, Y') }}</td>
                                    <td class="fw-bold">{{ $report->title }}</td>
                                    <td class="text-muted small">{{ Str::limit($report->message, 40) }}</td>
                                    <td class="text-end pe-4">
                                        <span
                                            class="badge bg-secondary bg-opacity-10 text-secondary border">Submitted</span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center py-5 text-muted">No reports sent yet.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>
@endsection
