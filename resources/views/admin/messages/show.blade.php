@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <h4 class="mb-0">Message Details</h4>
                        <a href="{{ route('messages.index') }}" class="btn btn-sm btn-light">
                            <i class="fas fa-arrow-left"></i> Back
                        </a>
                    </div>
                </div>

                <div class="card-body">
                    <div class="mb-4">
                        <h5>Regarding Property:</h5>
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">{{ $message->listing->title }}</h5>
                                <p class="card-text">{{ $message->listing->estate }}, {{ $message->listing->county }}
                                </p>
                                <a href="{{ route('listings.show', $message->listing) }}"
                                    class="btn btn-sm btn-primary">
                                    View Property
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="mb-4">
                        <h5>Message:</h5>
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex justify-content-between mb-3">
                                    <div>
                                        <strong>
                                            @if($message->sender_id === auth()->id())
                                            To: {{ $message->recipient->name }}
                                            @else
                                            From: {{ $message->sender->name }}
                                            @endif
                                        </strong>
                                    </div>
                                    <div class="text-muted">
                                        {{ $message->created_at->format('M j, Y g:i a') }}
                                    </div>
                                </div>
                                <p class="card-text">{{ $message->content }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <h5>Contact Information:</h5>
                        <ul class="list-group">
                            <li class="list-group-item">
                                <i class="fas fa-envelope me-2"></i> {{ $message->sender_email }}
                            </li>
                            <li class="list-group-item">
                                <i class="fas fa-phone me-2"></i> {{ $message->sender_phone }}
                            </li>
                        </ul>
                    </div>

                    @if($message->recipient_id === auth()->id() && !$message->is_successful)
                    <form method="POST" action="{{ route('messages.mark-successful', $message) }}">
                        @csrf
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-handshake me-2"></i> Mark as Successful Match
                        </button>
                    </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection