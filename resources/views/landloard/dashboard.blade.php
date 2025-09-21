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
            <a href="#add-property" class="btn btn-sm btn-outline-secondary" data-bs-toggle="tab">
                <i class="fas fa-plus me-1"></i> Add New Listing
            </a>
        </div>
    </div>

    <div class="tab-content">
        <!-- Overview Tab - Added id="overview" -->
        <div class="tab-pane fade show active" id="overview">
            @livewire('landlord.overview')
        </div>

        <!-- Listings Tab -->
        <div class="tab-pane fade" id="agents">
            @livewire('landlord.agents-table')
        </div>

        <!-- Tenants Tab -->
        <div class="tab-pane fade" id="tenants">
            @livewire('landlord.tenants-table')
        </div>

        <!-- Lease Agreements Tab -->
        <div class="tab-pane fade" id="lease-agreements">
            @livewire('landlord.lease-agreements')
        </div>

        <!-- My Properties Tab -->
        <div class="tab-pane fade" id="booked">
            @livewire('landlord.booked-properties')
        </div>
        <div class="tab-pane fade" id="my-properties">
            @livewire('landlord.my-properties')
        </div>

        <!-- Add Property Tab -->
        <div class="tab-pane" id="add-property" >
            @livewire('landlord.add-property')
        </div>

        <!-- Property Types Tab -->
        <div class="tab-pane fade" id="property-types">
            @livewire('landlord.property-types')
        </div>

        <!-- Rent Collection Tab -->
        <div class="tab-pane fade" id="rent-collection">
            @livewire('landlord.rent-collection')
        </div>

        <!-- Expenses Tab -->
        <div class="tab-pane fade" id="expenses">
            @livewire('landlord.expenses')
        </div>

        <!-- Invoices Tab -->
        <div class="tab-pane fade" id="invoices">
            @livewire('landlord.invoices')
        </div>

        <!-- Financial Reports Tab -->
        <div class="tab-pane fade" id="financial-reports">
            @livewire('landlord.financial-reports')
        </div>

        <!-- Messages Tab -->
        <div class="tab-pane fade" id="messages">
            @livewire('landlord.messages')
        </div>

        <!-- Notices Tab -->
        <div class="tab-pane fade" id="notices">
            @livewire('landlord.notices')
        </div>

        <!-- Reminders Tab -->
        <div class="tab-pane fade" id="reminders">
            @livewire('landlord.reminders')
        </div>

        <!-- Maintenance Requests Tab -->
        <div class="tab-pane fade" id="maintenance-requests">
            @livewire('landlord.maintenance-requests')
        </div>

        <!-- Contractors Tab -->
        <div class="tab-pane fade" id="contractors">
            @livewire('landlord.contractors')
        </div>
    </div>
</main>
    </div>
    @endsection
    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
   document.addEventListener('DOMContentLoaded', function() {
        // Get all tab buttons
        const tabButtons = document.querySelectorAll('[data-bs-target]');

        // Add click event to each button
        tabButtons.forEach(button => {
            button.addEventListener('click', function() {
                const targetId = this.getAttribute('data-bs-target');

                // Remove active class from all buttons
                tabButtons.forEach(btn => {
                    btn.classList.remove('active');
                });

                // Add active class to clicked button
                this.classList.add('active');

                // Hide all tab panes
                document.querySelectorAll('.tab-pane').forEach(pane => {
                    pane.classList.remove('active');
                });

                // Show the target tab pane
                const targetPane = document.getElementById(targetId);
                if (targetPane) {
                    targetPane.classList.add('active');
                }
            });
        });

        // Handle URL hash on page load
        if (window.location.hash) {
            const targetId = window.location.hash.substring(1);
            const targetButton = document.querySelector(`[data-bs-target="${targetId}"]`);

            if (targetButton) {
                targetButton.click();
            }
        }
    });
// Separate script for chart initialization
   document.addEventListener('livewire:load', function() {
    // Initialize chart only if the element exists
    const rentChartElement = document.querySelector("#rentChart");
    if (rentChartElement) {
        var chartData = {
            label: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
            data: [120000, 135000, 150000, 145000, 160000, 175000, 190000, 205000, 220000, 240000, 260000, 280000]
        };

        var options = {
            chart: {
                type: 'line',
                height: '100%',
                toolbar: { show: false },
                zoom: { enabled: false }
            },
            series: [{ name: 'Rent Collected', data: chartData.data }],
            xaxis: { categories: chartData.label },
            yaxis: {
                labels: {
                    formatter: function(value) {
                        return 'Ksh ' + (value/1000).toFixed(0) + 'K';
                    }
                }
            },
            stroke: { width: 3, curve: 'smooth' },
            colors: ['#3b82f6']
        };

        var chart = new ApexCharts(rentChartElement, options);
        chart.render();
    }
});
    </script>
@endpush
