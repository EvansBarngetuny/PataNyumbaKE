@extends('layouts.app')

@section('content')
<!-- Hero Section -->
<section class="hero-section position-relative py-5">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <h1 class="display-4 fw-bold mb-4">Find Your Perfect <span class="text-primary">Rooms &
                        Apartments</span></h1>
                <p class="lead mb-5">Discover quality living spaces across Kenya with our easy-to-use platform</p>
                <a href="#featured-listings" class="btn btn-primary btn-lg px-4 me-2">Browse Listings</a>
                <a href="{{ route('listings.create') }}" class="btn btn-outline-primary btn-lg px-4">List Your
                    Property</a>
            </div>
            <div class="col-lg-6">
                <img src="{{ asset('images/tenant.jpeg') }}" alt="Happy tenants" class="img-fluid rounded shadow">
            </div>
        </div>
    </div>
</section>

<!-- Featured Listings Section -->
<section id="featured-listings" class="py-5 bg-light">
    <div class="container">
        <div class="section-header d-flex justify-content-between align-items-center mb-5">
            <h2 class="fw-bold">📍 Featured Listings</h2>
            <a href="{{ route('listings.index') }}" class="btn btn-outline-primary">View All</a>
        </div>

        @if($featuredListings->isEmpty())
        <div class="alert alert-info text-center py-4">
            <i class="fas fa-info-circle fa-2x mb-3"></i>
            <h4>No featured properties available</h4>
            <p class="mb-0">Check back later for new listings</p>
        </div>
        @else
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
            @foreach($featuredListings as $listing)
            @include('partials.listing-card', ['listing' => $listing])
            @endforeach
        </div>
        @endif
    </div>
</section>

<!-- Popular Areas Section -->
<section class="py-5">
    <div class="container">
        <h2 class="fw-bold text-center mb-5">🗺️ Browse by Location</h2>

        <div class="row g-4">
            @foreach($popularCounties as $county)
            <div class="col-md-4">
                <div class="location-card card h-100 border-0 shadow-sm">
                    <div class="card-body text-center">
                        <div class="location-icon bg-primary bg-opacity-10 text-primary rounded-circle mx-auto mb-3">
                            <i class="fas fa-map-marker-alt"></i>
                        </div>
                        <h5>{{ $county->name }}</h5>
                        <p class="text-muted">{{ $county->listings_count }} properties available</p>
                        <a href="{{ route('listings.search') }}?county={{ urlencode($county->name) }}"
                            class="stretched-link"></a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Room Types Section -->
<section class="py-5 bg-light">
    <div class="container">
        <h2 class="fw-bold text-center mb-5">🏘️ What Are You Looking For?</h2>

        <div class="row g-4">
            <div class="col-md-4">
                <div class="card room-type-card h-100 border-0 shadow-sm">
                    <div class="card-body text-center">
                        <div class="room-icon bg-primary bg-opacity-10 text-primary rounded-circle mx-auto mb-3">
                            <i class="fas fa-bed"></i>
                        </div>
                        <h5>Single Room</h5>
                        <a href="{{ route('listings.search') }}?category=single" class="stretched-link"></a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card room-type-card h-100 border-0 shadow-sm">
                    <div class="card-body text-center">
                        <div class="room-icon bg-primary bg-opacity-10 text-primary rounded-circle mx-auto mb-3">
                            <i class="fas fa-couch"></i>
                        </div>
                        <h5>Bedsitter</h5>
                        <a href="{{ route('listings.search') }}?category=bedsitter" class="stretched-link"></a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card room-type-card h-100 border-0 shadow-sm">
                    <div class="card-body text-center">
                        <div class="room-icon bg-primary bg-opacity-10 text-primary rounded-circle mx-auto mb-3">
                            <i class="fas fa-home"></i>
                        </div>
                        <h5>One Bedroom</h5>
                        <a href="{{ route('listings.search') }}?category=one-bedroom" class="stretched-link"></a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card room-type-card h-100 border-0 shadow-sm">
                    <div class="card-body text-center">
                        <div class="room-icon bg-primary bg-opacity-10 text-primary rounded-circle mx-auto mb-3">
                            <i class="fas fa-home-lg-alt"></i>
                        </div>
                        <h5>Two Bedroom</h5>
                        <a href="{{ route('listings.search') }}?category=two-bedroom" class="stretched-link"></a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card room-type-card h-100 border-0 shadow-sm">
                    <div class="card-body text-center">
                        <div class="room-icon bg-primary bg-opacity-10 text-primary rounded-circle mx-auto mb-3">
                            <i class="fas fa-building"></i>
                        </div>
                        <h5>Entire House</h5>
                        <a href="{{ route('listings.search') }}?category=house" class="stretched-link"></a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card room-type-card h-100 border-0 shadow-sm">
                    <div class="card-body text-center">
                        <div class="room-icon bg-primary bg-opacity-10 text-primary rounded-circle mx-auto mb-3">
                            <i class="fas fa-search"></i>
                        </div>
                        <h5>View All Types</h5>
                        <a href="{{ route('listings.index') }}" class="stretched-link"></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- How It Works Section -->
<section class="py-5">
    <div class="container">
        <h2 class="fw-bold text-center mb-5">🤝 How It Works</h2>

        <div class="row g-4">
            <div class="col-md-4">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-body text-center">
                        <div class="step-number bg-primary text-white rounded-circle mx-auto mb-3">1</div>
                        <h5>Find Your Perfect Home</h5>
                        <p>Browse our verified listings and filter by location, price, and room type</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-body text-center">
                        <div class="step-number bg-primary text-white rounded-circle mx-auto mb-3">2</div>
                        <h5>Contact the Landlord</h5>
                        <p>Send inquiries directly to property owners or agents</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-body text-center">
                        <div class="step-number bg-primary text-white rounded-circle mx-auto mb-3">3</div>
                        <h5>Move In</h5>
                        <p>Complete the paperwork and move into your new home</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="text-center mt-5">
            <div class="row g-4">
                <div class="col-md-6">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body">
                            <h5>For Tenants</h5>
                            <p>Find your dream home with our easy search tools and verified listings</p>
                            <a href="#featured-listings" class="btn btn-outline-primary">Browse Listings</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body">
                            <h5>For Landlords</h5>
                            <p>List your property and connect with thousands of potential tenants</p>
                            <a href="{{ route('listings.create') }}" class="btn btn-outline-primary">List Your
                                Property</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Testimonials Section -->
<section class="py-5 bg-light">
    <div class="container">
        <h2 class="fw-bold text-center mb-5">💬 What Our Users Say</h2>

        <div class="row g-4">
            <div class="col-md-4">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-body">
                        <div class="d-flex mb-3">
                            <div class="flex-shrink-0">
                                <img src="{{ asset('images/testimonial1.jpg') }}" class="rounded-circle" width="50"
                                    alt="User">
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h6 class="mb-0">Sarah K.</h6>
                                <small class="text-muted">Tenant, Nairobi</small>
                            </div>
                        </div>
                        <p>"Found my perfect apartment in just 2 days! The verification process gave me confidence in
                            the listing."</p>
                        <div class="text-warning">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-body">
                        <div class="d-flex mb-3">
                            <div class="flex-shrink-0">
                                <img src="{{ asset('images/testimonial2.jpg') }}" class="rounded-circle" width="50"
                                    alt="User">
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h6 class="mb-0">James M.</h6>
                                <small class="text-muted">Landlord, Mombasa</small>
                            </div>
                        </div>
                        <p>"As a landlord, I appreciate how quickly I can list properties and find quality tenants."</p>
                        <div class="text-warning">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star-half-alt"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-body">
                        <div class="d-flex mb-3">
                            <div class="flex-shrink-0">
                                <img src="{{ asset('images/testimonial3.jpg') }}" class="rounded-circle" width="50"
                                    alt="User">
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h6 class="mb-0">Grace W.</h6>
                                <small class="text-muted">Student, Nakuru</small>
                            </div>
                        </div>
                        <p>"The room type filters saved me so much time. Found a great single room near campus!"</p>
                        <div class="text-warning">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Newly Added Section -->
<section class="py-5">
    <div class="container">
        <div class="section-header d-flex justify-content-between align-items-center mb-5">
            <h2 class="fw-bold">🆕 Newly Added Rooms</h2>
            <a href="{{ route('listings.index') }}" class="btn btn-outline-primary">View All</a>
        </div>

        @if($newListings->isEmpty())
        <div class="alert alert-info text-center py-4">
            <i class="fas fa-info-circle fa-2x mb-3"></i>
            <h4>No new properties available</h4>
            <p class="mb-0">Check back later for new listings</p>
        </div>
        @else
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
            @foreach($newListings as $listing)
            @include('partials.listing-card', ['listing' => $listing])
            @endforeach
        </div>
        @endif
    </div>
</section>

<!-- Contact/Support Section -->
<section class="py-5 bg-light">
    <div class="container">
        <h2 class="fw-bold text-center mb-5">📞 Need Help?</h2>

        <div class="row g-4">
            <div class="col-md-4">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-body text-center">
                        <div class="support-icon bg-primary bg-opacity-10 text-primary rounded-circle mx-auto mb-3">
                            <i class="fas fa-question-circle"></i>
                        </div>
                        <h5>FAQs</h5>
                        <p>Find answers to common questions</p>
                        <a href="#" class="btn btn-outline-primary">View FAQs</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-body text-center">
                        <div class="support-icon bg-primary bg-opacity-10 text-primary rounded-circle mx-auto mb-3">
                            <i class="fas fa-headset"></i>
                        </div>
                        <h5>Contact Support</h5>
                        <p>Our team is ready to help</p>
                        <a href="#" class="btn btn-outline-primary">Contact Us</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-body text-center">
                        <div class="support-icon bg-primary bg-opacity-10 text-primary rounded-circle mx-auto mb-3">
                            <i class="fas fa-book"></i>
                        </div>
                        <h5>Guides</h5>
                        <p>Tips for tenants and landlords</p>
                        <a href="#" class="btn btn-outline-primary">View Guides</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
.hero-section {
    background-color: #f8f9fa;
    padding: 5rem 0;
}

.location-icon,
.room-icon,
.support-icon {
    width: 60px;
    height: 60px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
}

.step-number {
    width: 50px;
    height: 50px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.25rem;
    font-weight: bold;
}

.card {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    border-radius: 10px;
}

.card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
}

.section-header {
    border-bottom: 2px solid #dee2e6;
    padding-bottom: 1rem;
}
</style>
@endsection