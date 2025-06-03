@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div>
        <nav class="flex" aria-label="Breadcrumb">
            <ol class="flex items-center space-x-2">
                <li><a href="{{ route('reservations.index') }}" class="text-gray-500 hover:text-gray-700">Reservations</a></li>
                <li><i class="fas fa-chevron-right text-gray-400 text-xs"></i></li>
                <li><a href="{{ route('reservations.show', $reservation) }}" class="text-gray-500 hover:text-gray-700">Reservation #{{ $reservation->id }}</a></li>
                <li><i class="fas fa-chevron-right text-gray-400 text-xs"></i></li>
                <li class="text-gray-900 font-medium">Edit Notes</li>
            </ol>
        </nav>
        <h1 class="mt-2 text-2xl font-bold text-gray-900">Edit Reservation Notes</h1>
        <p class="mt-1 text-sm text-gray-600">Update the notes for this reservation</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Edit Form -->
        <div class="lg:col-span-2">
            <div class="bg-white shadow-lg rounded-xl border border-gray-100">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900 flex items-center">
                        <i class="fas fa-edit mr-2 text-blue-500"></i>
                        Update Reservation Notes
                    </h3>
                </div>
                
                <form action="{{ route('reservations.update-notes', $reservation) }}" method="POST" class="p-6">
                    @csrf
                    @method('PATCH')
                    
                    <!-- Current Reservation Info -->
                    <div class="bg-gray-50 border border-gray-200 rounded-lg p-4 mb-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 mr-4">
                                @if($reservation->book->cover_image)
                                    <img src="{{ Storage::url($reservation->book->cover_image) }}" alt="{{ $reservation->book->title }}" 
                                         class="w-12 h-16 rounded object-cover">
                                @else
                                    <div class="w-12 h-16 bg-gray-200 rounded flex items-center justify-center">
                                        <i class="fas fa-book text-gray-400"></i>
                                    </div>
                                @endif
                            </div>
                            <div class="flex-1">
                                <h4 class="text-lg font-medium text-gray-900">{{ $reservation->book->title }}</h4>
                                <p class="text-sm text-gray-600">by {{ $reservation->book->author->name }}</p>
                                <div class="mt-1 flex items-center space-x-3 text-sm">
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium 
                                        {{ $reservation->status === 'active' ? 'bg-green-100 text-green-800' : 
                                           ($reservation->status === 'fulfilled' ? 'bg-blue-100 text-blue-800' : 'bg-gray-100 text-gray-800') }}">
                                        {{ ucfirst($reservation->status) }}
                                    </span>
                                    <span class="text-gray-500">Reserved: {{ $reservation->reserved_date->format('M j, Y') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Notes Field -->
                    <div>
                        <label for="notes" class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-sticky-note mr-1 text-yellow-500"></i>
                            Reservation Notes
                        </label>
                        <textarea name="notes" id="notes" rows="6" 
                                  class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-primary-500 focus:border-primary-500 sm:text-sm @error('notes') border-red-300 @enderror"
                                  placeholder="Add any special requests, reminders, or notes about this reservation...">{{ old('notes', $reservation->notes) }}</textarea>
                        @error('notes')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        <div class="mt-1 flex items-center justify-between">
                            <p class="text-sm text-gray-500">Maximum 500 characters</p>
                            <span id="character-count" class="text-sm text-gray-500">0/500</span>
                        </div>
                    </div>

                    <!-- Restrictions Notice -->
                    @if($reservation->status !== 'active')
                        <div class="mt-4 bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <i class="fas fa-info-circle text-yellow-400"></i>
                                </div>
                                <div class="ml-3">
                                    <h4 class="text-sm font-medium text-yellow-800">Note</h4>
                                    <div class="mt-1 text-sm text-yellow-700">
                                        <p>This reservation is {{ $reservation->status }}. Only notes can be modified.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- Action Buttons -->
                    <div class="flex items-center justify-end space-x-4 pt-6 mt-6 border-t border-gray-200">
                        <a href="{{ route('reservations.show', $reservation) }}" 
                           class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 shadow-sm transition-all duration-200">
                            <i class="fas fa-times mr-2"></i>Cancel
                        </a>
                        <button type="submit" 
                                class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-lg text-white bg-primary-600 hover:bg-primary-700 shadow-sm transition-all duration-200">
                            <i class="fas fa-save mr-2"></i>Update Notes
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="lg:col-span-1 space-y-6">
            <!-- Reservation Summary -->
            <div class="bg-white shadow-lg rounded-xl border border-gray-100">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900 flex items-center">
                        <i class="fas fa-info-circle mr-2 text-blue-500"></i>
                        Reservation Summary
                    </h3>
                </div>
                
                <div class="p-6 space-y-3 text-sm">
                    <div class="flex justify-between">
                        <span class="text-gray-500">Reservation ID:</span>
                        <span class="font-mono">#{{ $reservation->id }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-500">Status:</span>
                        <span class="font-medium capitalize {{ $reservation->status === 'active' ? 'text-green-600' : 'text-gray-600' }}">
                            {{ $reservation->status }}
                        </span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-500">Reserved:</span>
                        <span>{{ $reservation->reserved_date->format('M j, Y') }}</span>
                    </div>
                    @if($reservation->status === 'active')
                        <div class="flex justify-between">
                            <span class="text-gray-500">Expires:</span>
                            <span class="{{ $reservation->isExpired() ? 'text-red-600 font-medium' : '' }}">
                                {{ $reservation->expiry_date->format('M j, Y') }}
                            </span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-500">Queue Position:</span>
                            <span class="font-medium">#{{ $reservation->book->activeReservations()->where('created_at', '<', $reservation->created_at)->count() + 1 }}</span>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Notes Guidelines -->
            <div class="bg-white shadow-lg rounded-xl border border-gray-100">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900 flex items-center">
                        <i class="fas fa-lightbulb mr-2 text-yellow-500"></i>
                        Notes Guidelines
                    </h3>
                </div>
                
                <div class="p-6">
                    <div class="space-y-3 text-sm text-gray-700">
                        <div class="flex items-start">
                            <i class="fas fa-check text-green-500 mr-2 mt-1 text-xs"></i>
                            <span>Mention any special collection preferences</span>
                        </div>
                        <div class="flex items-start">
                            <i class="fas fa-check text-green-500 mr-2 mt-1 text-xs"></i>
                            <span>Note if you need the book for a specific date</span>
                        </div>
                        <div class="flex items-start">
                            <i class="fas fa-check text-green-500 mr-2 mt-1 text-xs"></i>
                            <span>Add contact preferences for notifications</span>
                        </div>
                        <div class="flex items-start">
                            <i class="fas fa-check text-green-500 mr-2 mt-1 text-xs"></i>
                            <span>Mention if it's for research or study</span>
                        </div>
                    </div>
                    
                    <div class="mt-4 p-3 bg-blue-50 border border-blue-200 rounded-lg">
                        <p class="text-sm text-blue-800">
                            <i class="fas fa-info-circle mr-1"></i>
                            <strong>Tip:</strong> Clear notes help librarians provide better service!
                        </p>
                    </div>
                </div>
            </div>

            <!-- Current Notes -->
            @if($reservation->notes)
                <div class="bg-white shadow-lg rounded-xl border border-gray-100">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900 flex items-center">
                            <i class="fas fa-file-alt mr-2 text-gray-500"></i>
                            Current Notes
                        </h3>
                    </div>
                    
                    <div class="p-6">
                        <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-3">
                            <p class="text-sm text-gray-800">{{ $reservation->notes }}</p>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

<script>
// Character counter
document.getElementById('notes').addEventListener('input', function() {
    const maxLength = 500;
    const currentLength = this.value.length;
    const counter = document.getElementById('character-count');
    
    counter.textContent = `${currentLength}/${maxLength}`;
    counter.className = `text-sm ${currentLength > maxLength ? 'text-red-600' : 'text-gray-500'}`;
    
    if (currentLength > maxLength) {
        this.style.borderColor = '#ef4444';
    } else {
        this.style.borderColor = '';
    }
});

// Initialize character count on page load
document.addEventListener('DOMContentLoaded', function() {
    const notesField = document.getElementById('notes');
    if (notesField) {
        notesField.dispatchEvent(new Event('input'));
    }
});

// Prevent double submission
document.querySelector('form').addEventListener('submit', function(e) {
    const submitBtn = this.querySelector('button[type="submit"]');
    submitBtn.disabled = true;
    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Updating...';
});
</script>
@endsection