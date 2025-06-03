<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Library Management System') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Font Awesome for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: {
                            50: '#eff6ff',
                            100: '#dbeafe',
                            500: '#3b82f6',
                            600: '#2563eb',
                            700: '#1d4ed8',
                            800: '#1e40af',
                            900: '#1e3a8a',
                        }
                    }
                }
            }
        }
    </script>
    
    <!-- Custom Meta Information -->
    <meta name="application-version" content="1.0.0">
    <meta name="last-updated" content="2025-06-03 08:39:01 UTC">
    <meta name="developer" content="Guram-jajanidze">
</head>
<body class="font-sans antialiased bg-gradient-to-br from-gray-50 to-blue-50 min-h-screen">
    <div class="min-h-screen">
        <!-- Navigation -->
        <nav class="bg-white shadow-xl border-b border-gray-200 backdrop-blur-sm bg-white/90 sticky top-0 z-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex items-center">
                        <!-- Logo -->
                        <div class="flex-shrink-0 flex items-center">
                            <a href="{{ route('dashboard') }}" class="flex items-center group">
                                <div class="relative">
                                    <i class="fas fa-book-open text-primary-500 text-2xl mr-3 transform group-hover:scale-110 transition-transform duration-200"></i>
                                    <div class="absolute -top-1 -right-1 w-2 h-2 bg-blue-400 rounded-full animate-pulse"></div>
                                </div>
                                <span class="font-bold text-xl bg-gradient-to-r from-primary-600 to-blue-600 bg-clip-text text-transparent">LibraryMS</span>
                            </a>
                        </div>

                        <!-- Navigation Links -->
                        <div class="hidden md:ml-10 md:flex md:space-x-8">
                            <a href="{{ route('dashboard') }}" 
                               class="inline-flex items-center px-3 py-2 rounded-lg text-sm font-medium transition-all duration-200 {{ request()->routeIs('dashboard') ? 'text-primary-600 bg-primary-50 shadow-sm' : 'text-gray-600 hover:text-primary-600 hover:bg-primary-50' }}">
                                <i class="fas fa-chart-line mr-2"></i>
                                Dashboard
                            </a>
                            
                        <a href="{{ route('books.index') }}" 
                        class="nav-link inline-flex items-center px-4 py-2 rounded-xl text-sm font-medium transition-all duration-300 {{ request()->routeIs('books.*') ? 'text-primary-700 bg-gradient-to-r from-primary-50 to-blue-50 shadow-soft border border-primary-100' : 'text-gray-600 hover:text-primary-600 hover:bg-gradient-to-r hover:from-primary-50 hover:to-blue-50' }}">
                            <i class="fas fa-book mr-2"></i>
                            Books
                        </a>>
                            
                            <a href="{{ route('reservations.index') }}" 
                               class="inline-flex items-center px-3 py-2 rounded-lg text-sm font-medium transition-all duration-200 {{ request()->routeIs('reservations.*') ? 'text-primary-600 bg-primary-50 shadow-sm' : 'text-gray-600 hover:text-primary-600 hover:bg-primary-50' }}">
                                <i class="fas fa-bookmark mr-2"></i>
                                Reservations
                                @php
                                    $userReservationsCount = auth()->user()->activeReservations()->count();
                                @endphp
                                @if($userReservationsCount > 0)
                                    <span class="ml-1 inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-primary-100 text-primary-800">
                                        {{ $userReservationsCount }}
                                    </span>
                                @endif
                            </a>
                            
                            @if(auth()->user()->isLibrarian())
                                <a href="{{ route('borrowings.index') }}" 
                                   class="inline-flex items-center px-3 py-2 rounded-lg text-sm font-medium transition-all duration-200 {{ request()->routeIs('borrowings.*') ? 'text-primary-600 bg-primary-50 shadow-sm' : 'text-gray-600 hover:text-primary-600 hover:bg-primary-50' }}">
                                    <i class="fas fa-hand-holding mr-2"></i>
                                    Borrowings
                                    @php
                                        $overdueCount = \App\Models\Borrowing::where('due_date', '<', now())->where('status', 'borrowed')->count();
                                    @endphp
                                    @if($overdueCount > 0)
                                        <span class="ml-1 inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                            {{ $overdueCount }}
                                        </span>
                                    @endif
                                </a>

                                <a href="{{ route('categories.index') }}" 
                                   class="inline-flex items-center px-3 py-2 rounded-lg text-sm font-medium transition-all duration-200 {{ request()->routeIs('categories.*') ? 'text-primary-600 bg-primary-50 shadow-sm' : 'text-gray-600 hover:text-primary-600 hover:bg-primary-50' }}">
                                    <i class="fas fa-tags mr-2"></i>
                                    Categories
                                </a>
                                
                                <a href="{{ route('users.index') }}" 
                                   class="inline-flex items-center px-3 py-2 rounded-lg text-sm font-medium transition-all duration-200 {{ request()->routeIs('users.*') ? 'text-primary-600 bg-primary-50 shadow-sm' : 'text-gray-600 hover:text-primary-600 hover:bg-primary-50' }}">
                                    <i class="fas fa-users mr-2"></i>
                                    Members
                                </a>
                            @else
                                <!-- Member-only links -->
                                <a href="{{ route('borrowings.index') }}" 
                                   class="inline-flex items-center px-3 py-2 rounded-lg text-sm font-medium transition-all duration-200 {{ request()->routeIs('borrowings.*') ? 'text-primary-600 bg-primary-50 shadow-sm' : 'text-gray-600 hover:text-primary-600 hover:bg-primary-50' }}">
                                    <i class="fas fa-hand-holding mr-2"></i>
                                    My Books
                                </a>
                            @endif
                        </div>
                    </div>

                    <!-- Right Side -->
                    <div class="flex items-center space-x-4">


                        <!-- Quick Actions Dropdown -->
                        <div class="relative" x-data="{ open: false }">
                            <button @click="open = !open" class="relative p-2 text-gray-500 hover:text-primary-600 hover:bg-primary-50 rounded-lg transition-all duration-200">
                                <i class="fas fa-plus-circle text-lg"></i>
                            </button>

                            <div x-show="open" @click.away="open = false" 
                                 class="absolute right-0 mt-2 w-56 bg-white rounded-xl shadow-lg py-2 z-50 border border-gray-200">
                                <div class="px-4 py-2 text-sm font-medium text-gray-900 border-b border-gray-100">
                                    <i class="fas fa-plus mr-2 text-primary-500"></i>Quick Actions
                                </div>
                                <a href="{{ route('reservations.create') }}" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">
                                    <i class="fas fa-bookmark mr-3 text-blue-500"></i>Reserve a Book
                                </a>
                                @if(auth()->user()->isLibrarian())
                                    <a href="{{ route('books.create') }}" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">
                                        <i class="fas fa-plus mr-3 text-green-500"></i>Add New Book
                                    </a>
                                    <a href="{{ route('borrowings.create') }}" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">
                                        <i class="fas fa-hand-holding mr-3 text-purple-500"></i>Create Borrowing
                                    </a>
                                    <a href="{{ route('users.create') }}" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">
                                        <i class="fas fa-user-plus mr-3 text-indigo-500"></i>Add Member
                                    </a>
                                @endif
                            </div>
                        </div>

                        <!-- Notifications -->
                        <div class="relative" x-data="{ open: false }">
                            <button @click="open = !open" class="relative p-2 text-gray-500 hover:text-primary-600 hover:bg-primary-50 rounded-lg transition-all duration-200">
                                <i class="fas fa-bell text-lg"></i>
                                @php
                                    $notificationCount = 0;
                                    if(auth()->user()->isLibrarian()) {
                                        $notificationCount = \App\Models\Borrowing::where('due_date', '<', now())->where('status', 'borrowed')->count() +
                                                           \App\Models\Reservation::where('status', 'active')->where('expiry_date', '<', now())->count();
                                    } else {
                                        $notificationCount = auth()->user()->borrowings()->where('due_date', '<', now())->where('status', 'borrowed')->count() +
                                                           auth()->user()->reservations()->where('status', 'active')->where('expiry_date', '<', now())->count();
                                    }
                                @endphp
                                @if($notificationCount > 0)
                                    <span class="absolute -top-1 -right-1 w-3 h-3 bg-red-500 rounded-full flex items-center justify-center">
                                        <span class="text-xs text-white font-bold">{{ $notificationCount > 9 ? '9+' : $notificationCount }}</span>
                                    </span>
                                @endif
                            </button>

                            <div x-show="open" @click.away="open = false" 
                                 class="absolute right-0 mt-2 w-80 bg-white rounded-xl shadow-lg py-2 z-50 border border-gray-200">
                                <div class="px-4 py-2 text-sm font-medium text-gray-900 border-b border-gray-100">
                                    <i class="fas fa-bell mr-2 text-primary-500"></i>Notifications
                                    @if($notificationCount > 0)
                                        <span class="float-right text-red-600">({{ $notificationCount }})</span>
                                    @endif
                                </div>
                                <div class="max-h-64 overflow-y-auto">
                                    @if($notificationCount > 0)
                                        @if(auth()->user()->isLibrarian())
                                            @php
                                                $overdueBorrowings = \App\Models\Borrowing::with(['user', 'book'])->where('due_date', '<', now())->where('status', 'borrowed')->take(3)->get();
                                                $expiredReservations = \App\Models\Reservation::with(['user', 'book'])->where('status', 'active')->where('expiry_date', '<', now())->take(3)->get();
                                            @endphp
                                            @foreach($overdueBorrowings as $borrowing)
                                                <a href="{{ route('borrowings.show', $borrowing) }}" class="block px-4 py-3 text-sm text-gray-700 hover:bg-gray-50 border-b border-gray-50">
                                                    <div class="flex items-start">
                                                        <div class="flex-shrink-0">
                                                            <i class="fas fa-exclamation-triangle text-red-500 mt-1"></i>
                                                        </div>
                                                        <div class="ml-3">
                                                            <p class="font-medium">Overdue Book</p>
                                                            <p class="text-gray-500">"{{ $borrowing->book->title }}" - {{ $borrowing->user->name }}</p>
                                                            <p class="text-xs text-red-600">Due: {{ $borrowing->due_date->format('M j') }}</p>
                                                        </div>
                                                    </div>
                                                </a>
                                            @endforeach
                                            @foreach($expiredReservations as $reservation)
                                                <a href="{{ route('reservations.show', $reservation) }}" class="block px-4 py-3 text-sm text-gray-700 hover:bg-gray-50 border-b border-gray-50">
                                                    <div class="flex items-start">
                                                        <div class="flex-shrink-0">
                                                            <i class="fas fa-clock text-yellow-500 mt-1"></i>
                                                        </div>
                                                        <div class="ml-3">
                                                            <p class="font-medium">Expired Reservation</p>
                                                            <p class="text-gray-500">"{{ $reservation->book->title }}" - {{ $reservation->user->name }}</p>
                                                            <p class="text-xs text-yellow-600">Expired: {{ $reservation->expiry_date->format('M j') }}</p>
                                                        </div>
                                                    </div>
                                                </a>
                                            @endforeach
                                        @else
                                            @php
                                                $userOverdue = auth()->user()->borrowings()->where('due_date', '<', now())->where('status', 'borrowed')->take(3)->get();
                                                $userExpired = auth()->user()->reservations()->where('status', 'active')->where('expiry_date', '<', now())->take(3)->get();
                                            @endphp
                                            @foreach($userOverdue as $borrowing)
                                                <a href="{{ route('borrowings.show', $borrowing) }}" class="block px-4 py-3 text-sm text-gray-700 hover:bg-gray-50">
                                                    <div class="flex items-start">
                                                        <div class="flex-shrink-0">
                                                            <i class="fas fa-exclamation-triangle text-red-500 mt-1"></i>
                                                        </div>
                                                        <div class="ml-3">
                                                            <p class="font-medium">Book Overdue</p>
                                                            <p class="text-gray-500">"{{ $borrowing->book->title }}"</p>
                                                            <p class="text-xs text-red-600">Due: {{ $borrowing->due_date->format('M j, Y') }}</p>
                                                        </div>
                                                    </div>
                                                </a>
                                            @endforeach
                                        @endif
                                    @else
                                        <div class="px-4 py-8 text-center">
                                            <i class="fas fa-check-circle text-green-400 text-2xl mb-2"></i>
                                            <p class="text-sm text-gray-500">No new notifications</p>
                                        </div>
                                    @endif
                                </div>
                                @if($notificationCount > 3)
                                    <div class="px-4 py-2 border-t border-gray-100">
                                        <a href="{{ auth()->user()->isLibrarian() ? route('borrowings.overdue') : route('borrowings.index') }}" 
                                           class="text-sm text-primary-600 hover:text-primary-700 font-medium">
                                            View all notifications ({{ $notificationCount - 3 }} more)
                                        </a>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- User Dropdown -->
                        <div class="relative" x-data="{ open: false }">
                            <button @click="open = !open" class="flex items-center text-sm rounded-xl hover:bg-primary-50 transition-all duration-200 p-2 group">
                                @if(auth()->user()->avatar)
                                    <img class="h-8 w-8 rounded-full object-cover ring-2 ring-primary-200 group-hover:ring-primary-300" src="{{ Storage::url(auth()->user()->avatar) }}" alt="{{ auth()->user()->name }}">
                                @else
                                    <div class="h-8 w-8 rounded-full bg-gradient-to-br from-primary-500 to-blue-600 flex items-center justify-center ring-2 ring-primary-200 group-hover:ring-primary-300 shadow-sm">
                                        <span class="text-white font-medium text-sm">{{ substr(auth()->user()->name, 0, 1) }}</span>
                                    </div>
                                @endif
                                <span class="ml-2 text-gray-700 font-medium group-hover:text-primary-600 hidden sm:block">{{ auth()->user()->name }}</span>
                                <i class="fas fa-chevron-down ml-2 text-gray-400 group-hover:text-primary-500 transition-transform duration-200 group-hover:rotate-180 hidden sm:block"></i>
                            </button>

                            <div x-show="open" @click.away="open = false" 
                                 class="absolute right-0 mt-2 w-56 bg-white rounded-xl shadow-lg py-2 z-50 border border-gray-200">
                                <div class="px-4 py-3 border-b border-gray-100">
                                    <p class="text-sm font-medium text-gray-900">{{ auth()->user()->name }}</p>
                                    <p class="text-xs text-gray-500">{{ auth()->user()->email }}</p>
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-primary-100 text-primary-800 mt-1">
                                        <i class="fas fa-crown mr-1"></i>{{ ucfirst(auth()->user()->role) }}
                                    </span>
                                </div>
                                <a href="{{ route('profile.show') }}" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 rounded-lg mx-2">
                                    <i class="fas fa-user-circle mr-3 text-blue-500"></i>My Profile
                                </a>
                                <a href="{{ route('profile.settings') }}" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 rounded-lg mx-2">
                                    <i class="fas fa-cog mr-3 text-gray-500"></i>Settings
                                </a>
                                <div class="border-t border-gray-100 my-2"></div>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="flex items-center w-full px-4 py-2 text-sm text-red-600 hover:bg-red-50 rounded-lg mx-2">
                                        <i class="fas fa-sign-out-alt mr-3 text-red-500"></i>Sign Out
                                    </button>
                                </form>
                            </div>
                        </div>

                        <!-- Mobile menu button -->
                        <div class="md:hidden">
                            <button type="button" class="text-gray-500 hover:text-primary-600 hover:bg-primary-50 p-2 rounded-lg transition-all duration-200" x-data="{}" @click="$dispatch('toggle-mobile-menu')">
                                <i class="fas fa-bars text-lg"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Mobile menu -->
            <div class="md:hidden" x-data="{ open: false }" @toggle-mobile-menu.window="open = !open" x-show="open" x-transition>
                <div class="px-4 pt-4 pb-6 space-y-2 border-t border-gray-200 bg-white/95 backdrop-blur-sm">
                    
                    <a href="{{ route('dashboard') }}" class="flex items-center px-3 py-3 text-base font-medium text-gray-700 hover:bg-primary-50 hover:text-primary-600 rounded-lg transition-all duration-200">
                        <i class="fas fa-chart-line mr-3 text-blue-500"></i>Dashboard
                    </a>
                    <a href="{{ route('books.index') }}" class="flex items-center px-3 py-3 text-base font-medium text-gray-700 hover:bg-primary-50 hover:text-primary-600 rounded-lg transition-all duration-200">
                        <i class="fas fa-book mr-2 text-emerald-500"></i>Books
                    </a>
                    <a href="{{ route('reservations.index') }}" class="flex items-center px-3 py-3 text-base font-medium text-gray-700 hover:bg-primary-50 hover:text-primary-600 rounded-lg transition-all duration-200">
                        <i class="fas fa-bookmark mr-3 text-purple-500"></i>Reservations
                    </a>
                    <a href="{{ route('borrowings.index') }}" class="flex items-center px-3 py-3 text-base font-medium text-gray-700 hover:bg-primary-50 hover:text-primary-600 rounded-lg transition-all duration-200">
                        <i class="fas fa-hand-holding mr-3 text-yellow-500"></i>
                        @if(auth()->user()->isLibrarian()) Borrowings @else My Books @endif
                    </a>
                    @if(auth()->user()->isLibrarian())
                        <a href="{{ route('categories.index') }}" class="flex items-center px-3 py-3 text-base font-medium text-gray-700 hover:bg-primary-50 hover:text-primary-600 rounded-lg transition-all duration-200">
                            <i class="fas fa-tags mr-3 text-orange-500"></i>Categories
                        </a>
                        <a href="{{ route('users.index') }}" class="flex items-center px-3 py-3 text-base font-medium text-gray-700 hover:bg-primary-50 hover:text-primary-600 rounded-lg transition-all duration-200">
                            <i class="fas fa-users mr-3 text-indigo-500"></i>Members
                        </a>
                    @endif
                </div>
            </div>
        </nav>

        <!-- Flash Messages -->
        @if(session('success'))
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
                <div class="bg-gradient-to-r from-green-50 to-emerald-50 border border-green-200 text-green-800 px-6 py-4 rounded-xl shadow-sm" x-data="{ show: true }" x-show="show" x-transition>
                    <div class="flex items-center">
                        <i class="fas fa-check-circle text-green-500 mr-3"></i>
                        <span class="flex-1">{{ session('success') }}</span>
                        <button type="button" class="ml-4 text-green-500 hover:text-green-700" @click="show = false">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>
            </div>
        @endif

        @if(session('error'))
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
                <div class="bg-gradient-to-r from-red-50 to-rose-50 border border-red-200 text-red-800 px-6 py-4 rounded-xl shadow-sm" x-data="{ show: true }" x-show="show" x-transition>
                    <div class="flex items-center">
                        <i class="fas fa-exclamation-triangle text-red-500 mr-3"></i>
                        <span class="flex-1">{{ session('error') }}</span>
                        <button type="button" class="ml-4 text-red-500 hover:text-red-700" @click="show = false">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>
            </div>
        @endif

        @if(session('warning'))
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
                <div class="bg-gradient-to-r from-yellow-50 to-amber-50 border border-yellow-200 text-yellow-800 px-6 py-4 rounded-xl shadow-sm" x-data="{ show: true }" x-show="show" x-transition>
                    <div class="flex items-center">
                        <i class="fas fa-exclamation-circle text-yellow-500 mr-3"></i>
                        <span class="flex-1">{{ session('warning') }}</span>
                        <button type="button" class="ml-4 text-yellow-500 hover:text-yellow-700" @click="show = false">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>
            </div>
        @endif

        @if(session('info'))
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
                <div class="bg-gradient-to-r from-blue-50 to-indigo-50 border border-blue-200 text-blue-800 px-6 py-4 rounded-xl shadow-sm" x-data="{ show: true }" x-show="show" x-transition>
                    <div class="flex items-center">
                        <i class="fas fa-info-circle text-blue-500 mr-3"></i>
                        <span class="flex-1">{{ session('info') }}</span>
                        <button type="button" class="ml-4 text-blue-500 hover:text-blue-700" @click="show = false">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>
            </div>
        @endif

        <!-- Page Content -->
        <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            @yield('content')
        </main>

        <!-- Footer -->
        <footer class="bg-white border-t border-gray-200 mt-auto">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
                <div class="flex items-center justify-between">
                    <div class="flex items-center text-sm text-gray-500">
                        <i class="fas fa-copyright mr-2"></i>
                        <span>{{ date('Y') }} LibraryMS v1.0.0 - Developed by Guram-jajanidze</span>
                    </div>
                    <div class="flex items-center space-x-4 text-sm text-gray-500">
                        <span class="flex items-center">
                            <i class="fas fa-clock mr-2 text-blue-500"></i>
                            <span id="current-time">{{ now()->format('M j, Y H:i') }} UTC</span>
                        </span>
                        <span class="flex items-center">
                            <i class="fas fa-user mr-2 text-green-500"></i>
                            Welcome, {{ auth()->user()->name }}
                        </span>
                    </div>
                </div>
            </div>
        </footer>
    </div>

    <!-- Scripts -->
    <script>
        // Auto-hide flash messages after 6 seconds
        document.addEventListener('DOMContentLoaded', function() {
            setTimeout(function() {
                const alerts = document.querySelectorAll('[x-data*="show: true"]');
                alerts.forEach(alert => {
                    if (alert.querySelector('button')) {
                        alert.querySelector('button').click();
                    }
                });
            }, 6000);
        });

        // Update current time every minute
        setInterval(function() {
            const now = new Date();
            const timeElement = document.getElementById('current-time');
            if (timeElement) {
                timeElement.textContent = now.toLocaleString('en-US', {
                    month: 'short',
                    day: 'numeric',
                    year: 'numeric',
                    hour: '2-digit',
                    minute: '2-digit',
                    timeZone: 'UTC'
                }) + ' UTC';
            }
        }, 60000);

        // Add smooth scrolling
        document.documentElement.style.scrollBehavior = 'smooth';

        // CSRF token setup for AJAX requests
        window.axios = window.axios || {};
        window.axios.defaults = window.axios.defaults || {};
        window.axios.defaults.headers = window.axios.defaults.headers || {};
        window.axios.defaults.headers.common = window.axios.defaults.headers.common || {};
        window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
        
        const token = document.querySelector('meta[name="csrf-token"]');
        if (token) {
            window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.getAttribute('content');
        }
    </script>
</body>
</html>