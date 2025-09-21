<div>
    <div class="row mb-4">
     <p>This is the overview section with dashboard statistics and summaries.</p>
        <div class="col-md-3">
            <div class="dashboard-card card mb-4">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h6 class="text-muted mb-2">Active Listings</h6>
                            <h3 class="mb-0">{{ $activeListings }}</h3>
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
                            <h3 class="mb-0">{{ $occupiedUnits }}</h3>
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
                            <h3 class="mb-0">{{ $pendingRent }}</h3>
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
                            <h3 class="mb-0">Ksh {{ number_format($totalRevenue) }}</h3>
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
                    @foreach($recentActivities as $activity)
                    <div class="activity-item mb-3">
                        <p class="mb-1"><strong>{{ $activity['action'] }}</strong> - {{ $activity['details'] }}</p>
                        <small class="text-muted">{{ $activity['time'] }}</small>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('livewire:load', function() {
            // Initialize chart
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

            var chart = new ApexCharts(document.querySelector("#rentChart"), options);
            chart.render();
        });
    </script>
</div>
