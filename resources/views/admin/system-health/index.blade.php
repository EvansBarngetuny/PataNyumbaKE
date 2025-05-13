@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">System Health Dashboard</h1>
        <span class="badge badge-{{ $systemStatus['health'] === 'healthy' ? 'success' : 'danger' }} p-2">
            System Status: {{ ucfirst($systemStatus['health']) }}
        </span>
    </div>

    <div class="row">
        <!-- Server Status Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Server Uptime
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ $serverStats['uptime'] }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-clock fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Resource Usage Card
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                CPU Load
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ $serverStats['cpu_load'] }}%
                            </div>
                            <div class="mt-2">
                                <div class="progress progress-sm">
                                    <div class="progress-bar bg-success"
                                         role="progressbar"
                                         style="width: {{ $serverStats['cpu_load'] }}%"
                                         aria-valuenow="{{ $serverStats['cpu_load'] }}"
                                         aria-valuemin="0"
                                         aria-valuemax="100">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-microchip fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
-->
<div class="col-xl-3 col-md-6 mb-4">
    <div class="card border-left-success shadow h-100 py-2">
        <div class="card-body">
            <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                        CPU Load
                        @if(!$serverStats['cpu_usage']['is_available'])
                            <span class="text-danger small">(Windows)</span>
                        @endif
                    </div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                        @if($serverStats['cpu_usage']['is_available'])
                            {{ round($serverStats['cpu_load'], 1) }}%
                        @else
                            {{ round($serverStats['cpu_usage']['load'][0], 1) }}%
                        @endif
                    </div>
                    <div class="mt-2">
                        <div class="progress progress-sm">
                            <div class="progress-bar bg-success"
                                 role="progressbar"
                                 style="width: {{ $serverStats['cpu_load'] }}%"
                                 aria-valuenow="{{ $serverStats['cpu_load'] }}"
                                 aria-valuemin="0"
                                 aria-valuemax="100">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-auto">
                    <i class="fas fa-microchip fa-2x text-gray-300"></i>
                </div>
            </div>
        </div>
    </div>
</div>
        <!-- Database Health Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Database Connections
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ $databaseStats['connections'] }}/{{ $databaseStats['max_connections'] }}
                            </div>
                            <div class="mt-2">
                                <div class="progress progress-sm">
                                    <div class="progress-bar bg-info"
                                         role="progressbar"
                                         style="width: {{ ($databaseStats['connections']/$databaseStats['max_connections'])*100 }}%"
                                         aria-valuenow="{{ ($databaseStats['connections']/$databaseStats['max_connections'])*100 }}"
                                         aria-valuemin="0"
                                         aria-valuemax="100">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-database fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Services Status Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Services Status
                            </div>
                            @foreach($services as $service)
                            <div class="mb-1">
                                <span class="badge badge-{{ $service['status'] ? 'success' : 'danger' }}">
                                    {{ $service['name'] }}
                                </span>
                            </div>
                            @endforeach
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-tasks fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Monitoring Chart -->
    <div class="row">
        <div class="col-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Resource Usage History</h6>
                </div>
                <div class="card-body">
                    <div class="chart-area">
                        <canvas id="resourceChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@section('scripts')
<script>
    const ctx = document.getElementById('resourceChart').getContext('2d');
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: @json($chartData['labels']),
            datasets: [{
                label: 'CPU Usage',
                data: @json($chartData['cpu']),
                borderColor: '#4e73df',
                tension: 0.3
            }, {
                label: 'Memory Usage',
                data: @json($chartData['memory']),
                borderColor: '#1cc88a',
                tension: 0.3
            }, {
                label: 'Disk Usage',
                data: @json($chartData['disk']),
                borderColor: '#36b9cc',
                tension: 0.3
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'top',
                }
            }
        }
    });
</script>

@endsection
@endsection
