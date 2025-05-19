@extends('layouts.app')

@section('content')
<style>
.card {
    transition: all 0.3s ease;
    border-left-width: 4px;
}

.card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
}

.progress {
    height: 8px;
    border-radius: 4px;
}

.progress-bar {
    transition: width 1s ease-in-out;
}

.badge-service {
    font-size: 0.85rem;
    padding: 0.35em 0.65em;
}

.chart-container {
    position: relative;
    height: 300px;
}

.health-indicator {
    animation: pulse 2s infinite;
}

@keyframes pulse {
    0% {
        opacity: 1;
    }

    50% {
        opacity: 0.7;
    }

    100% {
        opacity: 1;
    }
}

.system-card {
    background: linear-gradient(135deg, #f8f9fc 0%, #e9ecef 100%);
}

.metric-value {
    font-size: 1.0rem;
    font-weight: 600;
}

.metric-label {
    font-size: 0.8rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    color: #6c757d;
}
</style>

<div class="container-fluid">
    <!-- System Overview Card -->
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="card system-card border-0 shadow-sm">
                <div class="card-header bg-white border-0 py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-heartbeat mr-2"></i>System Overview
                    </h6>
                    <span
                        class="health-indicator badge badge-{{ $systemStatus['health'] === 'healthy' ? 'success' : 'danger' }} py-2 px-3">
                        <i
                            class="fas fa-{{ $systemStatus['health'] === 'healthy' ? 'check-circle' : 'exclamation-triangle' }} mr-1"></i>
                        {{ ucfirst($systemStatus['health']) }}
                    </span>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-md-3 border-right">
                            <div class="metric-label">Uptime</div>
                            <div class="metric-value text-primary">
                                <i class="fas fa-clock mr-2"></i>{{ $systemStatus['uptime'] }}
                            </div>
                        </div>
                        <div class="col-md-3 border-right">
                            <div class="metric-label">Load Average</div>
                            <div class="metric-value text-info">
                                <i
                                    class="fas fa-tachometer-alt mr-2"></i>{{ implode(', ', $systemStatus['load_average']) }}
                            </div>
                        </div>
                        <div class="col-md-3 border-right">
                            <div class="metric-label">Memory Usage</div>
                            <div class="metric-value text-warning">
                                <i class="fas fa-memory mr-2"></i>{{ $memoryUsage['usage_percentage'] }}
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="metric-label">Disk Space</div>
                            <div class="metric-value text-danger">
                                <i class="fas fa-hdd mr-2"></i>{{ $diskUsage['usage_percentage'] }}%
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Resource Cards -->
    <div class="row">
        <!-- CPU Usage Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow-sm h-100">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="metric-label">CPU Usage</div>
                            <div class="metric-value text-primary">{{ $cpuUsage['load'][0] ?? 0 }}%</div>
                            <div class="mt-2">
                                <div class="progress">
                                    <div class="progress-bar bg-primary progress-bar-striped"
                                        style="width: {{ $cpuUsage['load'][0] ?? 0 }}%" role="progressbar">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-microchip fa-3x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Memory Usage Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow-sm h-100">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="metric-label">Memory Usage</div>
                            <div class="metric-value text-success">{{ $memoryUsage['used'] }} /
                                {{ $memoryUsage['total'] }}</div>
                            <div class="mt-2">
                                <div class="progress">
                                    <div class="progress-bar bg-success progress-bar-striped"
                                        style="width: {{ str_replace('%', '', $memoryUsage['usage_percentage']) }}%"
                                        role="progressbar">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-memory fa-3x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Disk Usage Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow-sm h-100">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="metric-label">Disk Usage</div>
                            <div class="metric-value text-info">{{ $diskUsage['used_formatted'] }} /
                                {{ $diskUsage['total_formatted'] }}</div>
                            <div class="mt-2">
                                <div class="progress">
                                    <div class="progress-bar bg-info progress-bar-striped"
                                        style="width: {{ $diskUsage['usage_percentage'] }}%" role="progressbar">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-hdd fa-3x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Database Connections Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow-sm h-100">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="metric-label">Database Connections</div>
                            <div class="metric-value text-warning">
                                {{ $databaseStats['connections'] }} / {{ $databaseStats['max_connections'] }}
                            </div>
                            <div class="mt-2">
                                <div class="progress">
                                    <div class="progress-bar bg-warning progress-bar-striped"
                                        style="width: {{ ($databaseStats['connections']/$databaseStats['max_connections'])*100 }}%"
                                        role="progressbar">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-database fa-3x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Services and Queue Status -->
    <div class="row mb-4">
        <!-- Services Status -->
        <div class="col-md-6 mb-4 mb-md-0">
            <div class="card shadow-sm h-100">
                <div class="card-header bg-white border-0 py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-server mr-2"></i>System Services
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        @foreach($services as $service)
                        <div class="col-md-6 mb-3">
                            <div class="d-flex align-items-center p-2 rounded bg-light">
                                <span
                                    class="badge badge-{{ $service['status'] ? 'success' : 'danger' }} badge-service mr-2">
                                    <i class="fas fa-{{ $service['status'] ? 'check' : 'times' }} mr-1"></i>
                                </span>
                                <span class="font-weight-medium">{{ $service['name'] }}</span>
                                <span class="ml-auto small text-muted">
                                    {{ $service['status'] ? 'Running' : 'Stopped' }}
                                </span>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <!-- Queue and Cache Status -->
        <div class="col-md-6">
            <div class="card shadow-sm h-100">
                <div class="card-header bg-white border-0 py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-tasks mr-2"></i>Queue & Cache Status
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <div class="p-3 bg-light rounded">
                                <div class="text-muted small mb-1">Pending Jobs</div>
                                <div class="h4 font-weight-bold">{{ $queueStats['jobs'] }}</div>
                                <div class="progress mt-2" style="height: 4px;">
                                    <div class="progress-bar bg-primary"
                                        style="width: {{ min($queueStats['jobs'] * 2, 100) }}%"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="p-3 bg-light rounded">
                                <div class="text-muted small mb-1">Failed Jobs</div>
                                <div class="h4 font-weight-bold text-danger">{{ $queueStats['failed_jobs'] }}</div>
                                <div class="progress mt-2" style="height: 4px;">
                                    <div class="progress-bar bg-danger"
                                        style="width: {{ min($queueStats['failed_jobs'] * 5, 100) }}%"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="p-3 bg-light rounded">
                                <div class="text-muted small mb-1">Cache Hits</div>
                                <div class="h4 font-weight-bold text-success">{{ $cacheStats['cache_hits'] }}</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="p-3 bg-light rounded">
                                <div class="text-muted small mb-1">Cache Misses</div>
                                <div class="h4 font-weight-bold text-warning">{{ $cacheStats['cache_misses'] }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Resource Usage Chart -->
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header bg-white border-0 py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-chart-line mr-2"></i>Resource Usage History
                    </h6>
                </div>
                <div class="card-body">
                    <div class="chart-container">
                        <canvas id="resourceChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const ctx = document.getElementById('resourceChart').getContext('2d');
    const chart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: @json($chartData['labels']),
            datasets: [{
                    label: 'CPU Load (1 min)',
                    data: [@json($chartData['cpu'][0]), 0, 0],
                    borderColor: '#4e73df',
                    backgroundColor: 'rgba(78, 115, 223, 0.1)',
                    borderWidth: 2,
                    tension: 0.4,
                    fill: true,
                    pointBackgroundColor: '#4e73df',
                    pointRadius: 4,
                    pointHoverRadius: 6
                },
                {
                    label: 'Memory Usage',
                    data: [0, @json($memoryUsage['usage_percentage']), 0],
                    borderColor: '#1cc88a',
                    backgroundColor: 'rgba(28, 200, 138, 0.1)',
                    borderWidth: 2,
                    tension: 0.4,
                    fill: true,
                    pointBackgroundColor: '#1cc88a',
                    pointRadius: 4,
                    pointHoverRadius: 6
                },
                {
                    label: 'Disk Usage',
                    data: [0, 0, @json($diskUsage['usage_percentage'])],
                    borderColor: '#36b9cc',
                    backgroundColor: 'rgba(54, 185, 204, 0.1)',
                    borderWidth: 2,
                    tension: 0.4,
                    fill: true,
                    pointBackgroundColor: '#36b9cc',
                    pointRadius: 4,
                    pointHoverRadius: 6
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'top',
                    labels: {
                        boxWidth: 12,
                        padding: 20,
                        usePointStyle: true,
                    }
                },
                tooltip: {
                    mode: 'index',
                    intersect: false,
                    backgroundColor: 'rgba(0,0,0,0.8)',
                    titleFont: {
                        size: 14
                    },
                    bodyFont: {
                        size: 12
                    },
                    padding: 12,
                    callbacks: {
                        label: function(context) {
                            return context.dataset.label + ': ' + context.raw + '%';
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    max: 100,
                    grid: {
                        drawBorder: false,
                        color: 'rgba(0,0,0,0.05)'
                    },
                    ticks: {
                        callback: function(value) {
                            return value + '%';
                        }
                    },
                    title: {
                        display: true,
                        text: 'Usage Percentage',
                        color: '#6c757d'
                    }
                },
                x: {
                    grid: {
                        display: false,
                        drawBorder: false
                    }
                }
            },
            interaction: {
                mode: 'nearest',
                axis: 'x',
                intersect: false
            }
        }
    });

    // Add animation to progress bars
    document.querySelectorAll('.progress-bar').forEach(bar => {
        const width = bar.style.width;
        bar.style.width = '0';
        setTimeout(() => {
            bar.style.width = width;
        }, 100);
    });
});
</script>
@endsection
@endsection