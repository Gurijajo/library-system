@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div>
        <nav class="flex" aria-label="Breadcrumb">
            <ol class="flex items-center space-x-2">
                <li><a href="{{ route('users.index') }}" class="text-gray-500 hover:text-gray-700">Members</a></li>
                <li><i class="fas fa-chevron-right text-gray-400 text-xs"></i></li>
                <li><a href="{{ route('users.show', $user) }}" class="text-gray-500 hover:text-gray-700">{{ $user->name }}</a></li>
                <li><i class="fas fa-chevron-right text-gray-400 text-xs"></i></li>
                <li class="text-gray-900 font-medium">Edit</li>
            </ol>
        </nav>
        <h1 class="mt-2 text-2xl font-bold text-gray-900">Edit Member</h1>
    </div>

    <!-- Form -->
    <div class="bg-white shadow rounded-lg">
        <form action="{{ route('users.update', $user) }}" method="POST" enctype="multipart/form-data" class="space-y-6 p-6">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Left Column -->
                <div class="space-y-6">
                    <!-- Name -->
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700">Full Name *</label>
                        <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" required
                               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-primary-500 focus:border-primary-500 sm:text-sm @error('name') border-red-300 @enderror">
                        @error('name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700">Email Address *</label>
                        <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" required
                               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-primary-500 focus:border-primary-500 sm:text-sm @error('email') border-red-300 @enderror">
                        @error('email')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Password (Optional) -->
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700">New Password</label>
                        <input type="password" name="password" id="password"
                               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-primary-500 focus:border-primary-500 sm:text-sm @error('password') border-red-300 @enderror">
                        @error('password')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        <p class="mt-1 text-sm text-gray-500">Leave blank to keep current password</p>
                    </div>

                    <!-- Confirm Password -->
                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirm New Password</label>
                        <input type="password" name="password_confirmation" id="password_confirmation"
                               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-primary-500 focus:border-primary-500 sm:text-sm">
                        <p class="mt-1 text-sm text-gray-500">Required only if changing password</p>
                    </div>

                    <!-- Phone -->
                    <div>
                        <label for="phone" class="block text-sm font-medium text-gray-700">Phone Number</label>
                        <input type="text" name="phone" id="phone" value="{{ old('phone', $user->phone) }}"
                               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-primary-500 focus:border-primary-500 sm:text-sm @error('phone') border-red-300 @enderror">
                        @error('phone')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Date of Birth -->
                    <div>
                        <label for="date_of_birth" class="block text-sm font-medium text-gray-700">Date of Birth</label>
                        <input type="date" name="date_of_birth" id="date_of_birth" 
                               value="{{ old('date_of_birth', $user->date_of_birth?->format('Y-m-d')) }}"
                               max="{{ date('Y-m-d', strtotime('-13 years')) }}"
                               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-primary-500 focus:border-primary-500 sm:text-sm @error('date_of_birth') border-red-300 @enderror">
                        @error('date_of_birth')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Right Column -->
                <div class="space-y-6">
                    <!-- Current Avatar -->
                    @if($user->avatar)
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Current Avatar</label>
                            <img src="{{ Storage::url($user->avatar) }}" alt="{{ $user->name }}" 
                                 class="h-32 w-32 rounded-full object-cover">
                        </div>
                    @endif

                    <!-- Avatar -->
                    <div>
                        <label for="avatar" class="block text-sm font-medium text-gray-700">
                            {{ $user->avatar ? 'Replace Avatar' : 'Profile Photo' }}
                        </label>
                        <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md">
                            <div class="space-y-1 text-center">
                                <i class="fas fa-user-circle text-gray-400 text-3xl"></i>
                                <div class="flex text-sm text-gray-600">
                                    <label for="avatar" class="relative cursor-pointer bg-white rounded-md font-medium text-primary-600 hover:text-primary-500">
                                        <span>Upload a photo</span>
                                        <input id="avatar" name="avatar" type="file" class="sr-only" accept="image/*">
                                    </label>
                                    <p class="pl-1">or drag and drop</p>
                                </div>
                                <p class="text-xs text-gray-500">PNG, JPG, GIF up to 2MB</p>
                            </div>
                        </div>
                        @error('avatar')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Role -->
                    <div>
                        <label for="role" class="block text-sm font-medium text-gray-700">Role *</label>
                        <select name="role" id="role" required
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-primary-500 focus:border-primary-500 sm:text-sm @error('role') border-red-300 @enderror">
                            <option value="">Select a role</option>
                            <option value="member" {{ old('role', $user->role) === 'member' ? 'selected' : '' }}>Member</option>
                            <option value="librarian" {{ old('role', $user->role) === 'librarian' ? 'selected' : '' }}>Librarian</option>
                            @if(auth()->user()->isAdmin())
                                <option value="admin" {{ old('role', $user->role) === 'admin' ? 'selected' : '' }}>Admin</option>
                            @endif
                        </select>
                        @error('role')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Status -->
                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700">Status *</label>
                        <select name="status" id="status" required
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-primary-500 focus:border-primary-500 sm:text-sm @error('status') border-red-300 @enderror">
                            <option value="active" {{ old('status', $user->status) === 'active' ? 'selected' : '' }}>Active</option>
                            <option value="inactive" {{ old('status', $user->status) === 'inactive' ? 'selected' : '' }}>Inactive</option>
                            <option value="suspended" {{ old('status', $user->status) === 'suspended' ? 'selected' : '' }}>Suspended</option>
                        </select>
                        @error('status')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Membership Expiry -->
                    <div>
                        <label for="membership_expiry" class="block text-sm font-medium text-gray-700">Membership Expiry</label>
                        <input type="date" name="membership_expiry" id="membership_expiry" 
                               value="{{ old('membership_expiry', $user->membership_expiry?->format('Y-m-d')) }}"
                               min="{{ date('Y-m-d') }}"
                               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-primary-500 focus:border-primary-500 sm:text-sm @error('membership_expiry') border-red-300 @enderror">
                        @error('membership_expiry')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Membership ID (Read-only) -->
                    <div>
                        <label for="membership_id_display" class="block text-sm font-medium text-gray-700">Membership ID</label>
                        <input type="text" id="membership_id_display" value="{{ $user->membership_id }}" readonly
                               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm bg-gray-50 text-gray-500 sm:text-sm">
                        <p class="mt-1 text-sm text-gray-500">Membership ID cannot be changed</p>
                    </div>
                </div>
            </div>

            <!-- Address -->
            <div>
                <label for="address" class="block text-sm font-medium text-gray-700">Address</label>
                <textarea name="address" id="address" rows="3" 
                          class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-primary-500 focus:border-primary-500 sm:text-sm @error('address') border-red-300 @enderror"
                          placeholder="Enter full address...">{{ old('address', $user->address) }}</textarea>
                @error('address')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Member Statistics (Read-only) -->
            <div class="bg-gray-50 rounded-lg p-4">
                <h3 class="text-sm font-medium text-gray-900 mb-3">Member Statistics</h3>
                <div class="grid grid-cols-1 sm:grid-cols-4 gap-4 text-sm">
                    <div class="text-center">
                        <div class="text-lg font-medium text-gray-900">{{ $user->borrowings->count() }}</div>
                        <div class="text-gray-500">Total Borrowings</div>
                    </div>
                    <div class="text-center">
                        <div class="text-lg font-medium {{ $user->currentBorrowings->count() > 0 ? 'text-blue-600' : 'text-gray-900' }}">
                            {{ $user->currentBorrowings->count() }}
                        </div>
                        <div class="text-gray-500">Current Borrowings</div>
                    </div>
                    <div class="text-center">
                        <div class="text-lg font-medium {{ $user->overdueBooks()->count() > 0 ? 'text-red-600' : 'text-gray-900' }}">
                            {{ $user->overdueBooks()->count() }}
                        </div>
                        <div class="text-gray-500">Overdue Books</div>
                    </div>
                    <div class="text-center">
                        <div class="text-lg font-medium {{ $user->totalFines() > 0 ? 'text-red-600' : 'text-green-600' }}">
                            ${{ number_format($user->totalFines(), 2) }}
                        </div>
                        <div class="text-gray-500">Outstanding Fines</div>
                    </div>
                </div>
            </div>

            <!-- Warnings -->
            @if($user->currentBorrowings->count() > 0)
                <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <i class="fas fa-exclamation-triangle text-yellow-400"></i>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-yellow-800">
                                Active Borrowings
                            </h3>
                            <div class="mt-2 text-sm text-yellow-700">
                                <p>This member currently has {{ $user->currentBorrowings->count() }} borrowed book(s). Changes to status or role may affect their borrowing privileges.</p>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            @if($user->totalFines() > 0)
                <div class="bg-red-50 border border-red-200 rounded-lg p-4">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <i class="fas fa-dollar-sign text-red-400"></i>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-red-800">
                                Outstanding Fines
                            </h3>
                            <div class="mt-2 text-sm text-red-700">
                                <p>This member has ${{ number_format($user->totalFines(), 2) }} in outstanding fines. Consider resolving these before changing account status.</p>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Action Buttons -->
            <div class="flex items-center justify-end space-x-4 pt-6 border-t border-gray-200">
                <a href="{{ route('users.show', $user) }}" 
                   class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                    Cancel
                </a>
                
                @if($user->id !== auth()->id() && $user->currentBorrowings->count() === 0)
                    <form action="{{ route('users.destroy', $user) }}" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" 
                                class="inline-flex items-center px-4 py-2 border border-red-300 text-sm font-medium rounded-md text-red-700 bg-white hover:bg-red-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500"
                                onclick="return confirm('Are you sure you want to delete this member? This action cannot be undone.')">
                            <i class="fas fa-trash mr-2"></i>
                            Delete Member
                        </button>
                    </form>
                @endif
                
                <button type="submit" 
                        class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                    <i class="fas fa-save mr-2"></i>
                    Update Member
                </button>
            </div>
        </form>
    </div>
</div>

<script>
// Image preview functionality
document.getElementById('avatar').addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            const preview = document.createElement('img');
            preview.src = e.target.result;
            preview.className = 'mt-2 h-32 w-32 rounded-full object-cover mx-auto';
            
            const container = document.querySelector('.border-dashed').parentNode;
            const existingPreview = container.querySelector('img:not([src*="storage"])');
            if (existingPreview) {
                existingPreview.remove();
            }
            container.appendChild(preview);
        };
        reader.readAsDataURL(file);
    }
});

// Password confirmation validation
document.getElementById('password').addEventListener('input', function() {
    const passwordConfirmation = document.getElementById('password_confirmation');
    if (this.value) {
        passwordConfirmation.required = true;
        passwordConfirmation.parentNode.querySelector('label').textContent = 'Confirm New Password *';
    } else {
        passwordConfirmation.required = false;
        passwordConfirmation.value = '';
        passwordConfirmation.parentNode.querySelector('label').textContent = 'Confirm New Password';
    }
});

// Role change warning
document.getElementById('role').addEventListener('change', function() {
    const currentRole = '{{ $user->role }}';
    if (this.value !== currentRole && this.value === 'member' && currentRole === 'librarian') {
        if (!confirm('Changing from Librarian to Member will remove administrative privileges. Are you sure?')) {
            this.value = currentRole;
        }
    }
});

// Status change warning
document.getElementById('status').addEventListener('change', function() {
    const currentBorrowings = {{ $user->currentBorrowings->count() }};
    if ((this.value === 'inactive' || this.value === 'suspended') && currentBorrowings > 0) {
        if (!confirm('This member has active borrowings. Changing status may affect their ability to return books. Continue?')) {
            this.value = '{{ $user->status }}';
        }
    }
});
</script>
@endsection