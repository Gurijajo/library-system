@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
        <div>
            <nav class="flex" aria-label="Breadcrumb">
                <ol class="flex items-center space-x-2">
                    <li><a href="{{ route('users.index') }}" class="text-gray-500 hover:text-gray-700">Members</a></li>
                    <li><i class="fas fa-chevron-right text-gray-400 text-xs"></i></li>
                    <li class="text-gray-900 font-medium">{{ $user->name }}</li>
                </ol>
            </nav>
        </div>
        <div class="mt-4 sm:mt-0 flex space-x-3">
            <a href="{{ route('users.edit', $user) }}" 
               class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                <i class="fas fa-edit mr-2"></i>
                Edit Member
            </a>
            
            @if($user->canBorrowBooks())
                <a href="{{ route('borrowings.create', ['user_id' => $user->id]) }}" 
                   class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                    <i class="fas fa-hand-holding mr-2"></i>
                    Issue Book
                </a>
            @endif
        </div>
    </div>

    <!-- Member Profile -->
    <div class="bg-white shadow rounded-lg">
        <div class="px-6 py-8">
            <div class="flex flex-col md:flex-row">
                <!-- Member Photo -->
                <div class="flex-shrink-0 mb-6 md:mb-0 md:mr-8">
                    @if($user->avatar)
                        <img class="h-32 w-32 rounded-full object-cover mx-auto" src="{{ Storage::url($user->avatar) }}" alt="{{ $user->name }}">
                    @else
                        <div class="h-32 w-32 rounded-full bg-primary-500 flex items-center justify-center mx-auto">
                            <span class="text-white font-medium text-4xl">{{ substr($user->name, 0, 1) }}</span>
                        </div>
                    @endif
                </div>

                <!-- Member Details -->
                <div class="flex-1">
                    <div class="text-center md:text-left">
                        <h1 class="text-3xl font-bold text-gray-900">{{ $user->name }}</h1>
                        <p class="mt-1 text-lg text-gray-600">{{ $user->email }}</p>
                        <p class="mt-1 text-sm text-gray-500 font-mono">Member ID: {{ $user->membership_id }}</p>

                        <!-- Status Badges -->
                        <div class="mt-4 flex flex-wrap justify-center md:justify-start gap-2">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium 
                                {{ $user->role === 'admin' ? 'bg-purple-100 text-purple-800' : 
                                   ($user->role === 'librarian' ? 'bg-blue-100 text-blue-800' : 'bg-green-100 text-green-800') }}">
                                {{ ucfirst($user->role) }}
                            </span>
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium 
                                {{ $user->status === 'active' ? 'bg-green-100 text-green-800' : 
                                   ($user->status === 'suspended' ? 'bg-red-100 text-red-800' : 'bg-gray-100 text-gray-800') }}">
                                {{ ucfirst($user->status) }}
                            </span>
                        </div>

                        <!-- Member Info -->
                        <div class="mt-6 grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm">
                            @if($user->phone)
                                <div class="flex items-center justify-center md:justify-start text-gray-500">
                                    <i class="fas fa-phone mr-2"></i>
                                    <span>{{ $user->phone }}</span>
                                </div>
                            @endif

                            @if($user->date_of_birth)
                                <div class="flex items-center justify-center md:justify-start text-gray-500">
                                    <i class="fas fa-birthday-cake mr-2"></i>
                                    <span>{{ $user->date_of_birth->format('F j, Y') }}</span>
                                </div>
                            @endif

                            @if($user->membership_expiry)
                                <div class="flex items-center justify-center md:justify-start text-gray-500">
                                    <i class="fas fa-calendar-check mr-2"></i>
                                    <span>Expires: {{ $user->membership_expiry->format('F j, Y') }}</span>
                                </div>
                            @endif

                            <div class="flex items-center justify-center md:justify-start text-gray-500">
                                <i class="fas fa-user-plus mr-2"></i>
                                <span>Joined: {{ $user->created_at->format('F j, Y') }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            @if($user->address)
                <div class="mt-8 pt-8 border-t border-gray-200">
                    <h3 class="text-sm font-medium text-gray-500 mb-2">Address</h3>
                    <p class="text-gray-900">{{ $user->address }}</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
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
                            <dd class="text-lg font-medium text-gray-900">{{ $user->currentBorrowings->count() }}</dd>
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
                            <dd class="text-lg font-medium text-gray-900">{{ $user->borrowings->count() }}</dd>
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
                            <dt class="text-sm font-medium text-gray-500 truncate">Overdue Books</dt>
                            <dd class="text-lg font-medium text-gray-900">{{ $user->overdueBooks()->count() }}</dd>
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
                            <dd class="text-lg font-medium {{ $user->totalFines() > 0 ? 'text-red-600' : 'text-green-600' }}">
                                ${{ number_format($user->totalFines(), 2) }}
                            </dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Current Borrowings -->
    @if($user->currentBorrowings->count() > 0)
        <div class="bg-white shadow rounded-lg">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-medium text-gray-900">Currently Borrowed Books</h3>
            </div>
            <div class="p-6">
                <div class="space-y-4">
                    @foreach($user->currentBorrowings as $borrowing)
                        <div class="border rounded-lg p-4">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 mr-4">
                                        @if($borrowing->book->cover_image)
                                            <img src="{{ Storage::url($borrowing->book->cover_image) }}" alt="{{ $borrowing->book->title }}" 
                                                 class="w-12 h-16 rounded object-cover">
                                        @else
                                            <div class="w-12 h-16 bg-gray-200 rounded flex items-center justify-center">
                                                <i class="fas fa-book text-gray-400"></i>
                                            </div>
                                        @endif
                                    </div>
                                    <div>
                                        <h4 class="text-sm font-medium text-gray-900">{{ $borrowing->book->title }}</h4>
                                        <p class="text-sm text-gray-500">by {{ $borrowing->book->author->name }}</p>
                                        <div class="mt-1 text-xs text-gray-500">
                                            <span>Due: {{ $borrowing->due_date->format('M j, Y') }}</span>
                                            @if($borrowing->isOverdue())
                                                <span class="text-red-600 font-medium ml-2">({{ $borrowing->due_date->diffInDays(now()) }} days overdue)</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="flex items-center space-x-2">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                        {{ $borrowing->status === 'overdue' ? 'bg-red-100 text-red-800' : 'bg-blue-100 text-blue-800' }}">
                                        {{ ucfirst($borrowing->status) }}
                                    </span>
                                    <a href="{{ route('borrowings.show', $borrowing) }}" 
                                       class="text-primary-600 hover:text-primary-900 text-sm font-medium">
                                        View
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endif

    <!-- Borrowing History -->
    <div class="bg-white shadow rounded-lg">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-medium text-gray-900">Borrowing History</h3>
        </div>
        
        @if($borrowingHistory->count() > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Book
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Borrowed Date
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Due Date
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Status
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($borrowingHistory as $borrowing)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-10 w-10">
                                            @if($borrowing->book->cover_image)
                                                <img class="h-10 w-10 rounded object-cover" src="{{ Storage::url($borrowing->book->cover_image) }}" alt="">
                                            @else
                                                <div class="h-10 w-10 bg-gray-200 rounded flex items-center justify-center">
                                                    <i class="fas fa-book text-gray-400 text-xs"></i>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900">{{ $borrowing->book->title }}</div>
                                            <div class="text-sm text-gray-500">{{ $borrowing->book->author->name }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ $borrowing->borrowed_date->format('M j, Y') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ $borrowing->due_date->format('M j, Y') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                        {{ $borrowing->status === 'returned' ? 'bg-green-100 text-green-800' : 
                                           ($borrowing->status === 'overdue' ? 'bg-red-100 text-red-800' : 'bg-blue-100 text-blue-800') }}">
                                        {{ ucfirst($borrowing->status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <a href="{{ route('borrowings.show', $borrowing) }}" 
                                       class="text-primary-600 hover:text-primary-900">View</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($borrowingHistory->hasPages())
                <div class="bg-white px-4 py-3 flex items-center justify-between border-t border-gray-200 sm:px-6">
                    <div class="flex-1 flex justify-between sm:hidden">
                        @if($borrowingHistory->onFirstPage())
                            <span class="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-500 bg-white cursor-default">
                                Previous
                            </span>
                        @else
                            <a href="{{ $borrowingHistory->previousPageUrl() }}" class="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                                Previous
                            </a>
                        @endif

                        @if($borrowingHistory->hasMorePages())
                            <a href="{{ $borrowingHistory->nextPageUrl() }}" class="ml-3 relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                                Next
                            </a>
                        @else
                            <span class="ml-3 relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-500 bg-white cursor-default">
                                Next
                            </span>
                        @endif
                    </div>
                    
                    <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
                        <div>
                            <p class="text-sm text-gray-700">
                                Showing <span class="font-medium">{{ $borrowingHistory->firstItem() }}</span> to <span class="font-medium">{{ $borrowingHistory->lastItem() }}</span> of <span class="font-medium">{{ $borrowingHistory->total() }}</span> results
                            </p>
                        </div>
                        <div>
                            {{ $borrowingHistory->links() }}
                        </div>
                    </div>
                </div>
            @endif
        @else
            <div class="p-12 text-center">
                <i class="fas fa-history text-gray-300 text-4xl mb-4"></i>
                <h4 class="text-lg font-medium text-gray-900 mb-2">No Borrowing History</h4>
                <p class="text-gray-500">This member hasn't borrowed any books yet.</p>
            </div>
        @endif
    </div>
</div>
@endsection