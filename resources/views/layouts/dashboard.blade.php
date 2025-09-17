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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">


    @yield('styles')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"
        integrity="sha256-/xUj+3OJ+Y6k9sa5N0HfZsZ5xU2D6Nj1lEumJJ94Un8=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @livewireStyles
    <style>
        :root {
            --primary-color: #0056b3;
            --secondary-color: #6c757d;
            --accent-color: #dc3545;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f8f9fa;
            padding-top: 70px;
        }

        .navbar {
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            padding: 0.5rem 1rem;
        }

        .navbar-brand {
            font-weight: 700;
            font-size: 1.5rem;
            color: var(--primary-color);
            display: flex;
            align-items: center;
        }

        .navbar-brand i {
            margin-right: 10px;
            font-size: 1.8rem;
        }

        .nav-link {
            font-weight: 500;
            padding: 0.5rem 1rem;
            transition: all 0.3s ease;
        }

        .nav-link:hover {
            background-color: rgba(0, 0, 0, 0.05);
            border-radius: 4px;
        }

        .dropdown-notifications {
            width: 350px;
            padding: 0;
        }

        .dropdown-notifications .dropdown-header {
            background-color: var(--primary-color);
            color: white;
            padding: 10px 15px;
            border-top-left-radius: 0.375rem;
            border-top-right-radius: 0.375rem;
        }

        .dropdown-notifications .dropdown-item {
            padding: 10px 15px;
            border-bottom: 1px solid #eee;
        }

        .dropdown-notifications .dropdown-item:last-child {
            border-bottom: none;
        }

        .avatar-placeholder {
            font-weight: 600;
            font-size: 14px;
        }

        .badge {
            font-size: 0.6rem;
            padding: 0.25em 0.5em;
        }

        .notification-item {
            transition: background-color 0.2s;
        }

        .notification-item:hover {
            background-color: #f8f9fa;
        }

        .notification-icon {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: rgba(0, 86, 179, 0.1);
            color: var(--primary-color);
            font-size: 1rem;
        }

        @media (max-width: 991.98px) {
            .navbar-collapse {
                padding: 1rem 0;
            }

            .navbar-nav {
                margin-top: 1rem;
            }

            .nav-item {
                margin-bottom: 0.5rem;
            }
        }
    </style>
</head>

<body class="d-flex flex-column min-vh-100">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://kit.fontawesome.com/your-code.js" crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
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
    <nav class="navbar navbar-expand-lg navbar-light bg-white fixed-top">
        <div class="container-fluid">
            <!-- Logo/Application Name on Left -->
            <a class="navbar-brand" href="#">
                <i class="fas fa-home"></i>
                <span>RentalHub</span>
            </a>

            <!-- Mobile Toggle Button -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- Main Navigation Links -->
            <div class="collapse navbar-collapse" id="mainNavbar">
                <!-- Centered Navigation Items (optional) -->
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="#"><i class="fas fa-search me-1"></i> Browse</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#"><i class="fas fa-home me-1"></i> Properties</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#"><i class="fas fa-question-circle me-1"></i> Help</a>
                    </li>
                </ul>

                <!-- User Navigation on Right -->
                <ul class="navbar-nav ms-auto">
                    <!-- Notifications Dropdown -->
                    <li class="nav-item dropdown mx-2">
                        <a class="nav-link position-relative" href="#" id="notificationsDropdown" role="button"
                            data-bs-toggle="dropdown">
                            <i class="fas fa-bell"></i>
                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                3
                            </span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end dropdown-notifications">
                            <div class="dropdown-header">
                                <h6 class="mb-0">Notifications</h6>
                                <small>You have 3 unread notifications</small>
                            </div>
                            <div class="dropdown-item notification-item">
                                <div class="d-flex">
                                    <div class="flex-shrink-0">
                                        <div class="notification-icon">
                                            <i class="fas fa-home"></i>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <p class="mb-0">Your listing in Nairobi has been approved</p>
                                        <small class="text-muted">2 hours ago</small>
                                    </div>
                                </div>
                            </div>
                            <div class="dropdown-item notification-item">
                                <div class="d-flex">
                                    <div class="flex-shrink-0">
                                        <div class="notification-icon bg-warning">
                                            <i class="fas fa-exclamation-circle"></i>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <p class="mb-0">Maintenance request for Westlands apartment</p>
                                        <small class="text-muted">5 hours ago</small>
                                    </div>
                                </div>
                            </div>
                            <div class="dropdown-item notification-item">
                                <div class="d-flex">
                                    <div class="flex-shrink-0">
                                        <div class="notification-icon bg-success">
                                            <i class="fas fa-money-bill-wave"></i>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <p class="mb-0">Rent payment received from tenant</p>
                                        <small class="text-muted">1 day ago</small>
                                    </div>
                                </div>
                            </div>
                            <div class="dropdown-divider"></div>
                            <a href="#" class="dropdown-item text-center text-primary">View all notifications</a>
                        </div>
                    </li>

                    <!-- User Dropdown -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="userDropdown"
                            role="button" data-bs-toggle="dropdown">
                            <div class="avatar-placeholder rounded-circle bg-primary text-white d-flex align-items-center justify-content-center me-2"
                                style="width: 32px; height: 32px;">
                                J
                            </div>
                            <span class="d-none d-lg-inline">John Doe</span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end">
                            <div class="dropdown-header">
                                <h6 class="mb-0">My Account</h6>
                                <small class="text-muted">Role: Landlord</small>
                            </div>
                            <a class="dropdown-item" href="#">
                                <i class="fas fa-user me-2"></i> Profile
                            </a>
                            <a class="dropdown-item" href="#">
                                <i class="fas fa-edit me-2"></i> Edit Profile
                            </a>
                            <a class="dropdown-item" href="#">
                                <i class="fas fa-lock me-2"></i> Change Password
                            </a>
                            <a class="dropdown-item" href="#">
                                <i class="fas fa-plus-circle me-2"></i> Add Property
                            </a>
                            <a class="dropdown-item" href="#">
                                <i class="fas fa-cog me-2"></i> Settings
                            </a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="#">
                                <i class="fas fa-sign-out-alt me-2"></i> Logout
                            </a>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <!-- Main Content -->
    <main class="flex-grow-1 p-3">
        @yield('content')
    </main>

    <!-- Back to Top Button -->
    <button onclick="topFunction()" id="backToTop" class="btn btn-primary rounded-circle shadow">
        <i class="fas fa-arrow-up"></i>
    </button>

    <!-- Bootstrap JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

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
    @stack('scripts')
    @livewireScripts
</body>

</html>
