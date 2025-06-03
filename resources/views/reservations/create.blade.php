@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div>
        <nav class="flex" aria-label="Breadcrumb">
            <ol class="flex items-center space-x-2">
                <li><a href="{{ route('reservations.index') }}" class="text-gray-500 hover:text-gray-700">Reservations</a></li>
                <li><i class="fas fa-chevron-right text-gray-400 text-xs"></i></li>
                <li class="text-gray-900 font-medium">Create Reservation</li>
            </ol>
        </nav>
        <h1 class="mt-2 text-2xl font-bold text-gray-900">Reserve a Book</h1>
        <p class="mt-1 text-sm text-gray-600">Reserve a book that's currently unavailable for borrowing</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Reservation Form -->
        <div class="lg:col-span-2">
            <div class="bg-white shadow-lg rounded-xl border border-gray-100">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900 flex items-center">
                        <i class="fas fa-bookmark mr-2 text-primary-500"></i>
                        Book Reservation
                    </h3>
                </div>
                
                <form action="{{ route('reservations.store') }}" method="POST" class="p-6 space-y-6">
                    @csrf
                    
                    <!-- Pre-selected Book -->
                    @if($book)
                        <input type="hidden" name="book_id" value="{{ $book->id }}">
                        
                        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 mr-4">
                                    @if($book->cover_image)
                                        <img src="{{ Storage::url($book->cover_image) }}" alt="{{ $book->title }}" 
                                             class="w-16 h-20 rounded object-cover">
                                    @else
                                        <div class="w-16 h-20 bg-gray-200 rounded flex items-center justify-center">
                                            <i class="fas fa-book text-gray-400 text-xl"></i>
                                        </div>
                                    @endif
                                </div>
                                <div class="flex-1">
                                    <h4 class="text-lg font-medium text-gray-900">{{ $book->title }}</h4>
                                    <p class="text-sm text-gray-600">by {{ $book->author->name }}</p>
                                    <div class="mt-2 flex items-center space-x-4 text-sm">
                                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium"
                                              style="background-color: {{ $book->category->color }}20; color: {{ $book->category->color }}">
                                            <i class="fas fa-tag mr-1"></i>{{ $book->category->name }}
                                        </span>
                                        <span class="text-red-600 font-medium">
                                            <i class="fas fa-exclamation-circle mr-1"></i>
                                            All {{ $book->total_copies }} copies borrowed
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @else
                        <!-- Book Selection -->
                        <div>
                            <label for="book_id" class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fas fa-book mr-1 text-blue-500"></i>Select Book to Reserve *
                            </label>
                            <select name="book_id" id="book_id" required
                                    class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-primary-500 focus:border-primary-500 sm:text-sm @error('book_id') border-red-300 @enderror">
                                <option value="">Choose a book that's currently unavailable...</option>
                                @foreach($books as $availableBook)
                                    <option value="{{ $availableBook->id }}" {{ old('book_id') == $availableBook->id ? 'selected' : '' }}>
                                        {{ $availableBook->title }} by {{ $availableBook->author->name }} 
                                        ({{ $availableBook->total_copies }} copies - All borrowed)
                                    </option>
                                @endforeach
                            </select>
                            @error('book_id')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                            
                            @if($books->isEmpty())
                                <div class="mt-2 p-4 bg-green-50 border border-green-200 rounded-lg">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0">
                                            <i class="fas fa-check-circle text-green-400"></i>
                                        </div>
                                        <div class="ml-3">
                                            <h4 class="text-sm font-medium text-green-800">Great news!</h4>
                                            <div class="mt-1 text-sm text-green-700">
                                                <p>All books currently have available copies for immediate borrowing. No reservations needed!</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mt-4">
                                        <a href="{{ route('books.index') }}" 
                                           class="inline-flex items-center px-3 py-2 border border-transparent text-sm font-medium rounded-lg text-white bg-green-600 hover:bg-green-700">
                                            <i class="fas fa-search mr-2"></i>
                                            Browse Available Books
                                        </a>
                                    </div>
                                </div>
                            @endif
                        </div>
                    @endif

                    <!-- Notes -->
                    <div>
                        <label for="notes" class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-sticky-note mr-1 text-yellow-500"></i>Additional Notes (Optional)
                        </label>
                        <textarea name="notes" id="notes" rows="3" 
                                  class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-primary-500 focus:border-primary-500 sm:text-sm @error('notes') border-red-300 @enderror"
                                  placeholder="Any special requests or notes about this reservation...">{{ old('notes') }}</textarea>
                        @error('notes')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        <p class="mt-1 text-sm text-gray-500">Maximum 500 characters</p>
                    </div>

                    <!-- Reservation Terms -->
                    <div class="bg-gray-50 border border-gray-200 rounded-lg p-4">
                        <h4 class="text-sm font-medium text-gray-900 mb-3 flex items-center">
                            <i class="fas fa-info-circle mr-2 text-blue-500"></i>
                            Reservation Terms
                        </h4>
                        <ul class="text-sm text-gray-700 space-y-2">
                            <li class="flex items-start">
                                <i class="fas fa-clock text-blue-500 mr-2 mt-0.5 text-xs"></i>
                                <span>You will be notified when the book becomes available</span>
                            </li>
                            <li class="flex items-start">
                                <i class="fas fa-calendar-check text-green-500 mr-2 mt-0.5 text-xs"></i>
                                <span>You have <strong>7 days</strong> to collect the book once notified</span>
                            </li>
                            <li class="flex items-start">
                                <i class="fas fa-list-ol text-purple-500 mr-2 mt-0.5 text-xs"></i>
                                <span>Reservations are fulfilled on a first-come, first-served basis</span>
                            </li>
                            <li class="flex items-start">
                                <i class="fas fa-ban text-red-500 mr-2 mt-0.5 text-xs"></i>
                                <span>Expired reservations will be automatically cancelled</span>
                            </li>
                        </ul>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex items-center justify-end space-x-4 pt-6 border-t border-gray-200">
                        <a href="{{ route('reservations.index') }}" 
                           class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 shadow-sm transition-all duration-200">
                            <i class="fas fa-times mr-2"></i>Cancel
                        </a>
                        <button type="submit" 
                                class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-lg text-white bg-primary-600 hover:bg-primary-700 shadow-sm transition-all duration-200"
                                @if($books->isEmpty() && !$book) disabled @endif>
                            <i class="fas fa-bookmark mr-2"></i>
                            Create Reservation
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="lg:col-span-1 space-y-6">
            <!-- Current User Reservations -->
            <div class="bg-white shadow-lg rounded-xl border border-gray-100">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900 flex items-center">
                        <i class="fas fa-user mr-2 text-blue-500"></i>
                        My Active Reservations
                    </h3>
                </div>
                <div class="p-6">
                    @php
                        $userReservations = auth()->user()->activeReservations()->with(['book.author'])->get();
                    @endphp
                    
                    @if($userReservations->count() > 0)
                        <div class="space-y-3">
                            @foreach($userReservations as $reservation)
                                <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                                    <div class="flex-1 min-w-0">
                                        <p class="text-sm font-medium text-gray-900 truncate">
                                            {{ $reservation->book->title }}
                                        </p>
                                        <p class="text-xs text-gray-500">
                                            by {{ $reservation->book->author->name }}
                                        </p>
                                        <p class="text-xs text-blue-600 mt-1">
                                            <i class="fas fa-clock mr-1"></i>
                                            {{ $reservation->daysUntilExpiry() }} days left
                                        </p>
                                    </div>
                                    <a href="{{ route('reservations.show', $reservation) }}" 
                                       class="text-primary-600 hover:text-primary-900 ml-2">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </div>
                            @endforeach
                        </div>
                        
                        <div class="mt-4 pt-4 border-t border-gray-200">
                            <p class="text-sm text-gray-600">
                                You have <strong>{{ $userReservations->count() }}</strong> of 
                                <strong>3</strong> maximum reservations
                            </p>
                            @if($userReservations->count() >= 3)
                                <p class="text-sm text-red-600 mt-1">
                                    <i class="fas fa-exclamation-triangle mr-1"></i>
                                    You've reached your reservation limit
                                </p>
                            @endif
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="fas fa-bookmark text-gray-300 text-2xl mb-2"></i>
                            <p class="text-sm text-gray-500">No active reservations</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- How Reservations Work -->
            <div class="bg-white shadow-lg rounded-xl border border-gray-100">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900 flex items-center">
                        <i class="fas fa-question-circle mr-2 text-green-500"></i>
                        How It Works
                    </h3>
                </div>
                <div class="p-6">
                    <div class="space-y-4">
                        <div class="flex items-start">
                            <div class="flex-shrink-0">
                                <div class="flex items-center justify-center w-8 h-8 bg-blue-100 rounded-full">
                                    <span class="text-sm font-medium text-blue-600">1</span>
                                </div>
                            </div>
                            <div class="ml-3">
                                <h4 class="text-sm font-medium text-gray-900">Reserve</h4>
                                <p class="text-sm text-gray-600">Choose a book that's currently unavailable</p>
                            </div>
                        </div>
                        
                        <div class="flex items-start">
                            <div class="flex-shrink-0">
                                <div class="flex items-center justify-center w-8 h-8 bg-blue-100 rounded-full">
                                    <span class="text-sm font-medium text-blue-600">2</span>
                                </div>
                            </div>
                            <div class="ml-3">
                                <h4 class="text-sm font-medium text-gray-900">Wait</h4>
                                <p class="text-sm text-gray-600">You'll be added to the reservation queue</p>
                            </div>
                        </div>
                        
                        <div class="flex items-start">
                            <div class="flex-shrink-0">
                                <div class="flex items-center justify-center w-8 h-8 bg-blue-100 rounded-full">
                                    <span class="text-sm font-medium text-blue-600">3</span>
                                </div>
                            </div>
                            <div class="ml-3">
                                <h4 class="text-sm font-medium text-gray-900">Notification</h4>
                                <p class="text-sm text-gray-600">We'll notify you when it's available</p>
                            </div>
                        </div>
                        
                        <div class="flex items-start">
                            <div class="flex-shrink-0">
                                <div class="flex items-center justify-center w-8 h-8 bg-blue-100 rounded-full">
                                    <span class="text-sm font-medium text-blue-600">4</span>
                                </div>
                            </div>
                            <div class="ml-3">
                                <h4 class="text-sm font-medium text-gray-900">Collect</h4>
                                <p class="text-sm text-gray-600">Pick up your book within 7 days</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Popular Reserved Books -->
            <div class="bg-white shadow-lg rounded-xl border border-gray-100">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900 flex items-center">
                        <i class="fas fa-fire mr-2 text-red-500"></i>
                        Popular Reserved Books
                    </h3>
                </div>
                <div class="p-6">
                    @php
                        $popularBooks = \App\Models\Book::withCount('activeReservations')
                            ->where('available_copies', 0)
                            ->orderBy('active_reservations_count', 'desc')
                            ->take(5)
                            ->get();
                    @endphp
                    
                    @if($popularBooks->count() > 0)
                        <div class="space-y-3">
                            @foreach($popularBooks as $popularBook)
                                <div class="flex items-center justify-between">
                                    <div class="flex-1 min-w-0">
                                        <p class="text-sm font-medium text-gray-900 truncate">
                                            {{ $popularBook->title }}
                                        </p>
                                        <p class="text-xs text-gray-500">
                                            {{ $popularBook->active_reservations_count }} 
                                            {{ Str::plural('reservation', $popularBook->active_reservations_count) }}
                                        </p>
                                    </div>
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                        <i class="fas fa-flame mr-1"></i>Hot
                                    </span>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="fas fa-check-circle text-green-400 text-2xl mb-2"></i>
                            <p class="text-sm text-gray-500">All books are available!</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Real-time character count for notes
document.getElementById('notes').addEventListener('input', function() {
    const maxLength = 500;
    const currentLength = this.value.length;
    const remaining = maxLength - currentLength;
    
    // Find or create character counter
    let counter = document.getElementById('notes-counter');
    if (!counter) {
        counter = document.createElement('p');
        counter.id = 'notes-counter';
        counter.className = 'mt-1 text-sm text-right';
        this.parentNode.appendChild(counter);
    }
    
    counter.textContent = `${currentLength}/${maxLength} characters`;
    counter.className = `mt-1 text-sm text-right ${remaining < 50 ? 'text-red-600' : 'text-gray-500'}`;
});

// Enhanced book selection with search
document.addEventListener('DOMContentLoaded', function() {
    const bookSelect = document.getElementById('book_id');
    if (bookSelect) {
        // Add search functionality if there are many books
        const options = Array.from(bookSelect.options);
        if (options.length > 10) {
            // Convert to searchable select (you could integrate with a library like Select2 here)
            bookSelect.addEventListener('keyup', function(e) {
                const searchTerm = e.target.value.toLowerCase();
                options.forEach(option => {
                    if (option.textContent.toLowerCase().includes(searchTerm) || option.value === '') {
                        option.style.display = '';
                    } else {
                        option.style.display = 'none';
                    }
                });
            });
        }
    }
});

// Prevent double submission
document.querySelector('form').addEventListener('submit', function(e) {
    const submitBtn = this.querySelector('button[type="submit"]');
    submitBtn.disabled = true;
    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Creating Reservation...';
});
</script>
@endsection