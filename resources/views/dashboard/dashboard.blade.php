@extends('layouts.app')

@section('page-title')
{{ __('Admin Dashboard') }}
@endsection
@section('styles')
<style>
:root {
    /*--sidebar-width: 280px;
    --sidebar-bg: #1e293b; */
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

.sidebar-header {
    padding: 20px 15px;
    border-bottom: 1px solid var(--sidebar-border);
    margin-bottom: 10px;
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

.nav-link.active {
    background: var(--sidebar-active-bg);
    font-weight: 500;
    color: white;
}

/* Main Content Area */
.main-content {
    padding: 20px;
    min-height: 100vh;
    background-color: var(--content-bg);
    flex-grow: 1;
}

/* Card Styling */
.card {
    border: none;
    border-radius: 10px;
    box-shadow: var(--card-shadow);
    transition: transform 0.2s, box-shadow 0.2s;
}

.card:hover {
    transform: translateY(-2px);
}

/* Footer */
.admin-footer {
    background: white;
    padding: 15px 20px;
    border-top: 1px solid #e2e8f0;
}

/* Responsive: mobile sidebar hidden */
@media (max-width: 992px) {
    .sidebar {
        display: none;
    }

    .sidebar.show {
        display: block;
        position: absolute;
        z-index: 999;
        top: 0;
        left: 0;
        height: 100%;
    }
}
</style>
@endsection

@section('content')
<div class="d-flex">
    <!-- Sidebar -->
    <div class="sidebar">
        @include('partials.sidebar')
    </div>

    <!-- Main Content -->
    <main class="main-content flex-grow-1">
        <!-- Quick Stats -->
        <div id="dashboard-content" class="row g-4 mb-4">
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
                <div class="card stat-card" style="background-color: #14b8a6; border-color: #0d9488;">
                    <div class="card-body text-white">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h6 class="text-uppercase small">Agents</h6>
                                <h3 class="mb-0">{{ $user->total_agent }}</h3>
                            </div>
                            <i class="fas fa-user-tie fa-2x opacity-75"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="card stat-card" style="background-color: #10b981; border-color: #059669;">
                    <div class="card-body text-white">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h6 class="text-uppercase small">Tenants</h6>
                                <h3 class="mb-0">{{ $user->total_tenant }}</h3>
                            </div>
                            <i class="fas fa-user-tie fa-2x opacity-75"></i>
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
        <div id="dynamic-content" class="row">
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
            <!-- System Health -->
            <div class="row mb-4">
                <div class="col-md-4">
                    <div class="card text-center">
                        <div class="card-body">
                            <i class="fas fa-database fa-2x text-primary mb-2"></i>
                            <h6 class="mb-1">Database</h6>
                            <span class="badge bg-success">Connected</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card text-center">
                        <div class="card-body">
                            <i class="fas fa-server fa-2x text-secondary mb-2"></i>
                            <h6 class="mb-1">API Server</h6>
                            <span class="badge bg-success">Operational</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card text-center">
                        <div class="card-body">
                            <i class="fas fa-tasks fa-2x text-info mb-2"></i>
                            <h6 class="mb-1">Queues</h6>
                            <span class="badge bg-warning text-dark">1 job pending</span>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Approvals and Notifications Section -->
            <div class="row g-4 mb-4">

                <!-- Listings Approval Card -->
                <div class="col-md-4">
                    <div class="card h-100 shadow-sm border-start border-warning border-4">
                        <div class="card-body d-flex flex-column justify-content-between">
                            <div class="d-flex align-items-center mb-3">
                                <i class="fas fa-home fa-2x text-warning me-3"></i>
                                <div>
                                    <h6 class="mb-0">Listings Awaiting Approval</h6>
                                    <small class="text-muted">Review new property submissions</small>
                                </div>
                            </div>
                            <h3 class="text-warning fw-bold">{{ $pendingListings ?? 0 }}</h3>
                        </div>
                    </div>
                </div>

                <!-- Unverified Landlords Card -->
                <div class="col-md-4">
                    <div class="card h-100 shadow-sm border-start border-danger border-4">
                        <div class="card-body d-flex flex-column justify-content-between">
                            <div class="d-flex align-items-center mb-3">
                                <i class="fas fa-user-times fa-2x text-danger me-3"></i>
                                <div>
                                    <h6 class="mb-0">Unverified Landlords</h6>
                                    <small class="text-muted">Pending identity verification</small>
                                </div>
                            </div>
                            <h3 class="text-danger fw-bold">{{ $unverifiedLandlords ?? 0 }}</h3>
                        </div>
                    </div>
                </div>

                <!-- User Account Requests Card -->
                <div class="col-md-4">
                    <div class="card h-100 shadow-sm border-start border-primary border-4">
                        <div class="card-body d-flex flex-column justify-content-between">
                            <div class="d-flex align-items-center mb-3">
                                <i class="fas fa-user-clock fa-2x text-primary me-3"></i>
                                <div>
                                    <h6 class="mb-0">User Account Requests</h6>
                                    <small class="text-muted">New users awaiting activation</small>
                                </div>
                            </div>
                            <h3 class="text-primary fw-bold">{{ $pendingUsers ?? 0 }}</h3>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Notifications Card -->
            <!-- Notifications Card -->
            <div class="row mb-4">
                <div class="col-12">
                    <div class="card shadow-sm border-start border-info border-4">
                        <div class="card-header bg-white d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">System Notifications</h5>
                            <span class="badge bg-info text-white">Live</span>
                        </div>
                        <div class="card-body">
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item d-flex align-items-center">
                                    <i class="fas fa-bell text-warning me-3 fa-lg"></i>
                                    <div>
                                        <strong>Backup scheduled</strong><br>
                                        <small class="text-muted">Every midnight</small>
                                    </div>
                                </li>
                                <li class="list-group-item d-flex align-items-center">
                                    <i class="fas fa-shield-alt text-danger me-3 fa-lg"></i>
                                    <div>
                                        <strong>2FA not enforced</strong><br>
                                        <small class="text-muted">Critical security setting missing</small>
                                    </div>
                                </li>
                                <li class="list-group-item d-flex align-items-center">
                                    <i class="fas fa-envelope text-info me-3 fa-lg"></i>
                                    <div>
                                        <strong>1 support ticket unresolved</strong><br>
                                        <small class="text-muted">Check support queue</small>
                                    </div>
                                </li>
                            </ul>
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