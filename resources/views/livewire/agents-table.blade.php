<div>
    <div class="container-fluid">
        <!-- Page Header -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Agents Management</h1>
            <button class="btn btn-primary" wire:click="$emit('openCreateModal')">
                <i class="fas fa-plus-circle me-2"></i> Add New Agent
            </button>
        </div>

        <!-- Search and Filter -->
        <div class="card shadow mb-4">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" placeholder="Search..."
                                wire:model.debounce.500ms="search">
                            <span class="input-group-text">
                                <i class="fas fa-search"></i>
                            </span>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <select class="form-select" wire:model="perPage">
                            <option value="10">10 per page</option>
                            <option value="25">25 per page</option>
                            <option value="50">50 per page</option>
                            <option value="100">100 per page</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <!-- Landlords Table -->
        <div class="card shadow mb-4">
            <div class="card-header py-3 bg-white">
                <h6 class="m-0 font-weight-bold text-primary">Registered Agents</h6>
            </div>
            <div class="card-body">
                @if($agents->isEmpty())
                <div class="empty-state">
                    <i class="fas fa-user-tie fa-3x"></i>
                    <h3>No agents Found</h3>
                    <p class="lead">You haven't registered any agent yet.</p>
                </div>
                @else
                <div class="table-responsive">
                    <table class="table table-bordered table-hover" id="landlordsTable" width="100%" cellspacing="0">
                        <thead class="bg-light">
                            <tr>
                                <th wire:click="sortBy('id')" style="cursor: pointer;">
                                    # @if($sortField === 'id') <i
                                        class="fas fa-sort-{{ $sortDirection === 'asc' ? 'up' : 'down' }}"></i> @endif
                                </th>
                                <th wire:click="sortBy('name')" style="cursor: pointer;">
                                    Name @if($sortField === 'name') <i
                                        class="fas fa-sort-{{ $sortDirection === 'asc' ? 'up' : 'down' }}"></i> @endif
                                </th>
                                <th wire:click="sortBy('email')" style="cursor: pointer;">
                                    Email @if($sortField === 'email') <i
                                        class="fas fa-sort-{{ $sortDirection === 'asc' ? 'up' : 'down' }}"></i> @endif
                                </th>
                                <th>Phone</th>
                                <th wire:click="sortBy('role')" style="cursor: pointer;">
                                    Role @if($sortField === 'role') <i
                                        class="fas fa-sort-{{ $sortDirection === 'asc' ? 'up' : 'down' }}"></i> @endif
                                </th>
                                <th wire:click="sortBy('created_at')" style="cursor: pointer;">
                                    Registered On @if($sortField === 'created_at') <i
                                        class="fas fa-sort-{{ $sortDirection === 'asc' ? 'up' : 'down' }}"></i> @endif
                                </th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($agents as $user)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        @if($user->profile_picture)
                                        <img src="{{ asset('storage/'.$user->profile_picture) }}"
                                            class="rounded-circle me-3" width="40" height="40">
                                        @else
                                        <div class="avatar-placeholder rounded-circle me-3 bg-primary text-white d-flex align-items-center justify-content-center"
                                            style="width: 40px; height: 40px;">
                                            {{ substr($user->name, 0, 1) }}
                                        </div>
                                        @endif
                                        {{ $user->name }}
                                    </div>
                                </td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->phone_number }}</td>
                                <td>
                                    <span class="badge {{ $user->role == 'landlord' ? 'bg-primary' : 'bg-success' }}">
                                        {{ ucfirst($user->role) }}
                                    </span>
                                </td>
                                <td>{{ $user->created_at->format('M d, Y') }}</td>
                                <td>
                                    <div class="action-buttons">
                                        <button class="btn-action btn-edit" wire:click="openEditModal({{ $user->id }})">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="btn-action btn-delete"
                                            wire:click="openDeleteModal({{ $user->id }})">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination Links -->
                <div class="mt-3">
                    {{ $agents->links() }}
                </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Create Modal -->
    <div x-data="{ showCreateModal: @entangle('createModalOpen') }" x-show="showCreateModal" x-transition
        style="display: none; position: fixed; top: 0; left: 0; right: 0; bottom: 0; z-index: 1050;">
        <div
            class="position-absolute w-100 h-100 bg-black bg-opacity-50 d-flex align-items-center justify-content-center">
            <div class="bg-white rounded-lg shadow-xl w-100 mx-4"
                style="max-width: 800px; max-height: 90vh; overflow: hidden;">
                <div
                    class="modal-header bg-primary text-white p-3 d-flex justify-content-between align-items-center sticky-top">
                    <h5 class="modal-title m-0">Add New Agent</h5>
                    <button @click="showCreateModal = false" class="btn btn-sm btn-light p-0"
                        style="width: 30px; height: 30px; line-height: 30px;">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body p-4" style="overflow-y: auto; max-height: calc(90vh - 120px);">
                    <!-- Your existing form content -->
                    <form wire:submit.prevent="createLandlord">
                        <div class="mb-3">
                            <label class="form-label">Full Name*</label>
                            <input type="text" class="form-control" wire:model.defer="name" required>
                            @error('name') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Email Address*</label>
                            <input type="email" class="form-control" wire:model.defer="email" required>
                            @error('email') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Phone Number*</label>
                            <input type="tel" class="form-control" wire:model.defer="phone_number" required>
                            @error('phone_number') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Password*</label>
                            <input type="password" class="form-control" wire:model.defer="password" required>
                            @error('password') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                    </form>
                </div>
                <div class="modal-footer p-3 border-top sticky-bottom bg-white">
                    <button @click="showCreateModal = false" class="btn btn-secondary">Cancel</button>
                    <button wire:click="createAgent" class="btn btn-primary">Save</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Modal -->
    <div x-data="{ showEditModal: @entangle('editModalOpen') }" x-show="showEditModal" x-transition
        style="display: none; position: fixed; top: 0; left: 0; right: 0; bottom: 0; z-index: 1050;">
        <div
            class="position-absolute w-100 h-100 bg-black bg-opacity-50 d-flex align-items-center justify-content-center">
            <div class="bg-white rounded-lg shadow-xl w-100 mx-4"
                style="max-width: 800px; max-height: 90vh; overflow: hidden;">
                <div
                    class="modal-header bg-primary text-white p-3 d-flex justify-content-between align-items-center sticky-top">
                    <h5 class="modal-title m-0">Edit Agent</h5>
                    <button @click="showEditModal = false" class="btn btn-sm btn-light p-0"
                        style="width: 30px; height: 30px; line-height: 30px;">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body p-4" style="overflow-y: auto; max-height: calc(90vh - 120px);">
                    <!-- Your existing form content -->
                    <form wire:submit.prevent="updateUser">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Full Name*</label>
                                <input type="text" class="form-control" wire:model.defer="user.name" required>
                                @error('user.name') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Email Address*</label>
                                <input type="email" class="form-control" wire:model.defer="user.email" required>
                                @error('user.email') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Phone Number*</label>
                                <input type="tel" class="form-control" wire:model.defer="user.phone_number" required>
                                @error('user.phone_number') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Role*</label>
                                <select class="form-select" wire:model.defer="user.role" required>
                                    <option value="landlord">Landlord</option>
                                    <option value="agent">Agent</option>
                                </select>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Profile Picture</label>
                            <input type="file" class="form-control" wire:model="newProfilePicture">
                            @error('newProfilePicture') <span class="text-danger">{{ $message }}</span> @enderror
                            <small class="text-muted">Leave empty to keep current image</small>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Current Profile Picture</label>
                            @if($currentProfilePicture)
                            <img src="{{ $currentProfilePicture }}" class="rounded-circle" width="80" height="80">
                            @else
                            <div class="avatar-placeholder rounded-circle bg-primary text-white d-flex align-items-center justify-content-center"
                                style="width: 80px; height: 80px; font-size: 2rem;">
                                {{ substr($user['name'] ?? '', 0, 1) }}
                            </div>
                            @endif
                        </div>
                    </form>
                </div>
                <div class="modal-footer p-3 border-top sticky-bottom bg-white">
                    <button @click="showEditModal = false" class="btn btn-secondary">Cancel</button>
                    <button wire:click="updateUser" class="btn btn-primary">Update</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Delete Modal -->
    <div x-data="{ showDeleteModal: @entangle('deleteModalOpen') }" x-show="showDeleteModal" x-transition
        style="display: none; position: fixed; top: 0; left: 0; right: 0; bottom: 0; z-index: 1050;">
        <div
            class="position-absolute w-100 h-100 bg-black bg-opacity-50 d-flex align-items-center justify-content-center">
            <div class="bg-white rounded-lg shadow-xl w-100 mx-4" style="max-width: 500px;">
                <div class="modal-header bg-danger text-white p-3 d-flex justify-content-between align-items-center">
                    <h5 class="modal-title m-0">Confirm Deletion</h5>
                    <button @click="showDeleteModal = false" class="btn btn-sm btn-light p-0"
                        style="width: 30px; height: 30px; line-height: 30px;">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body p-4">
                    <p>Are you sure you want to delete this landlord? This action cannot be undone.</p>
                </div>
                <div class="modal-footer p-3 border-top">
                    <button @click="showDeleteModal = false" class="btn btn-secondary">Cancel</button>
                    <button wire:click="deleteUser" class="btn btn-danger">Delete</button>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<!-- Your existing styles -->
<style>
.table-container {
    position: relative;
    background: #fff;
    border-radius: 8px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
    overflow: hidden;
}

/* Table header styling */
.table thead {
    background: linear-gradient(135deg, #6a11cb 0%, #2575fc 100%);
    color: white;
}

.table thead th {
    border-bottom: none;
    padding: 15px 20px;
    font-weight: 500;
    text-transform: uppercase;
    font-size: 0.75rem;
    letter-spacing: 0.5px;
}

/* Table body styling */
.table tbody tr {
    transition: all 0.2s ease;
    border-bottom: 1px solid #f0f0f0;
}

.table tbody tr:last-child {
    border-bottom: none;
}

.table tbody tr:hover {
    background-color: rgba(74, 117, 252, 0.05);
    transform: translateY(-1px);
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
}

.table tbody td {
    padding: 15px 20px;
    vertical-align: middle;
    color: #555;
}

/* Avatar styling */
.avatar-container {
    display: flex;
    align-items: center;
}

.avatar-img {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    object-fit: cover;
    margin-right: 12px;
    border: 2px solid #e9ecef;
    transition: all 0.3s ease;
}

.avatar-placeholder {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-right: 12px;
    font-weight: bold;
    color: white;
    background: linear-gradient(135deg, #6a11cb 0%, #2575fc 100%);
    border: 2px solid #e9ecef;
    transition: all 0.3s ease;
}

.table tbody tr:hover .avatar-img,
.table tbody tr:hover .avatar-placeholder {
    transform: scale(1.1);
    border-color: #2575fc;
}

/* Badge styling */
.badge {
    padding: 5px 10px;
    font-weight: 500;
    font-size: 0.7rem;
    border-radius: 4px;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.badge-landlord {
    background-color: #6a11cb;
}

.badge-agent {
    background-color: #00b09b;
}

/* Action buttons */
.action-buttons {
    display: flex;
    gap: 8px;
}

.btn-action {
    width: 32px;
    height: 32px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 50%;
    transition: all 0.2s ease;
    border: none;
}

.btn-edit {
    background-color: rgba(37, 117, 252, 0.1);
    color: #2575fc;
}

.btn-delete {
    background-color: rgba(220, 53, 69, 0.1);
    color: #dc3545;
}

.btn-action:hover {
    transform: scale(1.1);
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
}

.btn-action i {
    font-size: 14px;
}

/* Empty state styling */
.empty-state {
    padding: 4rem;
    text-align: center;
    background-color: #f8f9fa;
    border-radius: 8px;
    margin: 2rem 0;
}

.empty-state-icon {
    font-size: 4rem;
    color: #adb5bd;
    margin-bottom: 1.5rem;
    opacity: 0.7;
}

.empty-state-title {
    font-size: 1.5rem;
    margin-bottom: 0.5rem;
    color: #495057;
}

.empty-state-text {
    color: #6c757d;
    max-width: 500px;
    margin: 0 auto 1.5rem;
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .table thead {
        display: none;
    }

    .table tbody tr {
        display: block;
        margin-bottom: 20px;
        border: 1px solid #f0f0f0;
        border-radius: 8px;
    }

    .table tbody td {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 12px 15px;
        border-bottom: 1px solid #f0f0f0;
    }

    .table tbody td:before {
        content: attr(data-label);
        font-weight: 600;
        color: #495057;
        margin-right: 15px;
        flex: 1;
    }

    .table tbody td:last-child {
        border-bottom: none;
    }

    .avatar-container {
        justify-content: space-between;
        width: 100%;
    }

    .action-buttons {
        margin-left: auto;
    }
}

/* Loading animation */
@keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateY(10px);
    }

    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.table tbody tr {
    animation: fadeIn 0.3s ease forwards;
}

.table tbody tr:nth-child(1) {
    animation-delay: 0.1s;
}

.table tbody tr:nth-child(2) {
    animation-delay: 0.2s;
}

.table tbody tr:nth-child(3) {
    animation-delay: 0.3s;
}
</style>
</script>@endpush @push('scripts') <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer>
</script>@endpush