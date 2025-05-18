@extends('layouts.app')
@section('styles')
<style>
/* Main table container */
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

/* Continue for as many rows as you expect */
</style>
@endsection

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Agents Management</h1>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addLandlordModal">
            <i class="fas fa-plus-circle me-2"></i> Add New Agent
        </button>
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
                <h3>No Users Found</h3>
                <p class="lead">You haven't registered any agent yet.</p>
            </div>
            @else
            <div class="table-responsive">
                <table class="table table-bordered table-hover" id="landlordsTable" width="100%" cellspacing="0">
                    <thead class="bg-light">
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Role</th>
                            <th>Registered On</th>
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
                                <span class="badge {{ $user->role == 'agent' ? 'bg-primary' : 'bg-success' }}">
                                    {{ ucfirst($user->role) }}
                                </span>
                            </td>
                            <td>{{ $user->created_at->format('M d, Y') }}</td>
                            <td>
                                <div class="d-flex">
                                    <button class="btn btn-sm btn-outline-primary me-2 edit-btn"
                                        data-id="{{ $user->id }}" data-name="{{ $user->name }}"
                                        data-email="{{ $user->email }}" data-phone="{{ $user->phone_number }}"
                                        data-role="{{ $user->role }}"
                                        data-profile-picture="{{ $user->profile_picture ? asset('storage/'.$user->profile_picture) : '' }}">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <form action="{{ route('admin.agents.destroy', $user->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger"
                                            onclick="return confirm('Are you sure?')">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @endif
        </div>
    </div>
</div>

<!-- Add User Modal -->
<div class="modal fade" id="addLandlordModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="{{ route('admin.agents.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title">Register New Agent</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Full Name*</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" name="name"
                                value="{{ old('name') }}" required>
                            @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Email Address*</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" name="email"
                                value="{{ old('email') }}" required>
                            @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Phone Number*</label>
                            <input type="tel" class="form-control @error('phone_number') is-invalid @enderror"
                                name="phone_number" value="{{ old('phone_number') }}" required>
                            @error('phone_number')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Password*</label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror"
                                name="password" required>
                            @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Role*</label>
                            <select class="form-select @error('role') is-invalid @enderror" name="role" required>
                                <option value="">Select Role</option>
                                <option value="landlord" {{ old('role') == 'landlord' ? 'selected' : '' }}>Landlord
                                </option>
                                <option value="agent" {{ old('role') == 'agent' ? 'selected' : '' }}>Agent</option>
                            </select>
                            @error('role')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Profile Picture</label>
                            <input type="file" class="form-control @error('profile_picture') is-invalid @enderror"
                                name="profile_picture" accept="image/*">
                            @error('profile_picture')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Register User</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit User Modal -->
<!-- Edit Landlord Modal -->
<div class="modal fade" id="editLandlordModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form method="POST" enctype="multipart/form-data" id="editLandlordForm">
                @csrf
                @method('PUT')
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title">Edit Agent</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Full Name*</label>
                            <input type="text" class="form-control" name="name" id="editName" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Email Address*</label>
                            <input type="email" class="form-control" name="email" id="editEmail" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Phone Number*</label>
                            <input type="tel" class="form-control" name="phone_number" id="editPhone" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Profile Picture</label>
                            <input type="file" class="form-control" name="profile_picture" accept="image/*">
                            <small class="text-muted">Leave empty to keep current image</small>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Current Profile Picture</label>
                        <div id="currentProfilePicture"></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Update Agent</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"
    integrity="sha256-/xUj+3OJ+Y6k9sa5N0HfZsZ5xU2D6Nj1lEumJJ94Un8=" crossorigin="anonymous"></script>

@push('scripts')
@if(!$agents ?? ''->isEmpty())
<script>
$(document).ready(function() {
            // Handle sidebar link clicks
            $(document).on('click', '.load-content', function(e) {
                e.preventDefault();
                const url = $(this).attr('href');
                const target = $(this).data('target');

                // Show loading indicator
                $('#dynamic-content').html(
                        '<div class="text-center py-5"><i class="fas fa-spinner fa-spin fa-3x"></i></div>')
                    .show();
                $('#dashboard-content').hide();

                // Load content via AJAX
                $.ajax({
                    url: url,
                    type: 'GET',
                    success: function(response) {
                        $('#dynamic-content').html(response).show();
                        $('#dashboard-content').hide();

                        // Update active state in sidebar
                        $('.nav-link').removeClass('active');
                        $(`.nav-link[href="${url}"]`).addClass('active');

                        // Initialize any plugins needed for the loaded content
                        if (target === 'landlords-content') {
                            initLandlordsTable();
                        }
                    },
                    error: function(xhr) {
                        $('#dynamic-content').html(
                            '<div class="alert alert-danger">Error loading content</div>');
                    }
                });
            });
            $(document).on('click', '.back-to-dashboard', function() {
                $('#dynamic-content').hide().empty();
                $('#dashboard-content').show();
                $('.nav-link').removeClass('active');
            });
            $(document).ready(function() {
                // Initialize DataTable only if records exist
                $('#landlordsTable').DataTable({
                    responsive: true,
                    columnDefs: [{
                            responsivePriority: 1,
                            targets: 1
                        },
                        {
                            responsivePriority: 2,
                            targets: -1
                        }
                    ]
                });

                // Handle edit button clicks
                $('.edit-btn').click(function() {
                    const id = $(this).data('id');
                    const name = $(this).data('name');
                    const email = $(this).data('email');
                    const phone = $(this).data('phone');
                    const role = $(this).data('role');

                    // Set form action URL
                    $('#editLandlordForm').attr('action', '/admin/agents/' + id);

                    // Populate form fields
                    $('#editName').val(name);
                    $('#editEmail').val(email);
                    $('#editPhone').val(phone);

                    // Get current profile picture (you might need to pass this via data attribute)
                    const profilePic = $(this).closest('tr').find('img').attr('src') ||
                        $(this).closest('tr').find('.avatar-placeholder').text().trim();

                    // Display current profile picture
                    if ($(this).closest('tr').find('img').length) {
                        $('#currentProfilePicture').html(
                            `<img src="${profilePic}" class="rounded-circle" width="80" height="80">`
                        );
                    } else {
                        $('#currentProfilePicture').html(`
                <div class="avatar-placeholder rounded-circle bg-primary text-white d-flex align-items-center justify-content-center" style="width: 80px; height: 80px; font-size: 2rem;">
                    ${profilePic}
                </div>
            `);
                    }

                    $('#editLandlordModal').modal('show');
                });
            });
</script>
@endif
@endpush


@endsection