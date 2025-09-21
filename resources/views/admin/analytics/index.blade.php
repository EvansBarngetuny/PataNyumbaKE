@extends('layouts.app')
@section('styles')
<style>
.metric-card {
    transition: all 0.3s ease;
    border-left: 4px solid transparent;
}

.metric-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1) !important;
}

.metric-card .bg-opacity-10 {
    background-color: rgba(var(--bs-primary-rgb), 0.1);
}

.metric-change.positive {
    color: #198754;
    font-weight: 500;
}

.metric-change.negative {
    color: #dc3545;
    font-weight: 500;
}

.health-status {
    color: #6c757d;
    font-size: 0.875rem;
}

/* Specific color variations for different metric cards */
.metric-card:nth-child(1) {
    border-left-color: #0d6efd;
}

.metric-card:nth-child(2) {
    border-left-color: #ffc107;
}

.metric-card:nth-child(3) {
    border-left-color: #0dcaf0;
}

.metric-card:nth-child(4) {
    border-left-color: #198754;
}

.metric-card:nth-child(5) {
    border-left-color: #6c757d;
}

.metric-card:nth-child(6) {
    border-left-color: #6f42c1;
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .row-cols-md-2 > * {
        flex: 0 0 auto;
        width: 100%;
    }
}

@media (max-width: 576px) {
    .metric-card .card-body {
        padding: 1rem;
    }

    .metric-card h3 {
        font-size: 1.5rem;
    }
}
</style>
@endsection

@section('content')
    @livewire('analytics-table')
@endsection
