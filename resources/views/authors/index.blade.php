@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Authors</h1>
            <p class="mt-1 text-sm text-gray-600">Manage authors and their publications</p>
        </div>
        @if(auth()->user()->isLibrarian())
            <div class="mt-4 sm:mt-0">
                <a href="{{ route('authors.create') }}" 
                   class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                    <i class="fas fa-plus mr-2"></i>
                    Add New Author
                </a>
            </div>
        @endif
    </div>

    <!-- Filters -->
    <div class="bg-white shadow rounded-lg">
        <div class="px-4 py-5 sm:p-6">
            <form method="GET" action="{{ route('authors.index') }}" class="space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <!-- Search -->
                    <div>
                        <label for="search" class="block text-sm font-medium text-gray-700">Search</label>
                        <input type="text" name="search" id="search" value="{{ request('search') }}" 
                               placeholder="Author name or nationality"
                               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-primary-500 focus:border-primary-500 sm:text-sm">
                    </div>

                    <!-- Nationality Filter -->
                    <div>
                        <label for="nationality" class="block text-sm font-medium text-gray-700">Nationality</label>
                        <select name="nationality" id="nationality" 
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-primary-500 focus:border-primary-500 sm:text-sm">
                            <option value="">All Nationalities</option>
                            @foreach($nationalities as $nationality)
                                <option value="{{ $nationality }}" {{ request('nationality') === $nationality ? 'selected' : '' }}>
                                    {{ $nationality }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Actions -->
                    <div class="flex items-end space-x-2">
                        <button type="submit" 
                                class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                            <i class="fas fa-search mr-2"></i>
                            Filter
                        </button>
                        
                        <a href="{{ route('authors.index') }}" 
                           class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                            <i class="fas fa-times mr-2"></i>
                            Clear
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Authors Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
        @forelse($authors as $author)
            <div class="bg-white overflow-hidden shadow rounded-lg hover:shadow-lg transition-shadow duration-300">
                <div class="p-6">
                    <div class="flex flex-col items-center text-center">
                        <!-- Author Photo -->
                        <div class="flex-shrink-0 mb-4">
                            @if($author->photo)
                                <img class="h-20 w-20 rounded-full object-cover" src="{{ Storage::url($author->photo) }}" alt="{{ $author->name }}">
                            @else
                                <div class="h-20 w-20 rounded-full bg-primary-500 flex items-center justify-center">
                                    <span class="text-white font-medium text-xl">{{ substr($author->name, 0, 1) }}</span>
                                </div>
                            @endif
                        </div>

                        <!-- Author Info -->
                        <div class="w-full">
                            <h3 class="text-lg font-medium text-gray-900 truncate">{{ $author->name }}</h3>
                            @if($author->nationality)
                                <p class="text-sm text-gray-500">{{ $author->nationality }}</p>
                            @endif
                            
                            <!-- Life Dates -->
                            @if($author->birth_date || $author->death_date)
                                <p class="text-sm text-gray-500 mt-1">
                                    @if($author->birth_date)
                                        {{ $author->birth_date->format('Y') }}
                                    @endif
                                    @if($author->birth_date && $author->death_date)
                                        -
                                    @endif
                                    @if($author->death_date)
                                        {{ $author->death_date->format('Y') }}
                                    @elseif($author->birth_date)
                                        - Present
                                    @endif
                                    @if($author->age)
                                        ({{ $author->age }} years)
                                    @endif
                                </p>
                            @endif
                        </div>

                        <!-- Books Count -->
                        <div class="mt-4 w-full">
                            <div class="text-center">
                                <div class="text-2xl font-bold text-primary-600">{{ $author->books_count }}</div>
                                <div class="text-xs text-gray-500">{{ Str::plural('Book', $author->books_count) }}</div>
                            </div>
                        </div>

                        <!-- Biography Preview -->
                        @if($author->biography)
                            <div class="mt-4 w-full">
                                <p class="text-sm text-gray-600 line-clamp-3">
                                    {{ Str::limit($author->biography, 100) }}
                                </p>
                            </div>
                        @endif

                        <!-- Actions -->
                        <div class="mt-6 w-full flex space-x-2">
                            <a href="{{ route('authors.show', $author) }}" 
                               class="flex-1 inline-flex items-center justify-center px-3 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                                <i class="fas fa-eye mr-1"></i>
                                View
                            </a>

                            @if(auth()->user()->isLibrarian())
                                <a href="{{ route('authors.edit', $author) }}" 
                                   class="flex-1 inline-flex items-center justify-center px-3 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                                    <i class="fas fa-edit mr-1"></i>
                                    Edit
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full">
                <div class="text-center py-12">
                    <i class="fas fa-feather-alt text-gray-300 text-6xl mb-4"></i>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">No authors found</h3>
                    <p class="text-gray-500 mb-6">Try adjusting your search criteria.</p>
                    @if(auth()->user()->isLibrarian())
                        <a href="{{ route('authors.create') }}" 
                           class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-primary-600 hover:bg-primary-700">
                            <i class="fas fa-plus mr-2"></i>
                            Add Your First Author
                        </a>
                    @endif
                </div>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if($authors->hasPages())
        <div class="bg-white px-4 py-3 flex items-center justify-between border-t border-gray-200 sm:px-6 rounded-lg shadow">
            <div class="flex-1 flex justify-between sm:hidden">
                @if($authors->onFirstPage())
                    <span class="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-500 bg-white cursor-default">
                        Previous
                    </span>
                @else
                    <a href="{{ $authors->previousPageUrl() }}" class="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                        Previous
                    </a>
                @endif

                @if($authors->hasMorePages())
                    <a href="{{ $authors->nextPageUrl() }}" class="ml-3 relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
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
                        Showing <span class="font-medium">{{ $authors->firstItem() }}</span> to <span class="font-medium">{{ $authors->lastItem() }}</span> of <span class="font-medium">{{ $authors->total() }}</span> results
                    </p>
                </div>
                <div>
                    {{ $authors->links() }}
                </div>
            </div>
        </div>
    @endif
</div>

<style>
.line-clamp-3 {
    display: -webkit-box;
    -webkit-line-clamp: 3;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
</style>
@endsection