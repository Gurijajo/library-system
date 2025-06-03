@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">My Profile</h1>
            <p class="mt-1 text-sm text-gray-600">Manage your account information and library activity</p>
        </div>
        <div class="mt-4 sm:mt-0 flex space-x-3">
            <a href="{{ route('profile.edit') }}" 
               class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                <i class="fas fa-edit mr-2"></i>
                Edit Profile
            </a>
            <a href="{{ route('profile.settings') }}" 
               class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                <i class="fas fa-cog mr-2"></i>
                Settings
            </a>
        </div>
    </div>

    <!-- Profile Information -->
    <div class="bg-white shadow rounded-lg">
        <div class="px-6 py-8">
            <div class="flex flex-col md:flex-row">
                <!-- Avatar -->
                <div class="flex-shrink-0 mb-6 md:mb-0 md:mr-8">
                    @if($user->avatar)
                        <img class="h-32 w-32 rounded-full object-cover mx-auto" src="{{ Storage::url($user->avatar) }}" alt="{{ $user->name }}">
                    @else
                        <div class="h-32 w-32 rounded-full bg-primary-500 flex items-center justify-center mx-auto">
                            <span class="text-white font-medium text-4xl">{{ substr($user->name, 0, 1) }}</span>
                        </div>
                    @endif
                </div>

                <!-- User Details -->
                <div class="flex-1">
                    <div class="text-center md:text-left">
                        <h2 class="text-3xl font-bold text-gray-900">{{ $user->name }}</h2>
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
                            @if($user->membership_expiry && $user->membership_expiry->lt(now()->addDays(30)))
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-yellow-100 text-yellow-800">
                                    <i class="fas fa-exclamation-triangle mr-1"></i>
                                    Expires Soon
                                </span>
                            @endif
                        </div>

                        <!-- Contact Information -->
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
                                    <span>Membership expires: {{ $user->membership_expiry->format('F j, Y') }}</span>
                                </div>
                            @endif

                            <div class="flex items-center justify-center md:justify-start text-gray-500">
                                <i class="fas fa-user-plus mr-2"></i>
                                <span>Member since: {{ $user->created_at->format('F j, Y') }}</span>
                            </div>
                        </div>

                        @if($user->address)
                            <div class="mt-6">
                                <div class="flex items-start justify-center md:justify-start text-gray-500">
                                    <i class="fas fa-map-marker-alt mr-2 mt-1"></i>
                                    <span>{{ $user->address }}</span>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Library Statistics -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-6">
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
                            <dd class="text-lg font-medium text-gray-900">{{ $stats['current_borrowings'] }}</dd>
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
                            <dd class="text-lg font-medium text-gray-900">{{ $stats['total_borrowings'] }}</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-green-600 rounded-md flex items-center justify-center">
                            <i class="fas fa-check text-white text-sm"></i>
                        </div>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Books Returned</dt>
                            <dd class="text-lg font-medium text-gray-900">{{ $stats['books_returned'] }}</dd>
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
                            <dd class="text-lg font-medium text-gray-900">{{ $stats['overdue_books'] }}</dd>
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
                            <dd class="text-lg font-medium {{ $stats['total_fines'] > 0 ? 'text-red-600' : 'text-green-600' }}">
                                ${{ number_format($stats['total_fines'], 2) }}
                            </dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Current Borrowings -->
    @if($currentBorrowings->count() > 0)
        <div class="bg-white shadow rounded-lg">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-medium text-gray-900">Currently Borrowed Books</h3>
            </div>
            <div class="p-6">
                <div class="space-y-4">
                    @foreach($currentBorrowings as $borrowing)
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
                                            @else
                                                <span class="text-blue-600 ml-2">({{ now()->diffInDays($borrowing->due_date) }} days remaining)</span>
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

    <!-- Recent Activity -->
    <div class="bg-white shadow rounded-lg">
        <div class="px-6 py-4 border-b border-gray-200">
            <div class="flex items-center justify-between">
                <h3 class="text-lg font-medium text-gray-900">Recent Borrowing Activity</h3>
                @if(auth()->user()->isLibrarian())
                    <a href="{{ route('borrowings.index', ['user_id' => $user->id]) }}" 
                       class="text-primary-600 hover:text-primary-900 text-sm font-medium">
                        View All
                    </a>
                @endif
            </div>
        </div>
        
        @if($recentBorrowings->count() > 0)
            <div class="divide-y divide-gray-200">
                @foreach($recentBorrowings as $borrowing)
                    <div class="px-6 py-4">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 mr-4">
                                    @if($borrowing->book->cover_image)
                                        <img src="{{ Storage::url($borrowing->book->cover_image) }}" alt="{{ $borrowing->book->title }}" 
                                             class="w-10 h-12 rounded object-cover">
                                    @else
                                        <div class="w-10 h-12 bg-gray-200 rounded flex items-center justify-center">
                                            <i class="fas fa-book text-gray-400 text-xs"></i>
                                        </div>
                                    @endif
                                </div>
                                <div>
                                    <h4 class="text-sm font-medium text-gray-900">{{ $borrowing->book->title }}</h4>
                                    <p class="text-sm text-gray-500">{{ $borrowing->book->author->name }}</p>
                                    <p class="text-xs text-gray-400">{{ $borrowing->created_at->diffForHumans() }}</p>
                                </div>
                            </div>
                            <div class="flex items-center space-x-3">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                    {{ $borrowing->status === 'returned' ? 'bg-green-100 text-green-800' : 
                                       ($borrowing->status === 'overdue' ? 'bg-red-100 text-red-800' : 'bg-blue-100 text-blue-800') }}">
                                    {{ ucfirst($borrowing->status) }}
                                </span>
                                <a href="{{ route('borrowings.show', $borrowing) }}" 
                                   class="text-primary-600 hover:text-primary-900 text-sm">
                                    <i class="fas fa-eye"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="p-12 text-center">
                <i class="fas fa-history text-gray-300 text-4xl mb-4"></i>
                <h4 class="text-lg font-medium text-gray-900 mb-2">No Borrowing History</h4>
                <p class="text-gray-500 mb-6">You haven't borrowed any books yet.</p>
                <a href="{{ route('books.index') }}" 
                   class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-primary-600 hover:bg-primary-700">
                    <i class="fas fa-search mr-2"></i>
                    Browse Books
                </a>
            </div>
        @endif
    </div>
</div>
@endsection