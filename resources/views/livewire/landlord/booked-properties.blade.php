<div>
    {{-- Do your work, then step back. --}}
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card shadow-lg">
                    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                        <h5 class="mb-0"><i class="fas fa-calendar-check me-2"></i> Booked Properties & Reservations</h5>
                        <div class="d-flex">
                            <select wire:model="statusFilter" class="form-select form-select-sm me-2">
                                <option value="">All Statuses</option>
                                <option value="pending">Pending</option>
                                <option value="confirmed">Confirmed</option>
                                <option value="cancelled">Cancelled</option>
                                <option value="completed">Completed</option>
                            </select>
                            <input type="text" wire:model.debounce.300ms="search" class="form-control form-control-sm"
                                   placeholder="Search bookings..." style="width: 200px;">
                        </div>
                    </div>

                    <div class="card-body">
                        @if (session()->has('message'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <i class="fas fa-check-circle me-2"></i>{{ session('message') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th>Tenant</th>
                                        <th>Property</th>
                                        <th>Contact Info</th>
                                        <th>Move-in Date</th>
                                        <th>Status</th>
                                        <th>Date Booked</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($bookings as $booking)
                                        <tr>
                                            <td>
                                                <strong>{{ $booking->full_name }}</strong>
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    @if($booking->listing->images)
                                                        @php
                                                            $images = json_decode($booking->listing->images, true);
                                                            $firstImage = is_array($images) && count($images) > 0 ? $images[0] : null;
                                                        @endphp
                                                        @if($firstImage)
                                                            <img src="{{ asset('storage/' . $firstImage) }}"
                                                                 class="rounded me-2"
                                                                 style="width: 40px; height: 40px; object-fit: cover;">
                                                        @endif
                                                    @endif
                                                    <div>
                                                        <div class="fw-bold">{{ $booking->listing->title }}</div>
                                                        <small class="text-muted">{{ $booking->listing->estate }}, {{ $booking->listing->county }}</small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div>{{ $booking->email }}</div>
                                                <small class="text-muted">{{ $booking->phone }}</small>
                                            </td>
                                            <td>
                                                {{ $booking->move_in_date ? $booking->move_in_date->format('M d, Y') : 'Not specified' }}
                                            </td>
                                            <td>
                                                @if($booking->status === 'pending')
                                                    <span class="badge bg-warning text-dark">Pending</span>
                                                @elseif($booking->status === 'confirmed')
                                                    <span class="badge bg-success">Confirmed</span>
                                                @elseif($booking->status === 'cancelled')
                                                    <span class="badge bg-danger">Cancelled</span>
                                                @elseif($booking->status === 'completed')
                                                    <span class="badge bg-info">Completed</span>
                                                @endif
                                            </td>
                                            <td>
                                                {{ $booking->created_at->format('M d, Y') }}
                                            </td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <button wire:click="showDetails({{ $booking->id }})"
                                                            class="btn btn-sm btn-outline-primary"
                                                            title="View Details">
                                                        <i class="fas fa-eye"></i>
                                                    </button>

                                                    @if($booking->status === 'pending')
                                                        <button wire:click="updateStatus({{ $booking->id }}, 'confirmed')"
                                                                class="btn btn-sm btn-outline-success"
                                                                title="Confirm Booking">
                                                            <i class="fas fa-check"></i>
                                                        </button>
                                                        <button wire:click="updateStatus({{ $booking->id }}, 'cancelled')"
                                                                class="btn btn-sm btn-outline-danger"
                                                                title="Cancel Booking">
                                                            <i class="fas fa-times"></i>
                                                        </button>
                                                    @elseif($booking->status === 'confirmed')
                                                        <button wire:click="updateStatus({{ $booking->id }}, 'completed')"
                                                                class="btn btn-sm btn-outline-info"
                                                                title="Mark as Completed">
                                                            <i class="fas fa-flag-checkered"></i>
                                                        </button>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="8" class="text-center py-4">
                                                <i class="fas fa-calendar-times fa-3x text-muted mb-3"></i>
                                                <h5>No bookings found</h5>
                                                <p class="text-muted">You don't have any property bookings yet.</p>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        @if($bookings->hasPages())
                            <div class="d-flex justify-content-between align-items-center mt-3">
                                <div class="text-muted">
                                    Showing {{ $bookings->firstItem() }} to {{ $bookings->lastItem() }} of {{ $bookings->total() }} results
                                </div>
                                <div>
                                    {{ $bookings->links() }}
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Booking Details Modal -->
    <div wire:ignore.self class="modal fade" id="detailsModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Booking Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    @if($selectedBooking)
                        <div class="row">
                            <div class="col-md-6">
                                <h6 class="text-primary">Tenant Information</h6>
                                <p><strong>Name:</strong> {{ $selectedBooking->full_name }}</p>
                                <p><strong>Email:</strong> {{ $selectedBooking->email }}</p>
                                <p><strong>Phone:</strong> {{ $selectedBooking->phone }}</p>
                                <p><strong>Move-in Date:</strong> {{ $selectedBooking->move_in_date ? $selectedBooking->move_in_date->format('M d, Y') : 'Not specified' }}</p>

                            </div>
                            <div class="col-md-6">
                                <h6 class="text-primary">Property Information</h6>
                                <p><strong>Title:</strong> {{ $selectedBooking->listing->title }}</p>
                                <p><strong>Location:</strong> {{ $selectedBooking->listing->estate }}, {{ $selectedBooking->listing->county }}</p>
                                <p><strong>Price:</strong> Ksh {{ number_format($selectedBooking->listing->price) }} / month</p>
                                <p><strong>Category:</strong> {{ ucfirst(str_replace('-', ' ', $selectedBooking->listing->category)) }}</p>
                            </div>
                        </div>

                        <div class="mt-3">
                            <h6 class="text-primary">Tenant Message</h6>
                            <p class="border p-3 rounded">{{ $selectedBooking->message ?? 'No message provided' }}</p>
                        </div>

                        <div class="mt-3">
                            <h6 class="text-primary">Landlord Notes</h6>
                            <textarea wire:model="landlordNotes" class="form-control" rows="3" placeholder="Add notes about this booking..."></textarea>
                            <button wire:click="saveLandlordNotes" class="btn btn-primary mt-2">Save Notes</button>
                        </div>
                    @endif
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('livewire:load', function () {
    window.addEventListener('show-details-modal', () => {
        const modalEl = document.getElementById('detailsModal');
        const modal = bootstrap.Modal.getOrCreateInstance(modalEl);
        modal.show();
    });
});
        document.addEventListener('DOMContentLoaded', function() {
            if (detailsModal) {
                detailsModal.addEventListener('hidden.bs.modal', function() {

                })
            }
        })
    </script>
</div>
