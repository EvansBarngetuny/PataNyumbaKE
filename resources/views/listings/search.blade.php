@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-5">
        <div>
            <h1 class="fw-bold">Search Results</h1>
            <p class="text-muted mb-0">
                @if(request('county') || request('category'))
                Showing properties
                @if(request('county')) in {{ request('county') }} @endif
                @if(request('category')) of type {{ str_replace('-', ' ', request('category')) }} @endif
                @else
                Showing all available properties
                @endif
            </p>
        </div>
        <span class="badge bg-primary">{{ $listings->total() }} results found</span>
    </div>

    <div class="row mb-4">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('listings.search') }}" method="GET">
                        <div class="row g-3">
                            <div class="col-md-5">
                                <select class="form-select" name="county">
                                    <option value="">All Counties</option>
                                    @foreach($counties as $county)
                                    <option value="{{ $county }}" {{ request('county') == $county ? 'selected' : '' }}>
                                        {{ $county }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-5">
                                <select class="form-select" name="category">
                                    <option value="">All Types</option>
                                    <option value="single" {{ request('category') == 'single' ? 'selected' : '' }}>
                                        Single Room</option>
                                    <option value="double" {{ request('category') == 'double' ? 'selected' : '' }}>
                                        Double Room</option>
                                    <option value="bedsitter"
                                        {{ request('category') == 'bedsitter' ? 'selected' : '' }}>Bedsitter</option>
                                    <option value="one-bedroom"
                                        {{ request('category') == 'one-bedroom' ? 'selected' : '' }}>One Bedroom
                                    </option>
                                    <option value="two-bedroom"
                                        {{ request('category') == 'two-bedroom' ? 'selected' : '' }}>Two Bedroom
                                    </option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <button type="submit" class="btn btn-primary w-100">Filter</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @if($listings->isEmpty())
    <div class="alert alert-warning text-center py-5">
        <i class="fas fa-exclamation-circle fa-3x mb-4"></i>
        <h3>No Matching Properties Found</h3>
        <p>Try adjusting your search filters or <a href="{{ route('listings.index') }}">browse all properties</a></p>
    </div>
    @else
    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
        @foreach($listings as $listing)
        @include('partials.listing-card', ['listing' => $listing])
        @endforeach
    </div>

    <div class="d-flex justify-content-center mt-5">
        {{ $listings->withQueryString()->links() }}
    </div>
    @endif
</div>
@endsection