
   <div>
     {{-- Close your eyes. Count to one. That is how long forever feels. --}}
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card shadow-lg">
                    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                        <h5 class="mb-0"><i class="fas fa-home me-2"></i> My Properties</h5>
                        <div class="d-flex">
                            <select wire:model="statusFilter" class="form-select form-select-sm me-2">
                                <option value="">All Statuses</option>
                                <option value="vacant">Vacant</option>
                                <option value="occupied">Occupied</option>
                                <option value="Booked">Booked</option>
                            </select>
                            <input type="text" wire:model.debounce.300ms="search" class="form-control form-control-sm"
                                   placeholder="Search properties..." style="width: 200px;">
                        </div>
                    </div>

                    <div class="card-body">
                        <!-- Success Message -->
                        @if (session()->has('message'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <i class="fas fa-check-circle me-2"></i>{{ session('message') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        <!-- Error Message -->
                        @if (session()->has('error'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        <!-- Responsive Table -->
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th wire:click="sortBy('title')" style="cursor: pointer;">
                                            Title
                                            @if($sortField === 'title')
                                                <i class="fas fa-sort-{{ $sortDirection === 'asc' ? 'up' : 'down' }}"></i>
                                            @else
                                                <i class="fas fa-sort"></i>
                                            @endif
                                        </th>
                                        <th wire:click="sortBy('category')" style="cursor: pointer;">
                                            Category
                                            @if($sortField === 'category')
                                                <i class="fas fa-sort-{{ $sortDirection === 'asc' ? 'up' : 'down' }}"></i>
                                            @else
                                                <i class="fas fa-sort"></i>
                                            @endif
                                        </th>
                                        <th wire:click="sortBy('price')" style="cursor: pointer;">
                                            Price
                                            @if($sortField === 'price')
                                                <i class="fas fa-sort-{{ $sortDirection === 'asc' ? 'up' : 'down' }}"></i>
                                            @else
                                                <i class="fas fa-sort"></i>
                                            @endif
                                        </th>
                                        <th>Location</th>
                                        <th wire:click="sortBy('status')" style="cursor: pointer;">
                                            Status
                                            @if($sortField === 'status')
                                                <i class="fas fa-sort-{{ $sortDirection === 'asc' ? 'up' : 'down' }}"></i>
                                            @else
                                                <i class="fas fa-sort"></i>
                                            @endif
                                        </th>
                                        <th wire:click="sortBy('created_at')" style="cursor: pointer;">
                                            Date Added
                                            @if($sortField === 'created_at')
                                                <i class="fas fa-sort-{{ $sortDirection === 'asc' ? 'up' : 'down' }}"></i>
                                            @else
                                                <i class="fas fa-sort"></i>
                                            @endif
                                        </th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($listings as $listing)
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    @if($listing->images)
                                                        @php
                                                            $images = json_decode($listing->images, true);
                                                            $firstImage = is_array($images) && count($images) > 0 ? $images[0] : null;
                                                        @endphp
                                                        @if($firstImage)
                                                            <img src="{{ asset('storage/' . $firstImage) }}"
                                                                 class="rounded me-3"
                                                                 style="width: 50px; height: 50px; object-fit: cover;">
                                                        @else
                                                            <div class="rounded me-3 d-flex align-items-center justify-content-center bg-light"
                                                                 style="width: 50px; height: 50px;">
                                                                <i class="fas fa-home text-muted"></i>
                                                            </div>
                                                        @endif
                                                    @endif
                                                    <div>
                                                        <strong>{{ $listing->title }}</strong>
                                                        @if($listing->is_verified)
                                                            <span class="badge bg-success ms-2">Verified</span>
                                                        @endif
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <span class="badge bg-info text-dark">
                                                    {{ ucfirst(str_replace('-', ' ', $listing->category)) }}
                                                </span>
                                            </td>
                                            <td>
                                                <strong>Ksh {{ number_format($listing->price) }}</strong>
                                                <div class="text-muted small">per month</div>
                                            </td>
                                            <td>
                                                <div>{{ $listing->estate }}</div>
                                                <div class="text-muted small">{{ $listing->county }}</div>
                                            </td>
                                            <td>
                                                @if($listing->status === 'vacant')
                                                    <span class="badge bg-success">{{ ucfirst($listing->status) }}</span>
                                                @elseif($listing->status === 'occupied')
                                                    <span class="badge bg-danger">{{ ucfirst($listing->status) }}</span>
                                                @elseif($listing->status === 'Booked')
                                                    <span class="badge bg-warning text-dark">{{ ucfirst($listing->status) }}</span>
                                                @else
                                                    <span class="badge bg-secondary">{{ ucfirst($listing->status) }}</span>
                                                @endif
                                            </td>
                                            <td>
                                                {{ $listing->created_at->format('M d, Y') }}
                                                <div class="text-muted small">{{ $listing->created_at->diffForHumans() }}</div>
                                            </td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <a href="{{ route('listings.show', $listing) }}"
                                                       class="btn btn-sm btn-outline-primary"
                                                       title="View">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    <button wire:click="editListing({{ $listing->id }})"
                                                            class="btn btn-sm btn-outline-secondary"
                                                            title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    @if($listing->status !== 'occupied')
                                                        <button wire:click="updateStatus({{ $listing->id }}, 'occupied')"
                                                                class="btn btn-sm btn-outline-danger"
                                                                title="Mark as Occupied">
                                                            <i class="fas fa-user-check"></i>
                                                        </button>
                                                    @endif
                                                    @if($listing->status !== 'Booked')
                                                        <button wire:click="updateStatus({{ $listing->id }}, 'Booked')"
                                                                class="btn btn-sm btn-outline-warning"
                                                                title="Mark as Booked">
                                                            <i class="fas fa-calendar-check"></i>
                                                        </button>
                                                    @endif
                                                    @if($listing->status !== 'vacant')
                                                        <button wire:click="updateStatus({{ $listing->id }}, 'vacant')"
                                                                class="btn btn-sm btn-outline-success"
                                                                title="Mark as Vacant">
                                                            <i class="fas fa-home"></i>
                                                        </button>
                                                    @endif
                                                    <button wire:click="confirmDelete({{ $listing->id }})"
                                                            class="btn btn-sm btn-outline-danger"
                                                            title="Delete">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7" class="text-center py-4">
                                                <i class="fas fa-home fa-3x text-muted mb-3"></i>
                                                <h5>No properties found</h5>
                                                <p class="text-muted">You don't have any properties listed yet.</p>
                                                <a href="#add-property" class="btn btn-primary" data-bs-toggle="tab">
                                                    <i class="fas fa-plus me-2"></i>Add Your First Property
                                                </a>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        @if($listings->hasPages())
                            <div class="d-flex justify-content-between align-items-center mt-3">
                                <div class="text-muted">
                                    Showing {{ $listings->firstItem() }} to {{ $listings->lastItem() }} of {{ $listings->total() }} results
                                </div>
                                <div>
                                    {{ $listings->links() }}
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div wire:ignore.self class="modal fade" id="deleteModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Confirm Delete</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete this listing? This action cannot be undone.</p>
                    <p class="fw-bold">{{ $selectedListing->title ?? '' }}</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-danger" wire:click="deleteListing">Delete Listing</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Listing Modal -->
    <div wire:ignore.self class="modal fade" id="editModal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Property Listing</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" wire:click="resetModal"></button>
                </div>
                <form wire:submit.prevent="updateListing">
                    <div class="modal-body">
                        <!-- Basic Information Section -->
                        <div class="mb-4">
                            <h6 class="text-primary mb-3"><i class="fas fa-info-circle me-2"></i>Property Details</h6>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="editTitle" class="form-label">Property Title*</label>
                                    <input type="text" class="form-control" id="editTitle" wire:model="editTitle" required>
                                    @error('editTitle') <span class="text-danger small">{{ $message }}</span> @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="editCategory" class="form-label">Category*</label>
                                    <select class="form-select" id="editCategory" wire:model="editCategory" required>
                                        <option value="">Select Category</option>
                                        <option value="single">Single Room</option>
                                        <option value="double">Double Room</option>
                                        <option value="bedsitter">Bedsitter</option>
                                        <option value="one-bedroom">One Bedroom</option>
                                        <option value="two-bedroom">Two Bedroom</option>
                                    </select>
                                    @error('editCategory') <span class="text-danger small">{{ $message }}</span> @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="editPrice" class="form-label">Monthly Price (Ksh)*</label>
                                    <input type="number" step="0.01" class="form-control" id="editPrice" wire:model="editPrice" required>
                                    @error('editPrice') <span class="text-danger small">{{ $message }}</span> @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="editStatus" class="form-label">Status*</label>
                                    <select class="form-select" id="editStatus" wire:model="editStatus" required>
                                        <option value="vacant">Vacant</option>
                                        <option value="Booked">Booked</option>
                                        <option value="occupied">Occupied</option>
                                    </select>
                                    @error('editStatus') <span class="text-danger small">{{ $message }}</span> @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Location Information Section -->
                        <div class="mb-4">
                            <h6 class="text-primary mb-3"><i class="fas fa-map-marker-alt me-2"></i>Location Details</h6>
                            <div class="row g-3">
                                <div class="col-md-4">
                                    <label for="editCounty" class="form-label">County*</label>
                                    <input type="text" class="form-control" id="editCounty" wire:model="editCounty" required>
                                    @error('editCounty') <span class="text-danger small">{{ $message }}</span> @enderror
                                </div>

                                <div class="col-md-4">
                                    <label for="editEstate" class="form-label">Estate/Area*</label>
                                    <input type="text" class="form-control" id="editEstate" wire:model="editEstate" required>
                                    @error('editEstate') <span class="text-danger small">{{ $message }}</span> @enderror
                                </div>

                                <div class="col-md-4">
                                    <label for="editLocation" class="form-label">Specific Location*</label>
                                    <input type="text" class="form-control" id="editLocation" wire:model="editLocation" required>
                                    @error('editLocation') <span class="text-danger small">{{ $message }}</span> @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Media Section -->
                        <div class="mb-4">
                            <h6 class="text-primary mb-3"><i class="fas fa-images me-2"></i>Property Photos</h6>

                            <!-- Existing Images -->
                            @if(count($existingImages) > 0)
                                <div class="mb-3">
                                    <label class="form-label">Existing Images</label>
                                    <div class="row g-2">
                                        @foreach($existingImages as $index => $image)
                                            <div class="col-md-3">
                                                <div class="position-relative">
                                                    <img src="{{ asset('storage/' . $image) }}"
                                                         class="img-thumbnail"
                                                         style="height: 100px; object-fit: cover;">
                                                    <button type="button"
                                                            class="btn btn-danger btn-sm position-absolute top-0 end-0"
                                                            wire:click="removeExistingImage({{ $index }})">
                                                        <i class="fas fa-times"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            <!-- New Images -->
                            <div class="mb-3">
                                <label for="newImages" class="form-label">Add New Images</label>
                                <input type="file" class="form-control" id="newImages" wire:model="newImages" multiple accept="image/*">
                                <small class="text-muted">Select additional images (max 10)</small>
                                @error('newImages.*') <span class="text-danger small">{{ $message }}</span> @enderror

                                @if($newImages)
                                    <div class="mt-2">
                                        <div class="row g-2">
                                            @foreach($newImages as $index => $image)
                                                <div class="col-md-3">
                                                    <div class="position-relative">
                                                        <img src="{{ $image->temporaryUrl() }}"
                                                             class="img-thumbnail"
                                                             style="height: 100px; object-fit: cover;">
                                                        <button type="button"
                                                                class="btn btn-danger btn-sm position-absolute top-0 end-0"
                                                                wire:click="removeNewImage({{ $index }})">
                                                            <i class="fas fa-times"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif
                            </div>

                            <div class="mb-3">
                                <label for="editVideoUrl" class="form-label">Video URL (Optional)</label>
                                <input type="url" class="form-control" id="editVideoUrl" wire:model="editVideoUrl"
                                       placeholder="https://youtube.com/example">
                                @error('editVideoUrl') <span class="text-danger small">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <!-- Description Section -->
                        <div class="mb-4">
                            <h6 class="text-primary mb-3"><i class="fas fa-align-left me-2"></i>Description</h6>
                            <div class="form-group">
                                <label for="editDescription" class="form-label">Detailed Description*</label>
                                <textarea class="form-control" id="editDescription" wire:model="editDescription" rows="5" required></textarea>
                                @error('editDescription') <span class="text-danger small">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <!-- Verification Section -->
                        <div class="mb-4">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="editIsVerified"
                                    wire:model="editIsVerified" value="1">
                                <label class="form-check-label" for="editIsVerified">Mark as Verified Property</label>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" wire:click="resetModal">Cancel</button>
                        <button type="submit" class="btn btn-primary">
                            <span wire:loading.remove>Update Property</span>
                            <span wire:loading>Updating...</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('livewire:load', function() {
            // Show delete modal when triggered
            Livewire.on('showDeleteModal', () => {
                var deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));
                deleteModal.show();
            });

            // Hide delete modal after deletion
            Livewire.on('hideDeleteModal', () => {
                var deleteModal = bootstrap.Modal.getInstance(document.getElementById('deleteModal'));
                if (deleteModal) {
                    deleteModal.hide();
                }
            });

            // Show edit modal when triggered
            Livewire.on('showEditModal', () => {
                var editModal = new bootstrap.Modal(document.getElementById('editModal'));
                editModal.show();
            });

            // Hide edit modal after update
            Livewire.on('hideEditModal', () => {
                var editModal = bootstrap.Modal.getInstance(document.getElementById('editModal'));
                if (editModal) {
                    editModal.hide();
                }
            });
        });
        document.addEventListener('livewire:load', function() {
    window.addEventListener('showDeleteModal', () => {
        new bootstrap.Modal(document.getElementById('deleteModal')).show();
    });

    window.addEventListener('hideDeleteModal', () => {
        const modal = bootstrap.Modal.getInstance(document.getElementById('deleteModal'));
        if (modal) modal.hide();
    });

    window.addEventListener('showEditModal', () => {
        new bootstrap.Modal(document.getElementById('editModal')).show();
    });

    window.addEventListener('hideEditModal', () => {
        const modal = bootstrap.Modal.getInstance(document.getElementById('editModal'));
        if (modal) modal.hide();
    });
});
    </script>
</div>
