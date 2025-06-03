@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
        <div>
            <nav class="flex" aria-label="Breadcrumb">
                <ol class="flex items-center space-x-2">
                    <li><a href="{{ route('books.index') }}" class="text-gray-500 hover:text-gray-700">Books</a></li>
                    <li><i class="fas fa-chevron-right text-gray-400 text-xs"></i></li>
                    <li class="text-gray-900 font-medium">{{ $book->title }}</li>
                </ol>
            </nav>
        </div>
        @if(auth()->user()->isLibrarian())
            <div class="mt-4 sm:mt-0 flex space-x-3">
                <a href="{{ route('books.edit', $book) }}" 
                   class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                    <i class="fas fa-edit mr-2"></i>
                    Edit
                </a>
                
                @if($book->isAvailable())
                    <a href="{{ route('borrowings.create', ['book_id' => $book->id]) }}" 
                       class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                        <i class="fas fa-hand-holding mr-2"></i>
                        Issue Book
                    </a>
                @else
                    <a href="{{ route('reservations.create', ['book_id' => $book->id]) }}" 
                       class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-purple-600 hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500">
                        <i class="fas fa-bookmark mr-2"></i>
                        Add Reservation
                    </a>
                @endif
            </div>
        @endif
    </div>

    <!-- Main Content -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Book Cover and Basic Info -->
        <div class="lg:col-span-1">
            <div class="bg-white shadow rounded-lg overflow-hidden">
                <div class="aspect-w-3 aspect-h-4">
                    @if($book->cover_image)
                        <img src="{{ Storage::url($book->cover_image) }}" alt="{{ $book->title }}" 
                             class="w-full h-96 object-cover">
                    @else
                        <div class="w-full h-96 bg-gray-200 flex items-center justify-center">
                            <i class="fas fa-book text-gray-400 text-6xl"></i>
                        </div>
                    @endif
                </div>
                
                <div class="p-6">
                    <div class="space-y-4">
                        <div class="flex items-center justify-between">
                            <span class="text-sm font-medium text-gray-500">Availability</span>
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium {{ $book->available_copies > 0 ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ $book->available_copies }}/{{ $book->total_copies }} Available
                            </span>
                        </div>

                        <div class="flex items-center justify-between">
                            <span class="text-sm font-medium text-gray-500">Status</span>
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium 
                                {{ $book->status === 'active' ? 'bg-green-100 text-green-800' : 
                                   ($book->status === 'inactive' ? 'bg-red-100 text-red-800' : 'bg-yellow-100 text-yellow-800') }}">
                                {{ ucfirst($book->status) }}
                            </span>
                        </div>

                        <div class="flex items-center justify-between">
                            <span class="text-sm font-medium text-gray-500">Category</span>
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium" 
                                  style="background-color: {{ $book->category->color }}20; color: {{ $book->category->color }}">
                                {{ $book->category->name }}
                            </span>
                        </div>

                        @if($book->price)
                            <div class="flex items-center justify-between">
                                <span class="text-sm font-medium text-gray-500">Price</span>
                                <span class="text-sm font-medium text-gray-900">${{ number_format($book->price, 2) }}</span>
                            </div>
                        @endif
                    </div>

                    @if(!auth()->user()->isLibrarian() && $book->isAvailable())
                        <div class="mt-6 pt-6 border-t border-gray-200">
                            <p class="text-sm text-gray-600 mb-3">Want to borrow this book? Contact a librarian or visit the library.</p>
                            <div class="text-xs text-gray-500">
                                <p><i class="fas fa-clock mr-1"></i>Standard loan period: 14 days</p>
                                <p><i class="fas fa-dollar-sign mr-1"></i>Late fee: $1.00 per day</p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Book Details -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Main Details -->
            <div class="bg-white shadow rounded-lg">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h1 class="text-2xl font-bold text-gray-900">{{ $book->title }}</h1>
                    <p class="mt-1 text-lg text-gray-600">by <a href="{{ route('authors.show', $book->author) }}" class="text-primary-600 hover:text-primary-900">{{ $book->author->name }}</a></p>
                </div>
                
                <div class="p-6">
                    <dl class="grid grid-cols-1 gap-x-4 gap-y-6 sm:grid-cols-2">
                        <div>
                            <dt class="text-sm font-medium text-gray-500">ISBN</dt>
                            <dd class="mt-1 text-sm text-gray-900 font-mono">{{ $book->isbn }}</dd>
                        </div>

                        @if($book->publication_date)
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Publication Date</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $book->publication_date->format('F j, Y') }}</dd>
                            </div>
                        @endif

                        @if($book->publisher)
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Publisher</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $book->publisher }}</dd>
                            </div>
                        @endif

                        <div>
                            <dt class="text-sm font-medium text-gray-500">Language</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $book->language }}</dd>
                        </div>

                        @if($book->pages)
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Pages</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ number_format($book->pages) }}</dd>
                            </div>
                        @endif

                        <div>
                            <dt class="text-sm font-medium text-gray-500">Added to Library</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $book->created_at->format('F j, Y') }}</dd>
                        </div>
                    </dl>

                    @if($book->description)
                        <div class="mt-6">
                            <dt class="text-sm font-medium text-gray-500 mb-2">Description</dt>
                            <dd class="text-sm text-gray-900 leading-relaxed">{{ $book->description }}</dd>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Current Borrowings -->
            @if($book->currentBorrowings->count() > 0)
                <div class="bg-white shadow rounded-lg">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900">Current Borrowings</h3>
                    </div>
                    <div class="p-6">
                        <div class="space-y-4">
                            @foreach($book->currentBorrowings as $borrowing)
                                <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                                    <div>
                                        <p class="text-sm font-medium text-gray-900">{{ $borrowing->user->name }}</p>
                                        <p class="text-sm text-gray-500">
                                            Borrowed: {{ $borrowing->borrowed_date->format('M j, Y') }} • 
                                            Due: {{ $borrowing->due_date->format('M j, Y') }}
                                            @if($borrowing->isOverdue())
                                                <span class="text-red-600 font-medium">(Overdue)</span>
                                            @endif
                                        </p>
                                    </div>
                                    @if(auth()->user()->isLibrarian())
                                        <a href="{{ route('borrowings.show', $borrowing) }}" 
                                           class="text-primary-600 hover:text-primary-900 text-sm font-medium">
                                            View Details
                                        </a>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif

            <!-- Active Reservations -->
            @if($book->activeReservations->count() > 0)
                <div class="bg-white shadow rounded-lg">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900">Active Reservations</h3>
                    </div>
                    <div class="p-6">
                        <div class="space-y-4">
                            @foreach($book->activeReservations as $reservation)
                                <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                                    <div>
                                        <p class="text-sm font-medium text-gray-900">{{ $reservation->user->name }}</p>
                                        <p class="text-sm text-gray-500">
                                            Reserved: {{ $reservation->reserved_date->format('M j, Y') }} • 
                                            Expires: {{ $reservation->expiry_date->format('M j, Y') }}
                                        </p>
                                    </div>
                                    @if(auth()->user()->isLibrarian())
                                        <div class="flex space-x-2">
                                            @if($book->isAvailable())
                                                <form action="{{ route('reservations.fulfill', $reservation) }}" method="POST" class="inline">
                                                    @csrf
                                                    <button type="submit" class="text-green-600 hover:text-green-900 text-sm font-medium">
                                                        Fulfill
                                                    </button>
                                                </form>
                                            @endif
                                            <a href="{{ route('reservations.show', $reservation) }}" 
                                               class="text-primary-600 hover:text-primary-900 text-sm font-medium">
                                                View
                                            </a>
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection