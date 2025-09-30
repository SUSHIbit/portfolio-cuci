@extends('layouts.admin')

@section('title', 'Contact Messages')

@section('page-title', 'Contact Messages')

@section('content')
<div class="max-w-6xl">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h2 class="text-xl font-semibold text-gray-800">Contact Messages</h2>
            <p class="text-sm text-gray-600">Messages received through your portfolio contact form</p>
        </div>
        <div class="flex items-center space-x-2 text-sm text-gray-600">
            <span>Total: {{ $messages->total() }}</span>
            <span>•</span>
            <span>Unread: {{ $messages->where('is_read', false)->count() }}</span>
        </div>
    </div>

    @if($messages->count() > 0)
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <div class="divide-y divide-gray-200">
                @foreach($messages as $message)
                    <div class="p-6 {{ !$message->is_read ? 'bg-blue-50 border-l-4 border-blue-400' : 'hover:bg-gray-50' }}">
                        <div class="flex items-start justify-between">
                            <div class="flex-1">
                                <div class="flex items-center space-x-3 mb-2">
                                    <h3 class="font-medium text-gray-900">{{ $message->name }}</h3>
                                    <a href="mailto:{{ $message->email }}" class="text-indigo-600 hover:text-indigo-800 text-sm">
                                        {{ $message->email }}
                                    </a>
                                    @if(!$message->is_read)
                                        <span class="px-2 py-1 bg-blue-100 text-blue-800 text-xs rounded-full">New</span>
                                    @endif
                                </div>

                                <div class="text-gray-700 mb-3">
                                    <p class="whitespace-pre-line">{{ $message->message }}</p>
                                </div>

                                <div class="flex items-center space-x-4 text-sm text-gray-500">
                                    <span>
                                        <i class="fas fa-clock mr-1"></i>
                                        {{ $message->created_at->format('M d, Y \a\t g:i A') }}
                                    </span>
                                    <span>
                                        <i class="fas fa-calendar mr-1"></i>
                                        {{ $message->created_at->diffForHumans() }}
                                    </span>
                                </div>
                            </div>

                            <div class="flex items-center space-x-2 ml-6">
                                @if(!$message->is_read)
                                    <form action="{{ route('admin.contacts.read', $message) }}" method="POST" class="inline">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="text-green-600 hover:text-green-800" title="Mark as read">
                                            <i class="fas fa-check"></i>
                                        </button>
                                    </form>
                                @else
                                    <span class="text-green-600" title="Read">
                                        <i class="fas fa-check"></i>
                                    </span>
                                @endif

                                <a href="mailto:{{ $message->email }}?subject=Re: Contact from {{ config('app.name') }}&body=Hi {{ $message->name }},%0D%0A%0D%0AThank you for your message: %0D%0A%0D%0A{{ str_replace(["\r\n", "\n", "\r"], '%0D%0A', $message->message) }}%0D%0A%0D%0A"
                                   class="text-indigo-600 hover:text-indigo-800" title="Reply via email">
                                    <i class="fas fa-reply"></i>
                                </a>

                                <form action="{{ route('admin.contacts.destroy', $message) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this message?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-800" title="Delete">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Pagination -->
        @if($messages->hasPages())
            <div class="mt-6">
                {{ $messages->links() }}
            </div>
        @endif

        <!-- Bulk Actions -->
        @if($messages->where('is_read', false)->count() > 0)
            <div class="mt-6 bg-white rounded-lg shadow p-4">
                <div class="flex items-center justify-between">
                    <div class="text-sm text-gray-600">
                        {{ $messages->where('is_read', false)->count() }} unread message(s)
                    </div>
                    <div class="flex items-center space-x-3">
                        <button onclick="markAllAsRead()" class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 text-sm">
                            <i class="fas fa-check-double mr-2"></i>Mark All as Read
                        </button>
                    </div>
                </div>
            </div>
        @endif
    @else
        <div class="bg-white rounded-lg shadow">
            <div class="p-12 text-center">
                <i class="fas fa-envelope-open text-gray-400 text-6xl mb-4"></i>
                <h3 class="text-lg font-medium text-gray-900 mb-2">No messages yet</h3>
                <p class="text-gray-600 mb-6">Contact messages will appear here when visitors reach out through your portfolio</p>
                <div class="text-sm text-gray-500">
                    <p>Make sure your contact form is working properly by testing it on your portfolio.</p>
                </div>
            </div>
        </div>
    @endif

    <!-- Back Button -->
    <div class="mt-8">
        <a href="{{ route('admin.dashboard') }}" class="px-4 py-2 text-gray-600 hover:text-gray-800">
            <i class="fas fa-arrow-left mr-2"></i>Back to Dashboard
        </a>
    </div>
</div>

<!-- Bulk Actions Modal -->
<div id="bulk-actions-modal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden flex items-center justify-center z-50">
    <div class="bg-white rounded-lg p-6 w-full max-w-md">
        <h3 class="text-lg font-semibold mb-4">Mark All Messages as Read</h3>
        <p class="text-gray-600 mb-6">Are you sure you want to mark all unread messages as read? This action cannot be undone.</p>

        <div class="flex justify-end space-x-3">
            <button onclick="closeBulkModal()" class="px-4 py-2 text-gray-600 hover:text-gray-800">Cancel</button>
            <button onclick="confirmMarkAllAsRead()" class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700">Confirm</button>
        </div>
    </div>
</div>

<script>
function markAllAsRead() {
    document.getElementById('bulk-actions-modal').classList.remove('hidden');
}

function closeBulkModal() {
    document.getElementById('bulk-actions-modal').classList.add('hidden');
}

function confirmMarkAllAsRead() {
    // Create forms for each unread message and submit them
    const unreadMessages = @json($messages->where('is_read', false)->pluck('id'));

    if (unreadMessages.length === 0) {
        closeBulkModal();
        return;
    }

    let completed = 0;
    const total = unreadMessages.length;

    unreadMessages.forEach(messageId => {
        fetch(`/admin/contacts/${messageId}/read`, {
            method: 'PATCH',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Accept': 'application/json',
            }
        })
        .then(response => response.json())
        .then(data => {
            completed++;
            if (completed === total) {
                window.location.reload();
            }
        })
        .catch(error => {
            console.error('Error:', error);
            completed++;
            if (completed === total) {
                window.location.reload();
            }
        });
    });

    closeBulkModal();
}

// Close modal when clicking outside
document.getElementById('bulk-actions-modal').addEventListener('click', function(e) {
    if (e.target === this) closeBulkModal();
});

// Close modal with escape key
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeBulkModal();
    }
});
</script>
@endsection