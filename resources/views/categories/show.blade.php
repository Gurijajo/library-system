@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
        <div>
            <nav class="flex" aria-label="Breadcrumb">
                <ol class="flex items-center space-x-2">
                    <li><a href="{{ route('categories.index') }}" class="text-gray-500 hover:text-gray-700">Categories</a></li>
                    <li><i class="fas fa-chevron-right text-gray-400 text-xs"></i></li>
                    <li class="text-gray-900 font-medium">{{ $category->name }}</li>
                </ol>
            </nav>
        </div>
        @if(auth()->user()->isLibrarian())
            <div class="mt-4 sm:mt-0 flex space-x-3">
                <a href="{{ route('categories.edit', $category) }}" 
                   class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                    <i class="fas fa-edit mr-2"></i>
                    Edit Category
                </a>
                
                @if($category->books->count() === 0)
                    <form action="{{ route('categories.destroy', $category) }}" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" 
                                class="inline-flex items-center px-4 py-2 border border-red-300 text-sm font-medium rounded-md text-red-700 bg-white hover:bg-red-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500"
                                onclick="return confirm('Are you sure you want to delete this category? This action cannot be undone.')">
                            <i class="fas fa-trash mr-2"></i>
                            Delete
                        </button>
                    </form>
                @endif
            </div>
        @endif
    </div>

    <!-- Category Information -->
    <div class="bg-white shadow rounded-lg">
        <div class="px-6 py-8">
            <div class="flex items-center">
                <!-- Color Indicator -->
                <div class="flex-shrink-0 mr-6">
                    <div class="w-20 h-20 rounded-lg flex items-center justify-center" 
                         style="background-color: {{ $category->color }}20;">
                        <div class="w-10 h-10 rounded-full" style="background-color: {{ $category->color }};"></div>
                    </div>
                </div>
                
                <div class="flex-1">
                    <h1 class="text-3xl font-bold text-gray-900">{{ $category->name }}</h1>
                    
                    <div class="mt-2">
                        <span class="inline-flex items-center px-4 py-2 rounded-full text-lg font-medium" 
                              style="background-color: {{ $category->color }}20; color: {{ $category->color }}">
                            {{ $category->name }}
                        </span>
                    </div>

                    @if($category->description)
                        <div class="mt-4">
                            <p class="text-gray-700 leading-relaxed">{{ $category->description }}</p>
                        </div>
                    @endif

                    <!-- Stats -->
                    <div class="mt-6 grid grid-cols-1 sm:grid-cols-3 gap-4">
                        <div class="bg-gray-50 rounded-lg p-4 text-center">
                            <div class="text-2xl font-bold text-primary-600">{{ $category->books->count() }}</div>
                            <div class="text-sm text-gray-500">Total Books</div>
                        </div>
                        
                        <div class="bg-gray-50 rounded-lg p-4 text-center">
                            <div class="text-2xl font-bold text-green-600">{{ $category->books->where('status', 'active')->count() }}</div>
                            <div class="text-sm text-gray-500">Active Books</div>
                        </div>

                        <div class="bg-gray-50 rounded-lg p-4 text-center">
                            <div class="text-2xl font-bold text-blue-600">{{ $category->books->sum('available_copies') }}</div>
                            <div class="text-sm text-gray-500">Available Copies</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Books in Category -->
    <div class="bg-white shadow rounded-lg">
        <div class="px-6 py-4 border-b border-gray-200">
            <div class="flex items-center justify-between">
                <h3 class="text-lg font-medium text-gray-900">Books in {{ $category->name }}</h3>
                @if(auth()->user()->isLibrarian())
                    <a href="{{ route('books.create', ['category_id' => $category->id]) }}" 
                       class="inline-flex items-center px-3 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-primary-600 hover:bg-primary-700">
                        <i class="fas fa-plus mr-2"></i>
                        Add Book
                    </a>
                @endif
            </div>
        </div>

        @if($category->books->count() > 0)
            <div class="p-6">
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($category->books as $book)
                        <div class="bg-gray-50 rounded-lg p-4 hover:shadow-md transition-shadow duration-300">
                            <div class="flex">
                                <div class="flex-shrink-0 mr-4">
                                    @if($book->cover_image)
                                        <img src="{{ Storage::url($book->cover_image) }}" alt="{{ $book->title }}" 
                                             class="w-16 h-20 rounded object-cover">
                                    @else
                                        <div class="w-16 h-20 bg-gray-200 rounded flex items-center justify-center">
                                            <i class="fas fa-book text-gray-400"></i>
                                        </div>
                                    @endif
                                </div>
                                
                                <div class="flex-1 min-w-0">
                                    <h4 class="text-sm font-medium text-gray-900 truncate">{{ $book->title }}</h4>
                                    <p class="text-sm text-gray-500 truncate">by {{ $book->author->name }}</p>
                                    
                                    <div class="mt-2 space-y-1">
                                        @if($book->publication_date)
                                            <div class="text-xs text-gray-500">
                                                Published: {{ $book->publication_date->format('Y') }}
                                            </div>
                                        @endif
                                        
                                        <div class="text-xs">
                                            <span class="font-medium {{ $book->available_copies > 0 ? 'text-green-600' : 'text-red-600' }}">
                                                {{ $book->available_copies }}/{{ $book->total_copies }} available
                                            </span>
                                        </div>

                                        <div class="text-xs">
                                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium 
                                                {{ $book->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                                {{ ucfirst($book->status) }}
                                            </span>
                                        </div>
                                    </div>
                                    
                                    <div class="mt-3">
                                        <a href="{{ route('books.show', $book) }}" 
                                           class="text-primary-600 hover:text-primary-900 text-xs font-medium">
                                            View Details <i class="fas fa-arrow-right ml-1"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @else
            <div class="p-12 text-center">
                <div class="w-16 h-16 mx-auto mb-4 rounded-lg flex items-center justify-center" 
                     style="background-color: {{ $category->color }}20;">
                    <i class="fas fa-book text-2xl" style="color: {{ $category->color }};"></i>
                </div>
                <h4 class="text-lg font-medium text-gray-900 mb-2">No Books in This Category</h4>
                <p class="text-gray-500 mb-6">This category doesn't have any books yet.</p>
                @if(auth()->user()->isLibrarian())
                    <a href="{{ route('books.create', ['category_id' => $category->id]) }}" 
                       class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-primary-600 hover:bg-primary-700">
                        <i class="fas fa-plus mr-2"></i>
                        Add First Book
                    </a>
                @endif
            </div>
        @endif
    </div>
</div>
@endsection