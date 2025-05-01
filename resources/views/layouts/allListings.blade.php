@extends('layouts.admin')

@section('content')
<div class="container">
    <h2 class="mb-4">All Listings</h2>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="card shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead class="bg-dark text-white">
                        <tr>
                            <th>#</th>
                            <th>Title</th>
                            <th>Category</th>
                            <th>Price</th>
                            <th>County</th>
                            <th>Estate</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($listings as $index => $listing)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $listing->title }}</td>
                                <td class="text-capitalize">{{ $listing->category }}</td>
                                <td>Ksh {{ number_format($listing->price, 2) }}</td>
                                <td>{{ $listing->county }}</td>
                                <td>{{ $listing->estate }}</td>
                                <td>
                                    @if($listing->is_verified)
                                        <span class="badge bg-success">Verified</span>
                                    @else
                                        <span class="badge bg-warning">Pending</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('listings.show', $listing->id) }}" class="btn btn-sm btn-primary">
                                        <i class="fas fa-eye"></i> View
                                    </a>
                                    <a href="#" class="btn btn-sm btn-warning">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                    <form action="#" method="POST" style="display:inline-block;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">
                                            <i class="fas fa-trash"></i> Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center text-muted">No listings found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="d-flex justify-content-center mt-3">
                {{ $listings->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
