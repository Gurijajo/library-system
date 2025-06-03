@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="bg-white overflow-hidden shadow rounded-lg">
        <div class="px-4 py-5 sm:p-6">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">My Library</h1>
                    <p class="mt-1 text-sm text-gray-600">Welcome back, {{ auth()->user()->name }}!</p>
                </div>
                <div class="text-right">
                    <p class="text-sm text-gray-500">Member ID: {{ auth()->user()->membership_id }}</p>
                    <p class="text-xs text-gray-400">Expires: {{ auth()->user()->membership_expiry?->format('M j, Y') }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- User Statistics -->
    <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-5">
        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-blue-500 rounded-md flex items-center justify-center">
                            <i class="fas fa-book text-white text-sm"></i>
                        </div>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Currently Borrowed</dt>
                            <dd class="text-lg font-medium text-gray-900">{{ $userStats['books_borrowed'] }}</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-green-500 rounded-md flex items-center justify-center">
                            <i class="fas fa-history text-white text-sm"></i>
                        </div>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Total Borrowed</dt>
                            <dd class="text-lg font-medium text-gray-900">{{ $userStats['total_borrowed'] }}</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-purple-500 rounded-md flex items-center justify-center">
                            <i class="fas fa-bookmark text-white text-sm"></i>
                        </div>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Reservations</dt>
                            <dd class="text-lg font-medium text-gray-900">{{ $userStats['active_reservations'] }}</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-red-500 rounded-md flex items-center justify-center">
                            <i class="fas fa-exclamation-triangle text-white text-sm"></i>
                        </div>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Overdue</dt>
                            <dd class="text-lg font-medium text-gray-900">{{ $userStats['overdue_books'] }}</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-yellow-500 rounded-md flex items-center justify-center">
                            <i class="fas fa-dollar-sign text-white text-sm"></i>
                        </div>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Outstanding Fines</dt>
                            <dd class="text-lg font-medium text-gray-900">${{ number_format($userStats['total_fines'], 2) }}</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Current Borrowings and Reservations -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Current Borrowings -->
        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="px-4 py-5 sm:p-6">
                <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">Currently Borrowed Books</h3>
                <div class="space-y-4">
                    @forelse($currentBorrowings as $borrowing)
                        <div class="border rounded-lg p-4">
                            <div class="flex items-start justify-between">
                                <div class="flex-1">
                                    <h4 class="text-sm font-medium text-gray-900">{{ $borrowing->book->title }}</h4>
                                    <p class="text-sm text-gray-500">by {{ $borrowing->book->author->name }}</p>
                                    <div class="mt-2 flex items-center space-x-4 text-xs text-gray-500">
                                        <span><i class="fas fa-calendar mr-1"></i>Borrowed: {{ $borrowing->borrowed_date->format('M j, Y') }}</span>
                                        <span class="flex items-center {{ $borrowing->due_date < now() ? 'text-red-600' : '' }}">
                                            <i class="fas fa-clock mr-1"></i>Due: {{ $borrowing->due_date->format('M j, Y') }}
                                        </span>
                                    </div>
                                </div>
                                <div class="ml-4">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                        {{ $borrowing->status === 'overdue' ? 'bg-red-100 text-red-800' : 'bg-green-100 text-green-800' }}">
                                        {{ ucfirst($borrowing->status) }}
                                    </span>
                                </div>
                            </div>
                            @if($borrowing->fine_amount > 0)
                                <div class="mt-2 text-sm text-red-600">
                                    Fine: ${{ number_format($borrowing->fine_amount, 2) }}
                                    @if(!$borrowing->fine_paid)
                                        (Unpaid)
                                    @endif
                                </div>
                            @endif
                        </div>
                    @empty
                        <div class="text-center py-8">
                            <i class="fas fa-book text-gray-300 text-4xl mb-2"></i>
                            <p class="text-gray-500">No books currently borrowed</p>
                            <a href="{{ route('books.index') }}" class="mt-2 text-primary-600 hover:text-primary-900 text-sm font-medium">Browse Books</a>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Active Reservations -->
        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="px-4 py-5 sm:p-6">
                <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">Active Reservations</h3>
                <div class="space-y-4">
                    @forelse($reservations as $reservation)
                        <div class="border rounded-lg p-4">
                            <div class="flex items-start justify-between">
                                <div class="flex-1">
                                    <h4 class="text-sm font-medium text-gray-900">{{ $reservation->book->title }}</h4>
                                    <p class="text-sm text-gray-500">by {{ $reservation->book->author->name }}</p>
                                    <div class="mt-2 flex items-center space-x-4 text-xs text-gray-500">
                                        <span><i class="fas fa-calendar mr-1"></i>Reserved: {{ $reservation->reserved_date->format('M j, Y') }}</span>
                                        <span><i class="fas fa-clock mr-1"></i>Expires: {{ $reservation->expiry_date->format('M j, Y') }}</span>
                                    </div>
                                </div>
                                <div class="ml-4">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                                        {{ ucfirst($reservation->status) }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-8">
                            <i class="fas fa-bookmark text-gray-300 text-4xl mb-2"></i>
                            <p class="text-gray-500">No active reservations</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <!-- Recommended Books -->
    <div class="bg-white overflow-hidden shadow rounded-lg">
        <div class="px-4 py-5 sm:p-6">
            <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">Recommended for You</h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                @forelse($recommendedBooks as $book)
                    <div class="border rounded-lg overflow-hidden hover:shadow-md transition-shadow">
                        <div class="aspect-w-3 aspect-h-4">
                            @if($book->cover_image)
                                <img src="{{ Storage::url($book->cover_image) }}" alt="{{ $book->title }}" class="w-full h-48 object-cover">
                            @else
                                <div class="w-full h-48 bg-gray-200 flex items-center justify-center">
                                    <i class="fas fa-book text-gray-400 text-2xl"></i>
                                </div>
                            @endif
                        </div>
                        <div class="p-4">
                            <h4 class="text-sm font-medium text-gray-900 truncate">{{ $book->title }}</h4>
                            <p class="text-sm text-gray-500">{{ $book->author->name }}</p>
                            <div class="mt-2 flex items-center justify-between">
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium" 
                                      style="background-color: {{ $book->category->color }}20; color: {{ $book->category->color }}">
                                    {{ $book->category->name }}
                                </span>
                                <a href="{{ route('books.show', $book) }}" class="text-primary-600 hover:text-primary-900 text-sm font-medium">
                                    View Details
                                </a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full text-center py-8">
                        <i class="fas fa-lightbulb text-gray-300 text-4xl mb-2"></i>
                        <p class="text-gray-500">No recommendations available</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Recent Borrowing History -->
    <div class="bg-white overflow-hidden shadow rounded-lg">
        <div class="px-4 py-5 sm:p-6">
            <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">Recent Borrowing History</h3>
            <div class="space-y-3">
                @forelse($borrowingHistory as $borrowing)
                    <div class="flex items-center justify-between py-2 border-b border-gray-100 last:border-0">
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-gray-900 truncate">{{ $borrowing->book->title }}</p>
                            <p class="text-sm text-gray-500">{{ $borrowing->book->author->name }} • {{ $borrowing->created_at->format('M j, Y') }}</p>
                        </div>
                        <div class="ml-4 flex-shrink-0">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                {{ $borrowing->status === 'returned' ? 'bg-green-100 text-green-800' : 
                                   ($borrowing->status === 'overdue' ? 'bg-red-100 text-red-800' : 'bg-blue-100 text-blue-800') }}">
                                {{ ucfirst($borrowing->status) }}
                            </span>
                        </div>
                    </div>
                @empty
                    <p class="text-gray-500 text-sm">No borrowing history yet.</p>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection