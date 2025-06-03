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
                    <li class="text-gray-900 font-medium">Reservation #{{ $reservation->id }}</li>
                </ol>
            </nav>
            <h1 class="mt-2 text-2xl font-bold text-gray-900">Reservation Details</h1>
        </div>
        <div class="mt-4 sm:mt-0 flex space-x-3">
            @if($reservation->status === 'active')
                @if(auth()->user()->isLibrarian() && $reservation->book->available_copies > 0)
                    <form action="{{ route('reservations.fulfill', $reservation) }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" 
                                class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-lg text-white bg-green-600 hover:bg-green-700 shadow-sm transition-all duration-200"
                                onclick="return confirm('Fulfill this reservation and create a borrowing record?')">
                            <i class="fas fa-check-circle mr-2"></i>
                            Fulfill Reservation
                        </button>
                    </form>
                @endif
                
                <form action="{{ route('reservations.cancel', $reservation) }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" 
                            class="inline-flex items-center px-4 py-2 border border-red-300 text-sm font-medium rounded-lg text-red-700 bg-white hover:bg-red-50 shadow-sm transition-all duration-200"
                            onclick="return confirm('Are you sure you want to cancel this reservation?')">
                        <i class="fas fa-times-circle mr-2"></i>
                        Cancel Reservation
                    </button>
                </form>
            @endif
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Content -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Reservation Status -->
            <div class="bg-white shadow-lg rounded-xl border border-gray-100">
                <div class="px-6 py-4 border-b border-gray-200">
                    <div class="flex items-center justify-between">
                        <h3 class="text-lg font-medium text-gray-900 flex items-center">
                            <i class="fas fa-info-circle mr-2 text-blue-500"></i>
                            Reservation Status
                        </h3>
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium 
                            {{ $reservation->status === 'active' ? 'bg-green-100 text-green-800' : 
                               ($reservation->status === 'fulfilled' ? 'bg-blue-100 text-blue-800' : 
                               ($reservation->status === 'expired' ? 'bg-red-100 text-red-800' : 'bg-gray-100 text-gray-800')) }}">
                            <i class="fas fa-{{ $reservation->status === 'active' ? 'clock' : ($reservation->status === 'fulfilled' ? 'check' : ($reservation->status === 'expired' ? 'times' : 'ban')) }} mr-2"></i>
                            {{ ucfirst($reservation->status) }}
                        </span>
                    </div>
                </div>
                
                <div class="p-6">
                    @if($reservation->status === 'active')
                        @if($reservation->isExpired())
                            <div class="bg-red-50 border border-red-200 rounded-lg p-4 mb-4">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0">
                                        <i class="fas fa-exclamation-triangle text-red-400"></i>
                                    </div>
                                    <div class="ml-3">
                                        <h4 class="text-sm font-medium text-red-800">Reservation Expired</h4>
                                        <div class="mt-1 text-sm text-red-700">
                                            <p>This reservation expired on {{ $reservation->expiry_date->format('M j, Y') }}. It will be automatically cancelled soon.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="bg-green-50 border border-green-200 rounded-lg p-4 mb-4">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0">
                                        <i class="fas fa-check-circle text-green-400"></i>
                                    </div>
                                    <div class="ml-3">
                                        <h4 class="text-sm font-medium text-green-800">Active Reservation</h4>
                                        <div class="mt-1 text-sm text-green-700">
                                            <p>Your reservation is active. You have <strong>{{ $reservation->daysUntilExpiry() }} days</strong> remaining once the book becomes available.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @elseif($reservation->status === 'fulfilled')
                        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-4">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <i class="fas fa-check-circle text-blue-400"></i>
                                </div>
                                <div class="ml-3">
                                    <h4 class="text-sm font-medium text-blue-800">Reservation Fulfilled</h4>
                                    <div class="mt-1 text-sm text-blue-700">
                                        <p>This reservation was fulfilled on {{ $reservation->fulfilled_date->format('M j, Y') }}. A borrowing record should have been created.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @elseif($reservation->status === 'cancelled')
                        <div class="bg-gray-50 border border-gray-200 rounded-lg p-4 mb-4">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <i class="fas fa-ban text-gray-400"></i>
                                </div>
                                <div class="ml-3">
                                    <h4 class="text-sm font-medium text-gray-800">Reservation Cancelled</h4>
                                    <div class="mt-1 text-sm text-gray-700">
                                        <p>This reservation was cancelled and is no longer active.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- Reservation Timeline -->
                    <div class="space-y-4">
                        <h4 class="text-sm font-medium text-gray-900 border-b border-gray-200 pb-2">Reservation Timeline</h4>
                        
                        <div class="flow-root">
                            <ul class="-mb-8">
                                <!-- Reserved -->
                                <li>
                                    <div class="relative pb-8">
                                        <div class="absolute top-5 left-5 -ml-px h-full w-0.5 bg-gray-200"></div>
                                        <div class="relative flex items-start space-x-3">
                                            <div class="relative">
                                                <div class="h-10 w-10 rounded-full bg-green-500 flex items-center justify-center ring-8 ring-white">
                                                    <i class="fas fa-bookmark text-white text-sm"></i>
                                                </div>
                                            </div>
                                            <div class="min-w-0 flex-1">
                                                <div>
                                                    <div class="text-sm">
                                                        <span class="font-medium text-gray-900">Reservation Created</span>
                                                    </div>
                                                    <p class="mt-0.5 text-sm text-gray-500">
                                                        {{ $reservation->reserved_date->format('M j, Y \a\t g:i A') }}
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                
                                @if($reservation->status === 'fulfilled')
                                    <!-- Fulfilled -->
                                    <li>
                                        <div class="relative">
                                            <div class="relative flex items-start space-x-3">
                                                <div class="relative">
                                                    <div class="h-10 w-10 rounded-full bg-blue-500 flex items-center justify-center ring-8 ring-white">
                                                        <i class="fas fa-check text-white text-sm"></i>
                                                    </div>
                                                </div>
                                                <div class="min-w-0 flex-1">
                                                    <div>
                                                        <div class="text-sm">
                                                            <span class="font-medium text-gray-900">Reservation Fulfilled</span>
                                                        </div>
                                                        <p class="mt-0.5 text-sm text-gray-500">
                                                            {{ $reservation->fulfilled_date->format('M j, Y \a\t g:i A') }}
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                @elseif($reservation->status === 'active')
                                    <!-- Waiting -->
                                    <li>
                                        <div class="relative">
                                            <div class="relative flex items-start space-x-3">
                                                <div class="relative">
                                                    <div class="h-10 w-10 rounded-full bg-yellow-500 flex items-center justify-center ring-8 ring-white">
                                                        <i class="fas fa-clock text-white text-sm"></i>
                                                    </div>
                                                </div>
                                                <div class="min-w-0 flex-1">
                                                    <div>
                                                        <div class="text-sm">
                                                            <span class="font-medium text-gray-900">Waiting in Queue</span>
                                                        </div>
                                                        <p class="mt-0.5 text-sm text-gray-500">
                                                            Position #{{ $queuePosition }} in reservation queue
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                @elseif($reservation->status === 'cancelled')
                                    <!-- Cancelled -->
                                    <li>
                                        <div class="relative">
                                            <div class="relative flex items-start space-x-3">
                                                <div class="relative">
                                                    <div class="h-10 w-10 rounded-full bg-gray-500 flex items-center justify-center ring-8 ring-white">
                                                        <i class="fas fa-times text-white text-sm"></i>
                                                    </div>
                                                </div>
                                                <div class="min-w-0 flex-1">
                                                    <div>
                                                        <div class="text-sm">
                                                            <span class="font-medium text-gray-900">Reservation Cancelled</span>
                                                        </div>
                                                        <p class="mt-0.5 text-sm text-gray-500">
                                                            {{ $reservation->updated_at->format('M j, Y \a\t g:i A') }}
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                @elseif($reservation->status === 'expired')
                                    <!-- Expired -->
                                    <li>
                                        <div class="relative">
                                            <div class="relative flex items-start space-x-3">
                                                <div class="relative">
                                                    <div class="h-10 w-10 rounded-full bg-red-500 flex items-center justify-center ring-8 ring-white">
                                                        <i class="fas fa-exclamation-triangle text-white text-sm"></i>
                                                    </div>
                                                </div>
                                                <div class="min-w-0 flex-1">
                                                    <div>
                                                        <div class="text-sm">
                                                            <span class="font-medium text-gray-900">Reservation Expired</span>
                                                        </div>
                                                        <p class="mt-0.5 text-sm text-gray-500">
                                                            {{ $reservation->expiry_date->format('M j, Y \a\t g:i A') }}
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                @endif
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Book Details -->
            <div class="bg-white shadow-lg rounded-xl border border-gray-100">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900 flex items-center">
                        <i class="fas fa-book mr-2 text-primary-500"></i>
                        Reserved Book
                    </h3>
                </div>
                
                <div class="p-6">
                    <div class="flex items-start space-x-6">
                        <div class="flex-shrink-0">
                            @if($reservation->book->cover_image)
                                <img src="{{ Storage::url($reservation->book->cover_image) }}" alt="{{ $reservation->book->title }}" 
                                     class="w-24 h-32 rounded-lg object-cover shadow-md">
                            @else
                                <div class="w-24 h-32 bg-gray-200 rounded-lg flex items-center justify-center shadow-md">
                                    <i class="fas fa-book text-gray-400 text-2xl"></i>
                                </div>
                            @endif
                        </div>
                        
                        <div class="flex-1">
                            <h4 class="text-xl font-bold text-gray-900 mb-2">{{ $reservation->book->title }}</h4>
                            <p class="text-lg text-gray-600 mb-4">by {{ $reservation->book->author->name }}</p>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                                <div>
                                    <span class="font-medium text-gray-500">Category:</span>
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium ml-2"
                                          style="background-color: {{ $reservation->book->category->color }}20; color: {{ $reservation->book->category->color }}">
                                        <i class="fas fa-tag mr-1"></i>{{ $reservation->book->category->name }}
                                    </span>
                                </div>
                                
                                <div>
                                    <span class="font-medium text-gray-500">ISBN:</span>
                                    <span class="ml-2 font-mono">{{ $reservation->book->isbn }}</span>
                                </div>
                                
                                <div>
                                    <span class="font-medium text-gray-500">Publisher:</span>
                                    <span class="ml-2">{{ $reservation->book->publisher }}</span>
                                </div>
                                
                                <div>
                                    <span class="font-medium text-gray-500">Pages:</span>
                                    <span class="ml-2">{{ $reservation->book->pages }}</span>
                                </div>
                                
                                <div>
                                    <span class="font-medium text-gray-500">Total Copies:</span>
                                    <span class="ml-2">{{ $reservation->book->total_copies }}</span>
                                </div>
                                
                                <div>
                                    <span class="font-medium text-gray-500">Available:</span>
                                    <span class="ml-2 {{ $reservation->book->available_copies > 0 ? 'text-green-600 font-medium' : 'text-red-600 font-medium' }}">
                                        {{ $reservation->book->available_copies }} copies
                                    </span>
                                </div>
                            </div>
                            
                            @if($reservation->book->description)
                                <div class="mt-4">
                                    <span class="font-medium text-gray-500">Description:</span>
                                    <p class="mt-1 text-gray-700">{{ Str::limit($reservation->book->description, 200) }}</p>
                                </div>
                            @endif
                            
                            <div class="mt-4">
                                <a href="{{ route('books.show', $reservation->book) }}" 
                                   class="inline-flex items-center px-3 py-2 border border-transparent text-sm font-medium rounded-lg text-primary-600 bg-primary-50 hover:bg-primary-100">
                                    <i class="fas fa-external-link-alt mr-2"></i>
                                    View Full Book Details
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Notes -->
            @if($reservation->notes)
                <div class="bg-white shadow-lg rounded-xl border border-gray-100">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900 flex items-center">
                            <i class="fas fa-sticky-note mr-2 text-yellow-500"></i>
                            Reservation Notes
                        </h3>
                    </div>
                    
                    <div class="p-6">
                        <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                            <p class="text-gray-800">{{ $reservation->notes }}</p>
                        </div>
                    </div>
                </div>
            @endif
        </div>

        <!-- Sidebar -->
        <div class="lg:col-span-1 space-y-6">
            <!-- Reservation Info -->
            <div class="bg-white shadow-lg rounded-xl border border-gray-100">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900 flex items-center">
                        <i class="fas fa-info-circle mr-2 text-blue-500"></i>
                        Reservation Info
                    </h3>
                </div>
                
                <div class="p-6 space-y-4">
                    <div>
                        <span class="text-sm font-medium text-gray-500">Reservation ID:</span>
                        <p class="text-sm font-mono text-gray-900">#{{ $reservation->id }}</p>
                    </div>
                    
                    <div>
                        <span class="text-sm font-medium text-gray-500">Reserved By:</span>
                        <p class="text-sm text-gray-900">{{ $reservation->user->name }}</p>
                        @if(auth()->user()->isLibrarian())
                            <p class="text-sm text-gray-500">{{ $reservation->user->email }}</p>
                        @endif
                    </div>
                    
                    <div>
                        <span class="text-sm font-medium text-gray-500">Reserved Date:</span>
                        <p class="text-sm text-gray-900">{{ $reservation->reserved_date->format('M j, Y') }}</p>
                    </div>
                    
                    <div>
                        <span class="text-sm font-medium text-gray-500">Expiry Date:</span>
                        <p class="text-sm {{ $reservation->isExpired() && $reservation->status === 'active' ? 'text-red-600 font-medium' : 'text-gray-900' }}">
                            {{ $reservation->expiry_date->format('M j, Y') }}
                        </p>
                        @if($reservation->status === 'active' && !$reservation->isExpired())
                            <p class="text-xs text-blue-600">{{ $reservation->daysUntilExpiry() }} days remaining</p>
                        @endif
                    </div>
                    
                    @if($reservation->fulfilled_date)
                        <div>
                            <span class="text-sm font-medium text-gray-500">Fulfilled Date:</span>
                            <p class="text-sm text-gray-900">{{ $reservation->fulfilled_date->format('M j, Y') }}</p>
                        </div>
                    @endif
                    
                    <div>
                        <span class="text-sm font-medium text-gray-500">Queue Position:</span>
                        <p class="text-sm text-gray-900">
                            @if($reservation->status === 'active')
                                #{{ $queuePosition }} in queue
                            @else
                                Not applicable
                            @endif
                        </p>
                    </div>
                </div>
            </div>

            <!-- Queue Information -->
            @if($reservation->status === 'active')
                <div class="bg-white shadow-lg rounded-xl border border-gray-100">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900 flex items-center">
                            <i class="fas fa-users mr-2 text-purple-500"></i>
                            Queue Status
                        </h3>
                    </div>
                    
                    <div class="p-6">
                        @php
                            $totalInQueue = $reservation->book->activeReservations()->count();
                            $aheadOfYou = $queuePosition - 1;
                        @endphp
                        
                        <div class="text-center">
                            <div class="text-3xl font-bold text-primary-600 mb-2">{{ $queuePosition }}</div>
                            <p class="text-sm text-gray-600 mb-4">Your position in queue</p>
                            
                            @if($aheadOfYou > 0)
                                <p class="text-sm text-gray-700">
                                    <span class="font-medium">{{ $aheadOfYou }}</span> 
                                    {{ Str::plural('person', $aheadOfYou) }} ahead of you
                                </p>
                            @else
                                <p class="text-sm text-green-600 font-medium">
                                    <i class="fas fa-star mr-1"></i>
                                    You're next in line!
                                </p>
                            @endif
                            
                            <p class="text-xs text-gray-500 mt-2">
                                Total in queue: {{ $totalInQueue }}
                            </p>
                        </div>
                        
                        @if(auth()->user()->isLibrarian())
                            <div class="mt-4 pt-4 border-t border-gray-200">
                                <a href="{{ route('reservations.queue', $reservation->book) }}" 
                                   class="inline-flex items-center px-3 py-2 border border-transparent text-sm font-medium rounded-lg text-white bg-purple-600 hover:bg-purple-700 w-full justify-center">
                                    <i class="fas fa-list mr-2"></i>
                                    View Full Queue
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            @endif

            <!-- Quick Actions -->
            @if($reservation->status === 'active' || auth()->user()->isLibrarian())
                <div class="bg-white shadow-lg rounded-xl border border-gray-100">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900 flex items-center">
                            <i class="fas fa-bolt mr-2 text-yellow-500"></i>
                            Quick Actions
                        </h3>
                    </div>
                    
                    <div class="p-6 space-y-3">
                        @if($reservation->status === 'active')
                            @if(auth()->user()->isLibrarian() && $reservation->book->available_copies > 0)
                                <form action="{{ route('reservations.fulfill', $reservation) }}" method="POST">
                                    @csrf
                                    <button type="submit" 
                                            class="w-full inline-flex items-center justify-center px-3 py-2 border border-transparent text-sm font-medium rounded-lg text-white bg-green-600 hover:bg-green-700"
                                            onclick="return confirm('Fulfill this reservation?')">
                                        <i class="fas fa-check-circle mr-2"></i>
                                        Fulfill Reservation
                                    </button>
                                </form>
                            @endif
                            
                            <form action="{{ route('reservations.cancel', $reservation) }}" method="POST">
                                @csrf
                                <button type="submit" 
                                        class="w-full inline-flex items-center justify-center px-3 py-2 border border-red-300 text-sm font-medium rounded-lg text-red-700 bg-white hover:bg-red-50"
                                        onclick="return confirm('Cancel this reservation?')">
                                    <i class="fas fa-times-circle mr-2"></i>
                                    Cancel Reservation
                                </button>
                            </form>
                        @endif
                        
                        <a href="{{ route('books.show', $reservation->book) }}" 
                           class="w-full inline-flex items-center justify-center px-3 py-2 border border-gray-300 text-sm font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50">
                            <i class="fas fa-book mr-2"></i>
                            View Book Details
                        </a>
                        
                        <a href="{{ route('reservations.index') }}" 
                           class="w-full inline-flex items-center justify-center px-3 py-2 border border-primary-300 text-sm font-medium rounded-lg text-primary-700 bg-primary-50 hover:bg-primary-100">
                            <i class="fas fa-list mr-2"></i>
                            All Reservations
                        </a>
                    </div>
                </div>
            @endif

            <!-- Related Information -->
            <div class="bg-gradient-to-br from-blue-50 to-indigo-100 rounded-xl p-6 border border-blue-200">
                <h4 class="text-sm font-medium text-blue-900 mb-3 flex items-center">
                    <i class="fas fa-lightbulb mr-2"></i>
                    Did you know?
                </h4>
                <div class="space-y-2 text-sm text-blue-800">
                    <p>• You can have up to 3 active reservations at once</p>
                    <p>• Reservations are fulfilled in order of creation</p>
                    <p>• You'll be notified when your book is available</p>
                    <p>• You have 7 days to collect once notified</p>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Auto-refresh page if reservation is active (to check for status updates)
@if($reservation->status === 'active')
    setTimeout(function() {
        // Only refresh if user is still on the page
        if (document.hasFocus()) {
            location.reload();
        }
    }, 300000); // Refresh every 5 minutes
@endif
</script>
@endsection