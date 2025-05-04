@extends('layouts.app')

@section('styles')
<style>
/* Avatar placeholder */
.avatar-placeholder {
    font-weight: bold;
    text-transform: uppercase;
}

/* Table actions */
.btn-sm {
    padding: 0.25rem 0.5rem;
    font-size: 0.75rem;
}

/* Hover effect on table rows */
.table-hover tbody tr:hover {
    background-color: rgba(0, 0, 0, 0.02);
}

/* Modal styling */
.modal-header {
    border-bottom: none;
    padding-bottom: 0;
}

.modal-footer {
    border-top: none;
}

/* Empty state styling */
.empty-state {
    padding: 3rem;
    text-align: center;
    background-color: #f8f9fa;
    border-radius: 0.25rem;
}

.empty-state i {
    font-size: 3rem;
    color: #6c757d;
    margin-bottom: 1rem;
}
</style>
@endsection

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Landlords Management</h1>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addLandlordModal">
            <i class="fas fa-plus-circle me-2"></i> Add New User
        </button>
    </div>

    <!-- Landlords Table -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 bg-white">
            <h6 class="m-0 font-weight-bold text-primary">Registered Landlords</h6>
        </div>
        <div class="card-body">
            @if($landlords->isEmpty())
            <div class="empty-state">
                <i class="fas fa-user-tie fa-3x"></i>
                <h3>No Users Found</h3>
                <p class="lead">You haven't registered any landlords yet.</p>
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
                        @foreach($landlords as $user)
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
                                <div class="d-flex">
                                    <button class="btn btn-sm btn-outline-primary me-2 edit-btn"
                                        data-id="{{ $user->id }}" data-name="{{ $user->name }}"
                                        data-email="{{ $user->email }}" data-phone="{{ $user->phone_number }}"
                                        data-role="{{ $user->role }}"
                                        data-profile-picture="{{ $user->profile_picture ? asset('storage/'.$user->profile_picture) : '' }}">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <form action="{{ route('admin.landlords.destroy', $user->id) }}" method="POST">
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
            <form action="{{ route('admin.landlords.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title">Register New User</h5>
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
                    <h5 class="modal-title">Edit Landlord</h5>
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
                    <button type="submit" class="btn btn-primary">Update Landlord</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"
    integrity="sha256-/xUj+3OJ+Y6k9sa5N0HfZsZ5xU2D6Nj1lEumJJ94Un8=" crossorigin="anonymous"></script>

@push('scripts')
@if(!$landlords->isEmpty())
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
                    $('#editLandlordForm').attr('action', '/admin/landlords/' + id);

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