@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
        <div>
            <nav class="flex" aria-label="Breadcrumb">
                <ol class="flex items-center space-x-2">
                    <li><a href="{{ route('reservations.index') }}" class="text-gray-500 hover:text-gray-700">Reservations</a></li>
                    <li><i class="fas fa-chevron-right text-gray-400 text-xs"></i></li>
                    <li><a href="{{ route('books.show', $book) }}" class="text-gray-500 hover:text-gray-700">{{ $book->title }}</a></li>
                    <li><i class="fas fa-chevron-right text-gray-400 text-xs"></i></li>
                    <li class="text-gray-900 font-medium">Reservation Queue</li>
                </ol>
            </nav>
            <h1 class="mt-2 text-2xl font-bold text-gray-900">Reservation Queue</h1>
            <p class="mt-1 text-sm text-gray-600">
                Manage the reservation queue for "{{ $book->title }}"
                <span class="text-gray-400">•</span>
                <span class="text-primary-600 font-medium">{{ $reservations->count() }} 
                {{ Str::plural('reservation', $reservations->count()) }} in queue</span>
            </p>
        </div>
        <div class="mt-4 sm:mt-0 flex space-x-3">
            @if($book->available_copies > 0 && $reservations->count() > 0)
                <form action="{{ route('reservations.fulfill', $reservations->first()) }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" 
                            class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-lg text-white bg-green-600 hover:bg-green-700 shadow-sm transition-all duration-200"
                            onclick="return confirm('Fulfill the next reservation in queue?')">
                        <i class="fas fa-user-check mr-2"></i>
                        Fulfill Next
                    </button>
                </form>
            @endif
            
            <a href="{{ route('books.show', $book) }}" 
               class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 shadow-sm transition-all duration-200">
                <i class="fas fa-book mr-2"></i>
                View Book
            </a>
        </div>
    </div>

    <!-- Book Summary Card -->
    <div class="bg-white shadow-lg rounded-xl border border-gray-100">
        <div class="p-6">
            <div class="flex items-center space-x-6">
                <div class="flex-shrink-0">
                    @if($book->cover_image)
                        <img src="{{ Storage::url($book->cover_image) }}" alt="{{ $book->title }}" 
                             class="w-20 h-28 rounded-lg object-cover shadow-md">
                    @else
                        <div class="w-20 h-28 bg-gray-200 rounded-lg flex items-center justify-center shadow-md">
                            <i class="fas fa-book text-gray-400 text-2xl"></i>
                        </div>
                    @endif
                </div>
                
                <div class="flex-1">
                    <h3 class="text-xl font-bold text-gray-900 mb-1">{{ $book->title }}</h3>
                    <p class="text-lg text-gray-600 mb-3">by {{ $book->author->name }}</p>
                    
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-sm">
                        <div class="bg-blue-50 rounded-lg p-3 text-center">
                            <div class="text-lg font-bold text-blue-600">{{ $book->total_copies }}</div>
                            <div class="text-blue-700 font-medium">Total Copies</div>
                        </div>
                        
                        <div class="bg-{{ $book->available_copies > 0 ? 'green' : 'red' }}-50 rounded-lg p-3 text-center">
                            <div class="text-lg font-bold text-{{ $book->available_copies > 0 ? 'green' : 'red' }}-600">
                                {{ $book->available_copies }}
                            </div>
                            <div class="text-{{ $book->available_copies > 0 ? 'green' : 'red' }}-700 font-medium">Available</div>
                        </div>
                        
                        <div class="bg-yellow-50 rounded-lg p-3 text-center">
                            <div class="text-lg font-bold text-yellow-600">{{ $book->total_copies - $book->available_copies }}</div>
                            <div class="text-yellow-700 font-medium">Borrowed</div>
                        </div>
                        
                        <div class="bg-purple-50 rounded-lg p-3 text-center">
                            <div class="text-lg font-bold text-purple-600">{{ $reservations->count() }}</div>
                            <div class="text-purple-700 font-medium">In Queue</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Queue Status Alert -->
    @if($book->available_copies > 0 && $reservations->count() > 0)
        <div class="bg-green-50 border border-green-200 rounded-xl p-4">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <i class="fas fa-check-circle text-green-400 text-xl"></i>
                </div>
                <div class="ml-3 flex-1">
                    <h4 class="text-sm font-medium text-green-800">Book Available for Fulfillment</h4>
                    <div class="mt-1 text-sm text-green-700">
                        <p>{{ $book->available_copies }} {{ Str::plural('copy', $book->available_copies) }} available. 
                        The next person in queue can collect their reserved book.</p>
                    </div>
                </div>
                <div class="ml-3">
                    <form action="{{ route('reservations.fulfill', $reservations->first()) }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" 
                                class="inline-flex items-center px-3 py-2 border border-transparent text-sm font-medium rounded-lg text-white bg-green-600 hover:bg-green-700"
                                onclick="return confirm('Fulfill {{ $reservations->first()->user->name }}\'s reservation?')">
                            <i class="fas fa-user-check mr-2"></i>
                            Fulfill Next
                        </button>
                    </form>
                </div>
            </div>
        </div>
    @elseif($book->available_copies === 0 && $reservations->count() > 0)
        <div class="bg-yellow-50 border border-yellow-200 rounded-xl p-4">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <i class="fas fa-clock text-yellow-400 text-xl"></i>
                </div>
                <div class="ml-3">
                    <h4 class="text-sm font-medium text-yellow-800">All Copies Currently Borrowed</h4>
                    <div class="mt-1 text-sm text-yellow-700">
                        <p>All {{ $book->total_copies }} {{ Str::plural('copy', $book->total_copies) }} are currently borrowed. 
                        {{ $reservations->count() }} {{ Str::plural('person', $reservations->count()) }} waiting in queue.</p>
                    </div>
                </div>
            </div>
        </div>
    @elseif($reservations->count() === 0)
        <div class="bg-blue-50 border border-blue-200 rounded-xl p-4">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <i class="fas fa-info-circle text-blue-400 text-xl"></i>
                </div>
                <div class="ml-3">
                    <h4 class="text-sm font-medium text-blue-800">No Reservations in Queue</h4>
                    <div class="mt-1 text-sm text-blue-700">
                        <p>There are currently no active reservations for this book. 
                        @if($book->available_copies > 0)
                            The book is available for immediate borrowing.
                        @else
                            Users can reserve when all copies are borrowed.
                        @endif
                        </p>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- Reservation Queue -->
    @if($reservations->count() > 0)
        <div class="bg-white shadow-lg rounded-xl border border-gray-100">
            <div class="px-6 py-4 border-b border-gray-200">
                <div class="flex items-center justify-between">
                    <h3 class="text-lg font-medium text-gray-900 flex items-center">
                        <i class="fas fa-users mr-2 text-purple-500"></i>
                        Reservation Queue ({{ $reservations->count() }})
                    </h3>
                    <div class="flex items-center space-x-4 text-sm text-gray-500">
                        <span>Updated: {{ now()->format('M j, Y \a\t g:i A') }}</span>
                        <button onclick="location.reload()" 
                                class="inline-flex items-center px-2 py-1 border border-gray-300 text-xs font-medium rounded text-gray-700 bg-white hover:bg-gray-50">
                            <i class="fas fa-sync-alt mr-1"></i>Refresh
                        </button>
                    </div>
                </div>
            </div>
            
            <div class="overflow-hidden">
                <ul class="divide-y divide-gray-200">
                    @foreach($reservations as $index => $reservation)
                        <li class="px-6 py-4 hover:bg-gray-50 transition-colors duration-200">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center space-x-4">
                                    <!-- Queue Position -->
                                    <div class="flex-shrink-0">
                                        <div class="w-10 h-10 rounded-full flex items-center justify-center font-bold text-white
                                            {{ $index === 0 ? 'bg-green-500' : ($index === 1 ? 'bg-blue-500' : ($index === 2 ? 'bg-purple-500' : 'bg-gray-500')) }}">
                                            {{ $index + 1 }}
                                        </div>
                                    </div>
                                    
                                    <!-- User Info -->
                                    <div class="flex-1">
                                        <div class="flex items-center space-x-3">
                                            <h4 class="text-sm font-medium text-gray-900">{{ $reservation->user->name }}</h4>
                                            @if($index === 0)
                                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                    <i class="fas fa-star mr-1"></i>Next in line
                                                </span>
                                            @endif
                                        </div>
                                        <div class="mt-1 flex items-center space-x-4 text-sm text-gray-500">
                                            <span>
                                                <i class="fas fa-envelope mr-1"></i>{{ $reservation->user->email }}
                                            </span>
                                            <span>
                                                <i class="fas fa-calendar mr-1"></i>Reserved: {{ $reservation->reserved_date->format('M j, Y') }}
                                            </span>
                                            <span class="inline-flex items-center">
                                                <i class="fas fa-clock mr-1 {{ $reservation->isExpired() ? 'text-red-500' : 'text-blue-500' }}"></i>
                                                @if($reservation->isExpired())
                                                    <span class="text-red-600 font-medium">Expired</span>
                                                @else
                                                    <span>{{ $reservation->daysUntilExpiry() }} days left</span>
                                                @endif
                                            </span>
                                        </div>
                                        
                                        @if($reservation->notes)
                                            <div class="mt-2 p-2 bg-yellow-50 border border-yellow-200 rounded text-sm">
                                                <i class="fas fa-sticky-note text-yellow-600 mr-1"></i>
                                                <span class="text-gray-700">{{ $reservation->notes }}</span>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                
                                <!-- Actions -->
                                <div class="flex items-center space-x-2">
                                    <!-- Waiting Time -->
                                    <div class="text-right text-sm">
                                        <div class="text-gray-900 font-medium">
                                            {{ $reservation->created_at->diffInDays(now()) }} 
                                            {{ Str::plural('day', $reservation->created_at->diffInDays(now())) }}
                                        </div>
                                        <div class="text-gray-500">waiting</div>
                                    </div>
                                    
                                    <!-- Action Buttons -->
                                    <div class="flex space-x-2">
                                        <a href="{{ route('reservations.show', $reservation) }}" 
                                           class="inline-flex items-center p-2 text-primary-600 hover:text-primary-900 hover:bg-primary-50 rounded"
                                           title="View Details">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        
                                        @if($book->available_copies > 0 && $index === 0)
                                            <form action="{{ route('reservations.fulfill', $reservation) }}" method="POST" class="inline">
                                                @csrf
                                                <button type="submit" 
                                                        class="inline-flex items-center p-2 text-green-600 hover:text-green-900 hover:bg-green-50 rounded"
                                                        onclick="return confirm('Fulfill {{ $reservation->user->name }}\'s reservation?')"
                                                        title="Fulfill Reservation">
                                                    <i class="fas fa-check-circle"></i>
                                                </button>
                                            </form>
                                        @endif
                                        
                                        <form action="{{ route('reservations.cancel', $reservation) }}" method="POST" class="inline">
                                            @csrf
                                            <button type="submit" 
                                                    class="inline-flex items-center p-2 text-red-600 hover:text-red-900 hover:bg-red-50 rounded"
                                                    onclick="return confirm('Cancel {{ $reservation->user->name }}\'s reservation?')"
                                                    title="Cancel Reservation">
                                                <i class="fas fa-times-circle"></i>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>
            
            <!-- Queue Statistics -->
            <div class="px-6 py-4 bg-gray-50 border-t border-gray-200">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4 text-sm">
                    <div class="text-center">
                        <div class="font-medium text-gray-900">Average Wait Time</div>
                        <div class="text-gray-600">
                            {{ number_format($reservations->avg(function($r) { return $r->created_at->diffInDays(now()); }), 1) }} days
                        </div>
                    </div>
                    
                    <div class="text-center">
                        <div class="font-medium text-gray-900">Longest Wait</div>
                        <div class="text-gray-600">
                            {{ $reservations->max(function($r) { return $r->created_at->diffInDays(now()); }) }} days
                        </div>
                    </div>
                    
                    <div class="text-center">
                        <div class="font-medium text-gray-900">Queue Priority</div>
                        <div class="text-gray-600">First-come, first-served</div>
                    </div>
                    
                    <div class="text-center">
                        <div class="font-medium text-gray-900">Last Updated</div>
                        <div class="text-gray-600" id="last-updated">
                            {{ now()->format('g:i A') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @else
        <!-- Empty State -->
        <div class="bg-white shadow-lg rounded-xl border border-gray-100">
            <div class="p-12 text-center">
                <div class="w-16 h-16 mx-auto mb-4 rounded-full bg-gray-100 flex items-center justify-center">
                    <i class="fas fa-users text-gray-400 text-2xl"></i>
                </div>
                <h4 class="text-lg font-medium text-gray-900 mb-2">No Active Reservations</h4>
                <p class="text-gray-500 mb-6">
                    This book currently has no reservations in the queue.
                    @if($book->available_copies > 0)
                        It's available for immediate borrowing.
                    @else
                        Users can create reservations when all copies are borrowed.
                    @endif
                </p>
                <div class="flex justify-center space-x-3">
                    <a href="{{ route('books.show', $book) }}" 
                       class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-lg text-white bg-primary-600 hover:bg-primary-700">
                        <i class="fas fa-book mr-2"></i>
                        View Book Details
                    </a>
                    <a href="{{ route('reservations.index') }}" 
                       class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50">
                        <i class="fas fa-list mr-2"></i>
                        All Reservations
                    </a>
                </div>
            </div>
        </div>
    @endif

    <!-- Management Actions -->
    @if($reservations->count() > 0)
        <div class="bg-white shadow-lg rounded-xl border border-gray-100">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-medium text-gray-900 flex items-center">
                    <i class="fas fa-tools mr-2 text-gray-500"></i>
                    Queue Management
                </h3>
            </div>
            
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    @if($book->available_copies > 0)
                        <form action="{{ route('reservations.fulfill', $reservations->first()) }}" method="POST">
                            @csrf
                            <button type="submit" 
                                    class="w-full inline-flex items-center justify-center px-4 py-3 border border-transparent text-sm font-medium rounded-lg text-white bg-green-600 hover:bg-green-700"
                                    onclick="return confirm('Fulfill the next reservation for {{ $reservations->first()->user->name }}?')">
                                <i class="fas fa-user-check mr-2"></i>
                                Fulfill Next in Queue
                            </button>
                        </form>
                    @endif
                    
                    <form action="{{ route('reservations.mark-expired') }}" method="POST">
                        @csrf
                        <button type="submit" 
                                class="w-full inline-flex items-center justify-center px-4 py-3 border border-yellow-300 text-sm font-medium rounded-lg text-yellow-700 bg-yellow-50 hover:bg-yellow-100"
                                onclick="return confirm('Mark all expired reservations as expired?')">
                            <i class="fas fa-clock mr-2"></i>
                            Process Expired
                        </button>
                    </form>
                    
                    <a href="{{ route('books.show', $book) }}" 
                       class="w-full inline-flex items-center justify-center px-4 py-3 border border-gray-300 text-sm font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50">
                        <i class="fas fa-eye mr-2"></i>
                        View Book Details
                    </a>
                </div>
            </div>
        </div>
    @endif
</div>

<script>
// Auto-refresh the page every 60 seconds to keep queue data current
setInterval(function() {
    // Only refresh if the page is visible and user is still on the page
    if (!document.hidden && document.hasFocus()) {
        // Update the last updated time
        document.getElementById('last-updated').textContent = new Date().toLocaleTimeString('en-US', {
            hour: 'numeric',
            minute: '2-digit',
            hour12: true
        });
        
        // Refresh page every 5 minutes
        if (Math.floor(Date.now() / 1000) % 300 === 0) {
            location.reload();
        }
    }
}, 60000);

// Show confirmation for batch actions
document.querySelectorAll('form').forEach(form => {
    form.addEventListener('submit', function(e) {
        const button = this.querySelector('button[type="submit"]');
        if (button && !button.onclick) {
            // Add loading state
            button.disabled = true;
            const originalHTML = button.innerHTML;
            button.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Processing...';
            
            // Re-enable after 3 seconds in case of error
            setTimeout(() => {
                button.disabled = false;
                button.innerHTML = originalHTML;
            }, 3000);
        }
    });
});

// Real-time queue position updates
document.addEventListener('DOMContentLoaded', function() {
    // Add visual indicators for priority positions
    const queueItems = document.querySelectorAll('li[class*="hover:bg-gray-50"]');
    queueItems.forEach((item, index) => {
        if (index === 0) {
            item.style.background = 'linear-gradient(90deg, #f0f9ff 0%, #ffffff 100%)';
            item.style.borderLeft = '4px solid #10b981';
        } else if (index === 1) {
            item.style.background = 'linear-gradient(90deg, #f8fafc 0%, #ffffff 100%)';
            item.style.borderLeft = '4px solid #3b82f6';
        } else if (index === 2) {
            item.style.background = 'linear-gradient(90deg, #faf5ff 0%, #ffffff 100%)';
            item.style.borderLeft = '4px solid #8b5cf6';
        }
    });
});
</script>

<style>
/* Custom animations for queue items */
@keyframes fadeIn {
    from { opacity: 0; transform: translateY(10px); }
    to { opacity: 1; transform: translateY(0); }
}

li[class*="hover:bg-gray-50"] {
    animation: fadeIn 0.3s ease-out;
}

/* Priority queue visual enhancements */
.queue-position-1 { border-left: 4px solid #10b981 !important; }
.queue-position-2 { border-left: 4px solid #3b82f6 !important; }
.queue-position-3 { border-left: 4px solid #8b5cf6 !important; }
</style>
@endsection