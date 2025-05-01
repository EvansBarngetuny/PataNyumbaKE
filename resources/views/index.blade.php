@extends('layouts.app')

@section('content')

<div class="container mx-auto mt-8">
    <h1 class="text-3xl font-bold text-center">Find Your Perfect Home</h1>
    <p class="text-center text-gray-600">Search for the best rooms and apartments across Kenya</p>

    <div class="mt-6 flex justify-center">
        <input type="text" class="border rounded-l px-4 py-2 w-1/2" placeholder="Search by location, price...">
        <button class="bg-blue-600 text-white px-4 py-2 rounded-r">Search</button>
    </div>
</div>

<script>
    document.getElementById('mobile-menu-button').addEventListener('click', function() {
        alert('Mobile menu clicked! Implement responsive menu here.');
    });
</script>
@endsection
