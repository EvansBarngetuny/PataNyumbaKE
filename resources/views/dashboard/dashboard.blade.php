@extends('layouts.app')

@section('page-title')
{{ __('Admin Dashboard') }}
@endsection

@section('styles')
<style>
:root {
    --sidebar-width: 280px;
    --sidebar-bg: #1e293b;
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

/* Sidebar Styling */
.sidebar {
    width: var(--sidebar-width);
    background: var(--sidebar-bg);
    color: var(--sidebar-color);
    position: fixed;
    top: var(--header-height);
    left: 0;
    bottom: 0;
    z-index: 100;
    transition: all 0.3s;
    overflow-y: auto;
    padding-bottom: 20px;
}

.sidebar-header {
    padding: 20px 15px;
    border-bottom: 1px solid var(--sidebar-border);
    margin-bottom: 10px;
}

.sidebar-header h4 {
    color: white;
    font-weight: 600;
    margin-bottom: 0;
}

.sidebar-header small {
    color: #94a3b8;
    font-size: 0.8rem;
}

.nav-link {
    color: var(--sidebar-color);
    padding: 12px 15px;
    margin: 2px 10px;
    border-radius: 6px;
    display: flex;
    align-items: center;
    transition: all 0.2s;
}

.nav-link i {
    width: 24px;
    text-align: center;
    margin-right: 10px;
    font-size: 1.1rem;
}

.nav-link:hover {
    background: var(--sidebar-hover-bg);
    color: white;
}

.nav-link.active {
    background: var(--sidebar-active-bg);
    color: white;
    font-weight: 500;
}

.nav-link.active::after {
    content: '';
    display: block;
    width: 3px;
    height: 24px;
    background: #3b82f6;
    position: absolute;
    right: 0;
    border-radius: 3px 0 0 3px;
}

.collapse .nav-link {
    padding-left: 45px;
    font-size: 0.9rem;
    margin: 0;
    border-radius: 0;
}

.collapse .nav-link:hover {
    background: var(--sidebar-hover-bg);
}

/* Main Content Area */
.main-content {
    margin-left: var(--sidebar-width);
    padding: 20px;
    min-height: calc(100vh - var(--header-height));
}

/* Cards Styling */
.card {
    border: none;
    border-radius: 10px;
    box-shadow: var(--card-shadow);
    transition: transform 0.2s, box-shadow 0.2s;
}

.card:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
}

.card-header {
    background: white;
    border-bottom: 1px solid #e2e8f0;
    font-weight: 600;
}

/* Stats Cards */
.stat-card {
    border-left: 4px solid;
}

.stat-card.bg-primary {
    border-left-color: #1d4ed8;
}

.stat-card.bg-warning {
    border-left-color: #b45309;
}

.stat-card.bg-success {
    border-left-color: #047857;
}

.stat-card.bg-info {
    border-left-color: #0e7490;
}

/* Footer */
.admin-footer {
    background: white;
    padding: 15px 20px;
    margin-left: var(--sidebar-width);
    border-top: 1px solid #e2e8f0;
}

/* Responsive Adjustments */
@media (max-width: 992px) {
    .sidebar {
        transform: translateX(-100%);
    }

    .sidebar.show {
        transform: translateX(0);
    }

    .main-content {
        margin-left: 0;
    }

    .admin-footer {
        margin-left: 0;
    }
}
</style>
@endsection

@section('content')
<div class="container-fluid px-0">
    <!-- Sidebar -->
    <nav class="sidebar">
        <div class="sidebar-header">
            <h4>PataNyumba</h4>
            <small>Admin Dashboard</small>
        </div>

        <ul class="nav flex-column">
            <!-- Dashboard -->
            <li class="nav-item">
                <a class="nav-link active" href="#">
                    <i class="fas fa-tachometer-alt"></i> Dashboard
                </a>
            </li>

            <!-- Users Management -->
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="collapse" href="#usersMenu">
                    <i class="fas fa-users"></i> Users Management
                    <i class="fas fa-angle-down ms-auto"></i>
                </a>
                <div class="collapse show" id="usersMenu">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link" href="#">All Users</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Pending Approvals</a>
                        </li>
                    </ul>
                </div>
            </li>

            <!-- Properties -->
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="collapse" href="#propertiesMenu">
                    <i class="fas fa-home"></i> Properties
                    <i class="fas fa-angle-down ms-auto"></i>
                </a>
                <div class="collapse show" id="propertiesMenu">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('listings.create') }}">Post A Room</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('layouts.allListings') }}">All Properties</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Pending Approvals</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Reported Listings</a>
                        </li>
                    </ul>
                </div>
            </li>

            <!-- Other Menu Items -->
            <li class="nav-item">
                <a class="nav-link" href="#">
                    <i class="fas fa-book"></i> Bookings
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">
                    <i class="fas fa-envelope"></i> Inquiries
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="collapse" href="#paymentsMenu">
                    <i class="fas fa-credit-card"></i> Payments
                    <i class="fas fa-angle-down ms-auto"></i>
                </a>
                <div class="collapse" id="paymentsMenu">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link" href="#">All Transactions</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Pending Payments</a>
                        </li>
                    </ul>
                </div>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">
                    <i class="fas fa-chart-line"></i> Analytics
                </a>
            </li>
        </ul>
    </nav>

    <!-- Main Content -->
    <main class="main-content">
        <!-- Quick Stats -->
        <div class="row g-4 mb-4">
            <div class="col-md-6 col-lg-3">
                <div class="card stat-card bg-primary text-white">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h6 class="text-uppercase small">Total Users</h6>
                                <h3 class="mb-0">{{ $user->total_user }}</h3>
                            </div>
                            <i class="fas fa-users fa-2x opacity-50"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-3">
                <div class="card stat-card bg-warning text-white">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h6 class="text-uppercase small">Landlords</h6>
                                <h3 class="mb-0">{{ $user->total_landlord }}</h3>
                            </div>
                            <i class="fas fa-user-tie fa-2x opacity-50"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-3">
                <div class="card stat-card bg-success text-white">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h6 class="text-uppercase small">Listings</h6>
                                <h3 class="mb-0">{{ $user->total_listing }}</h3>
                            </div>
                            <i class="fas fa-home fa-2x opacity-50"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-3">
                <div class="card stat-card bg-info text-white">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h6 class="text-uppercase small">Verified</h6>
                                <h3 class="mb-0">{{ $user->verified_listing }}</h3>
                            </div>
                            <i class="fas fa-check-circle fa-2x opacity-50"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Charts Section -->
        <div class="row">
            <div class="col-lg-8">
                <div class="card mb-4">
                    <div class="card-header bg-white d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Rent Payments</h5>
                        <div class="dropdown">
                            <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button"
                                data-bs-toggle="dropdown">
                                This Month
                            </button>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="#">This Week</a></li>
                                <li><a class="dropdown-item" href="#">This Month</a></li>
                                <li><a class="dropdown-item" href="#">This Year</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="card-body">
                        <div id="chart-sales" style="height: 300px;"></div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card mb-4">
                    <div class="card-header bg-white">
                        <h5 class="mb-0">Recent Activities</h5>
                    </div>
                    <div class="card-body">
                        <div class="activity-feed">
                            <div class="d-flex mb-3">
                                <div class="flex-shrink-0">
                                    <div class="avatar bg-primary text-white rounded-circle d-flex align-items-center justify-content-center"
                                        style="width: 40px; height: 40px;">
                                        <i class="fas fa-user"></i>
                                    </div>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <p class="mb-0">New landlord registered</p>
                                    <small class="text-muted">2 minutes ago</small>
                                </div>
                            </div>
                            <!-- More activity items -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize chart
    var chartData = @json($chartData);

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
            name: 'Payments',
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
                    return 'Ksh ' + value.toLocaleString();
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

    var chart = new ApexCharts(document.querySelector("#chart-sales"), options);
    chart.render();

    // Toggle sidebar on mobile
    document.querySelector('.sidebar-toggler').addEventListener('click', function() {
        document.querySelector('.sidebar').classList.toggle('show');
    });
});
</script>
@endpush