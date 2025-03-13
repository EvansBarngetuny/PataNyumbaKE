<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PataNyumba Kenya</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body class="bg-gray-100">
    <!-- Navbar -->
    <header class="bg-blue-600 text-white shadow-md p-4">
        <div class="container mx-auto flex justify-between items-center">
            <a href="{{ url('/') }}" class="text-2xl font-bold">PataNyumba Kenya</a>
            <nav class="hidden md:flex space-x-4">
                <a href="{{ url('/') }}" class="hover:text-gray-300">Home</a>
                <a href="{{ url('/listings') }}" class="hover:text-gray-300">Listings</a>
                <a href="{{ url('/about') }}" class="hover:text-gray-300">About</a>
                <a href="{{ url('/contact') }}" class="hover:text-gray-300">Contact</a>
                @guest
                    <a href="# " class="hover:text-gray-300">Login</a>
                    <a href="#" class="hover:text-gray-300">Register</a>
                @else
                    <a href="{{ route('dashboard') }}" class="hover:text-gray-300">Dashboard</a>
                    <form action="{{ route('logout') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="hover:text-gray-300">Logout</button>
                    </form>
                @endguest
            </nav>
            <button class="md:hidden text-white" id="mobile-menu-button">
                &#9776;
            </button>
        </div>
    </header>

    <!-- Main Content -->
    <main class="container mx-auto p-6">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white text-center p-4 mt-8">
        <p>&copy; {{ date('Y') }} PataNyumba Kenya. All Rights Reserved.</p>
    </footer>

    <script>
        document.getElementById('mobile-menu-button').addEventListener('click', function() {
            alert('Mobile menu clicked! Implement responsive menu here.');
        });
    </script>

</body>
</html>
