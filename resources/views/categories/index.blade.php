@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Categories</h1>
            <p class="mt-1 text-sm text-gray-600">Organize books by categories and genres</p>
        </div>
        @if(auth()->user()->isLibrarian())
            <div class="mt-4 sm:mt-0">
                <a href="{{ route('categories.create') }}" 
                   class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                    <i class="fas fa-plus mr-2"></i>
                    Add New Category
                </a>
            </div>
        @endif
    </div>

    <!-- Search -->
    <div class="bg-white shadow rounded-lg">
        <div class="px-4 py-5 sm:p-6">
            <form method="GET" action="{{ route('categories.index') }}">
                <div class="flex space-x-4">
                    <div class="flex-1">
                        <label for="search" class="sr-only">Search categories</label>
                        <input type="text" name="search" id="search" value="{{ request('search') }}" 
                               placeholder="Search categories..."
                               class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-primary-500 focus:border-primary-500 sm:text-sm">
                    </div>
                    <button type="submit" 
                            class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                        <i class="fas fa-search mr-2"></i>
                        Search
                    </button>
                    @if(request('search'))
                        <a href="{{ route('categories.index') }}" 
                           class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                            <i class="fas fa-times mr-2"></i>
                            Clear
                        </a>
                    @endif
                </div>
            </form>
        </div>
    </div>

    <!-- Categories Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
        @forelse($categories as $category)
            <div class="bg-white overflow-hidden shadow rounded-lg hover:shadow-lg transition-shadow duration-300">
                <div class="p-6">
                    <div class="flex items-center">
                        <!-- Color Indicator -->
                        <div class="flex-shrink-0 mr-4">
                            <div class="w-12 h-12 rounded-lg flex items-center justify-center" 
                                 style="background-color: {{ $category->color }}20;">
                                <div class="w-6 h-6 rounded-full" style="background-color: {{ $category->color }};"></div>
                            </div>
                        </div>
                        
                        <div class="flex-1 min-w-0">
                            <h3 class="text-lg font-medium text-gray-900 truncate">{{ $category->name }}</h3>
                            <p class="text-sm text-gray-500">{{ $category->books_count }} {{ Str::plural('book', $category->books_count) }}</p>
                        </div>
                    </div>

                    @if($category->description)
                        <div class="mt-4">
                            <p class="text-sm text-gray-600 line-clamp-3">{{ $category->description }}</p>
                        </div>
                    @endif

                    <!-- Category Stats -->
                    <div class="mt-6">
                        <div class="bg-gray-50 rounded-lg p-3">
                            <div class="flex items-center justify-between text-sm">
                                <span class="text-gray-500">Total Books:</span>
                                <span class="font-medium text-gray-900">{{ $category->books_count }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="mt-6 flex space-x-2">
                        <a href="{{ route('categories.show', $category) }}" 
                           class="flex-1 inline-flex items-center justify-center px-3 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                            <i class="fas fa-eye mr-1"></i>
                            View
                        </a>

                        @if(auth()->user()->isLibrarian())
                            <a href="{{ route('categories.edit', $category) }}" 
                               class="flex-1 inline-flex items-center justify-center px-3 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                                <i class="fas fa-edit mr-1"></i>
                                Edit
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full">
                <div class="text-center py-12">
                    <i class="fas fa-tags text-gray-300 text-6xl mb-4"></i>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">No categories found</h3>
                    <p class="text-gray-500 mb-6">Try adjusting your search criteria.</p>
                    @if(auth()->user()->isLibrarian())
                        <a href="{{ route('categories.create') }}" 
                           class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-primary-600 hover:bg-primary-700">
                            <i class="fas fa-plus mr-2"></i>
                            Add Your First Category
                        </a>
                    @endif
                </div>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if($categories->hasPages())
        <div class="bg-white px-4 py-3 flex items-center justify-between border-t border-gray-200 sm:px-6 rounded-lg shadow">
            <div class="flex-1 flex justify-between sm:hidden">
                @if($categories->onFirstPage())
                    <span class="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-500 bg-white cursor-default">
                        Previous
                    </span>
                @else
                    <a href="{{ $categories->previousPageUrl() }}" class="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                        Previous
                    </a>
                @endif

                @if($categories->hasMorePages())
                    <a href="{{ $categories->nextPageUrl() }}" class="ml-3 relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
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
                        Showing <span class="font-medium">{{ $categories->firstItem() }}</span> to <span class="font-medium">{{ $categories->lastItem() }}</span> of <span class="font-medium">{{ $categories->total() }}</span> results
                    </p>
                </div>
                <div>
                    {{ $categories->links() }}
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