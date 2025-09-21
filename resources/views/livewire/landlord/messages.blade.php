<style>
.messages-container {
    min-height: 500px;
}

.list-group-item.unread {
    background-color: #f8f9fa;
    border-left: 4px solid #007bff;
}

.list-group-item.active {
    border-left: 4px solid #007bff;
}

.message-content {
    white-space: pre-wrap;
    line-height: 1.6;
}
</style>
<div class="messages-container">
        {{-- To attain knowledge, add things every day; To attain wisdom, subtract things every day. --}}
    <div class="row">
        <!-- Messages List -->
        <div class="col-md-4">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Messages</h5>
                </div>
                <div class="card-body p-0">
                    @if($messages->count() > 0)
                        <div class="list-group list-group-flush">
                            @foreach($messages as $message)
                                <a href="#"
                                   wire:click="selectMessage({{ $message->id }})"
                                   class="list-group-item list-group-item-action {{ $selectedMessage && $selectedMessage->id == $message->id ? 'active' : '' }} {{ !$message->is_read ? 'fw-bold' : '' }}">
                                    <div class="d-flex justify-content-between">
                                        <h6 class="mb-1">{{ $message->sender_email }}</h6>
                                        <small>{{ $message->created_at->diffForHumans() }}</small>
                                    </div>
                                    <p class="mb-1 text-truncate">{{ Str::limit($message->content, 50) }}</p>
                                    <small>Property: {{ $message->listing->title ?? 'N/A' }}</small>
                                    @if($message->is_successful)
                                        <span class="badge bg-success float-end">Successful</span>
                                    @endif
                                </a>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center p-4">
                            <p class="text-muted">No messages yet</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Message Details -->
        <div class="col-md-8">
            @if($selectedMessage)
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Message Details</h5>
                        @if(!$selectedMessage->is_successful)
                            <button wire:click="markAsSuccessful({{ $selectedMessage->id }})"
                                    class="btn btn-sm btn-success">
                                Mark as Successful
                            </button>
                        @else
                            <span class="badge bg-success">Marked Successful</span>
                        @endif
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <strong>From:</strong> {{ $selectedMessage->sender_email }}<br>
                            <strong>Phone:</strong> {{ $selectedMessage->sender_phone }}<br>
                            <strong>Property:</strong> {{ $selectedMessage->listing->title ?? 'N/A' }}<br>
                            <strong>Date:</strong> {{ $selectedMessage->created_at->format('M d, Y H:i') }}
                        </div>

                        <div class="border p-3 rounded bg-light">
                            <p>{!! nl2br(e($selectedMessage->content)) !!}</p>
                        </div>

                        <!-- Reply Section (Optional) -->
                        <div class="mt-4">
                            <h6>Reply</h6>
                            <form wire:submit.prevent="sendReply">
                                <textarea wire:model="replyContent" class="form-control" rows="3" placeholder="Type your reply..."></textarea>
                                <button type="submit" class="btn btn-primary mt-2">Send Reply</button>
                            </form>
                        </div>
                    </div>
                </div>
            @else
                <div class="text-center p-4">
                    <p class="text-muted">Select a message to view details</p>
                </div>
            @endif
        </div>
    </div>
</div>
