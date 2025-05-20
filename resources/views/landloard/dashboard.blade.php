@extends('layouts.admin')

@section('page-title', 'Landlord Dashboard')
@section('styles')
<style>
:root {
    --sidebar-width: 280px;
    --sidebar-collapsed-width: 80px;
    --sidebar-bg: #0056b3;
    --sidebar-text-color: #ffffff;
    --sidebar-hover-bg: rgba(255, 255, 255, 0.1);
    --sidebar-active-bg: rgba(255, 255, 255, 0.2);
    --sidebar-transition: all 0.3s ease;
    --primary-color: #7b7a86;
    --card-bg: #ffffff;
    --card-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    --card-radius: 10px;
    --text-muted: #6b7280;
}

/* Sidebar */
.sidebar {
    width: auto;
    min-width: 220px;
    max-width: 100%;
    width: var(--sidebar-width);
    background: var(--sidebar-bg);
    color: var(--sidebar-text-color);
    transition: var(--sidebar-transition);
    min-height: 100vh;
    position: relative;
    overflow-y: auto;
    padding-bottom: 20px;
    white-space: nowrap;
    overflow-x: auto;
    flex: 0 0 auto;
    flex-shrink: 0;
}

.sidebar-logo {
    height: 70px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 0 20px;
    color: var(--sidebar-text-color);
    font-weight: bold;
    font-size: 1.2rem;
    border-bottom: 1px solid rgba(255, 255, 255, 0.2);
}

.sidebar-menu {
    flex: 1;
    padding: 20px 0;
    overflow-y: auto;
}

.nav-link {
    color: var(--sidebar-text-color);
    padding: 12px 20px;
    margin: 5px 10px;
    border-radius: 6px;
    display: flex;
    align-items: center;
    transition: var(--sidebar-transition);
    font-size: 0.95rem;
}

.nav-link:hover {
    background: var(--sidebar-hover-bg);
}

.nav-link.active {
    background: var(--sidebar-active-bg);
    font-weight: bold;
}

.nav-link i {
    margin-right: 12px;
    font-size: 1.2rem;
}

/* Main Content */
.main-content {
    flex-grow: 1;
    padding: 20px;
    background: #f9fafb;
    min-height: 100vh;
    overflow-x: hidden;
    transition: var(--sidebar-transition);
}

.dashboard-card {
    background: var(--card-bg);
    box-shadow: var(--card-shadow);
    border-radius: var(--card-radius);
    padding: 20px;
    transition: transform 0.3s ease;
}

.dashboard-card:hover {
    transform: translateY(-5px);
}

.dashboard-card h6 {
    color: var(--text-muted);
    font-size: 0.9rem;
}

.dashboard-card h3 {
    font-size: 1.5rem;
    font-weight: bold;
}

/* Responsive Design */
@media (max-width: 992px) {
    .sidebar {
        transform: translateX(-100%);
        position: absolute;
        z-index: 1100;
    }

    .sidebar-show {
        transform: translateX(0);
    }

    .main-content {
        margin-left: 0;
    }
}
</style>
@endsection

@section('content')
<div class="d-flex">
    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <div class="sidebar-logo">
            <span class="sidebar-logo-text">Landlord Panel</span>
            <span class="sidebar-logo-icon"><i class="fas fa-home"></i></span>
            <button class="collapse-btn" id="sidebarCollapse">
                <i class="fas fa-bars"></i>
            </button>
        </div>

        <div class="sidebar-menu">
            <ul class="nav flex-column">
                <!-- Dashboard -->
                <li class="nav-item">
                    <a class="nav-link active" href="#dashboard" data-bs-toggle="tab">
                        <i class="fas fa-tachometer-alt"></i>
                        <span class="sidebar-text">Dashboard</span>
                    </a>
                </li>

                <!-- Properties Dropdown -->
                <li class="nav-item sidebar-dropdown">
                    <a class="nav-link sidebar-dropdown-toggle" href="#properties" data-bs-toggle="collapse"
                        role="button" aria-expanded="false">
                        <i class="fas fa-home"></i>
                        <span class="sidebar-text">Properties</span>
                    </a>
                    <div class="sidebar-dropdown-menu collapse" id="properties">
                        <a class="nav-link" href="#listings" data-bs-toggle="tab">
                            <i class="fas fa-list"></i>
                            <span class="sidebar-text">My Listings</span>
                        </a>
                        <a class="nav-link" href="#add-property" data-bs-toggle="tab">
                            <i class="fas fa-plus-circle"></i>
                            <span class="sidebar-text">Add Property</span>
                        </a>
                        <a class="nav-link" href="#property-types" data-bs-toggle="tab">
                            <i class="fas fa-tags"></i>
                            <span class="sidebar-text">Property Types</span>
                        </a>
                    </div>
                </li>

                <!-- Tenants Management -->
                <li class="nav-item sidebar-dropdown">
                    <a class="nav-link sidebar-dropdown-toggle" href="#tenants" data-bs-toggle="collapse" role="button"
                        aria-expanded="false">
                        <i class="fas fa-users"></i>
                        <span class="sidebar-text">Tenants</span>
                        <span class="sidebar-badge">3 New</span>
                    </a>
                    <div class="sidebar-dropdown-menu collapse" id="tenants">
                        <a class="nav-link" href="#tenant-list" data-bs-toggle="tab">
                            <i class="fas fa-list"></i>
                            <span class="sidebar-text">Tenant List</span>
                        </a>
                        <a class="nav-link" href="#add-tenant" data-bs-toggle="tab">
                            <i class="fas fa-user-plus"></i>
                            <span class="sidebar-text">Add Tenant</span>
                        </a>
                        <a class="nav-link" href="#tenant-screening" data-bs-toggle="tab">
                            <i class="fas fa-search"></i>
                            <span class="sidebar-text">Tenant Screening</span>
                        </a>
                    </div>
                </li>

                <!-- Financials -->
                <li class="nav-item sidebar-dropdown">
                    <a class="nav-link sidebar-dropdown-toggle" href="#financials" data-bs-toggle="collapse"
                        role="button" aria-expanded="false">
                        <i class="fas fa-money-bill-wave"></i>
                        <span class="sidebar-text">Financials</span>
                    </a>
                    <div class="sidebar-dropdown-menu collapse" id="financials">
                        <a class="nav-link" href="#rent-collection" data-bs-toggle="tab">
                            <i class="fas fa-hand-holding-usd"></i>
                            <span class="sidebar-text">Rent Collection</span>
                        </a>
                        <a class="nav-link" href="#expenses" data-bs-toggle="tab">
                            <i class="fas fa-receipt"></i>
                            <span class="sidebar-text">Expenses</span>
                        </a>
                        <a class="nav-link" href="#invoices" data-bs-toggle="tab">
                            <i class="fas fa-file-invoice"></i>
                            <span class="sidebar-text">Invoices</span>
                        </a>
                        <a class="nav-link" href="#reports" data-bs-toggle="tab">
                            <i class="fas fa-chart-pie"></i>
                            <span class="sidebar-text">Financial Reports</span>
                        </a>
                    </div>
                </li>

                <!-- Maintenance -->
                <li class="nav-item sidebar-dropdown">
                    <a class="nav-link sidebar-dropdown-toggle" href="#maintenance" data-bs-toggle="collapse"
                        role="button" aria-expanded="false">
                        <i class="fas fa-tools"></i>
                        <span class="sidebar-text">Maintenance</span>
                        <span class="sidebar-badge">2 Pending</span>
                    </a>
                    <div class="sidebar-dropdown-menu collapse" id="maintenance">
                        <a class="nav-link" href="#maintenance-requests" data-bs-toggle="tab">
                            <i class="fas fa-clipboard-list"></i>
                            <span class="sidebar-text">Requests</span>
                        </a>
                        <a class="nav-link" href="#maintenance-schedule" data-bs-toggle="tab">
                            <i class="fas fa-calendar-alt"></i>
                            <span class="sidebar-text">Schedule</span>
                        </a>
                        <a class="nav-link" href="#maintenance-contractors" data-bs-toggle="tab">
                            <i class="fas fa-user-cog"></i>
                            <span class="sidebar-text">Contractors</span>
                        </a>
                    </div>
                </li>

                <!-- Documents -->
                <li class="nav-item">
                    <a class="nav-link" href="#documents" data-bs-toggle="tab">
                        <i class="fas fa-file-contract"></i>
                        <span class="sidebar-text">Documents</span>
                    </a>
                </li>

                <!-- Communications -->
                <li class="nav-item sidebar-dropdown">
                    <a class="nav-link sidebar-dropdown-toggle" href="#communications" data-bs-toggle="collapse"
                        role="button" aria-expanded="false">
                        <i class="fas fa-comments"></i>
                        <span class="sidebar-text">Communications</span>
                        <span class="sidebar-badge">5 Unread</span>
                    </a>
                    <div class="sidebar-dropdown-menu collapse" id="communications">
                        <a class="nav-link" href="#messages" data-bs-toggle="tab">
                            <i class="fas fa-envelope"></i>
                            <span class="sidebar-text">Messages</span>
                        </a>
                        <a class="nav-link" href="#notices" data-bs-toggle="tab">
                            <i class="fas fa-bell"></i>
                            <span class="sidebar-text">Notices</span>
                        </a>
                        <a class="nav-link" href="#reminders" data-bs-toggle="tab">
                            <i class="fas fa-clock"></i>
                            <span class="sidebar-text">Reminders</span>
                        </a>
                    </div>
                </li>

                <!-- Settings -->
                <li class="nav-item">
                    <a class="nav-link" href="#settings" data-bs-toggle="tab">
                        <i class="fas fa-cog"></i>
                        <span class="sidebar-text">Settings</span>
                    </a>
                </li>
            </ul>
        </div>

       <!-- <div class="sidebar-footer">
            <div class="d-flex align-items-center">
                <img src="https://randomuser.me/api/portraits/men/32.jpg" class="rounded-circle me-2" width="40"
                    height="40" alt="User">
                <div class="user-info">
                    <div class="user-name">John Doe</div>
                    <small class="text-muted">Landlord</small>
                </div>
                <a href="#" class="ms-auto text-white"><i class="fas fa-sign-out-alt"></i></a>
            </div>
        </div> -->
    </div>

    <!-- Main Content -->
    <main class="main-content" id="mainContent">
        <!-- Your existing content here... -->
        <div
            class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
            <h1 class="h2">Landlord Dashboard</h1>
            <div class="btn-toolbar mb-2 mb-md-0">
                <a href="{{ route('listings.create') }}" class="btn btn-sm btn-outline-secondary">
                    <i class="fas fa-plus me-1"></i> Add New Listing
                </a>
            </div>
        </div>

        <div class="tab-content">
            <!-- Dashboard Tab -->
            <div class="tab-pane fade show active" id="dashboard">
                <div class="row mb-4">
                    <div class="col-md-3">
                        <div class="dashboard-card card mb-4">
                            <div class="card-body">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <h6 class="text-muted mb-2">Active Listings</h6>
                                        <h3 class="mb-0">12</h3>
                                    </div>
                                    <div class="avatar avatar-sm bg-primary bg-opacity-10 p-2">
                                        <i class="fas fa-home text-primary"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="dashboard-card card mb-4">
                            <div class="card-body">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <h6 class="text-muted mb-2">Occupied Units</h6>
                                        <h3 class="mb-0">8</h3>
                                    </div>
                                    <div class="avatar avatar-sm bg-success bg-opacity-10 p-2">
                                        <i class="fas fa-user-check text-success"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="dashboard-card card mb-4">
                            <div class="card-body">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <h6 class="text-muted mb-2">Pending Rent</h6>
                                        <h3 class="mb-0">3</h3>
                                    </div>
                                    <div class="avatar avatar-sm bg-warning bg-opacity-10 p-2">
                                        <i class="fas fa-exclamation-triangle text-warning"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="dashboard-card card mb-4">
                            <div class="card-body">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <h6 class="text-muted mb-2">Total Revenue</h6>
                                        <h3 class="mb-0">Ksh 240,000</h3>
                                    </div>
                                    <div class="avatar avatar-sm bg-info bg-opacity-10 p-2">
                                        <i class="fas fa-money-bill-wave text-info"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-8">
                        <div class="card mb-4">
                            <div class="card-header">
                                <h5 class="mb-0">Rent Collection Overview</h5>
                            </div>
                            <div class="card-body">
                                <div class="chart-container">
                                    <canvas id="rentChart"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card mb-4">
                            <div class="card-header">
                                <h5 class="mb-0">Recent Activities</h5>
                            </div>
                            <div class="card-body">
                                <div class="activity-item mb-3">
                                    <p class="mb-1"><strong>New tenant added</strong> - James Kariuki</p>
                                    <small class="text-muted">2 hours ago</small>
                                </div>
                                <div class="activity-item mb-3">
                                    <p class="mb-1"><strong>Payment received</strong> - Ksh 15,000</p>
                                    <small class="text-muted">1 day ago</small>
                                </div>
                                <div class="activity-item mb-3">
                                    <p class="mb-1"><strong>New listing created</strong> - 2 Bedroom Apartment</p>
                                    <small class="text-muted">3 days ago</small>
                                </div>
                                <div class="activity-item">
                                    <p class="mb-1"><strong>Maintenance request</strong> - Plumbing issue</p>
                                    <small class="text-muted">5 days ago</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Listings Tab -->
            <div class="tab-pane fade" id="listings">
                <div class="d-flex justify-content-between mb-3">
                    <h4>My Property Listings</h4>
                    <a href="{{ route('listings.create') }}" class="btn btn-primary btn-sm">
                        <i class="fas fa-plus me-1"></i> Add Listing
                    </a>
                </div>

                <div class="row">
                    @foreach([1,2,3,4] as $listing)
                    <div class="col-md-6 col-lg-4 mb-4">
                        <div class="card listing-card h-100">
                            <img src="https://images.unsplash.com/photo-1564013799919-ab600027ffc6?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=60"
                                class="card-img-top" alt="Property">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <h5 class="card-title mb-0">2 Bedroom Apartment</h5>
                                    <span class="badge bg-success">Occupied</span>
                                </div>
                                <p class="card-text text-muted mb-2">
                                    <i class="fas fa-map-marker-alt me-1"></i> Westlands, Nairobi
                                </p>
                                <p class="card-text mb-3">
                                    <span class="fw-bold">Ksh 25,000</span> / month
                                </p>
                                <div class="d-flex justify-content-between">
                                    <button class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-eye me-1"></i> View
                                    </button>
                                    <button class="btn btn-sm btn-outline-warning">
                                        <i class="fas fa-edit me-1"></i> Edit
                                    </button>
                                    <button class="btn btn-sm btn-outline-danger">
                                        <i class="fas fa-trash me-1"></i> Delete
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Tenants Tab -->
            <div class="tab-pane fade" id="tenants">
                <h4 class="mb-3">Tenant Management</h4>

                <div class="card mb-4">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Tenant</th>
                                        <th>Property</th>
                                        <th>Rent</th>
                                        <th>Lease End</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach([1,2,3] as $tenant)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <img src="https://randomuser.me/api/portraits/men/{{ $tenant }}.jpg"
                                                    class="tenant-avatar me-2" alt="Tenant">
                                                <div>
                                                    <p class="mb-0">Tenant Name {{ $tenant }}</p>
                                                    <small class="text-muted">tenant{{ $tenant }}@email.com</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td>2 Bedroom Apartment</td>
                                        <td>Ksh 25,000</td>
                                        <td>15 Dec 2023</td>
                                        <td><span class="badge bg-success">Current</span></td>
                                        <td>
                                            <button class="btn btn-sm btn-outline-primary btn-action">
                                                <i class="fas fa-envelope"></i>
                                            </button>
                                            <button class="btn btn-sm btn-outline-info btn-action">
                                                <i class="fas fa-file-contract"></i>
                                            </button>
                                            <button class="btn btn-sm btn-outline-warning btn-action">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Payments Tab -->
            <div class="tab-pane fade" id="payments">
                <div class="d-flex justify-content-between mb-3">
                    <h4>Rent Payments</h4>
                    <div class="btn-group">
                        <button class="btn btn-outline-secondary btn-sm">This Month</button>
                        <button class="btn btn-outline-secondary btn-sm">Last Month</button>
                        <button class="btn btn-outline-secondary btn-sm">All Time</button>
                    </div>
                </div>

                <div class="card mb-4">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Tenant</th>
                                        <th>Property</th>
                                        <th>Amount</th>
                                        <th>Method</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach([1,2,3,4,5] as $payment)
                                    <tr>
                                        <td>{{ now()->subDays($payment)->format('d M Y') }}</td>
                                        <td>Tenant Name {{ $payment }}</td>
                                        <td>2 Bedroom Apartment</td>
                                        <td>Ksh 25,000</td>
                                        <td>MPESA</td>
                                        <td>
                                            <span class="badge bg-{{ $payment % 2 == 0 ? 'success' : 'warning' }}">
                                                {{ $payment % 2 == 0 ? 'Paid' : 'Pending' }}
                                            </span>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Reminders Tab -->
            <div class="tab-pane fade" id="reminders">
                <div class="d-flex justify-content-between mb-3">
                    <h4>Rent Reminders</h4>
                    <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addReminderModal">
                        <i class="fas fa-plus me-1"></i> Add Reminder
                    </button>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-4">
                        <div class="card reminder-card">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div>
                                        <h5 class="card-title">James Kariuki</h5>
                                        <p class="card-text mb-1">2 Bedroom Apartment</p>
                                        <p class="card-text text-danger mb-1">
                                            <i class="fas fa-clock me-1"></i> Due in 3 days
                                        </p>
                                    </div>
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button"
                                            data-bs-toggle="dropdown">
                                            Actions
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li><a class="dropdown-item" href="#"><i class="fas fa-envelope me-1"></i>
                                                    Send Reminder</a></li>
                                            <li><a class="dropdown-item" href="#"><i class="fas fa-edit me-1"></i>
                                                    Edit</a></li>
                                            <li><a class="dropdown-item text-danger" href="#"><i
                                                        class="fas fa-trash me-1"></i> Delete</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 mb-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div>
                                        <h5 class="card-title">Mary Wambui</h5>
                                        <p class="card-text mb-1">1 Bedroom Apartment</p>
                                        <p class="card-text text-success mb-1">
                                            <i class="fas fa-check-circle me-1"></i> Paid on time
                                        </p>
                                    </div>
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button"
                                            data-bs-toggle="dropdown">
                                            Actions
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li><a class="dropdown-item" href="#"><i class="fas fa-envelope me-1"></i>
                                                    Send Receipt</a></li>
                                            <li><a class="dropdown-item" href="#"><i class="fas fa-edit me-1"></i>
                                                    Edit</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Sidebar collapse functionality
    const sidebar = document.getElementById('sidebar');
    const mainContent = document.getElementById('mainContent');
    const collapseBtn = document.getElementById('sidebarCollapse');

    collapseBtn.addEventListener('click', function() {
        sidebar.classList.toggle('sidebar-collapsed');
        mainContent.classList.toggle('main-content-collapsed');

        // Store preference in localStorage
        const isCollapsed = sidebar.classList.contains('sidebar-collapsed');
        localStorage.setItem('sidebarCollapsed', isCollapsed);
    });

    // Check for saved preference
    if (localStorage.getItem('sidebarCollapsed') === 'true') {
        sidebar.classList.add('sidebar-collapsed');
        mainContent.classList.add('main-content-collapsed');
    }

    // Responsive sidebar toggle for mobile
    const mobileMenuBtn = document.createElement('button');
    mobileMenuBtn.className = 'btn btn-primary d-lg-none fixed-bottom m-3';
    mobileMenuBtn.innerHTML = '<i class="fas fa-bars"></i>';
    mobileMenuBtn.style.zIndex = '1000';
    mobileMenuBtn.style.width = '50px';
    mobileMenuBtn.style.height = '50px';
    mobileMenuBtn.style.borderRadius = '50%';
    document.body.appendChild(mobileMenuBtn);

    mobileMenuBtn.addEventListener('click', function() {
        sidebar.classList.toggle('sidebar-show');
    });

    // Close sidebar when clicking outside on mobile
    document.addEventListener('click', function(e) {
        if (window.innerWidth < 992 && !sidebar.contains(e.target) && e.target !== mobileMenuBtn) {
            sidebar.classList.remove('sidebar-show');
        }
    });

    // Initialize dropdown toggles
    const dropdownToggles = document.querySelectorAll('.sidebar-dropdown-toggle');
    dropdownToggles.forEach(toggle => {
        toggle.addEventListener('click', function(e) {
            e.preventDefault();
            const targetId = this.getAttribute('href');
            const targetMenu = document.querySelector(targetId);

            // Close other open dropdowns
            document.querySelectorAll('.sidebar-dropdown-menu').forEach(menu => {
                if (menu !== targetMenu) {
                    menu.classList.remove('show');
                    menu.previousElementSibling.setAttribute('aria-expanded', 'false');
                }
            });

            // Toggle current dropdown
            targetMenu.classList.toggle('show');
            this.setAttribute('aria-expanded', targetMenu.classList.contains('show'));
        });
    });
    collapseBtn.addEventListener('click', function() {
        if (sidebar.classList.contains('sidebar-collapsed')) {
            document.querySelectorAll('.sidebar-dropdown-menu').forEach(menu => {
                menu.classList.remove('show');
                menu.previousElementSibling.setAttribute('aria-expanded', 'false');
            });
        }
    });

    // Initialize Bootstrap tabs
    const triggerTabList = [].slice.call(document.querySelectorAll('a[data-bs-toggle="tab"]'));
    triggerTabList.forEach(function(triggerEl) {
        const tabTrigger = new bootstrap.Tab(triggerEl);
        triggerEl.addEventListener('click', function(event) {
            event.preventDefault();
            tabTrigger.show();
        });
    });
});
</script>
@endpush

@endsection
