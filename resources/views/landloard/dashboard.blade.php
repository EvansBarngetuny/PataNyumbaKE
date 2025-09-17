@extends('layouts.dashboard')
@section('page-title')
{{ ('Landlord Dashboard') }}
@endsection
@section('styles')
    <style>
    :root {
        --sidebar-color: #f8fafc;
    --sidebar-active-bg: rgba(255, 255, 255, 0.1);
    --sidebar-hover-bg: rgba(255, 255, 255, 0.05);
    --sidebar-border: rgba(255, 255, 255, 0.1);
    --header-height: 60px;
    --content-bg: #f1f5f9;
    --card-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
    }

    body {
        background-color: var(--content-bg);
        font-family: 'Inter', sans-serif;
    }

    /* Sidebar */
    .sidebar {
        width: auto;
    /* Or remove this entirely if you use flex-shrink/width in layout */
    min-width: 220px;
    max-width: 100%;
    width: var(--sidebar-width);
    background: var(--sidebar-bg);
    color: var(--sidebar-color);
    min-height: 100vh;
    overflow-y: auto;
    padding-bottom: 20px;
    position: relative;
    white-space: nowrap;
    overflow-x: auto;
    flex: 0 0 auto;
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

    /* Additional styling for the dashboard */
    .avatar {
        width: 40px;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
    }

    .tenant-avatar {
        width: 40px;
        height: 40px;
        border-radius: 50%;
    }

    .btn-action {
        padding: 0.25rem 0.5rem;
        margin: 0 2px;
    }

    .listing-card {
        transition: all 0.3s ease;
    }

    .listing-card:hover {
        box-shadow: 0 10px 20px rgba(0,0,0,0.1);
    }

    .reminder-card {
        border-left: 4px solid #ffc107;
    }
    </style>
@endsection
@section('content')
    <div class="d-flex">
        <!-- Sidebar -->
         <div class="sidebar">
        @include('landloard.navigation')
    </div>

        <!-- Main Content -->
        <main class="main-content flex-grow-1" id="mainContent">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Landlord Dashboard</h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <a href="#" class="btn btn-sm btn-outline-secondary">
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
                                    <div id="rentChart" style="height: 300px;"></div>
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
                        <a href="#" class="btn btn-primary btn-sm">
                            <i class="fas fa-plus me-1"></i> Add Listing
                        </a>
                    </div>

                    <div class="row">
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
                        <div class="col-md-6 col-lg-4 mb-4">
                            <div class="card listing-card h-100">
                                <img src="https://images.unsplash.com/photo-1568605114967-8130f3a36994?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=60"
                                    class="card-img-top" alt="Property">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-start mb-2">
                                        <h5 class="card-title mb-0">3 Bedroom House</h5>
                                        <span class="badge bg-success">Occupied</span>
                                    </div>
                                    <p class="card-text text-muted mb-2">
                                        <i class="fas fa-map-marker-alt me-1"></i> Kilimani, Nairobi
                                    </p>
                                    <p class="card-text mb-3">
                                        <span class="fw-bold">Ksh 45,000</span> / month
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
                        <div class="col-md-6 col-lg-4 mb-4">
                            <div class="card listing-card h-100">
                                <img src="https://images.unsplash.com/photo-1574362848149-11496d93a7c7?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=60"
                                    class="card-img-top" alt="Property">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-start mb-2">
                                        <h5 class="card-title mb-0">1 Bedroom Apartment</h5>
                                        <span class="badge bg-warning text-dark">Vacant</span>
                                    </div>
                                    <p class="card-text text-muted mb-2">
                                        <i class="fas fa-map-marker-alt me-1"></i> Kileleshwa, Nairobi
                                    </p>
                                    <p class="card-text mb-3">
                                        <span class="fw-bold">Ksh 18,000</span> / month
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
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <img src="https://randomuser.me/api/portraits/men/32.jpg"
                                                        class="tenant-avatar me-2" alt="Tenant">
                                                    <div>
                                                        <p class="mb-0">James Kariuki</p>
                                                        <small class="text-muted">james@email.com</small>
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
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <img src="https://randomuser.me/api/portraits/women/44.jpg"
                                                        class="tenant-avatar me-2" alt="Tenant">
                                                    <div>
                                                        <p class="mb-0">Mary Wambui</p>
                                                        <small class="text-muted">mary@email.com</small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>1 Bedroom Apartment</td>
                                            <td>Ksh 18,000</td>
                                            <td>20 Jan 2024</td>
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
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <img src="https://randomuser.me/api/portraits/men/22.jpg"
                                                        class="tenant-avatar me-2" alt="Tenant">
                                                    <div>
                                                        <p class="mb-0">John Kamau</p>
                                                        <small class="text-muted">john@email.com</small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>3 Bedroom House</td>
                                            <td>Ksh 45,000</td>
                                            <td>10 Nov 2023</td>
                                            <td><span class="badge bg-warning text-dark">Pending</span></td>
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
                                        <tr>
                                            <td>15 Oct 2023</td>
                                            <td>James Kariuki</td>
                                            <td>2 Bedroom Apartment</td>
                                            <td>Ksh 25,000</td>
                                            <td>MPESA</td>
                                            <td>
                                                <span class="badge bg-success">Paid</span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>12 Oct 2023</td>
                                            <td>Mary Wambui</td>
                                            <td>1 Bedroom Apartment</td>
                                            <td>Ksh 18,000</td>
                                            <td>Bank Transfer</td>
                                            <td>
                                                <span class="badge bg-success">Paid</span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>10 Oct 2023</td>
                                            <td>John Kamau</td>
                                            <td>3 Bedroom House</td>
                                            <td>Ksh 45,000</td>
                                            <td>MPESA</td>
                                            <td>
                                                <span class="badge bg-warning">Pending</span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>05 Oct 2023</td>
                                            <td>Sarah Mwende</td>
                                            <td>Studio Apartment</td>
                                            <td>Ksh 15,000</td>
                                            <td>Cash</td>
                                            <td>
                                                <span class="badge bg-success">Paid</span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>01 Oct 2023</td>
                                            <td>Peter Otieno</td>
                                            <td>4 Bedroom House</td>
                                            <td>Ksh 60,000</td>
                                            <td>Bank Transfer</td>
                                            <td>
                                                <span class="badge bg-danger">Overdue</span>
                                            </td>
                                        </tr>
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
                        <button class="btn btn-primary btn-sm">
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
    @endsection
    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize chart with sample data for landlord dashboard
        var chartData = {
            label: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
            data: [120000, 135000, 150000, 145000, 160000, 175000, 190000, 205000, 220000, 240000, 260000, 280000]
        };

        var options = {
            chart: {
                type: 'line',
                height: '100%',
                toolbar: {
                    show: false
                },
                zoom: {
                    enabled: false
                }
            },
            series: [{
                name: 'Rent Collected',
                data: chartData.data.map(Number)
            }],
            xaxis: {
                categories: chartData.label,
                labels: {
                    style: {
                        colors: '#64748b'
                    }
                }
            },
            yaxis: {
                labels: {
                    formatter: function(value) {
                        return 'Ksh ' + (value/1000).toFixed(0) + 'K';
                    },
                    style: {
                        colors: '#64748b'
                    }
                }
            },
            stroke: {
                width: 3,
                curve: 'smooth'
            },
            colors: ['#3b82f6'],
            grid: {
                borderColor: '#e2e8f0',
                strokeDashArray: 4
            },
            tooltip: {
                y: {
                    formatter: function(value) {
                        return 'Ksh ' + value.toLocaleString();
                    }
                }
            }
        };

        var chart = new ApexCharts(document.querySelector("#rentChart"), options);
        chart.render();

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
