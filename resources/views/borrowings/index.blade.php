@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Borrowings</h1>
            <p class="mt-1 text-sm text-gray-600">Manage book borrowings and returns</p>
        </div>
        <div class="mt-4 sm:mt-0 flex space-x-3">
            <form action="{{ route('borrowings.mark-overdue') }}" method="POST" class="inline">
                @csrf
                <button type="submit" 
                        class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                    <i class="fas fa-exclamation-triangle mr-2"></i>
                    Update Overdue
                </button>
            </form>
            <a href="{{ route('borrowings.create') }}" 
               class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                <i class="fas fa-plus mr-2"></i>
                Issue Book
            </a>
        </div>
    </div>

    <!-- Filters -->
    <div class="bg-white shadow rounded-lg">
        <div class="px-4 py-5 sm:p-6">
            <form method="GET" action="{{ route('borrowings.index') }}" class="space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <!-- Status Filter -->
                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                        <select name="status" id="status" 
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-primary-500 focus:border-primary-500 sm:text-sm">
                            <option value="">All Status</option>
                            <option value="borrowed" {{ request('status') === 'borrowed' ? 'selected' : '' }}>Borrowed</option>
                            <option value="overdue" {{ request('status') === 'overdue' ? 'selected' : '' }}>Overdue</option>
                            <option value="returned" {{ request('status') === 'returned' ? 'selected' : '' }}>Returned</option>
                        </select>
                    </div>

                    <!-- User Filter -->
                    <div>
                        <label for="user_id" class="block text-sm font-medium text-gray-700">Member</label>
                        <select name="user_id" id="user_id" 
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-primary-500 focus:border-primary-500 sm:text-sm">
                            <option value="">All Members</option>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}" {{ request('user_id') == $user->id ? 'selected' : '' }}>
                                    {{ $user->name }} ({{ $user->membership_id }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Quick Filters -->
                    <div class="flex items-end">
                        <label class="inline-flex items-center">
                            <input type="checkbox" name="overdue_only" value="1" {{ request('overdue_only') ? 'checked' : '' }}
                                   class="rounded border-gray-300 text-primary-600 shadow-sm focus:border-primary-300 focus:ring focus:ring-primary-200 focus:ring-opacity-50">
                            <span class="ml-2 text-sm text-gray-600">Overdue only</span>
                        </label>
                    </div>
                </div>

                <div class="flex space-x-4">
                    <button type="submit" 
                            class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                        <i class="fas fa-search mr-2"></i>
                        Filter
                    </button>
                    
                    <a href="{{ route('borrowings.index') }}" 
                       class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                        <i class="fas fa-times mr-2"></i>
                        Clear
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Borrowings Table -->
    <div class="bg-white shadow rounded-lg overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Book & Member
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Dates
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Status
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Fine
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Actions
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($borrowings as $borrowing)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-12 w-12">
                                        @if($borrowing->book->cover_image)
                                            <img class="h-12 w-12 rounded object-cover" src="{{ Storage::url($borrowing->book->cover_image) }}" alt="">
                                        @else
                                            <div class="h-12 w-12 bg-gray-200 rounded flex items-center justify-center">
                                                <i class="fas fa-book text-gray-400"></i>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900">{{ $borrowing->book->title }}</div>
                                        <div class="text-sm text-gray-500">by {{ $borrowing->book->author->name }}</div>
                                        <div class="text-sm text-gray-500 mt-1">
                                            <i class="fas fa-user mr-1"></i>{{ $borrowing->user->name }}
                                            <span class="ml-2 text-xs">({{ $borrowing->user->membership_id }})</span>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                <div class="space-y-1">
                                    <div><strong>Borrowed:</strong> {{ $borrowing->borrowed_date->format('M j, Y') }}</div>
                                    <div class="{{ $borrowing->due_date < now() && !$borrowing->returned_date ? 'text-red-600' : '' }}">
                                        <strong>Due:</strong> {{ $borrowing->due_date->format('M j, Y') }}
                                    </div>
                                    @if($borrowing->returned_date)
                                        <div class="text-green-600">
                                            <strong>Returned:</strong> {{ $borrowing->returned_date->format('M j, Y') }}
                                        </div>
                                    @endif
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                    {{ $borrowing->status === 'returned' ? 'bg-green-100 text-green-800' : 
                                       ($borrowing->status === 'overdue' ? 'bg-red-100 text-red-800' : 'bg-blue-100 text-blue-800') }}">
                                    {{ ucfirst($borrowing->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                @if($borrowing->fine_amount > 0)
                                    <div class="text-red-600 font-medium">${{ number_format($borrowing->fine_amount, 2) }}</div>
                                    @if(!$borrowing->fine_paid && $borrowing->fine_amount > 0)
                                        <div class="text-xs text-red-500">Unpaid</div>
                                    @else
                                        <div class="text-xs text-green-500">Paid</div>
                                    @endif
                                @else
                                    <span class="text-gray-400">No fine</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2">
                                <a href="{{ route('borrowings.show', $borrowing) }}" 
                                   class="text-primary-600 hover:text-primary-900">View</a>
                                
                                @if(in_array($borrowing->status, ['borrowed', 'overdue']))
                                    <form action="{{ route('borrowings.return', $borrowing) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" 
                                                class="text-green-600 hover:text-green-900"
                                                onclick="return confirm('Mark this book as returned?')">
                                            Return
                                        </button>
                                    </form>
                                @endif

                                @if($borrowing->fine_amount > 0 && !$borrowing->fine_paid)
                                    <form action="{{ route('borrowings.pay-fine', $borrowing) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" 
                                                class="text-yellow-600 hover:text-yellow-900"
                                                onclick="return confirm('Mark fine as paid?')">
                                            Pay Fine
                                        </button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center">
                                <div class="text-gray-500">
                                    <i class="fas fa-exchange-alt text-4xl mb-4"></i>
                                    <h3 class="text-lg font-medium mb-2">No borrowings found</h3>
                                    <p class="mb-4">Try adjusting your search criteria or issue a new book.</p>
                                    <a href="{{ route('borrowings.create') }}" 
                                       class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-primary-600 hover:bg-primary-700">
                                        <i class="fas fa-plus mr-2"></i>
                                        Issue First Book
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($borrowings->hasPages())
            <div class="bg-white px-4 py-3 flex items-center justify-between border-t border-gray-200 sm:px-6">
                <div class="flex-1 flex justify-between sm:hidden">
                    @if($borrowings->onFirstPage())
                        <span class="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-500 bg-white cursor-default">
                            Previous
                        </span>
                    @else
                        <a href="{{ $borrowings->previousPageUrl() }}" class="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                            Previous
                        </a>
                    @endif

                    @if($borrowings->hasMorePages())
                        <a href="{{ $borrowings->nextPageUrl() }}" class="ml-3 relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
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
                            Showing <span class="font-medium">{{ $borrowings->firstItem() }}</span> to <span class="font-medium">{{ $borrowings->lastItem() }}</span> of <span class="font-medium">{{ $borrowings->total() }}</span> results
                        </p>
                    </div>
                    <div>
                        {{ $borrowings->links() }}
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection