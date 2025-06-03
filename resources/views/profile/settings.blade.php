@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div>
        <nav class="flex" aria-label="Breadcrumb">
            <ol class="flex items-center space-x-2">
                <li><a href="{{ route('profile.show') }}" class="text-gray-500 hover:text-gray-700">Profile</a></li>
                <li><i class="fas fa-chevron-right text-gray-400 text-xs"></i></li>
                <li class="text-gray-900 font-medium">Settings</li>
            </ol>
        </nav>
        <h1 class="mt-2 text-2xl font-bold text-gray-900">Account Settings</h1>
        <p class="mt-1 text-sm text-gray-600">Manage your account preferences and notification settings</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Settings Form -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Notification Settings -->
            <div class="bg-white shadow rounded-lg">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">Notification Preferences</h3>
                    <p class="mt-1 text-sm text-gray-600">Choose how you want to receive notifications</p>
                </div>
                
                <form action="{{ route('profile.update-settings') }}" method="POST" class="p-6" x-data="settingsForm()">
                    @csrf
                    @method('PATCH')
                    
                    <div class="space-y-6">
                        <!-- Email Notifications -->
                        <div class="bg-gray-50 rounded-lg p-4">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0">
                                        <i class="fas fa-envelope text-blue-500 text-lg"></i>
                                    </div>
                                    <div class="ml-3">
                                        <h4 class="text-sm font-medium text-gray-900">Email Notifications</h4>
                                        <p class="text-sm text-gray-500">Receive notifications via email</p>
                                    </div>
                                </div>
                                <label class="inline-flex items-center">
                                    <input type="checkbox" name="email_notifications" value="1" 
                                           {{ ($preferences['notifications']['email'] ?? true) ? 'checked' : '' }}
                                           class="form-checkbox h-5 w-5 text-primary-600 rounded border-gray-300 focus:ring-primary-500">
                                </label>
                            </div>
                        </div>

                        <!-- SMS Notifications -->
                        <div class="bg-gray-50 rounded-lg p-4">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0">
                                        <i class="fas fa-sms text-green-500 text-lg"></i>
                                    </div>
                                    <div class="ml-3">
                                        <h4 class="text-sm font-medium text-gray-900">SMS Notifications</h4>
                                        <p class="text-sm text-gray-500">Receive notifications via text message</p>
                                    </div>
                                </div>
                                <label class="inline-flex items-center">
                                    <input type="checkbox" name="sms_notifications" value="1" 
                                           {{ ($preferences['notifications']['sms'] ?? false) ? 'checked' : '' }}
                                           class="form-checkbox h-5 w-5 text-primary-600 rounded border-gray-300 focus:ring-primary-500">
                                </label>
                            </div>
                        </div>

                        <!-- Due Date Reminders -->
                        <div class="bg-gray-50 rounded-lg p-4">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0">
                                        <i class="fas fa-calendar-alt text-yellow-500 text-lg"></i>
                                    </div>
                                    <div class="ml-3">
                                        <h4 class="text-sm font-medium text-gray-900">Due Date Reminders</h4>
                                        <p class="text-sm text-gray-500">Get reminders before books are due</p>
                                    </div>
                                </div>
                                <label class="inline-flex items-center">
                                    <input type="checkbox" name="due_date_reminders" value="1" 
                                           {{ ($preferences['notifications']['due_date_reminders'] ?? true) ? 'checked' : '' }}
                                           class="form-checkbox h-5 w-5 text-primary-600 rounded border-gray-300 focus:ring-primary-500">
                                </label>
                            </div>
                        </div>

                        <!-- New Book Alerts -->
                        <div class="bg-gray-50 rounded-lg p-4">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0">
                                        <i class="fas fa-book text-purple-500 text-lg"></i>
                                    </div>
                                    <div class="ml-3">
                                        <h4 class="text-sm font-medium text-gray-900">New Book Alerts</h4>
                                        <p class="text-sm text-gray-500">Be notified when new books are added</p>
                                    </div>
                                </div>
                                <label class="inline-flex items-center">
                                    <input type="checkbox" name="new_book_alerts" value="1" 
                                           {{ ($preferences['notifications']['new_book_alerts'] ?? false) ? 'checked' : '' }}
                                           class="form-checkbox h-5 w-5 text-primary-600 rounded border-gray-300 focus:ring-primary-500">
                                </label>
                            </div>
                        </div>

                        <!-- Newsletter Subscription -->
                        <div class="bg-gray-50 rounded-lg p-4">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0">
                                        <i class="fas fa-newspaper text-indigo-500 text-lg"></i>
                                    </div>
                                    <div class="ml-3">
                                        <h4 class="text-sm font-medium text-gray-900">Newsletter Subscription</h4>
                                        <p class="text-sm text-gray-500">Receive library news and updates</p>
                                    </div>
                                </div>
                                <label class="inline-flex items-center">
                                    <input type="checkbox" name="newsletter_subscription" value="1" 
                                           {{ ($preferences['notifications']['newsletter'] ?? false) ? 'checked' : '' }}
                                           class="form-checkbox h-5 w-5 text-primary-600 rounded border-gray-300 focus:ring-primary-500">
                                </label>
                            </div>
                        </div>
                    </div>

                    <!-- Display Preferences -->
                    <div class="mt-8 pt-8 border-t border-gray-200">
                        <h4 class="text-lg font-medium text-gray-900 mb-6">Display Preferences</h4>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Theme -->
                            <div>
                                <label for="theme" class="block text-sm font-medium text-gray-700 mb-2">Theme</label>
                                <select name="theme" id="theme" x-model="theme" @change="previewTheme()"
                                        class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-primary-500 focus:border-primary-500 sm:text-sm">
                                    <option value="light" {{ ($preferences['display']['theme'] ?? 'light') === 'light' ? 'selected' : '' }}>Light</option>
                                    <option value="dark" {{ ($preferences['display']['theme'] ?? 'light') === 'dark' ? 'selected' : '' }}>Dark</option>
                                    <option value="auto" {{ ($preferences['display']['theme'] ?? 'light') === 'auto' ? 'selected' : '' }}>Auto (System)</option>
                                </select>
                                <p class="mt-1 text-sm text-gray-500">Choose your preferred color scheme</p>
                            </div>

                            <!-- Language -->
                            <div>
                                <label for="language" class="block text-sm font-medium text-gray-700 mb-2">Language</label>
                                <select name="language" id="language"
                                        class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-primary-500 focus:border-primary-500 sm:text-sm">
                                    <option value="en" {{ ($preferences['display']['language'] ?? 'en') === 'en' ? 'selected' : '' }}>English</option>
                                    <option value="es" {{ ($preferences['display']['language'] ?? 'en') === 'es' ? 'selected' : '' }}>Español</option>
                                    <option value="fr" {{ ($preferences['display']['language'] ?? 'en') === 'fr' ? 'selected' : '' }}>Français</option>
                                    <option value="de" {{ ($preferences['display']['language'] ?? 'en') === 'de' ? 'selected' : '' }}>Deutsch</option>
                                </select>
                                <p class="mt-1 text-sm text-gray-500">Select your preferred language</p>
                            </div>

                            <!-- Items per page -->
                            <div>
                                <label for="items_per_page" class="block text-sm font-medium text-gray-700 mb-2">Items per page</label>
                                <select name="items_per_page" id="items_per_page"
                                        class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-primary-500 focus:border-primary-500 sm:text-sm">
                                    <option value="10" {{ ($preferences['display']['items_per_page'] ?? 20) == 10 ? 'selected' : '' }}>10</option>
                                    <option value="20" {{ ($preferences['display']['items_per_page'] ?? 20) == 20 ? 'selected' : '' }}>20</option>
                                    <option value="50" {{ ($preferences['display']['items_per_page'] ?? 20) == 50 ? 'selected' : '' }}>50</option>
                                    <option value="100" {{ ($preferences['display']['items_per_page'] ?? 20) == 100 ? 'selected' : '' }}>100</option>
                                </select>
                                <p class="mt-1 text-sm text-gray-500">Number of items to show per page</p>
                            </div>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="mt-8 pt-6 border-t border-gray-200">
                        <div class="flex items-center justify-end space-x-4">
                            <a href="{{ route('profile.show') }}" 
                               class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                                Cancel
                            </a>
                            <button type="submit" 
                                    class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-primary-600 hover:bg-primary-700">
                                <i class="fas fa-save mr-2"></i>
                                Save Settings
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Settings Info Sidebar -->
        <div class="lg:col-span-1 space-y-6">
            <!-- Current Settings Summary -->
            <div class="bg-white shadow rounded-lg">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">Current Settings</h3>
                </div>
                <div class="p-6 space-y-4">
                    <div class="flex items-center justify-between text-sm">
                        <span class="text-gray-500">Email Notifications:</span>
                        <span class="font-medium {{ ($preferences['notifications']['email'] ?? true) ? 'text-green-600' : 'text-gray-400' }}">
                            {{ ($preferences['notifications']['email'] ?? true) ? 'Enabled' : 'Disabled' }}
                        </span>
                    </div>
                    <div class="flex items-center justify-between text-sm">
                        <span class="text-gray-500">SMS Notifications:</span>
                        <span class="font-medium {{ ($preferences['notifications']['sms'] ?? false) ? 'text-green-600' : 'text-gray-400' }}">
                            {{ ($preferences['notifications']['sms'] ?? false) ? 'Enabled' : 'Disabled' }}
                        </span>
                    </div>
                    <div class="flex items-center justify-between text-sm">
                        <span class="text-gray-500">Due Date Reminders:</span>
                        <span class="font-medium {{ ($preferences['notifications']['due_date_reminders'] ?? true) ? 'text-green-600' : 'text-gray-400' }}">
                            {{ ($preferences['notifications']['due_date_reminders'] ?? true) ? 'Enabled' : 'Disabled' }}
                        </span>
                    </div>
                    <div class="flex items-center justify-between text-sm">
                        <span class="text-gray-500">Theme:</span>
                        <span class="font-medium capitalize">{{ $preferences['display']['theme'] ?? 'light' }}</span>
                    </div>
                    <div class="flex items-center justify-between text-sm">
                        <span class="text-gray-500">Language:</span>
                        <span class="font-medium uppercase">{{ $preferences['display']['language'] ?? 'en' }}</span>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="bg-white shadow rounded-lg">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">Quick Actions</h3>
                </div>
                <div class="p-6 space-y-3">
                    <button type="button" onclick="enableAllNotifications()" 
                            class="w-full inline-flex items-center justify-center px-3 py-2 border border-green-300 text-sm font-medium rounded-md text-green-700 bg-green-50 hover:bg-green-100">
                        <i class="fas fa-bell mr-2"></i>
                        Enable All Notifications
                    </button>
                    <button type="button" onclick="disableAllNotifications()" 
                            class="w-full inline-flex items-center justify-center px-3 py-2 border border-red-300 text-sm font-medium rounded-md text-red-700 bg-red-50 hover:bg-red-100">
                        <i class="fas fa-bell-slash mr-2"></i>
                        Disable All Notifications
                    </button>
                    <button type="button" onclick="resetToDefaults()" 
                            class="w-full inline-flex items-center justify-center px-3 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                        <i class="fas fa-undo mr-2"></i>
                        Reset to Defaults
                    </button>
                </div>
            </div>

            <!-- Privacy & Security -->
            <div class="bg-white shadow rounded-lg">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">Privacy & Security</h3>
                </div>
                <div class="p-6 space-y-4">
                    <div class="text-sm">
                        <h4 class="font-medium text-gray-900 mb-2">Data Privacy</h4>
                        <p class="text-gray-600 mb-3">Your personal information is protected and never shared with third parties.</p>
                        <a href="#" class="text-primary-600 hover:text-primary-900 font-medium">Privacy Policy</a>
                    </div>
                    
                    <div class="text-sm pt-4 border-t">
                        <h4 class="font-medium text-gray-900 mb-2">Account Security</h4>
                        <p class="text-gray-600 mb-3">Last password change: {{ $user->updated_at->format('M j, Y') }}</p>
                        <a href="{{ route('profile.edit') }}" class="text-primary-600 hover:text-primary-900 font-medium">Change Password</a>
                    </div>
                </div>
            </div>

            <!-- System Information -->
            <div class="bg-gray-50 rounded-lg p-4">
                <h4 class="text-sm font-medium text-gray-900 mb-3">System Information</h4>
                <div class="space-y-2 text-xs text-gray-600">
                    <div class="flex justify-between">
                        <span>Current Time:</span>
                        <span>{{ now()->format('M j, Y H:i') }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span>Last Login:</span>
                        <span>{{ $user->updated_at->diffForHumans() }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span>Browser:</span>
                        <span>{{ request()->header('User-Agent') ? Str::limit(request()->header('User-Agent'), 20) : 'Unknown' }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function settingsForm() {
    return {
        theme: '{{ $preferences["display"]["theme"] ?? "light" }}',
        
        previewTheme() {
            // This would implement theme preview functionality
            console.log('Theme changed to:', this.theme);
        }
    }
}

function enableAllNotifications() {
    const checkboxes = document.querySelectorAll('input[type="checkbox"][name*="notifications"], input[type="checkbox"][name*="reminders"], input[type="checkbox"][name*="alerts"], input[type="checkbox"][name*="subscription"]');
    checkboxes.forEach(checkbox => {
        checkbox.checked = true;
    });
}

function disableAllNotifications() {
    const checkboxes = document.querySelectorAll('input[type="checkbox"][name*="notifications"], input[type="checkbox"][name*="reminders"], input[type="checkbox"][name*="alerts"], input[type="checkbox"][name*="subscription"]');
    checkboxes.forEach(checkbox => {
        checkbox.checked = false;
    });
}

function resetToDefaults() {
    if (confirm('Reset all settings to default values? This will undo all your customizations.')) {
        // Reset notification preferences
        document.querySelector('input[name="email_notifications"]').checked = true;
        document.querySelector('input[name="sms_notifications"]').checked = false;
        document.querySelector('input[name="due_date_reminders"]').checked = true;
        document.querySelector('input[name="new_book_alerts"]').checked = false;
        document.querySelector('input[name="newsletter_subscription"]').checked = false;
        
        // Reset display preferences
        document.querySelector('select[name="theme"]').value = 'light';
        document.querySelector('select[name="language"]').value = 'en';
        document.querySelector('select[name="items_per_page"]').value = '20';
    }
}

// Auto-save indicator
let saveTimeout;
document.querySelectorAll('input, select').forEach(element => {
    element.addEventListener('change', function() {
        clearTimeout(saveTimeout);
        
        // Show saving indicator
        const indicator = document.createElement('div');
        indicator.className = 'fixed top-4 right-4 bg-blue-100 border border-blue-400 text-blue-700 px-4 py-2 rounded shadow-lg z-50';
        indicator.innerHTML = '<i class="fas fa-save mr-2"></i>Changes detected - remember to save!';
        document.body.appendChild(indicator);
        
        // Remove indicator after 3 seconds
        saveTimeout = setTimeout(() => {
            indicator.remove();
        }, 3000);
    });
});
</script>

<style>
.form-checkbox {
    border-radius: 0.25rem;
}
.form-checkbox:checked {
    background-color: #2563eb;
    border-color: #2563eb;
}
</style>
@endsection