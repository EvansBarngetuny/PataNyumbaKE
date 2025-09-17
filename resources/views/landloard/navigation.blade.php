<div class="d-flex flex-column flex-shrink-0 p-3 bg-light border-end" style="width: 250px; min-height: 100vh;">
    <a href="{{ route('landlord.dashboard') }}"
        class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-decoration-none">

        <span class="fs-5 fw-bold">Landlord Panel</span>
    </a>
    <hr>
    <ul class="nav nav-pills flex-column mb-auto">
        <!-- Dashboard Overview -->
        <li class="nav-item">
            <a href="#dashboard" class="nav-link {{ request()->is('dashboard') ? 'active' : 'text-dark' }}"
                data-bs-toggle="tab">
                <i class="fas fa-tachometer-alt me-2"></i> Overview
            </a>
        </li>
        <!-- User Management fas fa-building me-2-->
        <li class="mt-2 mb-1 text-uppercase fw-bold small text-muted">User Management</li>
        <li>
            <a href="#agents" class="nav-link {{ request()->is('admin/agents*') ? 'active' : 'text-dark' }}"
                data-bs-toggle="tab" data-url="{{ route('admin.agents.index') }}">
                <i class="fas fa-user-secret me-2"></i> Agents
            </a>
        </li>
        <li>
            <a href="#tenants" class="nav-link {{ request()->is('admin/tenants*') ? 'active' : 'text-dark' }}"
                data-bs-toggle="tab" data-url="{{ route('admin.tenants.index') }}">
                <i class="fas fa-users me-2"></i> Tenants
            </a>
        </li>
        <li>
            <a href="#tenants" class="nav-link {{ request()->is('admin/tenants*') ? 'active' : 'text-dark' }}"
                data-bs-toggle="tab" data-url="{{ route('admin.tenants.index') }}">
                <i class="fas fa-file-contract"></i>
                    Lease Agreements
            </a>
        </li>
        <!-- System Monitoring -->
        <li class="mt-3 mb-1 text-uppercase fw-bold small text-muted">My Listings</li>
        <li>
            <a href="{{ route('admin.analytics.index') }}"
                class="nav-link {{ request()->is('analytics*') ? 'active' : 'text-dark' }}">
                <i class="fas fa-home"></i> My Properties
            </a>
        </li>
        <li>
            <a href="{{ route('admin.reports.index') }}"
                class="nav-link {{ request()->is('spam-reports*') ? 'active' : 'text-dark' }}">
                <i class="fas fa-plus-circle"></i> Add Property
            </a>
        </li>
        <li>
            <a href="#system-health"
                class="nav-link {{ request()->is('admin/system-health*') ? 'active' : 'text-dark' }}">
                <i class="fas fa-tags"></i> Property Types
            </a>
        </li>
        <!-- Content & Settings -->
        <li class="mt-3 mb-1 text-uppercase fw-bold small text-muted">Financial Management</li>
        <li>
            <a href="#" class="nav-link {{ request()->is('listings*') ? 'active' : 'text-dark' }}">
                <i class="fas fa-money-bill-wave"></i> Rent Collection
            </a>
        </li>
        <li>
            <a href="#" class="nav-link {{ request()->is('payments*') ? 'active' : 'text-dark' }}">
                <i class="fas fa-receipt"></i> Expenses
            </a>
        </li>
        <li>
            <a href="#" class="nav-link {{ request()->is('audit-trail*') ? 'active' : 'text-dark' }}">
                <i class="fas fa-file-invoice"></i> Invoices
            </a>
        </li>
        <li>
            <a href="#" class="nav-link {{ request()->is('settings') ? 'active' : 'text-dark' }}">
                <i class="fas fa-chart-pie"></i> Financial Reports
            </a>
        </li>
        <li class="mt-3 mb-1 text-uppercase fw-bold small text-muted">Communications</li>
        <li>
            <a href="#" class="nav-link {{ request()->is('listings*') ? 'active' : 'text-dark' }}">
                <i class="fas fa-envelope"></i> Messages
            </a>
        </li>
        <li>
            <a href="#" class="nav-link {{ request()->is('payments*') ? 'active' : 'text-dark' }}">
                <i class="fas fa-bell"></i> Notices
            </a>
        </li>
        <li>
            <a href="#" class="nav-link {{ request()->is('audit-trail*') ? 'active' : 'text-dark' }}">
                <i class="fas fa-clock"></i> Reminders
            </a>
        </li>
  <li class="mt-3 mb-1 text-uppercase fw-bold small text-muted">Maintenance</li>
        <li>
            <a href="#" class="nav-link {{ request()->is('listings*') ? 'active' : 'text-dark' }}">
                <i class="fas fa-tools"></i> Maintenance Requests
                <span class="sidebar-badge">2</span>
            </a>
        </li>
        <li>
            <a href="#" class="nav-link {{ request()->is('payments*') ? 'active' : 'text-dark' }}">
                <i class="fas fa-user-cog"></i> Contractors
            </a>
        </li>
    </ul>
    <hr>
</div>
