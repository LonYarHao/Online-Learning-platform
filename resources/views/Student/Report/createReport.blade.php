@extends('Student.Layouts.master')
@section('content')
    <main class="p-4 bg-light min-vh-100">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-lg-6">
                    <div class="card border-0 shadow-sm rounded-4">
                        <div class="card-body p-4">
                            <h5 class="fw-bold mb-4">Submit a Report</h5>
                            <form action="{{ route('student#sendReport') }}" method="POST">
                                @csrf
                                <div class="mb-3">
                                    <label class="form-label small fw-bold text-muted">Which Department?</label>
                                    <select name="department_id" class="form-select bg-light border-0 py-2">
                                        <option value="" selected disabled>Select Department...</option>
                                        @foreach ($departments as $dep)
                                            <option value="{{ $dep->id }}">{{ $dep->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label small fw-bold text-muted">Issue Title</label>
                                    <input type="text" name="title" class="form-control bg-light border-0 py-2"
                                        placeholder="Subject">
                                </div>

                                <div class="mb-4">
                                    <label class="form-label small fw-bold text-muted">Description</label>
                                    <textarea name="message" rows="5" class="form-control bg-light border-0 py-2"
                                        placeholder="Tell us what's wrong..."></textarea>
                                </div>

                                <button type="submit" class="btn btn-primary w-100 fw-bold py-2 rounded-3">Submit
                                    Report</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
