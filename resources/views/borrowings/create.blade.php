@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div>
        <nav class="flex" aria-label="Breadcrumb">
            <ol class="flex items-center space-x-2">
                <li><a href="{{ route('borrowings.index') }}" class="text-gray-500 hover:text-gray-700">Borrowings</a></li>
                <li><i class="fas fa-chevron-right text-gray-400 text-xs"></i></li>
                <li class="text-gray-900 font-medium">Issue Book</li>
            </ol>
        </nav>
        <h1 class="mt-2 text-2xl font-bold text-gray-900">Issue Book</h1>
    </div>

    <!-- Form -->
    <div class="bg-white shadow rounded-lg">
        <form action="{{ route('borrowings.store') }}" method="POST" class="space-y-6 p-6" x-data="borrowingForm()">
            @csrf
            
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Left Column - Member Selection -->
                <div class="space-y-6">
                    <div>
                        <label for="user_id" class="block text-sm font-medium text-gray-700">Select Member *</label>
                        <select name="user_id" id="user_id" required x-model="selectedUser" @change="updateUserInfo()"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-primary-500 focus:border-primary-500 sm:text-sm @error('user_id') border-red-300 @enderror">
                            <option value="">Choose a member</option>
                            @foreach($users as $userOption)
                                <option value="{{ $userOption->id }}" 
                                        data-name="{{ $userOption->name }}"
                                        data-email="{{ $userOption->email }}"
                                        data-membership="{{ $userOption->membership_id }}"
                                        data-current-borrowings="{{ $userOption->currentBorrowings->count() }}"
                                        data-total-fines="{{ $userOption->totalFines() }}"
                                        {{ ($user && $user->id == $userOption->id) || old('user_id') == $userOption->id ? 'selected' : '' }}>
                                    {{ $userOption->name }} ({{ $userOption->membership_id }})
                                </option>
                            @endforeach
                        </select>
                        @error('user_id')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Member Info Card -->
                    <div x-show="selectedUser" class="bg-gray-50 rounded-lg p-4">
                        <h4 class="text-sm font-medium text-gray-900 mb-3">Member Information</h4>
                        <dl class="grid grid-cols-1 gap-2 text-sm">
                            <div class="flex justify-between">
                                <dt class="text-gray-500">Name:</dt>
                                <dd class="text-gray-900 font-medium" x-text="userInfo.name"></dd>
                            </div>
                            <div class="flex justify-between">
                                <dt class="text-gray-500">Email:</dt>
                                <dd class="text-gray-900" x-text="userInfo.email"></dd>
                            </div>
                            <div class="flex justify-between">
                                <dt class="text-gray-500">Membership ID:</dt>
                                <dd class="text-gray-900 font-mono" x-text="userInfo.membership"></dd>
                            </div>
                            <div class="flex justify-between">
                                <dt class="text-gray-500">Current Borrowings:</dt>
                                <dd class="text-gray-900" x-text="userInfo.currentBorrowings + '/5'"></dd>
                            </div>
                            <div class="flex justify-between">
                                <dt class="text-gray-500">Outstanding Fines:</dt>
                                <dd class="font-medium" x-text="'$' + parseFloat(userInfo.totalFines).toFixed(2)" 
                                    :class="userInfo.totalFines > 0 ? 'text-red-600' : 'text-green-600'"></dd>
                            </div>
                        </dl>
                        
                        <!-- Warnings -->
                        <div x-show="userInfo.currentBorrowings >= 5" class="mt-3 p-2 bg-red-100 border border-red-200 rounded text-sm text-red-700">
                            <i class="fas fa-exclamation-triangle mr-1"></i>
                            Member has reached maximum borrowing limit (5 books).
                        </div>
                        
                        <div x-show="userInfo.totalFines >= 50" class="mt-3 p-2 bg-red-100 border border-red-200 rounded text-sm text-red-700">
                            <i class="fas fa-dollar-sign mr-1"></i>
                            Member has outstanding fines over $50.00.
                        </div>
                    </div>

                    <!-- Borrowing Dates -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label for="borrowed_date" class="block text-sm font-medium text-gray-700">Borrowed Date *</label>
                            <input type="date" name="borrowed_date" id="borrowed_date" 
                                   value="{{ old('borrowed_date', date('Y-m-d')) }}" required
                                   max="{{ date('Y-m-d') }}"
                                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-primary-500 focus:border-primary-500 sm:text-sm @error('borrowed_date') border-red-300 @enderror">
                            @error('borrowed_date')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="due_date" class="block text-sm font-medium text-gray-700">Due Date *</label>
                            <input type="date" name="due_date" id="due_date" 
                                   value="{{ old('due_date', date('Y-m-d', strtotime('+14 days'))) }}" required
                                   min="{{ date('Y-m-d', strtotime('+1 day')) }}"
                                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-primary-500 focus:border-primary-500 sm:text-sm @error('due_date') border-red-300 @enderror">
                            @error('due_date')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Notes -->
                    <div>
                        <label for="notes" class="block text-sm font-medium text-gray-700">Notes</label>
                        <textarea name="notes" id="notes" rows="3" 
                                  class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-primary-500 focus:border-primary-500 sm:text-sm @error('notes') border-red-300 @enderror"
                                  placeholder="Any special notes or conditions...">{{ old('notes') }}</textarea>
                        @error('notes')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Right Column - Book Selection -->
                <div class="space-y-6">
                    <div>
                        <label for="book_id" class="block text-sm font-medium text-gray-700">Select Book *</label>
                        <select name="book_id" id="book_id" required x-model="selectedBook" @change="updateBookInfo()"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-primary-500 focus:border-primary-500 sm:text-sm @error('book_id') border-red-300 @enderror">
                            <option value="">Choose a book</option>
                            @foreach($books as $bookOption)
                                <option value="{{ $bookOption->id }}" 
                                        data-title="{{ $bookOption->title }}"
                                        data-author="{{ $bookOption->author->name }}"
                                        data-isbn="{{ $bookOption->isbn }}"
                                        data-category="{{ $bookOption->category->name }}"
                                        data-available="{{ $bookOption->available_copies }}"
                                        data-total="{{ $bookOption->total_copies }}"
                                        data-cover="{{ $bookOption->cover_image ? Storage::url($bookOption->cover_image) : '' }}"
                                        {{ ($book && $book->id == $bookOption->id) || old('book_id') == $bookOption->id ? 'selected' : '' }}>
                                    {{ $bookOption->title }} by {{ $bookOption->author->name }} ({{ $bookOption->available_copies }} available)
                                </option>
                            @endforeach
                        </select>
                        @error('book_id')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Book Info Card -->
                    <div x-show="selectedBook" class="bg-gray-50 rounded-lg p-4">
                        <h4 class="text-sm font-medium text-gray-900 mb-3">Book Information</h4>
                        
                        <div class="flex">
                            <div class="flex-shrink-0 mr-4">
                                <div x-show="bookInfo.cover" class="w-20 h-28 rounded overflow-hidden">
                                    <img :src="bookInfo.cover" :alt="bookInfo.title" class="w-full h-full object-cover">
                                </div>
                                <div x-show="!bookInfo.cover" class="w-20 h-28 bg-gray-200 rounded flex items-center justify-center">
                                    <i class="fas fa-book text-gray-400 text-xl"></i>
                                </div>
                            </div>
                            
                            <div class="flex-1">
                                <dl class="grid grid-cols-1 gap-2 text-sm">
                                    <div>
                                        <dt class="text-gray-500">Title:</dt>
                                        <dd class="text-gray-900 font-medium" x-text="bookInfo.title"></dd>
                                    </div>
                                    <div>
                                        <dt class="text-gray-500">Author:</dt>
                                        <dd class="text-gray-900" x-text="bookInfo.author"></dd>
                                    </div>
                                    <div>
                                        <dt class="text-gray-500">ISBN:</dt>
                                        <dd class="text-gray-900 font-mono text-xs" x-text="bookInfo.isbn"></dd>
                                    </div>
                                    <div>
                                        <dt class="text-gray-500">Category:</dt>
                                        <dd class="text-gray-900" x-text="bookInfo.category"></dd>
                                    </div>
                                    <div>
                                        <dt class="text-gray-500">Availability:</dt>
                                        <dd class="font-medium" x-text="bookInfo.available + '/' + bookInfo.total + ' copies'"
                                            :class="bookInfo.available > 0 ? 'text-green-600' : 'text-red-600'"></dd>
                                    </div>
                                </dl>
                            </div>
                        </div>

                        <!-- Book Availability Warning -->
                        <div x-show="bookInfo.available <= 0" class="mt-3 p-2 bg-red-100 border border-red-200 rounded text-sm text-red-700">
                            <i class="fas fa-exclamation-triangle mr-1"></i>
                            This book is currently not available for borrowing.
                        </div>
                    </div>

                    <!-- Quick Search for Books -->
                    <div class="border-t pt-4">
                        <label for="book_search" class="block text-sm font-medium text-gray-700 mb-2">Quick Book Search</label>
                        <input type="text" id="book_search" placeholder="Search by title, author, or ISBN..." 
                               class="w-full border-gray-300 rounded-md shadow-sm focus:ring-primary-500 focus:border-primary-500 sm:text-sm"
                               @input="filterBooks($event.target.value)">
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex items-center justify-end space-x-4 pt-6 border-t border-gray-200">
                <a href="{{ route('borrowings.index') }}" 
                   class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                    Cancel
                </a>
                <button type="submit" 
                        class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500"
                        :disabled="!canSubmit()" :class="!canSubmit() ? 'opacity-50 cursor-not-allowed' : ''">
                    <i class="fas fa-hand-holding mr-2"></i>
                    Issue Book
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function borrowingForm() {
    return {
        selectedUser: '{{ ($user ? $user->id : old("user_id")) }}',
        selectedBook: '{{ ($book ? $book->id : old("book_id")) }}',
        userInfo: {
            name: '',
            email: '',
            membership: '',
            currentBorrowings: 0,
            totalFines: 0
        },
        bookInfo: {
            title: '',
            author: '',
            isbn: '',
            category: '',
            available: 0,
            total: 0,
            cover: ''
        },
        allBooks: [],

        init() {
            this.initializeBooks();
            if (this.selectedUser) this.updateUserInfo();
            if (this.selectedBook) this.updateBookInfo();
        },

        initializeBooks() {
            const bookSelect = document.getElementById('book_id');
            this.allBooks = Array.from(bookSelect.options).map(option => ({
                value: option.value,
                text: option.textContent,
                title: option.dataset.title || '',
                author: option.dataset.author || '',
                isbn: option.dataset.isbn || ''
            }));
        },

        updateUserInfo() {
            if (!this.selectedUser) return;
            
            const option = document.querySelector(`#user_id option[value="${this.selectedUser}"]`);
            if (option) {
                this.userInfo = {
                    name: option.dataset.name || '',
                    email: option.dataset.email || '',
                    membership: option.dataset.membership || '',
                    currentBorrowings: parseInt(option.dataset.currentBorrowings) || 0,
                    totalFines: parseFloat(option.dataset.totalFines) || 0
                };
            }
        },

        updateBookInfo() {
            if (!this.selectedBook) return;
            
            const option = document.querySelector(`#book_id option[value="${this.selectedBook}"]`);
            if (option) {
                this.bookInfo = {
                    title: option.dataset.title || '',
                    author: option.dataset.author || '',
                    isbn: option.dataset.isbn || '',
                    category: option.dataset.category || '',
                    available: parseInt(option.dataset.available) || 0,
                    total: parseInt(option.dataset.total) || 0,
                    cover: option.dataset.cover || ''
                };
            }
        },

        filterBooks(searchTerm) {
            const bookSelect = document.getElementById('book_id');
            const options = bookSelect.querySelectorAll('option');
            
            options.forEach(option => {
                if (option.value === '') return; // Skip empty option
                
                const text = option.textContent.toLowerCase();
                const title = (option.dataset.title || '').toLowerCase();
                const author = (option.dataset.author || '').toLowerCase();
                const isbn = (option.dataset.isbn || '').toLowerCase();
                
                const matches = text.includes(searchTerm.toLowerCase()) ||
                              title.includes(searchTerm.toLowerCase()) ||
                              author.includes(searchTerm.toLowerCase()) ||
                              isbn.includes(searchTerm.toLowerCase());
                
                option.style.display = matches ? '' : 'none';
            });
        },

        canSubmit() {
            return this.selectedUser && 
                   this.selectedBook && 
                   this.userInfo.currentBorrowings < 5 && 
                   this.userInfo.totalFines < 50 && 
                   this.bookInfo.available > 0;
        }
    }
}
</script>
@endsection