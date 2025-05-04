@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">My Messages</h4>
                </div>

                <div class="card-body">
                    <div class="list-group">
                        @forelse ($messages as $message)
                        <a href="{{ route('admin.messages.show', $message) }}"
                            class="list-group-item list-group-item-action {{ $message->read_at ? '' : 'fw-bold' }}">
                            <div class="d-flex w-100 justify-content-between">
                                <h5 class="mb-1">
                                    @if($message->sender_id === auth()->id())
                                    To: {{ $message->recipient->name }}
                                    @else
                                    From: {{ $message->sender->name }}
                                    @endif
                                </h5>
                                <small>{{ $message->created_at->diffForHumans() }}</small>
                            </div>
                            <p class="mb-1">{{ Str::limit($message->content, 100) }}</p>
                            <small>Regarding: {{ $message->listing->title }}</small>

                            @if($message->is_successful)
                            <span class="badge bg-success float-end">Successful Match</span>
                            @endif
                        </a>
                        @empty
                        <div class="list-group-item">
                            <p class="mb-0 text-center text-muted">You have no messages yet.</p>
                        </div>
                        @endforelse
                    </div>

                    <div class="mt-4">
                        {{ $messages->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection