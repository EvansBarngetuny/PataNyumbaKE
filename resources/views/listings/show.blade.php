@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-lg-8">
            <!-- Listing Gallery -->
            <div class="card mb-4 border-0 shadow-sm">
                @if($listing->images && count(json_decode($listing->images)) > 0)
                <div id="mainCarousel" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-inner ratio ratio-16x9">
                        @foreach(json_decode($listing->images) as $key => $image)
                        <div class="carousel-item {{ $key == 0 ? 'active' : '' }}">
                            <img src="{{ asset('storage/' . $image) }}" class="d-block w-100" alt="Property image"
                                style="object-fit: cover;">
                        </div>
                        @endforeach
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#mainCarousel"
                        data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#mainCarousel"
                        data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    </button>
                </div>

                <div class="p-3">
                    <div class="row g-2">
                        @foreach(json_decode($listing->images) as $key => $image)
                        <div class="col-3">
                            <a href="#" class="d-block thumbnail" data-bs-target="#mainCarousel"
                                data-bs-slide-to="{{ $key }}">
                                <img src="{{ asset('storage/' . $image) }}" class="img-fluid rounded" alt="Thumbnail">
                            </a>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif
            </div>

            <!-- Listing Details -->
            <div class="card mb-4 border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <h2 class="card-title mb-0">{{ $listing->title }}</h2>
                        <div>
                            <span class="badge bg-primary">{{ ucfirst($listing->category) }}</span>
                            @if($listing->is_verified)
                            <span class="badge bg-success"><i class="fas fa-check-circle"></i> Verified</span>
                            @endif
                        </div>
                    </div>

                    <div class="d-flex align-items-center text-muted mb-4">
                        <i class="fas fa-map-marker-alt me-2"></i>
                        <span>{{ $listing->estate }}, {{ $listing->county }}</span>
                    </div>

                    <h4 class="text-primary mb-4">Ksh {{ number_format($listing->price, 2) }} <small
                            class="text-muted">/ month</small></h4>

                    <div class="mb-4">
                        <h5 class="mb-3">Description</h5>
                        <p class="card-text">{{ $listing->description }}</p>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h5 class="mb-3">Details</h5>
                            <ul class="list-unstyled">
                                <li class="mb-2"><i class="fas fa-home me-2 text-primary"></i> Type:
                                    {{ str_replace('-', ' ', ucfirst($listing->category)) }}</li>
                                <li class="mb-2"><i class="fas fa-calendar-alt me-2 text-primary"></i> Posted:
                                    {{ $listing->created_at->diffForHumans() }}</li>
                                <li class="mb-2"><i class="fas fa-sync-alt me-2 text-primary"></i> Status: <span
                                        class="badge bg-{{ $listing->status == 'vacant' ? 'success' : ($listing->status == 'booked' ? 'warning' : 'danger') }}">{{ ucfirst($listing->status) }}</span>
                                </li>
                            </ul>
                        </div>
                        <div class="col-md-6">
                            <h5 class="mb-3">Amenities</h5>
                            <div class="d-flex flex-wrap gap-2">
                                <span class="badge bg-light text-dark"><i class="fas fa-wifi me-1"></i> WiFi</span>
                                <span class="badge bg-light text-dark"><i class="fas fa-parking me-1"></i>
                                    Parking</span>
                                <span class="badge bg-light text-dark"><i class="fas fa-tshirt me-1"></i> Laundry</span>
                                <span class="badge bg-light text-dark"><i class="fas fa-tv me-1"></i> TV</span>
                            </div>
                        </div>
                    </div>

                    @if($listing->video_url)
                    <div class="mb-4">
                        <h5 class="mb-3">Video Tour</h5>
                        <div class="ratio ratio-16x9">
                            <iframe src="{{ $listing->video_url }}" title="Property video tour"
                                allowfullscreen></iframe>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <!-- Contact Card -->
            <div class="card mb-4 border-0 shadow-sm sticky-top" style="top: 20px;">
                <div class="card-body">
                    <h5 class="card-title mb-4">Contact Landlord</h5>

                    <div class="d-flex align-items-center mb-4">
                        @if($listing->user->profile_picture)
                        <img src="{{ asset('storage/' . $listing->user->profile_picture) }}" class="rounded-circle me-3"
                            width="60" height="60" alt="Landlord">
                        @else
                        <div class="rounded-circle bg-secondary text-white d-flex align-items-center justify-content-center me-3"
                            style="width: 60px; height: 60px;">
                            <i class="fas fa-user fa-2x"></i>
                        </div>
                        @endif
                        <div>
                            <h6 class="mb-0">{{ $listing->user->name }}</h6>
                            <small class="text-muted">Landlord</small>
                        </div>
                    </div>

                    <ul class="list-unstyled mb-4">
                        <li class="mb-2"><i class="fas fa-phone me-2 text-primary"></i>
                            {{ $listing->user->phone_number ?? 'Not provided' }}</li>
                        <li class="mb-2"><i class="fas fa-envelope me-2 text-primary"></i> {{ $listing->user->email }}
                        </li>
                        <li><i class="fas fa-clock me-2 text-primary"></i> Available 8AM - 6PM</li>
                    </ul>

                    <button class="btn btn-primary w-100 mb-3" data-bs-toggle="modal" data-bs-target="#contactModal">
                        <i class="fas fa-envelope me-2"></i> Send Message
                    </button>

                    <button class="btn btn-outline-primary w-100">
                        <i class="fas fa-phone me-2"></i> Call Now
                    </button>
                </div>
            </div>

            <!-- Map Card -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body">
                    <h5 class="card-title mb-3">Location</h5>
                    <div class="ratio ratio-16x9 mb-3">
                        <iframe
                            src="https://maps.google.com/maps?q={{ urlencode($listing->estate . ', ' . $listing->county) }}&output=embed"
                            frameborder="0" style="border:0;" allowfullscreen="" aria-hidden="false" tabindex="0">
                        </iframe>
                    </div>
                    <p class="text-muted">
                        <i class="fas fa-map-marker-alt text-danger me-2"></i>
                        {{ $listing->location ?? 'Exact location provided after contact' }}
                    </p>
                </div>
            </div>

            <!-- Safety Tips -->
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <h5 class="card-title mb-3">Safety Tips</h5>
                    <ul class="list-unstyled">
                        <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i> Meet in a public place
                        </li>
                        <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i> Don't send money in
                            advance</li>
                        <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i> Inspect the property
                            thoroughly</li>
                        <li><i class="fas fa-check-circle text-success me-2"></i> Request proper documentation</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Contact Modal -->
<div class="modal fade" id="contactModal" tabindex="-1" aria-labelledby="contactModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="contactModalLabel">Contact Landlord</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="contactForm" method="POST" action="{{ route('messages.store') }}">
                    @csrf
                    <input type="hidden" name="recipient_id" value="{{ $listing->user->id }}">
                    <input type="hidden" name="listing_id" value="{{ $listing->id }}">
                    <div class="mb-3">
                        <label for="name" class="form-label">Your Name *</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email Address *</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="phone" class="form-label">Phone Number *</label>
                        <input type="tel" class="form-control" id="phone" name="phone" required>
                    </div>
                    <div class="mb-3">
                        <label for="message" class="form-label">Message</label>
                        <textarea name="content" class="form-control" id="message" rows="4"
                            required>I'm interested in your property at {{ $listing->estate }}, {{ $listing->county }}. Please contact me with more details.</textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" form="contactForm" class="btn btn-primary">Send Message</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
.thumbnail {
    transition: transform 0.2s;
}

.thumbnail:hover {
    transform: scale(1.05);
}

.sticky-top {
    z-index: 1;
}
</style>
@endsection