<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'PataNyumba') }} @yield('title')</title>

    <!-- Favicon -->
    <link rel="icon" href="{{ asset('images/favicon.png') }}" type="image/png">

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    @yield('styles')
</head>

<body class="d-flex flex-column min-vh-100">
    <!-- Top Notification Bar -->
    <div class="top-bar bg-primary text-white py-2 d-none d-md-block">
        <div class="container d-flex justify-content-between align-items-center">
            <div class="top-bar-left">
                <span><i class="fas fa-phone-alt me-2"></i> +254 716250529</span>
                <span class="ms-4"><i class="fas fa-envelope me-2"></i> info@patanyumba.co.ke</span>
            </div>
            <div class="top-bar-right">
                <a href="#" class="text-white me-3"><i class="fab fa-facebook-f"></i></a>
                <a href="#" class="text-white me-3"><i class="fab fa-twitter"></i></a>
                <a href="#" class="text-white me-3"><i class="fab fa-instagram"></i></a>
                <a href="#" class="text-white"><i class="fab fa-linkedin-in"></i></a>
            </div>
        </div>
    </div>

    <!-- Main Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm sticky-top">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">
                <img src="{{ asset('images/logo.png') }}" alt="PataNyumba" height="40">
            </a>

            <!-- Mobile Toggle -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- Main Navigation Links -->
            <div class="collapse navbar-collapse" id="mainNavbar">
                <ul class="navbar-nav mx-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/') }}">Home</a>
                    </li>
                    <!-- <li class="nav-item">
                        <a class="nav-link" href="{{ route('listings.index') }}">Properties</a>
                    </li> 
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="countiesDropdown" role="button"
                            data-bs-toggle="dropdown">
                            Counties
                        </a>
                        <div class="dropdown-menu">
                            @foreach(kenyanCounties() as $county)
                            <a class="dropdown-item"
                                href="{{ route('listings.search') }}?county={{ urlencode($county) }}">{{ $county }}</a>
                            @endforeach
                        </div>
                    </li> -->
                    <li class="nav-item">
                        <a class="nav-link" href="#">About Us</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Contact</a>
                    </li>
                </ul>

                <!-- User Navigation -->
                <ul class="navbar-nav">
                    @guest
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">
                            <i class="fas fa-sign-in-alt me-1"></i> Login
                        </a>
                    </li>
                    <li class="nav-item ms-2">
                        <a class="btn btn-primary" href="{{ route('register') }}">
                            <i class="fas fa-user-plus me-1"></i> Register
                        </a>
                    </li>
                    @else
                    <!-- Notifications Dropdown -->
                    <li class="nav-item dropdown mx-2">
                        <a class="nav-link position-relative" href="#" id="notificationsDropdown" role="button"
                            data-bs-toggle="dropdown">
                            <i class="fas fa-bell"></i>
                            <span
                                class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                3
                            </span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end dropdown-notifications">
                            <div class="dropdown-header">
                                <h6>Notifications</h6>
                            </div>
                            <div class="dropdown-item">
                                <div class="d-flex">
                                    <div class="flex-shrink-0">
                                        <i class="fas fa-home text-primary"></i>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <p class="mb-0">Your listing in Nairobi has been approved</p>
                                        <small class="text-muted">2 hours ago</small>
                                    </div>
                                </div>
                            </div>
                            <div class="dropdown-divider"></div>
                            <a href="#" class="dropdown-item text-center">View all notifications</a>
                        </div>
                    </li>

                    <!-- User Dropdown -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="userDropdown"
                            role="button" data-bs-toggle="dropdown">
                            @if(Auth::user()->profile_picture)
                            <img src="{{ asset('storage/' . Auth::user()->profile_picture) }}"
                                class="rounded-circle me-2" width="32" height="32" alt="Profile">
                            @else
                            <div class="avatar-placeholder rounded-circle bg-primary text-white d-flex align-items-center justify-content-center me-2"
                                style="width: 32px; height: 32px;">
                                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                            </div>
                            @endif
                            <span class="d-none d-lg-inline">{{ Auth::user()->name }}</span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end">
                            <div class="dropdown-header">
                                <h6>My Account</h6>
                                <small class="text-muted">Role: {{ ucfirst(Auth::user()->role) }}</small>
                            </div>
                            <a class="dropdown-item" href="{{ route('profile.show') }}">
                                <i class="fas fa-user me-2"></i> Profile
                            </a>
                            <a class="dropdown-item" href="{{ route('profile.edit') }}">
                                <i class="fas fa-edit me-2"></i> Edit Profile
                            </a>
                            <a class="dropdown-item" href="{{ route('profile.password.edit') }}">
                                <i class="fas fa-lock me-2"></i> Change Password
                            </a>
                            <a class="dropdown-item" href="{{ route('listings.create') }}">
                                <i class="fas fa-plus-circle me-2"></i> Add Property
                            </a>
                            @if(Auth::user()->role === 'admin')
                            <a class="dropdown-item" href="{{ route('admin.dashboard') }}">
                                <i class="fas fa-tachometer-alt me-2"></i> Admin Dashboard
                            </a>
                            @endif
                            <a class="dropdown-item" href="#">
                                <i class="fas fa-cog me-2"></i> Settings
                            </a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="{{ route('logout') }}"
                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <i class="fas fa-sign-out-alt me-2"></i> Logout
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </div>
                    </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="flex-grow-1">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-dark text-white pt-5 pb-4">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 mb-4">
                    <img src="{{ asset('images/logo-white.png') }}" alt="PataNyumba" height="40" class="mb-3">
                    <p>Kenya's premier property rental platform connecting tenants with quality homes and landlords with
                        reliable tenants.</p>
                    <div class="social-icons">
                        <a href="#" class="text-white me-3"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="text-white me-3"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="text-white me-3"><i class="fab fa-instagram"></i></a>
                        <a href="#" class="text-white"><i class="fab fa-linkedin-in"></i></a>
                    </div>
                </div>
                <div class="col-lg-2 col-md-4 mb-4">
                    <h5>Quick Links</h5>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="{{ url('/') }}" class="text-white">Home</a></li>
                        <li class="mb-2"><a href="{{ route('listings.index') }}" class="text-white">Properties</a></li>
                        <li class="mb-2"><a href="#" class="text-white">About Us</a></li>
                        <li class="mb-2"><a href="#" class="text-white">Contact</a></li>
                        <li><a href="#" class="text-white">FAQs</a></li>
                    </ul>
                </div>
                <div class="col-lg-3 col-md-4 mb-4">
                    <h5>Popular Counties</h5>
                    <ul class="list-unstyled">
                        @foreach($popularCounties ?? [] as $county)
                        <li class="mb-2">
                            <a href="{{ route('listings.search') }}?county={{ urlencode($county->name ?? $county['name'] ?? '') }}"
                                class="text-white">
                                {{ $county->name ?? $county['name'] ?? '' }}
                            </a>
                        </li>
                        @endforeach
                    </ul>
                </div>
                <div class="col-lg-3 col-md-4 mb-4">
                    <h5>Contact Us</h5>
                    <address>
                        <p><i class="fas fa-map-marker-alt me-2"></i> Nairobi, Kenya</p>
                        <p><i class="fas fa-phone-alt me-2"></i> +254 716250529</p>
                        <p><i class="fas fa-envelope me-2"></i> info@patanyumba.co.ke</p>
                    </address>
                </div>
            </div>
            <hr class="my-4 bg-secondary">
            <div class="row">
                <div class="col-md-6 text-center text-md-start">
                    <p class="mb-0">&copy; {{ date('Y') }} PataNyumba. All rights reserved.</p>
                </div>
                <div class="col-md-6 text-center text-md-end">
                    <p class="mb-0">
                        <a href="#" class="text-white me-3">Terms of Service</a>
                        <a href="#" class="text-white">Privacy Policy</a>
                    </p>
                </div>
            </div>
        </div>
    </footer>

    <!-- Back to Top Button -->
    <button onclick="topFunction()" id="backToTop" class="btn btn-primary rounded-circle shadow">
        <i class="fas fa-arrow-up"></i>
    </button>

    <!-- Bootstrap JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Custom JS -->
    <script src="{{ asset('js/app.js') }}"></script>

    <script>
    // Back to top button
    const backToTopButton = document.getElementById("backToTop");

    window.onscroll = function() {
        if (document.body.scrollTop > 100 || document.documentElement.scrollTop > 100) {
            backToTopButton.style.display = "block";
        } else {
            backToTopButton.style.display = "none";
        }
    };

    function topFunction() {
        window.scrollTo({
            top: 0,
            behavior: 'smooth'
        });
    }

    // Initialize tooltips
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    });
    </script>

    @yield('scripts')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" defer></script>

</body>

</html>