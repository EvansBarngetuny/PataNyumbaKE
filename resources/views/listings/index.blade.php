@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-5">
        <h1 class="fw-bold">All Available Properties</h1>
        <div class="dropdown">
            <button class="btn btn-outline-primary dropdown-toggle" type="button" id="sortDropdown"
                data-bs-toggle="dropdown" aria-expanded="false">
                <i class="fas fa-sort me-2"></i>Sort By
            </button>
            <ul class="dropdown-menu" aria-labelledby="sortDropdown">
                <li><a class="dropdown-item" href="?sort=newest">Newest First</a></li>
                <li><a class="dropdown-item" href="?sort=price_asc">Price (Low to High)</a></li>
                <li><a class="dropdown-item" href="?sort=price_desc">Price (High to Low)</a></li>
                <li><a class="dropdown-item" href="?sort=verified">Verified First</a></li>
            </ul>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-md-6">
            <form action="{{ route('listings.search') }}" method="GET">
                <div class="input-group">
                    <input type="text" class="form-control" name="search" placeholder="Search by location, estate..."
                        value="{{ request('search') }}">
                    <button class="btn btn-primary" type="submit"><i class="fas fa-search"></i></button>
                </div>
            </form>
        </div>
        <div class="col-md-6">
            <div class="d-flex justify-content-end">
                <a href="{{ route('listings.index') }}" class="btn btn-outline-secondary me-2"><i
                        class="fas fa-sync-alt"></i></a>
                <div class="btn-group" role="group">
                    <a href="?view=list" class="btn btn-outline-secondary"><i class="fas fa-list"></i></a>
                    <a href="?view=grid" class="btn btn-outline-secondary active"><i class="fas fa-th-large"></i></a>
                </div>
            </div>
        </div>
    </div>

    @if($listings->isEmpty())
    <div class="alert alert-info text-center py-5">
        <i class="fas fa-home fa-3x mb-4 text-primary"></i>
        <h3>No Properties Available</h3>
        <p class="lead">There are currently no properties matching your criteria.</p>
        @auth
        @if(auth()->user()->role === 'landlord' || auth()->user()->role === 'admin')
        <a href="{{ route('listings.create') }}" class="btn btn-primary mt-3">
            <i class="fas fa-plus me-2"></i>List Your Property
        </a>
        @endif
        @endauth
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