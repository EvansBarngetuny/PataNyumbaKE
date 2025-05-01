<div class="col-lg-4 col-md-6 mb-4">
    <div class="card h-100 shadow-sm border-0 overflow-hidden">
        <!-- Status Badge -->
        <div class="position-absolute top-0 end-0 m-3">
            <span class="badge rounded-pill 
                    {{ $listing->status == 'vacant' ? 'bg-success' : '' }}
                    {{ $listing->status == 'booked' ? 'bg-warning text-dark' : '' }}
                    {{ $listing->status == 'taken' ? 'bg-danger' : '' }}">
                {{ ucfirst($listing->status) }}
            </span>
        </div>

        <!-- Image Carousel -->
        @if($listing->images && count(json_decode($listing->images)) > 0)
        <div id="carousel{{ $listing->id }}" class="carousel slide">
            <div class="carousel-inner ratio ratio-16x9">
                @foreach(json_decode($listing->images) as $key => $image)
                <div class="carousel-item {{ $key == 0 ? 'active' : '' }}">
                    <img src="{{ asset('storage/' . $image) }}" class="d-block w-100" alt="Property Image"
                        style="object-fit: cover;">
                </div>
                @endforeach
            </div>
        </div>
        @endif

        <div class="card-body">
            <div class="d-flex justify-content-between align-items-start mb-2">
                <h5 class="card-title mb-0">{{ $listing->title }}</h5>
                <span class="badge bg-primary">{{ ucfirst($listing->category) }}</span>
            </div>

            <p class="text-muted mb-3">
                <i class="fas fa-map-marker-alt"></i> {{ $listing->estate }}, {{ $listing->county }}
            </p>

            <p class="card-text text-truncate-3">{{ $listing->description }}</p>

            <div class="d-flex justify-content-between align-items-center mt-4">
                <h4 class="text-primary mb-0">Ksh {{ number_format($listing->price, 2) }}</h4>
                @if($listing->is_verified)
                <span class="badge bg-success"><i class="fas fa-check-circle me-1"></i> Verified</span>
                @endif
            </div>
        </div>

        <div class="card-footer bg-transparent border-top-0 pt-0">
            <a href="{{ route('listings.show', $listing->id) }}" class="btn btn-outline-primary w-100">
                <i class="fas fa-eye me-2"></i>View Details
            </a>
        </div>
    </div>
</div>