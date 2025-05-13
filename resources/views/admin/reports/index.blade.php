@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-2 text-gray-800">Spam Reports</h1>

    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Report ID</th>
                            <th>Type</th>
                            <th>Reported By</th>
                            <th>Content</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($reports as $report)
                        <tr>
                            <td>{{ $report->id }}</td>
                            <td>{{ $report->type }}</td>
                            <td>{{ $report->reporter->name }}</td>
                            <td>{{ Str::limit($report->reason, 50) }}</td>
                            <td>
                                <span class="badge {{ $report->resolved_at ? 'bg-success' : 'bg-warning' }}">
                                    {{ $report->resolved_at ? 'Resolved' : 'Pending' }}
                                </span>
                            </td>
                            <td>
                                <a href="#" class="btn btn-sm btn-primary">
                                    <i class="fas fa-eye"></i>
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                {{ $reports->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
