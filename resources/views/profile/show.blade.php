@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <h4 class="mb-0">My Profile</h4>
                        <a href="{{ route('profile.edit') }}" class="btn btn-outline-primary btn-sm">
                            <i class="fas fa-edit me-1"></i> Edit Profile
                        </a>
                    </div>
                </div>

                <div class="card-body">
                    @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                    @endif

                    <div class="text-center mb-4">
                        @if(Auth::user()->profile_picture)
                        <img src="{{ asset('storage/' . Auth::user()->profile_picture) }}" class="rounded-circle"
                            width="150" height="150" alt="Profile Picture">
                        @else
                        <div class="avatar-placeholder rounded-circle bg-primary text-white d-flex align-items-center justify-content-center mx-auto"
                            style="width: 150px; height: 150px; font-size: 3rem;">
                            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                        </div>
                        @endif
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <h5>Name</h5>
                            <p>{{ Auth::user()->name }}</p>
                        </div>
                        <div class="col-md-6">
                            <h5>Email</h5>
                            <p>{{ Auth::user()->email }}</p>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <h5>Phone Number</h5>
                            <p>{{ Auth::user()->phone_number ?? 'Not provided' }}</p>
                        </div>
                        <div class="col-md-6">
                            <h5>Account Type</h5>
                            <p>{{ ucfirst(Auth::user()->role) }}</p>
                        </div>
                    </div>

                    <div class="text-center mt-4">
                        <a href="{{ route('profile.password.edit') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-lock me-1"></i> Change Password
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection