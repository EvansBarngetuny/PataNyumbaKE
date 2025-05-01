@extends('layouts.admin')

@section('page-title')
{{ __('Dashboard') }}
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <!-- Enhanced Sidebar -->
        <div class="col-md-3">
            <nav class="sidebar bg-dark-blue-gradient">
                <div class="sidebar-header text-center py-3">
                    <h4 class="text-white mb-1">PataNyumba</h4>
                    <small class="text-muted bold">Admin Dashboard</small>
                </div>
                <div class="position-sticky pt-3">
                    <ul class="nav flex-column">

                        <!-- Dashboard -->
                        <li class="nav-item">
                            <a class="nav-link active" href="#">
                                <i class="fas fa-tachometer-alt me-2"></i> Dashboard
                                <span class="active-indicator"></span>
                            </a>
                        </li>

                        <!-- Users Management -->
                        <li class="nav-item">
                            <a class="nav-link dropdown-toggle" data-bs-toggle="collapse" href="#usersMenu">
                                <i class="fas fa-users me-2"></i> Users Management
                            </a>
                            <ul class="collapse list-unstyled ps-3" id="usersMenu">
                                <li><a class="nav-link" href="#">All Users</a></li>
                                <li><a class="nav-link" href="#">Pending Approvals</a></li>
                            </ul>
                        </li>

                        <!-- Properties -->
                        <li class="nav-item">
                            <a class="nav-link dropdown-toggle" data-bs-toggle="collapse" href="#propertiesMenu">
                                <i class="fas fa-home me-2"></i> Properties
                            </a>
                            <ul class="collapse list-unstyled ps-3" id="propertiesMenu">
                                <li><a class="nav-link" href="{{ route('listings.create') }}">Post A room</a></li>
                                <li><a class="nav-link" href="{{ route('layouts.allListings') }}">All Properties</a>
                                </li>
                                <li><a class="nav-link" href="#">Pending Approvals</a></li>
                                <li><a class="nav-link" href="#">Reported Listings</a></li>
                            </ul>
                        </li>

                        <!-- Bookings & Inquiries -->
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                <i class="fas fa-book me-2"></i> Bookings
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                <i class="fas fa-envelope me-2"></i> Inquiries
                            </a>
                        </li>
                        <!-- Payments & Transactions -->
                        <li class="nav-item">
                            <a class="nav-link dropdown-toggle" data-bs-toggle="collapse" href="#paymentsMenu">
                                <i class="fas fa-credit-card me-2"></i> Payments & Transactions
                            </a>
                            <ul class="collapse list-unstyled ps-3" id="paymentsMenu">
                                <li><a class="nav-link" href="#">All Transactions</a></li>
                                <li><a class="nav-link" href="#">Pending Payments</a></li>
                                <li><a class="nav-link" href="#">Invoices & Receipts</a></li>
                            </ul>
                        </li>
                        <!-- Reviews & Ratings -->
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                <i class="fas fa-star me-2"></i> Reviews & Ratings
                            </a>
                        </li>

                        <!-- Notifications -->
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                <i class="fas fa-bell me-2"></i> Notifications
                            </a>
                        </li>
                        <!-- Reports & Analytics -->
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                <i class="fas fa-chart-line me-2"></i> Reports & Analytics
                            </a>
                        </li>
                        <!-- Fraud Detection & Security -->
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                <i class="fas fa-shield-alt me-2"></i> Fraud Detection & Security
                            </a>
                        </li>
                        <!-- Legal & Support -->
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                <i class="fas fa-gavel me-2"></i> Legal & Support
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>
        </div>

        <!-- Main Content -->
        <div class="col-md-9" id="main-content">

            <!-- Quick Stats Row -->
            <div class="row g-4 mb-4">
                <div class="col-12 col-sm-6 col-lg-3">
                    <div class="card text-white bg-primary h-100 shadow-sm">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="text-uppercase small">Total Users</h6>
                                    <h3 class="mb-0">{{$user->total_user}}</h3>
                                </div>
                                <i class="fas fa-users fa-2x"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-sm-6 col-lg-3">
                    <div class="card text-white bg-warning h-100 shadow-sm">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="text-uppercase small">Total Landlords</h6>
                                    <h3 class="mb-0">{{$user->total_landlord}}</h3>
                                </div>
                                <i class="fas fa-calendar-times fa-2x"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-sm-6 col-lg-3">
                    <div class="card text-white bg-success h-100 shadow-sm">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="text-uppercase small">Total Posted Rooms</h6>
                                    <h3 class="mb-0">{{$user->total_listing}}</h3>
                                </div>
                                <i class="fas fa-birthday-cake fa-2x"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-sm-6 col-lg-3">
                    <div class="card text-white bg-info h-100 shadow-sm">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="text-uppercase small">Verified List</h6>
                                    <h3 class="mb-0">{{ $user->verified_listing}}</h3>
                                </div>
                                <i class="fas fa-briefcase fa-2x"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-dark text-white">
                    <h5 class="card-title mb-0">Recent Rent Payments</h5>
                </div>
                <div class="card-body">
                    <div id="chart-sales" style="height: 300px;"></div>
                </div>
            </div>
            <!-- Add this at the bottom of your content section -->
            <footer class="mt-auto py-3 bg-dark-blue-gradient">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12 text-center">
                            <span class="text-white-50">&copy; 2025 - PataNyumba. All rights reserved.</span>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
/* Sidebar Styling */
.sidebar {
    width: 250px;
    height: 12ss0vh;
    background: linear-gradient(135deg, #2c3e50, #1a252f);
    padding: 15px;
    transition: all 0.3s;
}

.sidebar-header {
    text-align: center;
    border-bottom: 1px solid rgba(255, 255, 255, 0.2);
    padding-bottom: 10px;
}

.nav-link {
    color: #ffffff;
    font-size: 15px;
    padding: 10px;
    transition: all 0.3s;
    display: flex;
    align-items: center;
}

.nav-link i {
    font-size: 18px;
}

.nav-link:hover,
.nav-link.active {
    background: rgba(255, 255, 255, 0.1);
    border-radius: 5px;
    color: #f8f9fa;
}

.active-indicator {
    height: 5px;
    width: 5px;
    background: #17a2b8;
    border-radius: 50%;
    margin-left: auto;
}

.list-unstyled {
    background: rgba(255, 255, 255, 0.05);
    border-left: 3px solid #17a2b8;
}

.list-unstyled .nav-link {
    font-size: 14px;
    padding-left: 30px;
}

.list-unstyled .nav-link:hover {
    background: rgba(255, 255, 255, 0.1);
    color: #f8f9fa;
}
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    var chartContainer = document.querySelector("#chart-sales");

    if (!chartContainer) {
        console.error("Chart container not found!");
        return;
    }

    var chartData = @json($chartData);
    console.log(chartData); // Debugging step

    var options = {
        chart: {
            type: 'line',
            height: 300,
            toolbar: {
                show: false
            }
        },
        series: [{
            name: 'Payments',
            data: chartData.data.map(Number) // Ensure it's an array of numbers
        }],
        xaxis: {
            categories: chartData.label,
            type: 'category', // Change from 'datetime' to 'category'
            labels: {
                rotate: -45
            }
        },
        yaxis: {
            title: {
                text: 'Amount',
                style: {
                    fontSize: '12px',
                    color: '#333'
                }
            },
            labels: {
                formatter: value => 'Ksh ' + value.toLocaleString()
            }
        },
        stroke: {
            curve: 'smooth',
            width: 3
        },
        markers: {
            size: 5
        },
        colors: ['#2c3e50']
    };

    var chart = new ApexCharts(chartContainer, options);
    chart.render();
});
</script>
@endpush