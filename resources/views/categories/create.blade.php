@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div>
        <nav class="flex" aria-label="Breadcrumb">
            <ol class="flex items-center space-x-2">
                <li><a href="{{ route('categories.index') }}" class="text-gray-500 hover:text-gray-700">Categories</a></li>
                <li><i class="fas fa-chevron-right text-gray-400 text-xs"></i></li>
                <li class="text-gray-900 font-medium">Add New Category</li>
            </ol>
        </nav>
        <h1 class="mt-2 text-2xl font-bold text-gray-900">Add New Category</h1>
    </div>

    <!-- Form -->
    <div class="bg-white shadow rounded-lg">
        <form action="{{ route('categories.store') }}" method="POST" class="space-y-6 p-6">
            @csrf
            
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Left Column -->
                <div class="space-y-6">
                    <!-- Name -->
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700">Category Name *</label>
                        <input type="text" name="name" id="name" value="{{ old('name') }}" required
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
                                  placeholder="Enter category description...">{{ old('description') }}</textarea>
                        @error('description')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Right Column -->
                <div class="space-y-6">
                    <!-- Color -->
                    <div>
                        <label for="color" class="block text-sm font-medium text-gray-700">Category Color *</label>
                        <div class="mt-1 flex items-center space-x-3">
                            <input type="color" name="color" id="color" value="{{ old('color', '#3B82F6') }}" required
                                   class="h-10 w-16 border border-gray-300 rounded-md @error('color') border-red-300 @enderror">
                            <input type="text" id="color_text" value="{{ old('color', '#3B82F6') }}" 
                                   class="flex-1 border-gray-300 rounded-md shadow-sm focus:ring-primary-500 focus:border-primary-500 sm:text-sm"
                                   placeholder="#3B82F6" readonly>
                        </div>
                        @error('color')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        <p class="mt-1 text-sm text-gray-500">This color will be used to identify books in this category</p>
                    </div>

                    <!-- Color Preview -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Preview</label>
                        <div class="flex items-center space-x-4">
                            <div id="color_preview" class="w-16 h-16 rounded-lg border-2 border-gray-300" style="background-color: {{ old('color', '#3B82F6') }};"></div>
                            <div>
                                <span id="preview_badge" class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium" 
                                      style="background-color: {{ old('color', '#3B82F6') }}20; color: {{ old('color', '#3B82F6') }}">
                                    {{ old('name', 'Category Name') }}
                                </span>
                                <p class="text-xs text-gray-500 mt-1">Badge preview</p>
                            </div>
                        </div>
                    </div>

                    <!-- Suggested Colors -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Suggested Colors</label>
                        <div class="grid grid-cols-6 gap-2">
                            <button type="button" class="w-8 h-8 rounded border-2 border-gray-300 hover:border-gray-400" 
                                    style="background-color: #3B82F6;" onclick="setColor('#3B82F6')"></button>
                            <button type="button" class="w-8 h-8 rounded border-2 border-gray-300 hover:border-gray-400" 
                                    style="background-color: #10B981;" onclick="setColor('#10B981')"></button>
                            <button type="button" class="w-8 h-8 rounded border-2 border-gray-300 hover:border-gray-400" 
                                    style="background-color: #8B5CF6;" onclick="setColor('#8B5CF6')"></button>
                            <button type="button" class="w-8 h-8 rounded border-2 border-gray-300 hover:border-gray-400" 
                                    style="background-color: #F59E0B;" onclick="setColor('#F59E0B')"></button>
                            <button type="button" class="w-8 h-8 rounded border-2 border-gray-300 hover:border-gray-400" 
                                    style="background-color: #EF4444;" onclick="setColor('#EF4444')"></button>
                            <button type="button" class="w-8 h-8 rounded border-2 border-gray-300 hover:border-gray-400" 
                                    style="background-color: #EC4899;" onclick="setColor('#EC4899')"></button>
                            <button type="button" class="w-8 h-8 rounded border-2 border-gray-300 hover:border-gray-400" 
                                    style="background-color: #6366F1;" onclick="setColor('#6366F1')"></button>
                            <button type="button" class="w-8 h-8 rounded border-2 border-gray-300 hover:border-gray-400" 
                                    style="background-color: #14B8A6;" onclick="setColor('#14B8A6')"></button>
                            <button type="button" class="w-8 h-8 rounded border-2 border-gray-300 hover:border-gray-400" 
                                    style="background-color: #F97316;" onclick="setColor('#F97316')"></button>
                            <button type="button" class="w-8 h-8 rounded border-2 border-gray-300 hover:border-gray-400" 
                                    style="background-color: #84CC16;" onclick="setColor('#84CC16')"></button>
                            <button type="button" class="w-8 h-8 rounded border-2 border-gray-300 hover:border-gray-400" 
                                    style="background-color: #06B6D4;" onclick="setColor('#06B6D4')"></button>
                            <button type="button" class="w-8 h-8 rounded border-2 border-gray-300 hover:border-gray-400" 
                                    style="background-color: #8B5A3C;" onclick="setColor('#8B5A3C')"></button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex items-center justify-end space-x-4 pt-6 border-t border-gray-200">
                <a href="{{ route('categories.index') }}" 
                   class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                    Cancel
                </a>
                <button type="submit" 
                        class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                    <i class="fas fa-save mr-2"></i>
                    Create Category
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
    updateBadgePreview(this.value || 'Category Name');
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
</script>
@endsection