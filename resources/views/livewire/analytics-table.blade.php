<div>
    <!-- resources/views/analytics/index.blade.php -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 b-600 mb-0 text-gray-800">Rental Platform Analytics</h1>
        <div class="dropdown">
            <button class="btn btn-outline-secondary dropdown-toggle" type="button" id="analyticsPeriodDropdown"
                data-bs-toggle="dropdown">
                <i class="fas fa-calendar-alt me-2"></i>
                @if($timeRange == 'today') Today
                @elseif($timeRange == 'week') This Week
                @elseif($timeRange == 'year') This Year
                @else This Month
                @endif
            </button>
            <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="#" wire:click.prevent="setTimeRange('today')">Today</a></li>
                <li><a class="dropdown-item" href="#" wire:click.prevent="setTimeRange('week')">This Week</a></li>
                <li><a class="dropdown-item" href="#" wire:click.prevent="setTimeRange('month')">This Month</a></li>
                <li><a class="dropdown-item" href="#" wire:click.prevent="setTimeRange('year')">This Year</a></li>
            </ul>
        </div>
    </div>

    <!-- Analytics Grid with proper styling -->
    <div class="row row-cols-1 row-cols-md-2 row-cols-xl-4 g-4 mb-4">
        <!-- Connection Metrics -->
        <div class="col">
            <div class="card metric-card h-100 border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        <div class="bg-primary bg-opacity-10 p-3 rounded">
                            <i class="fas fa-handshake fa-lg text-primary"></i>
                        </div>
                        <div class="ms-3">
                            <h6 class="mb-0 text-muted small">Successful Matches</h6>
                            <h3 class="mb-0 mt-1 fw-bold">{{ number_format($successfulMatches) }}</h3>
                        </div>
                    </div>
                    <div class="metric-change {{ $matchPercentageChange >= 0 ? 'positive' : 'negative' }} small">
                        <i class="fas fa-arrow-{{ $matchPercentageChange >= 0 ? 'up' : 'down' }} me-1"></i>
                        {{ abs($matchPercentageChange) }}%
                        <span class="text-muted ms-1">
                            @if($timeRange == 'today') today
                            @elseif($timeRange == 'week') this week
                            @elseif($timeRange == 'year') this year
                            @else this month
                            @endif
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Vacancy Metrics -->
        <div class="col">
            <div class="card metric-card h-100 border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        <div class="bg-warning bg-opacity-10 p-3 rounded">
                            <i class="fas fa-home fa-lg text-warning"></i>
                        </div>
                        <div class="ms-3">
                            <h6 class="mb-0 text-muted small">Vacant Rooms</h6>
                            <h3 class="mb-0 mt-1 fw-bold">{{ number_format($vacantProperties) }}</h3>
                        </div>
                    </div>
                    <div class="metric-change {{ $vacantChange >= 0 ? 'negative' : 'positive' }} small">
                        <i class="fas fa-arrow-{{ $vacantChange >= 0 ? 'up' : 'down' }} me-1"></i>
                        {{ abs($vacantChange) }}%
                         <span class="text-muted ms-1">
                            @if($timeRange == 'today') today
                            @elseif($timeRange == 'week') this week
                            @elseif($timeRange == 'year') this year
                            @else this month
                            @endif
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Response Time -->
        <div class="col">
            <div class="card metric-card h-100 border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        <div class="bg-info bg-opacity-10 p-3 rounded">
                            <i class="fas fa-clock fa-lg text-info"></i>
                        </div>
                        <div class="ms-3">
                            <h6 class="mb-0 text-muted small">Avg. Response Time</h6>
                            <h3 class="mb-0 mt-1 fw-bold">{{ number_format($avgResponseTime, 1) }}h</h3>
                        </div>
                    </div>
                    <div class="metric-change {{ $responseTimeChange >= 0 ? 'positive' : 'negative' }} small">
                        <i class="fas fa-arrow-{{ $responseTimeChange >= 0 ? 'up' : 'down' }} me-1"></i>
                        {{ $responseTimeChange >= 0 ? 'Faster' : 'Slower' }} by {{ abs($responseTimeChange) }}%
                    </div>
                </div>
            </div>
        </div>

        <!-- Platform Health -->
        <div class="col">
            <div class="card metric-card h-100 border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        <div class="bg-success bg-opacity-10 p-3 rounded">
                            <i class="fas fa-heartbeat fa-lg text-success"></i>
                        </div>
                        <div class="ms-3">
                            <h6 class="mb-0 text-muted small">Platform Health</h6>
                            <h3 class="mb-0 mt-1 fw-bold">{{ $healthScore }}%</h3>
                        </div>
                    </div>
                    <div class="health-status small text-muted">
                        {{ $healthStatus }}
                    </div>
                </div>
            </div>
        </div>

        @foreach ($bookedHouses as $booked)
        <div class="col">
            <div class="card metric-card h-100 border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        <div class="bg-secondary bg-opacity-10 p-3 rounded">
                            <i class="fas fa-door-closed fa-lg text-secondary"></i>
                        </div>
                        <div class="ms-3">
                            <h6 class="mb-0 text-muted small">{{ ucfirst($booked->category) }} Booked</h6>
                            <h3 class="mb-0 mt-1 fw-bold">{{ number_format($booked->total) }}</h3>
                        </div>
                    </div>
                    <div class="metric-change positive small">
                        <i class="fas fa-check-circle me-1"></i>
                        Booked units
                        <span class="text-muted ms-1">
                            @if($timeRange == 'today') today
                            @elseif($timeRange == 'week') this week
                            @elseif($timeRange == 'year') this year
                            @else this month
                            @endif
                        </span>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Additional Analytics Sections -->
    <div class="row mt-4">
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white d-flex justify-content-between align-items-center border-0 pb-0">
                    <h5 class="mb-0">Most Popular Counties</h5>
                    <button class="btn btn-sm btn-outline-primary" wire:click="loadData">
                        <i class="fas fa-sync"></i> Refresh
                    </button>
                </div>
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        @foreach($popularCounties as $county)
                        <li class="list-group-item d-flex justify-content-between align-items-center border-0 px-0">
                            <span class="fw-medium">{{ $county->county }}</span>
                            <span class="badge bg-primary rounded-pill">{{ $county->total }}</span>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white d-flex justify-content-between align-items-center border-0 pb-0">
                    <h5 class="mb-0">Most Occupied Categories</h5>
                    <button class="btn btn-sm btn-outline-primary" wire:click="loadData">
                        <i class="fas fa-sync"></i> Refresh
                    </button>
                </div>
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        @foreach($ocupiedCategories as $category)
                        <li class="list-group-item d-flex justify-content-between align-items-center border-0 px-0">
                            <span class="fw-medium">{{ ucfirst($category->category) }}</span>
                            <span class="badge bg-success rounded-pill">{{ $category->total }}</span>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- Auto-refresh script -->
    <script>
        document.addEventListener('livewire:load', function () {
            // Refresh data every 2 minutes
            setInterval(() => {
                @this.loadData();
            }, 120000);
        });
    </script>
</div>
