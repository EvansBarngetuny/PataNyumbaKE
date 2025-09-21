<div>
     {{-- Close your eyes. Count to one. That is how long forever feels. --}}
    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card shadow-lg">
                    <div class="card-header bg-primary text-white">
                        <div class="d-flex justify-content-between align-items-center">
                            <h4 class="mb-0">Post a New Room</h4>
                            <a href="#overview" class="btn btn-light" data-bs-toggle="tab">
                                <i class="fas fa-arrow-left me-2"></i>Back to Properties
                            </a>
                        </div>
                    </div>

                    <div class="card-body">
                        <!-- Success/Error Messages -->
                        @if (session()->has('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        @if (session()->has('error'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        <form wire:submit.prevent="save">
                            <!-- Basic Information Section -->
                            <div class="mb-4">
                                <h5 class="text-primary mb-3"><i class="fas fa-info-circle me-2"></i>Room Data</h5>
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label for="title" class="form-label">Room Title*</label>
                                        <input type="text" class="form-control @error('title') is-invalid @enderror"
                                            id="title" wire:model="title" required>
                                        @error('title') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>

                                    <div class="col-md-6">
                                        <label for="category" class="form-label">Category*</label>
                                        <select class="form-select @error('category') is-invalid @enderror" id="category"
                                            wire:model="category" required>
                                            <option value="">Select Category</option>
                                            <option value="single">Single Room</option>
                                            <option value="double">Double Room</option>
                                            <option value="bedsitter">Bedsitter</option>
                                            <option value="one-bedroom">One Bedroom</option>
                                            <option value="two-bedroom">Two Bedroom</option>
                                        </select>
                                        @error('category') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>

                                    <div class="col-md-6">
                                        <label for="price" class="form-label">Monthly Price (Ksh)*</label>
                                        <input type="number" step="0.01"
                                            class="form-control @error('price') is-invalid @enderror" id="price"
                                            wire:model="price" required>
                                        @error('price') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>

                                    <div class="col-md-6">
                                        <label for="status" class="form-label">Status*</label>
                                        <select class="form-select @error('status') is-invalid @enderror" id="status"
                                            wire:model="status" required>
                                            <option value="vacant">Vacant</option>
                                            <option value="Booked">Booked</option>
                                            <option value="occupied">Occupied</option>
                                        </select>
                                        @error('status') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Location Information Section -->
                            <div class="mb-4">
                                <h5 class="text-primary mb-3"><i class="fas fa-map-marker-alt me-2"></i>Location Details</h5>
                                <div class="row g-3">
                                    <div class="col-md-4">
                                        <label for="county" class="form-label">County*</label>
                                        <input type="text" class="form-control @error('county') is-invalid @enderror"
                                            id="county" wire:model="county" required>
                                        @error('county') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>

                                    <div class="col-md-4">
                                        <label for="estate" class="form-label">Estate/Area*</label>
                                        <input type="text" class="form-control @error('estate') is-invalid @enderror"
                                            id="estate" wire:model="estate" required>
                                        @error('estate') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>

                                    <div class="col-md-4">
                                        <label for="location" class="form-label">Specific Location*</label>
                                        <input type="text" class="form-control @error('location') is-invalid @enderror"
                                            id="location" wire:model="location" required>
                                        @error('location') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Media Section -->
                            <div class="mb-4">
                                <h5 class="text-primary mb-3"><i class="fas fa-images me-2"></i>Room Photos</h5>
                                <div class="row g-3">
                                    <div class="col-12">
                                        <label for="images" class="form-label">Upload Images (Multiple)*</label>
                                        <input type="file" class="form-control @error('images') is-invalid @enderror"
                                            id="images" wire:model="images" multiple accept="image/*" required>
                                        <small class="text-muted">Upload at least 3 images (max 10)</small>
                                        @error('images') <div class="invalid-feedback">{{ $message }}</div> @enderror

                                        <!-- Image preview -->
                                        @if ($images)
                                            <div class="mt-3">
                                                <h6 class="text-muted">Selected Images:</h6>
                                                <div class="row g-2">
                                                    @foreach ($images as $index => $image)
                                                        <div class="col-md-3">
                                                            <div class="position-relative">
                                                                <img src="{{ $image->temporaryUrl() }}"
                                                                     class="img-thumbnail"
                                                                     style="height: 100px; object-fit: cover;">
                                                                <button type="button"
                                                                        class="btn btn-danger btn-sm position-absolute top-0 end-0"
                                                                        wire:click="removeImage({{ $index }})">
                                                                    <i class="fas fa-times"></i>
                                                                </button>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        @endif
                                    </div>

                                    <div class="col-12">
                                        <label for="video_url" class="form-label">Video URL (Optional)</label>
                                        <input type="url" class="form-control @error('video_url') is-invalid @enderror"
                                            id="video_url" wire:model="video_url"
                                            placeholder="https://youtube.com/example">
                                        @error('video_url') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Description Section -->
                            <div class="mb-4">
                                <h5 class="text-primary mb-3"><i class="fas fa-align-left me-2"></i>Description</h5>
                                <div class="form-group">
                                    <label for="description" class="form-label">Detailed Description*</label>
                                    <textarea class="form-control @error('description') is-invalid @enderror"
                                        id="description" wire:model="description" rows="5" required></textarea>
                                    @error('description') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>

                            <!-- Verification Section -->
                            <div class="mb-4">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="is_verified"
                                        wire:model="is_verified" value="1">
                                    <label class="form-check-label" for="is_verified">Mark as Verified Room</label>
                                </div>
                            </div>

                            <!-- Submit Button -->
                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary btn-lg" wire:loading.attr="disabled">
                                    <span wire:loading.remove>
                                        <i class="fas fa-save me-2"></i>Post Room
                                    </span>
                                    <span wire:loading>
                                        <i class="fas fa-spinner fa-spin me-2"></i>Posting...
                                    </span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
