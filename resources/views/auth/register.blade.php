<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Register - {{ config('app.name', 'Library Management System') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Font Awesome for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

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
                        }
                    }
                }
            }
        }
    </script>
</head>
<body class="font-sans antialiased bg-gradient-to-br from-primary-50 to-blue-100 min-h-screen">
    <div class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-2xl w-full space-y-8">
            <!-- Header -->
            <div class="text-center">
                <div class="flex justify-center">
                    <div class="bg-primary-600 rounded-full p-3">
                        <i class="fas fa-book text-white text-2xl"></i>
                    </div>
                </div>
                <h2 class="mt-6 text-3xl font-extrabold text-gray-900">
                    Join Our Library
                </h2>
                <p class="mt-2 text-sm text-gray-600">
                    Create your account to start borrowing books
                </p>
            </div>

            <!-- Registration Form -->
            <div class="bg-white shadow-xl rounded-lg p-8">
                <form class="space-y-6" action="{{ route('register') }}" method="POST" enctype="multipart/form-data" x-data="registrationForm()">
                    @csrf
                    
                    <!-- Profile Photo -->
                    <div class="flex justify-center">
                        <div class="relative">
                            <div class="w-24 h-24 rounded-full overflow-hidden bg-gray-100 flex items-center justify-center border-2 border-dashed border-gray-300 hover:border-primary-400 transition-colors cursor-pointer"
                                 @click="$refs.avatar.click()">
                                <div x-show="!previewUrl" class="text-center">
                                    <i class="fas fa-camera text-gray-400 text-xl mb-1"></i>
                                    <p class="text-xs text-gray-500">Photo</p>
                                </div>
                                <img x-show="previewUrl" :src="previewUrl" alt="Preview" class="w-full h-full object-cover">
                            </div>
                            <input type="file" name="avatar" x-ref="avatar" class="hidden" accept="image/*" @change="handleFileSelect($event)">
                            @error('avatar')
                                <p class="mt-1 text-sm text-red-600 text-center">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Left Column -->
                        <div class="space-y-4">
                            <!-- Full Name -->
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700">
                                    Full Name *
                                </label>
                                <div class="mt-1 relative">
                                    <input id="name" name="name" type="text" required 
                                           value="{{ old('name') }}"
                                           class="appearance-none block w-full px-3 py-2 pl-10 border border-gray-300 placeholder-gray-400 text-gray-900 rounded-md focus:outline-none focus:ring-primary-500 focus:border-primary-500 sm:text-sm @error('name') border-red-300 @enderror"
                                           placeholder="Enter your full name">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fas fa-user text-gray-400"></i>
                                    </div>
                                </div>
                                @error('name')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Email -->
                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700">
                                    Email Address *
                                </label>
                                <div class="mt-1 relative">
                                    <input id="email" name="email" type="email" required 
                                           value="{{ old('email') }}"
                                           class="appearance-none block w-full px-3 py-2 pl-10 border border-gray-300 placeholder-gray-400 text-gray-900 rounded-md focus:outline-none focus:ring-primary-500 focus:border-primary-500 sm:text-sm @error('email') border-red-300 @enderror"
                                           placeholder="Enter your email">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fas fa-envelope text-gray-400"></i>
                                    </div>
                                </div>
                                @error('email')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Phone -->
                            <div>
                                <label for="phone" class="block text-sm font-medium text-gray-700">
                                    Phone Number
                                </label>
                                <div class="mt-1 relative">
                                    <input id="phone" name="phone" type="tel" 
                                           value="{{ old('phone') }}"
                                           class="appearance-none block w-full px-3 py-2 pl-10 border border-gray-300 placeholder-gray-400 text-gray-900 rounded-md focus:outline-none focus:ring-primary-500 focus:border-primary-500 sm:text-sm @error('phone') border-red-300 @enderror"
                                           placeholder="Enter your phone number">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fas fa-phone text-gray-400"></i>
                                    </div>
                                </div>
                                @error('phone')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Date of Birth -->
                            <div>
                                <label for="date_of_birth" class="block text-sm font-medium text-gray-700">
                                    Date of Birth
                                </label>
                                <div class="mt-1 relative">
                                    <input id="date_of_birth" name="date_of_birth" type="date" 
                                           value="{{ old('date_of_birth') }}"
                                           max="{{ date('Y-m-d', strtotime('-13 years')) }}"
                                           class="appearance-none block w-full px-3 py-2 pl-10 border border-gray-300 placeholder-gray-400 text-gray-900 rounded-md focus:outline-none focus:ring-primary-500 focus:border-primary-500 sm:text-sm @error('date_of_birth') border-red-300 @enderror">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fas fa-calendar text-gray-400"></i>
                                    </div>
                                </div>
                                @error('date_of_birth')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Right Column -->
                        <div class="space-y-4">
                            <!-- Password -->
                            <div>
                                <label for="password" class="block text-sm font-medium text-gray-700">
                                    Password *
                                </label>
                                <div class="mt-1 relative">
                                    <input id="password" name="password" type="password" required
                                           x-model="password" @input="checkPasswordStrength()"
                                           class="appearance-none block w-full px-3 py-2 pl-10 border border-gray-300 placeholder-gray-400 text-gray-900 rounded-md focus:outline-none focus:ring-primary-500 focus:border-primary-500 sm:text-sm @error('password') border-red-300 @enderror"
                                           placeholder="Create a password">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fas fa-lock text-gray-400"></i>
                                    </div>
                                </div>
                                @error('password')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                                
                                <!-- Password Strength Indicator -->
                                <div x-show="password.length > 0" class="mt-2">
                                    <div class="flex items-center space-x-2">
                                        <div class="flex-1 bg-gray-200 rounded-full h-1">
                                            <div class="h-1 rounded-full transition-all duration-300" 
                                                 :class="passwordStrengthColor" 
                                                 :style="`width: ${passwordStrengthWidth}%`"></div>
                                        </div>
                                        <span class="text-xs font-medium" :class="passwordStrengthTextColor" x-text="passwordStrengthText"></span>
                                    </div>
                                </div>
                            </div>

                            <!-- Confirm Password -->
                            <div>
                                <label for="password_confirmation" class="block text-sm font-medium text-gray-700">
                                    Confirm Password *
                                </label>
                                <div class="mt-1 relative">
                                    <input id="password_confirmation" name="password_confirmation" type="password" required
                                           x-model="passwordConfirmation"
                                           class="appearance-none block w-full px-3 py-2 pl-10 border border-gray-300 placeholder-gray-400 text-gray-900 rounded-md focus:outline-none focus:ring-primary-500 focus:border-primary-500 sm:text-sm"
                                           placeholder="Confirm your password">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fas fa-lock text-gray-400"></i>
                                    </div>
                                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center" x-show="passwordConfirmation.length > 0">
                                        <i :class="passwordsMatch ? 'fas fa-check text-green-500' : 'fas fa-times text-red-500'"></i>
                                    </div>
                                </div>
                                <div x-show="passwordConfirmation.length > 0 && !passwordsMatch" class="mt-1 text-sm text-red-600">
                                    Passwords do not match
                                </div>
                            </div>

                            <!-- Address -->
                            <div>
                                <label for="address" class="block text-sm font-medium text-gray-700">
                                    Address
                                </label>
                                <div class="mt-1 relative">
                                    <textarea id="address" name="address" rows="3"
                                              class="appearance-none block w-full px-3 py-2 pl-10 border border-gray-300 placeholder-gray-400 text-gray-900 rounded-md focus:outline-none focus:ring-primary-500 focus:border-primary-500 sm:text-sm @error('address') border-red-300 @enderror"
                                              placeholder="Enter your address">{{ old('address') }}</textarea>
                                    <div class="absolute top-3 left-0 pl-3 flex items-start pointer-events-none">
                                        <i class="fas fa-map-marker-alt text-gray-400"></i>
                                    </div>
                                </div>
                                @error('address')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Terms and Conditions -->
                    <div class="flex items-start">
                        <div class="flex items-center h-5">
                            <input id="terms" name="terms" type="checkbox" required
                                   class="h-4 w-4 text-primary-600 focus:ring-primary-500 border-gray-300 rounded">
                        </div>
                        <div class="ml-3 text-sm">
                            <label for="terms" class="text-gray-600">
                                I agree to the 
                                <a href="#" class="text-primary-600 hover:text-primary-500 font-medium">Terms of Service</a> 
                                and 
                                <a href="#" class="text-primary-600 hover:text-primary-500 font-medium">Privacy Policy</a>
                            </label>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div>
                        <button type="submit" 
                                :disabled="!formValid"
                                class="group relative w-full flex justify-center py-3 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition duration-150 ease-in-out disabled:opacity-50 disabled:cursor-not-allowed">
                            <span class="absolute left-0 inset-y-0 flex items-center pl-3">
                                <i class="fas fa-user-plus text-primary-500 group-hover:text-primary-400"></i>
                            </span>
                            Create Account
                        </button>
                    </div>

                    <!-- Login Link -->
                    <div class="text-center">
                        <p class="text-sm text-gray-600">
                            Already have an account? 
                            <a href="{{ route('login') }}" class="font-medium text-primary-600 hover:text-primary-500">
                                Sign in here
                            </a>
                        </p>
                    </div>
                </form>

                <!-- Benefits Section -->
                <div class="mt-8 pt-6 border-t border-gray-200">
                    <h3 class="text-sm font-medium text-gray-900 mb-3">Member Benefits:</h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 text-xs text-gray-600">
                        <div class="flex items-center">
                            <i class="fas fa-check text-green-500 mr-2"></i>
                            Borrow up to 5 books simultaneously
                        </div>
                        <div class="flex items-center">
                            <i class="fas fa-check text-green-500 mr-2"></i>
                            14-day loan period for all books
                        </div>
                        <div class="flex items-center">
                            <i class="fas fa-check text-green-500 mr-2"></i>
                            Reserve unavailable books
                        </div>
                        <div class="flex items-center">
                            <i class="fas fa-check text-green-500 mr-2"></i>
                            Access to digital resources
                        </div>
                    </div>
                </div>
            </div>

            <!-- Footer -->
            <div class="text-center">
                <p class="text-sm text-gray-600">
                    © {{ date('Y') }} Library Management System. All rights reserved.
                </p>
            </div>
        </div>
    </div>

    <script>
    function registrationForm() {
        return {
            password: '',
            passwordConfirmation: '',
            previewUrl: null,
            passwordStrength: 0,
            
            get passwordsMatch() {
                return this.password === this.passwordConfirmation && this.passwordConfirmation.length > 0;
            },
            
            get formValid() {
                return this.password.length >= 8 && 
                       this.passwordsMatch && 
                       this.passwordStrength >= 2;
            },
            
            get passwordStrengthColor() {
                if (this.passwordStrength <= 1) return 'bg-red-500';
                if (this.passwordStrength <= 2) return 'bg-yellow-500';
                if (this.passwordStrength <= 3) return 'bg-blue-500';
                return 'bg-green-500';
            },
            
            get passwordStrengthTextColor() {
                if (this.passwordStrength <= 1) return 'text-red-600';
                if (this.passwordStrength <= 2) return 'text-yellow-600';
                if (this.passwordStrength <= 3) return 'text-blue-600';
                return 'text-green-600';
            },
            
            get passwordStrengthText() {
                if (this.passwordStrength <= 1) return 'Weak';
                if (this.passwordStrength <= 2) return 'Fair';
                if (this.passwordStrength <= 3) return 'Good';
                return 'Strong';
            },
            
            get passwordStrengthWidth() {
                return (this.passwordStrength + 1) * 25;
            },
            
            checkPasswordStrength() {
                let strength = 0;
                
                if (this.password.length >= 8) strength++;
                if (/[a-z]/.test(this.password)) strength++;
                if (/[A-Z]/.test(this.password)) strength++;
                if (/[0-9]/.test(this.password)) strength++;
                if (/[^A-Za-z0-9]/.test(this.password)) strength++;
                
                this.passwordStrength = Math.min(strength, 4);
            },
            
            handleFileSelect(event) {
                const file = event.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = (e) => {
                        this.previewUrl = e.target.result;
                    };
                    reader.readAsDataURL(file);
                }
            }
        }
    }
    </script>

    @if(session('success'))
        <div class="fixed top-4 right-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded shadow-lg z-50" x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 8000)">
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="fixed top-4 right-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded shadow-lg z-50" x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 8000)">
            <strong>Registration failed!</strong> Please check the form for errors.
        </div>
    @endif
</body>
</html>