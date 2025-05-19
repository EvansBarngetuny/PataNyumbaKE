<div>
    {{-- Do your work, then step back. --}}
</div>
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">System Health Dashboard</h1>
        <div>
            <span class="text-muted mr-2">Last updated: {{ $lastUpdated->diffForHumans() }}</span>
            <button wire:click="poll" class="btn btn-sm btn-primary">
                <i class="fas fa-sync-alt"></i> Refresh
            </button>
        </div>
    </div>

    <!-- System Status Cards -->
    <div class="row">
        <!-- Uptime Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                System Uptime</div>
                            <div class="h6 mb-0 font-weight-bold text-gray-800">
                                {{ $systemStatus['uptime'] }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-clock fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- CPU Load Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                CPU Load (1/5/15 min)</div>
                            <div class="h6 mb-0 font-weight-bold text-gray-400">
                                {{ implode(' / ', $systemStatus['load_average']) }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-microchip fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Memory Usage Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Memory Usage</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ $memoryUsage['used'] }} / {{ $memoryUsage['total'] }}
                            </div>
                            <div class="mt-2">
                                <div class="progress progress-sm">
                                    <div class="progress-bar bg-warning" role="progressbar"
                                        style="width: {{ $memoryUsage['usage_percentage'] }}"
                                        aria-valuenow="{{ str_replace('%', '', $memoryUsage['usage_percentage']) }}"
                                        aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-memory fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Disk Usage Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Disk Usage</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ $diskUsage['used_formatted'] }} / {{ $diskUsage['total_formatted'] }}
                            </div>
                            <div class="mt-2">
                                <div class="progress progress-sm">
                                    <div class="progress-bar bg-success" role="progressbar"
                                        style="width: {{ $diskUsage['usage_percentage'] }}%"
                                        aria-valuenow="{{ $diskUsage['usage_percentage'] }}" aria-valuemin="0"
                                        aria-valuemax="100"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-hdd fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Row -->
    <div class="row">
        <!-- CPU Usage Chart -->
        <div class="col-xl-4 col-lg-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">CPU Usage</h6>
                </div>
                <div class="card-body">
                    <div class="chart-pie pt-4 pb-2">
                        <canvas id="cpuChart"></canvas>
                    </div>
                    <div class="mt-4 text-center small">
                        <span class="mr-2">
                            <i class="fas fa-circle text-primary"></i> 1 min: {{ $chartData['cpu'][0] ?? 0 }}
                        </span>
                        <span class="mr-2">
                            <i class="fas fa-circle text-info"></i> 5 min: {{ $chartData['cpu'][1] ?? 0 }}
                        </span>
                        <span class="mr-2">
                            <i class="fas fa-circle text-success"></i> 15 min: {{ $chartData['cpu'][2] ?? 0 }}
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Memory Usage Chart -->
        <div class="col-xl-4 col-lg-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-warning">Memory Usage</h6>
                </div>
                <div class="card-body">
                    <div class="chart-pie pt-4 pb-2">
                        <canvas id="memoryChart"></canvas>
                    </div>
                    <div class="mt-4 text-center small">
                        <span class="mr-2">
                            <i class="fas fa-circle text-warning"></i> Used: {{ $memoryUsage['used'] }}
                        </span>
                        <span class="mr-2">
                            <i class="fas fa-circle text-gray-300"></i> Free: {{ $memoryUsage['free'] }}
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Disk Usage Chart -->
        <div class="col-xl-4 col-lg-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-success">Disk Usage</h6>
                </div>
                <div class="card-body">
                    <div class="chart-pie pt-4 pb-2">
                        <canvas id="diskChart"></canvas>
                    </div>
                    <div class="mt-4 text-center small">
                        <span class="mr-2">
                            <i class="fas fa-circle text-success"></i> Used: {{ $diskUsage['used_formatted'] }}
                        </span>
                        <span class="mr-2">
                            <i class="fas fa-circle text-gray-300"></i> Free: {{ $diskUsage['free_formatted'] }}
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Services Status -->
    <div class="row">
        <div class="col-lg-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Services Status</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        @foreach($services as $service)
                        <div class="col-md-3 mb-4">
                            <div
                                class="card border-left-{{ $service['status'] ? 'success' : 'danger' }} shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div
                                                class="text-xs font-weight-bold text-{{ $service['status'] ? 'success' : 'danger' }} text-uppercase mb-1">
                                                {{ $service['name'] }}
                                            </div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                {{ $service['status'] ? 'Running' : 'Stopped' }}
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <i
                                                class="fas fa-{{ $service['status'] ? 'check-circle' : 'times-circle' }} fa-2x text-{{ $service['status'] ? 'success' : 'danger' }}"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Database and Cache Stats -->
    <div class="row">
        <!-- Database Stats -->
        <div class="col-lg-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Database Statistics</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" width="100%" cellspacing="0">
                            <tbody>
                                <tr>
                                    <td>Active Connections</td>
                                    <td>{{ $databaseStats['connections'] }}</td>
                                </tr>
                                <tr>
                                    <td>Max Connections</td>
                                    <td>{{ $databaseStats['max_connections'] }}</td>
                                </tr>
                                <tr>
                                    <td>Connection Usage</td>
                                    <td>
                                        <div class="progress">
                                            <div class="progress-bar" role="progressbar"
                                                style="width: {{ ($databaseStats['connections'] / $databaseStats['max_connections']) * 100 }}%"
                                                aria-valuenow="{{ ($databaseStats['connections'] / $databaseStats['max_connections']) * 100 }}"
                                                aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Cache and Queue Stats -->
        <div class="col-lg-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Cache & Queue Statistics</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" width="100%" cellspacing="0">
                            <tbody>
                                <tr>
                                    <td>Cache Hits</td>
                                    <td>{{ $cacheStats['cache_hits'] }}</td>
                                </tr>
                                <tr>
                                    <td>Cache Misses</td>
                                    <td>{{ $cacheStats['cache_misses'] }}</td>
                                </tr>
                                <tr>
                                    <td>Pending Jobs</td>
                                    <td>{{ $queueStats['jobs'] }}</td>
                                </tr>
                                <tr>
                                    <td>Failed Jobs</td>
                                    <td>{{ $queueStats['failed_jobs'] }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Auto-refresh script -->
    <script>
    document.addEventListener('livewire:load', function() {
        // Auto-refresh every 30 seconds
        setInterval(() => {
            Livewire.emit('poll');
        }, 30000);

        // Initialize charts
        initCharts();
    });

    function initCharts() {
        // CPU Chart
        new Chart(document.getElementById('cpuChart'), {
            type: 'doughnut',
            data: {
                labels: ['1 min', '5 min', '15 min'],
                datasets: [{
                    data: @json($chartData['cpu']),
                    backgroundColor: ['#4e73df', '#1cc88a', '#36b9cc'],
                    hoverBackgroundColor: ['#2e59d9', '#17a673', '#2c9faf'],
                    hoverBorderColor: "rgba(234, 236, 244, 1)",
                }],
            },
            options: {
                maintainAspectRatio: false,
                cutoutPercentage: 80,
            },
        });

        // Memory Chart
        new Chart(document.getElementById('memoryChart'), {
            type: 'doughnut',
            data: {
                labels: ['Used', 'Free'],
                datasets: [{
                    data: [
                        @json($memoryUsage['used_cleaned']),
                        @json($memoryUsage['free_cleaned'])
                    ],
                    backgroundColor: ['#f6c23e', '#d1d3e2'],
                    hoverBackgroundColor: ['#dda20a', '#b7b9cc'],
                    hoverBorderColor: "rgba(234, 236, 244, 1)",
                }],
            },
            options: {
                maintainAspectRatio: false,
                cutout: '80%', // Use 'cutout' instead of 'cutoutPercentage' for modern Chart.js
            },
        });
        // Disk Chart
        const usedDisk = @json($diskUsage['used_cleaned']);
        const freeDisk = @json($diskUsage['free_cleaned']);

        // Initialize the chart
        new Chart(document.getElementById('diskChart'), {
            type: 'doughnut',
            data: {
                labels: ['Used', 'Free'],
                datasets: [{
                    data: [usedDisk, freeDisk],
                    backgroundColor: ['#1cc88a', '#d1d3e2'],
                    hoverBackgroundColor: ['#17a673', '#b7b9cc'],
                    hoverBorderColor: "rgba(234, 236, 244, 1)",
                }],
            },
            options: {
                maintainAspectRatio: false,
                cutout: '80%',
            },
        });
    }
    </script>
</div>