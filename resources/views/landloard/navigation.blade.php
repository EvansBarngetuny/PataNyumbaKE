<div class="d-flex flex-column flex-shrink-0 p-3 bg-light border-end" style="width: 250px; min-height: 100vh;">
    <a href="{{ route('landlord.dashboard') }}"
        class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-decoration-none">
        <span class="fs-5 fw-bold">Landlord Panel</span>
    </a>
    <hr>
    <ul class="nav nav-pills flex-column mb-auto">
        <!-- Dashboard Overview -->
        <li class="nav-item">
            <a href="#overview" class="nav-link {{ request()->is('dashboard') ? 'active' : 'text-dark' }}"
                data-bs-toggle="tab">
                <i class="fas fa-tachometer-alt me-2"></i> Overview
            </a>
        </li>

        <!-- User Management -->
        <li class="mt-2 mb-1 text-uppercase fw-bold small text-muted">User Management</li>
        <li>
            <a href="#agents" class="nav-link text-dark" data-bs-toggle="tab">
                <i class="fas fa-user-secret me-2"></i> Agents
            </a>
        </li>
        <li>
            <a href="#tenants" class="nav-link text-dark" data-bs-toggle="tab">
                <i class="fas fa-users me-2"></i> Tenants
            </a>
        </li>
        <li>
            <a href="#lease-agreements" class="nav-link text-dark" data-bs-toggle="tab">
                <i class="fas fa-file-contract me-2"></i> Lease Agreements
            </a>
        </li>

        <!-- My Listings -->
        <li class="mt-3 mb-1 text-uppercase fw-bold small text-muted">My Listings</li>
        <li>
              <a href="#booked" class="nav-link text-dark" data-bs-toggle="tab">
                <i class="fas fa-home me-2"></i> Booked Rooms
            </a>
        </li>
        <li>
            <a href="#my-properties" class="nav-link text-dark" data-bs-toggle="tab">
                <i class="fas fa-home me-2"></i> All Vacant Rooms
            </a>
        </li>
        <li>
            <a class="nav-link text-dark" data-bs-target="add-property">
                <i class="fas fa-plus-circle me-2"></i> Add Property
            </a>
        </li>
        <li>
            <a href="#property-types" class="nav-link text-dark" data-bs-toggle="tab">
                <i class="fas fa-tags me-2"></i> Property Types
            </a>
        </li>

        <!-- Financial Management -->
        <li class="mt-3 mb-1 text-uppercase fw-bold small text-muted">Financial Management</li>
        <li>
            <a href="#rent-collection" class="nav-link text-dark" data-bs-toggle="tab">
                <i class="fas fa-money-bill-wave me-2"></i> Rent Collection
            </a>
        </li>
        <li>
            <a href="#expenses" class="nav-link text-dark" data-bs-toggle="tab">
                <i class="fas fa-receipt me-2"></i> Expenses
            </a>
        </li>
        <li>
            <a href="#invoices" class="nav-link text-dark" data-bs-toggle="tab">
                <i class="fas fa-file-invoice me-2"></i> Invoices
            </a>
        </li>
        <li>
            <a href="#financial-reports" class="nav-link text-dark" data-bs-toggle="tab">
                <i class="fas fa-chart-pie me-2"></i> Financial Reports
            </a>
        </li>

        <!-- Communications -->
        <li class="mt-3 mb-1 text-uppercase fw-bold small text-muted">Communications</li>
        <li>
            <a href="#messages" class="nav-link text-dark" data-bs-toggle="tab">
                <i class="fas fa-envelope me-2"></i> Messages
                @if ($unreadCount > 0)
                    <span class="badge bg-danger">{{ $unreadCount }}</span>
                @endif
            </a>
        </li>
        <li>
            <a href="#notices" class="nav-link text-dark" data-bs-toggle="tab">
                <i class="fas fa-bell me-2"></i> Notices
            </a>
        </li>
        <li>
            <a href="#reminders" class="nav-link text-dark" data-bs-toggle="tab">
                <i class="fas fa-clock me-2"></i> Reminders
            </a>
        </li>

        <!-- Maintenance -->
        <li class="mt-3 mb-1 text-uppercase fw-bold small text-muted">Maintenance</li>
        <li>
            <a href="#maintenance-requests" class="nav-link text-dark" data-bs-toggle="tab">
                <i class="fas fa-tools me-2"></i> Maintenance Requests
                <span class="badge bg-danger ms-2">2</span>
            </a>
        </li>
        <li>
            <a href="#contractors" class="nav-link text-dark" data-bs-toggle="tab">
                <i class="fas fa-user-cog me-2"></i> Contractors
            </a>
        </li>
    </ul>
    <hr>
</div>
