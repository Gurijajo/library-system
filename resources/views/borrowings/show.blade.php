@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
        <div>
            <nav class="flex" aria-label="Breadcrumb">
                <ol class="flex items-center space-x-2">
                    <li><a href="{{ route('borrowings.index') }}" class="text-gray-500 hover:text-gray-700">Borrowings</a></li>
                    <li><i class="fas fa-chevron-right text-gray-400 text-xs"></i></li>
                    <li class="text-gray-900 font-medium">Borrowing #{{ $borrowing->id }}</li>
                </ol>
            </nav>
        </div>
        <div class="mt-4 sm:mt-0 flex space-x-3">
            @if(in_array($borrowing->status, ['borrowed', 'overdue']))
                <form action="{{ route('borrowings.return', $borrowing) }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" 
                            class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500"
                            onclick="return confirm('Mark this book as returned?')">
                        <i class="fas fa-undo mr-2"></i>
                        Return Book
                    </button>
                </form>
            @endif

            @if($borrowing->fine_amount > 0 && !$borrowing->fine_paid)
                <form action="{{ route('borrowings.pay-fine', $borrowing) }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" 
                            class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-yellow-600 hover:bg-yellow-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500"
                            onclick="return confirm('Mark fine as paid?')">
                        <i class="fas fa-dollar-sign mr-2"></i>
                        Mark Fine Paid
                    </button>
                </form>
            @endif
        </div>
    </div>

    <!-- Main Content -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Book and Member Info -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Borrowing Status Card -->
            <div class="bg-white shadow rounded-lg">
                <div class="px-6 py-4 border-b border-gray-200">
                    <div class="flex items-center justify-between">
                        <h2 class="text-lg font-medium text-gray-900">Borrowing Details</h2>
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium 
                            {{ $borrowing->status === 'returned' ? 'bg-green-100 text-green-800' : 
                               ($borrowing->status === 'overdue' ? 'bg-red-100 text-red-800' : 'bg-blue-100 text-blue-800') }}">
                            {{ ucfirst($borrowing->status) }}
                        </span>
                    </div>
                </div>
                
                <div class="p-6">
                    <dl class="grid grid-cols-1 gap-x-4 gap-y-6 sm:grid-cols-2">
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Borrowing ID</dt>
                            <dd class="mt-1 text-sm text-gray-900 font-mono">#{{ $borrowing->id }}</dd>
                        </div>

                        <div>
                            <dt class="text-sm font-medium text-gray-500">Status</dt>
                            <dd class="mt-1">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                    {{ $borrowing->status === 'returned' ? 'bg-green-100 text-green-800' : 
                                       ($borrowing->status === 'overdue' ? 'bg-red-100 text-red-800' : 'bg-blue-100 text-blue-800') }}">
                                    {{ ucfirst($borrowing->status) }}
                                </span>
                            </dd>
                        </div>

                        <div>
                            <dt class="text-sm font-medium text-gray-500">Borrowed Date</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $borrowing->borrowed_date->format('F j, Y') }}</dd>
                        </div>

                        <div>
                            <dt class="text-sm font-medium text-gray-500">Due Date</dt>
                            <dd class="mt-1 text-sm {{ $borrowing->due_date < now() && !$borrowing->returned_date ? 'text-red-600 font-medium' : 'text-gray-900' }}">
                                {{ $borrowing->due_date->format('F j, Y') }}
                                @if($borrowing->due_date < now() && !$borrowing->returned_date)
                                    ({{ $borrowing->due_date->diffInDays(now()) }} days overdue)
                                @endif
                            </dd>
                        </div>

                        @if($borrowing->returned_date)
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Returned Date</dt>
                                <dd class="mt-1 text-sm text-green-600 font-medium">{{ $borrowing->returned_date->format('F j, Y') }}</dd>
                            </div>

                            <div>
                                <dt class="text-sm font-medium text-gray-500">Loan Duration</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $borrowing->borrowed_date->diffInDays($borrowing->returned_date) }} days</dd>
                            </div>
                        @endif

                        <div>
                            <dt class="text-sm font-medium text-gray-500">Issued By</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $borrowing->issuedBy->name }}</dd>
                        </div>

                        @if($borrowing->returnedTo)
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Returned To</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $borrowing->returnedTo->name }}</dd>
                            </div>
                        @endif
                    </dl>

                    @if($borrowing->notes)
                        <div class="mt-6 pt-6 border-t border-gray-200">
                            <dt class="text-sm font-medium text-gray-500 mb-2">Notes</dt>
                            <dd class="text-sm text-gray-900">{{ $borrowing->notes }}</dd>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Fine Information -->
            @if($borrowing->fine_amount > 0)
                <div class="bg-white shadow rounded-lg">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900">Fine Information</h3>
                    </div>
                    
                    <div class="p-6">
                        <div class="bg-red-50 border border-red-200 rounded-lg p-4">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <i class="fas fa-exclamation-triangle text-red-400 text-xl"></i>
                                </div>
                                <div class="ml-3 flex-1">
                                    <h4 class="text-sm font-medium text-red-800">
                                        Fine Amount: ${{ number_format($borrowing->fine_amount, 2) }}
                                    </h4>
                                    <div class="mt-2 text-sm text-red-700">
                                        <p>Status: {{ $borrowing->fine_paid ? 'Paid' : 'Unpaid' }}</p>
                                        @if($borrowing->isOverdue())
                                            <p>Reason: Book returned {{ $borrowing->due_date->diffInDays($borrowing->returned_date ?? now()) }} days late</p>
                                            <p>Rate: $1.00 per day</p>
                                        @endif
                                    </div>
                                </div>
                                @if(!$borrowing->fine_paid)
                                    <div class="ml-4">
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                            Unpaid
                                        </span>
                                    </div>
                                @else
                                    <div class="ml-4">
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                            Paid
                                        </span>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>

        <!-- Book and Member Cards -->
        <div class="space-y-6">
            <!-- Book Card -->
            <div class="bg-white shadow rounded-lg">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">Book Details</h3>
                </div>
                
                <div class="p-6">
                    <div class="flex">
                        <div class="flex-shrink-0 mr-4">
                            @if($borrowing->book->cover_image)
                                <img src="{{ Storage::url($borrowing->book->cover_image) }}" alt="{{ $borrowing->book->title }}" 
                                     class="w-20 h-28 rounded object-cover">
                            @else
                                <div class="w-20 h-28 bg-gray-200 rounded flex items-center justify-center">
                                    <i class="fas fa-book text-gray-400 text-xl"></i>
                                </div>
                            @endif
                        </div>
                        
                        <div class="flex-1">
                            <h4 class="text-sm font-medium text-gray-900 mb-2">{{ $borrowing->book->title }}</h4>
                            <dl class="text-sm space-y-1">
                                <div>
                                    <dt class="inline text-gray-500">Author:</dt>
                                    <dd class="inline text-gray-900 ml-1">{{ $borrowing->book->author->name }}</dd>
                                </div>
                                <div>
                                    <dt class="inline text-gray-500">ISBN:</dt>
                                    <dd class="inline text-gray-900 ml-1 font-mono text-xs">{{ $borrowing->book->isbn }}</dd>
                                </div>
                                <div>
                                    <dt class="inline text-gray-500">Category:</dt>
                                    <dd class="inline ml-1">
                                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium" 
                                              style="background-color: {{ $borrowing->book->category->color }}20; color: {{ $borrowing->book->category->color }}">
                                            {{ $borrowing->book->category->name }}
                                        </span>
                                    </dd>
                                </div>
                            </dl>
                            
                            <div class="mt-4">
                                <a href="{{ route('books.show', $borrowing->book) }}" 
                                   class="text-primary-600 hover:text-primary-900 text-sm font-medium">
                                    View Book Details <i class="fas fa-arrow-right ml-1"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Member Card -->
            <div class="bg-white shadow rounded-lg">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">Member Details</h3>
                </div>
                
                <div class="p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 mr-4">
                            @if($borrowing->user->avatar)
                                <img src="{{ Storage::url($borrowing->user->avatar) }}" alt="{{ $borrowing->user->name }}" 
                                     class="w-12 h-12 rounded-full object-cover">
                            @else
                                <div class="w-12 h-12 bg-primary-500 rounded-full flex items-center justify-center">
                                    <span class="text-white font-medium">{{ substr($borrowing->user->name, 0, 1) }}</span>
                                </div>
                            @endif
                        </div>
                        
                        <div class="flex-1">
                            <h4 class="text-sm font-medium text-gray-900">{{ $borrowing->user->name }}</h4>
                            <dl class="text-sm space-y-1">
                                <div>
                                    <dt class="inline text-gray-500">Email:</dt>
                                    <dd class="inline text-gray-900 ml-1">{{ $borrowing->user->email }}</dd>
                                </div>
                                <div>
                                    <dt class="inline text-gray-500">Member ID:</dt>
                                    <dd class="inline text-gray-900 ml-1 font-mono">{{ $borrowing->user->membership_id }}</dd>
                                </div>
                                <div>
                                    <dt class="inline text-gray-500">Status:</dt>
                                    <dd class="inline ml-1">
                                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium 
                                            {{ $borrowing->user->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                            {{ ucfirst($borrowing->user->status) }}
                                        </span>
                                    </dd>
                                </div>
                            </dl>
                            
                            <div class="mt-4">
                                <a href="{{ route('users.show', $borrowing->user) }}" 
                                   class="text-primary-600 hover:text-primary-900 text-sm font-medium">
                                    View Member Profile <i class="fas fa-arrow-right ml-1"></i>
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Member Stats -->
                    <div class="mt-6 pt-4 border-t border-gray-200">
                        <dl class="grid grid-cols-2 gap-4 text-sm">
                            <div class="text-center">
                                <dt class="text-gray-500">Current Borrowings</dt>
                                <dd class="text-lg font-medium text-gray-900">{{ $borrowing->user->currentBorrowings()->count() }}</dd>
                            </div>
                            <div class="text-center">
                                <dt class="text-gray-500">Total Fines</dt>
                                <dd class="text-lg font-medium {{ $borrowing->user->totalFines() > 0 ? 'text-red-600' : 'text-green-600' }}">
                                    ${{ number_format($borrowing->user->totalFines(), 2) }}
                                </dd>
                            </div>
                        </dl>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection