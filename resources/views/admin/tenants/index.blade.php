@extends('layouts.app')

@section('styles')
<style>
/* Enhanced Table Styling */
.table-responsive {
    overflow-x: auto;
    -webkit-overflow-scrolling: touch;
}

#landlordsTable {
    width: 100%;
    border-collapse: separate;
    border-spacing: 0;
}

#landlordsTable thead th {
    position: sticky;
    top: 0;
    background-color: #f8fafc;
    z-index: 10;
    font-weight: 600;
    color: #334155;
    padding: 1rem 1.25rem;
    border-bottom: 1px solid #e2e8f0;
}

#landlordsTable tbody td {
    padding: 1rem 1.25rem;
    vertical-align: middle;
    border-bottom: 1px solid #e2e8f0;
    transition: all 0.2s ease;
}

#landlordsTable tbody tr:last-child td {
    border-bottom: none;
}

#landlordsTable tbody tr:hover td {
    background-color: #f8fafc;
}

/* Action Buttons */
.action-buttons {
    display: flex;
    gap: 0.5rem;
}

.btn-action {
    width: 32px;
    height: 32px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    border-radius: 6px;
    transition: all 0.2s;
}

.btn-edit {
    color: #3b82f6;
    border: 1px solid #bfdbfe;
    background-color: #eff6ff;
}

.btn-edit:hover {
    background-color: #dbeafe;
    color: #2563eb;
}

.btn-delete {
    color: #ef4444;
    border: 1px solid #fecaca;
    background-color: #fef2f2;
}

.btn-delete:hover {
    background-color: #fee2e2;
    color: #dc2626;
}

/* Modern Modal Styling */
.modal-content {
    border: none;
    border-radius: 12px;
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
}

.modal-header {
    padding: 1.5rem;
    border-bottom: 1px solid #e2e8f0;
}

.modal-title {
    font-weight: 600;
    color: #1e293b;
}

.modal-body {
    padding: 1.5rem;
}

.modal-footer {
    padding: 1.25rem 1.5rem;
    border-top: 1px solid #e2e8f0;
}

/* Form Styling */
.form-control,
.form-select {
    padding: 0.625rem 1rem;
    border-radius: 8px;
    border: 1px solid #e2e8f0;
    transition: all 0.2s;
}

.form-control:focus,
.form-select:focus {
    border-color: #93c5fd;
    box-shadow: 0 0 0 3px rgba(147, 197, 253, 0.2);
}

/* Avatar Improvements */
.avatar-placeholder {
    width: 40px;
    height: 40px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 50%;
    font-weight: 500;
    font-size: 1rem;
}

/* Badge Styling */
.badge {
    padding: 0.35em 0.65em;
    font-weight: 500;
    letter-spacing: 0.5px;
    border-radius: 6px;
}

.badge-landlord {
    background-color: #e0f2fe;
    color: #0369a1;
}

.badge-agent {
    background-color: #dcfce7;
    color: #166534;
}

/* Responsive Adjustments */
@media (max-width: 768px) {
    #landlordsTable thead {
        display: none;
    }

    #landlordsTable tbody tr {
        display: block;
        margin-bottom: 1rem;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        padding: 1rem;
    }

    #landlordsTable tbody td {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0.75rem 0.5rem;
        border-bottom: 1px solid #f1f5f9;
    }

    #landlordsTable tbody td:before {
        content: attr(data-label);
        font-weight: 600;
        color: #64748b;
        margin-right: 1rem;
    }

    #landlordsTable tbody td:last-child {
        border-bottom: none;
    }

    .action-buttons {
        justify-content: flex-end;
    }
}
</style>
@endsection

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Tenants Management</h1>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addLandlordModal">
            <i class="fas fa-plus-circle me-2"></i> Add New Tenant
        </button>
    </div>

    <!-- Landlords Table -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 bg-white">
            <h6 class="m-0 font-weight-bold text-primary">Registered Tenants</h6>
        </div>
        <div class="card-body">
            @if($tenants->isEmpty())
            <div class="empty-state">
                <i class="fas fa-user-tie fa-3x"></i>
                <h3>No Users Found</h3>
                <p class="lead">You haven't registered any tenant yet.</p>
            </div>
            @else
            <div class="table-responsive">
                <table class="table" id="landlordsTable" width="100%" cellspacing="0">
                    <thead>
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
                        @foreach($tenants as $user)
                        <tr>
                            <td data-label="#">{{ $loop->iteration }}</td>
                            <td data-label="Name">
                                <div class="d-flex align-items-center">
                                    @if($user->profile_picture)
                                    <img src="{{ asset('storage/'.$user->profile_picture) }}"
                                        class="rounded-circle me-3" width="40" height="40" alt="{{ $user->name }}">
                                    @else
                                    <div class="avatar-placeholder rounded-circle me-3 bg-primary text-white d-flex align-items-center justify-content-center"
                                        style="width: 40px; height: 40px;">
                                        {{ substr($user->name, 0, 1) }}
                                    </div>
                                    @endif
                                    <span>{{ $user->name }}</span>
                                </div>
                            </td>
                            <td data-label="Email">{{ $user->email }}</td>
                            <td data-label="Phone">{{ $user->phone_number }}</td>
                            <td data-label="Role">
                                <span class="badge badge-{{ $user->role == 'tenant' ? 'tenant' : 'tenant' }}">
                                    {{ ucfirst($user->role) }}
                                </span>
                            </td>
                            <td data-label="Registered">{{ $user->created_at->format('M d, Y') }}</td>
                            <td data-label="Actions">
                                <div class="action-buttons">
                                    <button class="btn-action btn-edit edit-btn" data-id="{{ $user->id }}"
                                        data-name="{{ $user->name }}" data-email="{{ $user->email }}"
                                        data-phone="{{ $user->phone_number }}" data-role="{{ $user->role }}"
                                        data-profile-picture="{{ $user->profile_picture ? asset('storage/'.$user->profile_picture) : '' }}">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <form action="{{ route('admin.tenants.destroy', $user->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-action btn-delete"
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
<!-- Add User Modal -->
<div class="modal fade" id="addLandlordModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0">
            <form action="{{ route('admin.tenants.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Register New tenant</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Full Name*</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" name="name"
                                value="{{ old('name') }}" required>
                            @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Email Address*</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" name="email"
                                value="{{ old('email') }}" required>
                            @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Phone Number*</label>
                            <input type="tel" class="form-control @error('phone_number') is-invalid @enderror"
                                name="phone_number" value="{{ old('phone_number') }}" required>
                            @error('phone_number')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Password*</label>
                            <div class="input-group">
                                <input type="password" class="form-control @error('password') is-invalid @enderror"
                                    name="password" required id="passwordField">
                                <button class="btn btn-outline-secondary toggle-password" type="button">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                            @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Role*</label>
                            <select class="form-select @error('role') is-invalid @enderror" name="role" required>
                                <option value="">Select Role</option>
                                <option value="tenant" {{ old('role') == 'tenant' ? 'selected' : '' }}>Tenant
                                </option>
                            </select>
                            @error('role')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
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
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-1"></i> Register User
                    </button>
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
                    <h5 class="modal-title">Edit Tenant</h5>
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
                    <button type="submit" class="btn btn-primary">Update Tenant</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"
    integrity="sha256-/xUj+3OJ+Y6k9sa5N0HfZsZ5xU2D6Nj1lEumJJ94Un8=" crossorigin="anonymous"></script>

@push('scripts')
@if(!$tenants->isEmpty())
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
                    $('#editLandlordForm').attr('action', '/admin/tenants/' + id);

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