@extends('Teacher.Layouts.master')

@section('content')
    <main class="p-4 bg-light min-vh-100">
        <div class="container-fluid">

            <div class="row mb-4 align-items-center">
                <div class="col-md-6">
                    <h4 class="fw-bold mb-0 text-dark">My Support Tickets</h4>
                    <p class="text-muted small mb-0">Track the status of your reported issues.</p>
                </div>
                <div class="col-md-6 text-md-end mt-3 mt-md-0">
                    <a href="{{ route('teacher#createReportPage') }}"
                        class="btn btn-primary rounded-3 px-4 shadow-sm fw-bold">
                        <i class="fa-solid fa-paper-plane me-2"></i>Send New Report
                    </a>
                </div>
            </div>

            <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="bg-light">
                                <tr class="text-muted small text-uppercase">
                                    <th class="ps-4 border-0 py-3">Reference ID</th>
                                    <th class="border-0 py-3">Subject</th>
                                    <th class="border-0 py-3">Message Snippet</th>
                                    <th class="border-0 py-3">Date Sent</th>

                                </tr>
                            </thead>
                            <tbody>
                                @forelse($reports as $report)
                                    <tr>
                                        <td class="ps-4 fw-bold text-primary">#RP-{{ $report->id }}</td>
                                        <td>
                                            <span class="fw-semibold text-dark">{{ $report->title }}</span>
                                        </td>
                                        <td>
                                            <span class="text-muted small">{{ Str::limit($report->message, 50) }}</span>
                                        </td>
                                        <td>
                                            <span class="text-muted small">
                                                {{ $report->created_at->format('M d, Y') }}
                                                <br>
                                                <small class="opacity-75">{{ $report->created_at->diffForHumans() }}</small>
                                            </span>
                                        </td>

                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center py-5">
                                            <div class="py-4">
                                                <i
                                                    class="fa-solid fa-clipboard-question fs-1 text-muted opacity-25 mb-3"></i>
                                                <h6 class="text-muted fw-normal">You haven't submitted any reports yet.</h6>
                                                <p class="small text-muted opacity-75">When you report an issue, it will
                                                    appear here.</p>
                                            </div>
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

    <style>
        .hvr-lift:hover {
            transform: translateY(-2px);
            transition: 0.2s;
        }
    </style>
@endsection
