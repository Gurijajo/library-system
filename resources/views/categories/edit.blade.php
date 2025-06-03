@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div>
        <nav class="flex" aria-label="Breadcrumb">
            <ol class="flex items-center space-x-2">
                <li><a href="{{ route('categories.index') }}" class="text-gray-500 hover:text-gray-700">Categories</a></li>
                <li><i class="fas fa-chevron-right text-gray-400 text-xs"></i></li>
                <li><a href="{{ route('categories.show', $category) }}" class="text-gray-500 hover:text-gray-700">{{ $category->name }}</a></li>
                <li><i class="fas fa-chevron-right text-gray-400 text-xs"></i></li>
                <li class="text-gray-900 font-medium">Edit</li>
            </ol>
        </nav>
        <h1 class="mt-2 text-2xl font-bold text-gray-900">Edit Category</h1>
    </div>

    <!-- Form -->
    <div class="bg-white shadow rounded-lg">
        <form action="{{ route('categories.update', $category) }}" method="POST" class="space-y-6 p-6">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Left Column -->
                <div class="space-y-6">
                    <!-- Name -->
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700">Category Name *</label>
                        <input type="text" name="name" id="name" value="{{ old('name', $category->name) }}" required
                               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-primary-500 focus:border-primary-500 sm:text-sm @error('name') border-red-300 @enderror">
                        @error('name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Description -->
                    <div>
                        <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                        <textarea name="description" id="description" rows="4" 
                                  class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-primary-500 focus:border-primary-500 sm:text-sm @error('description') border-red-300 @enderror"
                                  placeholder="Enter category description...">{{ old('description', $category->description) }}</textarea>
                        @error('description')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Category Statistics (Read-only) -->
                    <div class="bg-gray-50 rounded-lg p-4">
                        <h3 class="text-sm font-medium text-gray-900 mb-3">Category Statistics</h3>
                        <div class="grid grid-cols-2 gap-4 text-sm">
                            <div class="text-center">
                                <div class="text-lg font-medium text-gray-900">{{ $category->books->count() }}</div>
                                <div class="text-gray-500">Total Books</div>
                            </div>
                            <div class="text-center">
                                <div class="text-lg font-medium {{ $category->books->where('status', 'active')->count() > 0 ? 'text-green-600' : 'text-gray-900' }}">
                                    {{ $category->books->where('status', 'active')->count() }}
                                </div>
                                <div class="text-gray-500">Active Books</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Column -->
                <div class="space-y-6">
                    <!-- Color -->
                    <div>
                        <label for="color" class="block text-sm font-medium text-gray-700">Category Color *</label>
                        <div class="mt-1 flex items-center space-x-3">
                            <input type="color" name="color" id="color" value="{{ old('color', $category->color) }}" required
                                   class="h-10 w-16 border border-gray-300 rounded-md @error('color') border-red-300 @enderror">
                            <input type="text" id="color_text" value="{{ old('color', $category->color) }}" 
                                   class="flex-1 border-gray-300 rounded-md shadow-sm focus:ring-primary-500 focus:border-primary-500 sm:text-sm"
                                   placeholder="#3B82F6" readonly>
                        </div>
                        @error('color')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        <p class="mt-1 text-sm text-gray-500">This color will be used to identify books in this category</p>
                    </div>

                    <!-- Current Color Preview -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Current Color</label>
                        <div class="flex items-center space-x-4 mb-4">
                            <div class="w-16 h-16 rounded-lg border-2 border-gray-300" style="background-color: {{ $category->color }};"></div>
                            <div>
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium" 
                                      style="background-color: {{ $category->color }}20; color: {{ $category->color }}">
                                    {{ $category->name }}
                                </span>
                                <p class="text-xs text-gray-500 mt-1">Current badge</p>
                            </div>
                        </div>
                    </div>

                    <!-- Color Preview -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">New Preview</label>
                        <div class="flex items-center space-x-4">
                            <div id="color_preview" class="w-16 h-16 rounded-lg border-2 border-gray-300" style="background-color: {{ old('color', $category->color) }};"></div>
                            <div>
                                <span id="preview_badge" class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium" 
                                      style="background-color: {{ old('color', $category->color) }}20; color: {{ old('color', $category->color) }}">
                                    {{ old('name', $category->name) }}
                                </span>
                                <p class="text-xs text-gray-500 mt-1">New badge preview</p>
                            </div>
                        </div>
                    </div>

                    <!-- Suggested Colors -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Suggested Colors</label>
                        <div class="grid grid-cols-6 gap-2">
                            <button type="button" class="w-8 h-8 rounded border-2 border-gray-300 hover:border-gray-400 focus:outline-none focus:ring-2 focus:ring-primary-500" 
                                    style="background-color: #3B82F6;" onclick="setColor('#3B82F6')" title="Blue"></button>
                            <button type="button" class="w-8 h-8 rounded border-2 border-gray-300 hover:border-gray-400 focus:outline-none focus:ring-2 focus:ring-primary-500" 
                                    style="background-color: #10B981;" onclick="setColor('#10B981')" title="Green"></button>
                            <button type="button" class="w-8 h-8 rounded border-2 border-gray-300 hover:border-gray-400 focus:outline-none focus:ring-2 focus:ring-primary-500" 
                                    style="background-color: #8B5CF6;" onclick="setColor('#8B5CF6')" title="Purple"></button>
                            <button type="button" class="w-8 h-8 rounded border-2 border-gray-300 hover:border-gray-400 focus:outline-none focus:ring-2 focus:ring-primary-500" 
                                    style="background-color: #F59E0B;" onclick="setColor('#F59E0B')" title="Amber"></button>
                            <button type="button" class="w-8 h-8 rounded border-2 border-gray-300 hover:border-gray-400 focus:outline-none focus:ring-2 focus:ring-primary-500" 
                                    style="background-color: #EF4444;" onclick="setColor('#EF4444')" title="Red"></button>
                            <button type="button" class="w-8 h-8 rounded border-2 border-gray-300 hover:border-gray-400 focus:outline-none focus:ring-2 focus:ring-primary-500" 
                                    style="background-color: #EC4899;" onclick="setColor('#EC4899')" title="Pink"></button>
                            <button type="button" class="w-8 h-8 rounded border-2 border-gray-300 hover:border-gray-400 focus:outline-none focus:ring-2 focus:ring-primary-500" 
                                    style="background-color: #6366F1;" onclick="setColor('#6366F1')" title="Indigo"></button>
                            <button type="button" class="w-8 h-8 rounded border-2 border-gray-300 hover:border-gray-400 focus:outline-none focus:ring-2 focus:ring-primary-500" 
                                    style="background-color: #14B8A6;" onclick="setColor('#14B8A6')" title="Teal"></button>
                            <button type="button" class="w-8 h-8 rounded border-2 border-gray-300 hover:border-gray-400 focus:outline-none focus:ring-2 focus:ring-primary-500" 
                                    style="background-color: #F97316;" onclick="setColor('#F97316')" title="Orange"></button>
                            <button type="button" class="w-8 h-8 rounded border-2 border-gray-300 hover:border-gray-400 focus:outline-none focus:ring-2 focus:ring-primary-500" 
                                    style="background-color: #84CC16;" onclick="setColor('#84CC16')" title="Lime"></button>
                            <button type="button" class="w-8 h-8 rounded border-2 border-gray-300 hover:border-gray-400 focus:outline-none focus:ring-2 focus:ring-primary-500" 
                                    style="background-color: #06B6D4;" onclick="setColor('#06B6D4')" title="Cyan"></button>
                            <button type="button" class="w-8 h-8 rounded border-2 border-gray-300 hover:border-gray-400 focus:outline-none focus:ring-2 focus:ring-primary-500" 
                                    style="background-color: #8B5A3C;" onclick="setColor('#8B5A3C')" title="Brown"></button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Books in Category -->
            @if($category->books->count() > 0)
                <div class="bg-gray-50 rounded-lg p-4">
                    <h3 class="text-sm font-medium text-gray-900 mb-4">Books in this Category ({{ $category->books->count() }})</h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3 max-h-64 overflow-y-auto">
                        @foreach($category->books->take(9) as $book)
                            <div class="bg-white rounded border p-3 flex items-center space-x-3">
                                <div class="flex-shrink-0">
                                    @if($book->cover_image)
                                        <img src="{{ Storage::url($book->cover_image) }}" alt="{{ $book->title }}" 
                                             class="w-8 h-10 rounded object-cover">
                                    @else
                                        <div class="w-8 h-10 bg-gray-200 rounded flex items-center justify-center">
                                            <i class="fas fa-book text-gray-400 text-xs"></i>
                                        </div>
                                    @endif
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-medium text-gray-900 truncate">{{ $book->title }}</p>
                                    <p class="text-xs text-gray-500 truncate">{{ $book->author->name }}</p>
                                </div>
                                <div class="flex-shrink-0">
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium 
                                        {{ $book->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                        {{ ucfirst($book->status) }}
                                    </span>
                                </div>
                            </div>
                        @endforeach
                        
                        @if($category->books->count() > 9)
                            <div class="bg-white rounded border p-3 flex items-center justify-center">
                                <p class="text-sm text-gray-500">
                                    +{{ $category->books->count() - 9 }} more books
                                </p>
                            </div>
                        @endif
                    </div>
                    
                    @if($category->books->count() > 0)
                        <div class="mt-3 pt-3 border-t">
                            <a href="{{ route('books.index', ['category' => $category->id]) }}" 
                               class="text-primary-600 hover:text-primary-900 text-sm font-medium">
                                View all books in this category <i class="fas fa-arrow-right ml-1"></i>
                            </a>
                        </div>
                    @endif
                </div>
            @endif

            <!-- Warnings -->
            @if($category->books->count() > 0)
                <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <i class="fas fa-exclamation-triangle text-yellow-400"></i>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-yellow-800">
                                Category Contains Books
                            </h3>
                            <div class="mt-2 text-sm text-yellow-700">
                                <p>This category currently contains {{ $category->books->count() }} book(s). Color changes will affect how these books are displayed throughout the system.</p>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Action Buttons -->
            <div class="flex items-center justify-end space-x-4 pt-6 border-t border-gray-200">
                <a href="{{ route('categories.show', $category) }}" 
                   class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                    Cancel
                </a>
                
                @if($category->books->count() === 0)
                    <form action="{{ route('categories.destroy', $category) }}" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" 
                                class="inline-flex items-center px-4 py-2 border border-red-300 text-sm font-medium rounded-md text-red-700 bg-white hover:bg-red-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500"
                                onclick="return confirm('Are you sure you want to delete this category? This action cannot be undone.')">
                            <i class="fas fa-trash mr-2"></i>
                            Delete Category
                        </button>
                    </form>
                @endif
                
                <button type="submit" 
                        class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                    <i class="fas fa-save mr-2"></i>
                    Update Category
                </button>
            </div>
        </form>
    </div>
</div>

<script>
// Color picker functionality
document.getElementById('color').addEventListener('input', function() {
    updateColorPreview(this.value);
});

document.getElementById('name').addEventListener('input', function() {
    updateBadgePreview(this.value || '{{ $category->name }}');
});

function setColor(color) {
    document.getElementById('color').value = color;
    updateColorPreview(color);
}

function updateColorPreview(color) {
    document.getElementById('color_text').value = color;
    document.getElementById('color_preview').style.backgroundColor = color;
    
    const badge = document.getElementById('preview_badge');
    badge.style.backgroundColor = color + '20';
    badge.style.color = color;
}

function updateBadgePreview(name) {
    document.getElementById('preview_badge').textContent = name;
}

// Initialize on page load
document.addEventListener('DOMContentLoaded', function() {
    updateColorPreview('{{ old('color', $category->color) }}');
    updateBadgePreview('{{ old('name', $category->name) }}');
});

// Warn about unsaved changes
let hasChanges = false;
document.querySelectorAll('input, textarea, select').forEach(element => {
    element.addEventListener('change', function() {
        hasChanges = true;
    });
});

window.addEventListener('beforeunload', function(e) {
    if (hasChanges) {
        e.preventDefault();
        e.returnValue = '';
    }
});

// Reset changes flag when form is submitted
document.querySelector('form').addEventListener('submit', function() {
    hasChanges = false;
});
</script>
@endsection