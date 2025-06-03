@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
        <div>
            <nav class="flex" aria-label="Breadcrumb">
                <ol class="flex items-center space-x-2">
                    <li><a href="{{ route('authors.index') }}" class="text-gray-500 hover:text-gray-700">Authors</a></li>
                    <li><i class="fas fa-chevron-right text-gray-400 text-xs"></i></li>
                    <li class="text-gray-900 font-medium">{{ $author->name }}</li>
                </ol>
            </nav>
        </div>
        @if(auth()->user()->isLibrarian())
            <div class="mt-4 sm:mt-0 flex space-x-3">
                <a href="{{ route('authors.edit', $author) }}" 
                   class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                    <i class="fas fa-edit mr-2"></i>
                    Edit Author
                </a>
                
                <form action="{{ route('authors.destroy', $author) }}" method="POST" class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" 
                            class="inline-flex items-center px-4 py-2 border border-red-300 text-sm font-medium rounded-md text-red-700 bg-white hover:bg-red-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500"
                            onclick="return confirm('Are you sure you want to delete this author? This action cannot be undone.')">
                        <i class="fas fa-trash mr-2"></i>
                        Delete
                    </button>
                </form>
            </div>
        @endif
    </div>

    <!-- Author Profile -->
    <div class="bg-white shadow rounded-lg">
        <div class="px-6 py-8">
            <div class="flex flex-col md:flex-row">
                <!-- Author Photo -->
                <div class="flex-shrink-0 mb-6 md:mb-0 md:mr-8">
                    @if($author->photo)
                        <img class="h-48 w-48 rounded-lg object-cover mx-auto" src="{{ Storage::url($author->photo) }}" alt="{{ $author->name }}">
                    @else
                        <div class="h-48 w-48 rounded-lg bg-primary-500 flex items-center justify-center mx-auto">
                            <span class="text-white font-medium text-6xl">{{ substr($author->name, 0, 1) }}</span>
                        </div>
                    @endif
                </div>

                <!-- Author Details -->
                <div class="flex-1">
                    <div class="text-center md:text-left">
                        <h1 class="text-3xl font-bold text-gray-900">{{ $author->name }}</h1>
                        
                        @if($author->nationality)
                            <p class="mt-2 text-lg text-gray-600">{{ $author->nationality }} Author</p>
                        @endif

                        <!-- Life Information -->
                        <div class="mt-4 space-y-2">
                            @if($author->birth_date)
                                <div class="flex items-center justify-center md:justify-start text-sm text-gray-500">
                                    <i class="fas fa-calendar-alt mr-2"></i>
                                    <span>Born: {{ $author->birth_date->format('F j, Y') }}</span>
                                </div>
                            @endif

                            @if($author->death_date)
                                <div class="flex items-center justify-center md:justify-start text-sm text-gray-500">
                                    <i class="fas fa-calendar-times mr-2"></i>
                                    <span>Died: {{ $author->death_date->format('F j, Y') }}</span>
                                </div>
                            @endif

                            @if($author->age)
                                <div class="flex items-center justify-center md:justify-start text-sm text-gray-500">
                                    <i class="fas fa-hourglass-half mr-2"></i>
                                    <span>{{ $author->death_date ? 'Lived' : 'Age' }}: {{ $author->age }} years</span>
                                </div>
                            @endif
                        </div>

                        <!-- Stats -->
                        <div class="mt-6 grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div class="bg-gray-50 rounded-lg p-4 text-center">
                                <div class="text-2xl font-bold text-primary-600">{{ $author->books->count() }}</div>
                                <div class="text-sm text-gray-500">{{ Str::plural('Book', $author->books->count()) }} in Library</div>
                            </div>
                            
                            <div class="bg-gray-50 rounded-lg p-4 text-center">
                                <div class="text-2xl font-bold text-green-600">{{ $author->books->where('status', 'active')->count() }}</div>
                                <div class="text-sm text-gray-500">Active {{ Str::plural('Title', $author->books->where('status', 'active')->count()) }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Biography -->
            @if($author->biography)
                <div class="mt-8 pt-8 border-t border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Biography</h3>
                    <div class="prose max-w-none text-gray-700">
                        {!! nl2br(e($author->biography)) !!}
                    </div>
                </div>
            @endif
        </div>
    </div>

    <!-- Books by Author -->
    <div class="bg-white shadow rounded-lg">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-medium text-gray-900">Books by {{ $author->name }}</h3>
        </div>

        @if($author->books->count() > 0)
            <div class="p-6">
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($author->books as $book)
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
                                    
                                    <div class="mt-2 space-y-1">
                                        <div class="flex items-center text-xs text-gray-500">
                                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium" 
                                                  style="background-color: {{ $book->category->color }}20; color: {{ $book->category->color }}">
                                                {{ $book->category->name }}
                                            </span>
                                        </div>
                                        
                                        <div class="text-xs text-gray-500">
                                            @if($book->publication_date)
                                                Published: {{ $book->publication_date->format('Y') }}
                                            @endif
                                        </div>
                                        
                                        <div class="text-xs">
                                            <span class="font-medium {{ $book->available_copies > 0 ? 'text-green-600' : 'text-red-600' }}">
                                                {{ $book->available_copies }}/{{ $book->total_copies }} available
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
                <i class="fas fa-book text-gray-300 text-4xl mb-4"></i>
                <h4 class="text-lg font-medium text-gray-900 mb-2">No Books Available</h4>
                <p class="text-gray-500 mb-6">This author doesn't have any books in the library yet.</p>
                @if(auth()->user()->isLibrarian())
                    <a href="{{ route('books.create', ['author_id' => $author->id]) }}" 
                       class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-primary-600 hover:bg-primary-700">
                        <i class="fas fa-plus mr-2"></i>
                        Add Book by {{ $author->name }}
                    </a>
                @endif
            </div>
        @endif
    </div>
</div>
@endsection