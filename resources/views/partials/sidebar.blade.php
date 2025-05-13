<div class="d-flex flex-column flex-shrink-0 p-3 bg-light border-end" style="width: 250px; min-height: 100vh;">
    <a href="{{ route('admin.dashboard') }}"
        class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-decoration-none">

        <span class="fs-5 fw-bold">Admin Panel</span>
    </a>
    <hr>
    <ul class="nav nav-pills flex-column mb-auto">
        <!-- Dashboard Overview -->
        <li class="nav-item">
            <a href="{{ route('admin.dashboard') }}"
                class="nav-link {{ request()->is('dashboard') ? 'active' : 'text-dark' }}">
                <i class="fas fa-tachometer-alt me-2"></i> Overview
            </a>
        </li>
        <!-- User Management fas fa-building me-2-->
        <li class="mt-2 mb-1 text-uppercase fw-bold small text-muted">User Management</li>
        <li>
            <a href="{{ route('admin.landlords.index') }}"
                class="nav-link load-content {{ request()->is('landlord') ? 'active' : 'text-dark' }} "
                data-target="landlords-content">
                <i class="fas fa-user-tie me-2"></i> Landlords
            </a>
        </li>
        <li>
            <a href=" {{ route('admin.agents.index') }}"
                class="nav-link {{ request()->is('agents*') ? 'active' : 'text-dark' }}">
                <i class="fas fa-user-secret me-2"></i> Agents
            </a>
        </li>
        <li>
            <a href="{{ route('admin.tenants.index') }}"
                class="nav-link {{ request()->is('tenants*') ? 'active' : 'text-dark' }}">
                <i class="fas fa-users me-2"></i> Tenants
            </a>
        </li>
        <!--<li>
            <a href="{{ route('admin.messages.index') }}"
                class="nav-link {{ request()->is('messagess*') ? 'active' : 'text-dark' }}">
                <i class="fas fa-envelope m-2"></i> Messages
                @auth
                @if(auth()->user()->unreadMessages()->count() > 0)
                <span class="badge bg-danger">{{ auth()->user()->unreadMessages()->count() }}</span>
                @endif
                @endauth
            </a>
        </li> -->
        <!-- System Monitoring -->
        <li class="mt-3 mb-1 text-uppercase fw-bold small text-muted">System Monitoring</li>
        <li>
            <a href="{{ route('admin.analytics.index') }}"
                class="nav-link {{ request()->is('analytics*') ? 'active' : 'text-dark' }}">
                <i class="fas fa-chart-bar me-2"></i> Analytics
            </a>
        </li>
        <li>
            <a href="{{ route('admin.reports.index') }}" class="nav-link {{ request()->is('spam-reports*') ? 'active' : 'text-dark' }}">
                <i class="fas fa-shield-alt me-2"></i> Spam/Reports
            </a>
        </li>
        <li>
            <a href="{{ route('admin.system-health.index') }}"  class="nav-link {{ request()->is('system-health*') ? 'active' : 'text-dark' }}">
                <i class="fas fa-server me-2"></i> System Health
            </a>
        </li>
        <!-- Content & Settings -->
        <li class="mt-3 mb-1 text-uppercase fw-bold small text-muted">System Control</li>
        <li>
            <a href="#" class="nav-link {{ request()->is('listings*') ? 'active' : 'text-dark' }}">
                <i class="fas fa-door-open me-2"></i> Room Listings
            </a>
        </li>
        <li>
            <a href="#" class="nav-link {{ request()->is('payments*') ? 'active' : 'text-dark' }}">
                <i class="fas fa-credit-card me-2"></i> Payments
            </a>
        </li>
        <li>
            <a href="#" class="nav-link {{ request()->is('audit-trail*') ? 'active' : 'text-dark' }}">
                <i class="fas fa-clipboard-list me-2"></i> Audit Trail
            </a>
        </li>
        <li>
            <a href="#" class="nav-link {{ request()->is('settings') ? 'active' : 'text-dark' }}">
                <i class="fas fa-cog me-2"></i> Settings
            </a>
        </li>
    </ul>
    <hr>
</div>
