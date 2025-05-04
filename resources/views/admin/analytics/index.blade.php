@extends('layouts.app')
@section('styles')
<style>
.analytics-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 1.5rem;
    margin-bottom: 2rem;
}

.metric-card {
    background: white;
    border-radius: 10px;
    padding: 1.5rem;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
    /*border-left: 4px solid;*/
    border-left: 4px solid var(--metric-accent, #3b82f6);
    transition: transform 0.3s ease;
}

.metric-card:hover {
    transform: translateY(-5px);
}

.metric-header {
    display: flex;
    align-items: center;
    margin-bottom: 1rem;
    color: #64748b;
}

.metric-header i {
    font-size: 1.25rem;
    margin-right: 0.75rem;
    color: var(--metric-accent, #3b82f6);
}

.metric-header h6 {
    margin: 0;
    font-size: 0.9rem;
    font-weight: 600;
}

.metric-value {
    font-size: 1.75rem;
    font-weight: 700;
    color: #1e293b;
    margin-bottom: 0.5rem;
}

.metric-change {
    font-size: 0.85rem;
    display: flex;
    align-items: center;
}

.metric-change.positive {
    color: #10b981;
}

.metric-change.negative {
    color: #ef4444;
}

.metric-change i {
    margin-right: 0.25rem;
}

.health-score {
    font-size: 1.75rem;
    font-weight: 700;
    color: #1e293b;
}

.health-status {
    font-size: 0.9rem;
    color: #64748b;
}
</style>
@endsection

@section('content')
<!-- resources/views/analytics/index.blade.php -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0 text-gray-800">Rental Platform Analytics</h1>
    <div class="dropdown">
        <button class="btn btn-outline-secondary dropdown-toggle" type="button" id="analyticsPeriodDropdown"
            data-bs-toggle="dropdown">
            <i class="fas fa-calendar-alt me-2"></i>This Month
        </button>
        <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="#">Today</a></li>
            <li><a class="dropdown-item" href="#">This Week</a></li>
            <li><a class="dropdown-item" href="#">This Month</a></li>
            <li><a class="dropdown-item" href="#">This Year</a></li>
        </ul>
    </div>
</div>
<div class="analytics-grid">
    <!-- Connection Metrics -->
    <div class="metric-card">
        <div class="metric-header">
            <i class="fas fa-handshake"></i>
            <h6>Successful Matches</h6>
        </div>
        <div class="metric-value">{{ number_format($successfulMatches) }}</div>
        <div class="metric-change {{ $matchPercentageChange >= 0 ? 'positive' : 'negative' }}">
            <i class="fas fa-arrow-{{ $matchPercentageChange >= 0 ? 'up' : 'down' }}"></i>
            {{ abs($matchPercentageChange) }}% this month
        </div>
    </div>


    <!-- Vacancy Metrics -->
    <div class="metric-card">
        <div class="metric-header">
            <i class="fas fa-home"></i>
            <h6>Vacant Rooms</h6>
        </div>
        <div class="metric-value">{{ number_format($vacantProperties) }}</div>
        <div class="metric-change {{ $vacantChange >= 0 ? 'negative' : 'positive' }}">
            <i class="fas fa-arrow-{{ $vacantChange >= 0 ? 'up' : 'down' }}"></i>
            {{ abs($vacantChange) }}% this week
        </div>
    </div>

    <!-- Response Time -->
    <div class="metric-card">
        <div class="metric-header">
            <i class="fas fa-clock"></i>
            <h6>Avg. Response Time</h6>
        </div>
        <div class="metric-value">{{ number_format($avgResponseTime, 1) }}h</div>
        <div class="metric-change {{ $responseTimeChange >= 0 ? 'positive' : 'negative' }}">
            <i class="fas fa-arrow-{{ $responseTimeChange >= 0 ? 'up' : 'down' }}"></i>
            {{ $responseTimeChange >= 0 ? 'Faster' : 'Slower' }} by {{ abs($responseTimeChange) }}%
        </div>
    </div>

    <!-- Platform Health -->
    <div class="metric-card">
        <div class="metric-header">
            <i class="fas fa-heartbeat"></i>
            <h6>Platform Health</h6>
        </div>
        <div class="metric-value">
            <div class="health-score">{{ $healthScore }}%</div>
            <div class="health-status">{{ $healthStatus }}</div>
        </div>
    </div>
    @foreach ($bookedHouses as $booked)
    <div class="metric-card">
        <div class="metric-header">
            <i class="fas fa-door-closed"></i>
            <h6>{{ ucfirst($booked->category) }} Booked</h6>
        </div>
        <div class="metric-value">{{ number_format($booked->total) }}</div>
        <div class="metric-change positive">
            <i class="fas fa-check-circle"></i>
            Booked units this month
        </div>
    </div>
    @endforeach

</div>

<!-- Additional Analytics Sections -->
<div class="row mt-4">
    <div class="col-md-6">
        <div class="card shadow">
            <div class="card-header bg-white">
                <h5>Most Popular Counties</h5>
            </div>
            <div class="card-body">
                <ul class="list-group list-group-flush">
                    @foreach($popularCounties as $county)
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        {{ $county->county }}
                        <span class="badge bg-primary rounded-pill">{{ $county->total }}</span>
                    </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card shadow">
            <div class="card-header bg-white">
                <h5>Most Occupied Categories</h5>
            </div>
            <div class="card-body">
                <ul class="list-group list-group-flush">
                    @foreach($ocupiedCategories as $category)
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        {{ ucfirst($category->category) }}
                        <span class="badge bg-success rounded-pill">{{ $category->total }}</span>
                    </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection