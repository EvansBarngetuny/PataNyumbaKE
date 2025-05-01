@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4 text-center">Available Listings</h2>

    <div class="row">
        @foreach($listings as $listing)
        <div class="col-md-4 mb-4">
            <div class="card shadow-sm">
                <!-- Image Carousel -->
                <div id="carousel{{ $listing->id }}" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-inner">
                        @foreach(json_decode($listing->images) as $key => $image)
                        <div class="carousel-item {{ $key == 0 ? 'active' : '' }}">
                            <img src="{{ asset('storage/' . $image) }}" class="d-block w-100" alt="Listing Image">
                        </div>
                        @endforeach
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#carousel{{ $listing->id }}" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#carousel{{ $listing->id }}" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    </button>
                </div>

                <div class="card-body">
                    <h5 class="card-title">{{ $listing->title }}</h5>
                    <p class="text-muted"><i class="fas fa-map-marker-alt"></i> {{ $listing->estate }}, {{ $listing->county }}</p>

                    <div class="d-flex justify-content-between align-items-center">
                        <span class="badge bg-primary">{{ ucfirst($listing->category) }}</span>
                        @if($listing->is_verified)
                        <span class="badge bg-success"><i class="fas fa-check-circle"></i> Verified</span>
                        @else
                        <span class="badge bg-warning"><i class="fas fa-exclamation-circle"></i> Unverified</span>
                        @endif
                    </div>

                    <p class="mt-3">{{ Str::limit($listing->description, 100) }}</p>
                    <h4 class="text-primary">Ksh {{ number_format($listing->price, 2) }}</h4>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Pagination -->
    <div class="d-flex justify-content-center mt-4">
        {{ $listings->links() }}
    </div>
</div>
@endsection
