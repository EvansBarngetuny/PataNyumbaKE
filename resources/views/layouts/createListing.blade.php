@extends('layouts.admin')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow-lg">
                <div class="card-header bg-primary text-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <h4 class="mb-0">Post a New Room</h4>
                        <a href="{{ route('layouts.allListings') }}" class="btn btn-light">
                            <i class="fas fa-arrow-left me-2"></i>Back to Listings
                        </a>
                    </div>
                </div>

                <div class="card-body">
                    <form action="{{ route('listings.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <!-- Basic Information Section -->
                        <div class="mb-4">
                            <h5 class="text-primary mb-3"><i class="fas fa-info-circle me-2"></i>Room Data</h5>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="title" class="form-label">Room Title*</label>
                                    <input type="text" class="form-control @error('title') is-invalid @enderror"
                                        id="title" name="title" value="{{ old('title') }}" required>
                                    @error('title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="category" class="form-label">Category*</label>
                                    <select class="form-select @error('category') is-invalid @enderror" id="category"
                                        name="category" required>
                                        <option value="">Select Category</option>
                                        <option value="single" {{ old('category') == 'single' ? 'selected' : '' }}>
                                            Single Room</option>
                                        <option value="double" {{ old('category') == 'double' ? 'selected' : '' }}>
                                            Double Room</option>
                                        <option value="bedsitter"
                                            {{ old('category') == 'bedsitter' ? 'selected' : '' }}>Bedsitter</option>
                                        <option value="one-bedroom"
                                            {{ old('category') == 'one-bedroom' ? 'selected' : '' }}>One Bedroom
                                        </option>
                                        <option value="two-bedroom"
                                            {{ old('category') == 'two-bedroom' ? 'selected' : '' }}>Two Bedroom
                                        </option>
                                    </select>
                                    @error('category')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="price" class="form-label">Monthly Price (Ksh)*</label>
                                    <input type="number" step="0.01"
                                        class="form-control @error('price') is-invalid @enderror" id="price"
                                        name="price" value="{{ old('price') }}" required>
                                    @error('price')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="status" class="form-label">Status*</label>
                                    <select class="form-select @error('status') is-invalid @enderror" id="status"
                                        name="status" required>
                                        <option value="vacant" selected>Vacant</option>
                                        <option value="Booked">Booked</option>
                                        <option value="occupied">Occupied</option>
                                    </select>
                                    @error('status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Location Information Section -->
                        <div class="mb-4">
                            <h5 class="text-primary mb-3"><i class="fas fa-map-marker-alt me-2"></i>Location Details
                            </h5>
                            <div class="row g-3">
                                <div class="col-md-4">
                                    <label for="county" class="form-label">County*</label>
                                    <input type="text" class="form-control @error('county') is-invalid @enderror"
                                        id="county" name="county" value="{{ old('county') }}" required>
                                    @error('county')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-4">
                                    <label for="estate" class="form-label">Estate/Area*</label>
                                    <input type="text" class="form-control @error('estate') is-invalid @enderror"
                                        id="estate" name="estate" value="{{ old('estate') }}" required>
                                    @error('estate')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-4">
                                    <label for="location" class="form-label">Specific Location*</label>
                                    <input type="text" class="form-control @error('location') is-invalid @enderror"
                                        id="location" name="location" value="{{ old('location') }}" required>
                                    @error('location')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Media Section -->
                        <div class="mb-4">
                            <h5 class="text-primary mb-3"><i class="fas fa-images me-2"></i>Room Photo</h5>
                            <div class="row g-3">
                                <div class="col-12">
                                    <label for="images" class="form-label">Upload Images (Multiple)*</label>
                                    <input type="file" class="form-control @error('images') is-invalid @enderror"
                                        id="images" name="images[]" multiple accept="image/*" required>
                                    <small class="text-muted">Upload at least 3 images (max 10)</small>
                                    @error('images')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-12">
                                    <label for="video_url" class="form-label">Video URL (Optional)</label>
                                    <input type="url" class="form-control @error('video_url') is-invalid @enderror"
                                        id="video_url" name="video_url" value="{{ old('video_url') }}"
                                        placeholder="https://youtube.com/example">
                                    @error('video_url')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Description Section -->
                        <div class="mb-4">
                            <h5 class="text-primary mb-3"><i class="fas fa-align-left me-2"></i>Description</h5>
                            <div class="form-group">
                                <label for="description" class="form-label">Detailed Description*</label>
                                <textarea class="form-control @error('description') is-invalid @enderror"
                                    id="description" name="description" rows="5"
                                    required>{{ old('description') }}</textarea>
                                @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Verification Section -->
                        <div class="mb-4">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="is_verified" name="is_verified"
                                    value="1">
                                <label class="form-check-label" for="is_verified">Mark as Verified Room</label>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="fas fa-save me-2"></i>Post Room
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection