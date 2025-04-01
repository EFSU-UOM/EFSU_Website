<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="light">
    <head>
        @include('partials.head')
    </head>
    <body class="min-h-screen bg-gray-50 font-sans antialiased">
        <!-- Navigation Header -->
        <header class="bg-white shadow-sm border-b border-gray-200">
            <nav class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="flex h-16 justify-between items-center">
                    <!-- Logo -->
                    <div class="flex items-center">
                        <a href="{{ route('home') }}" class="flex items-center space-x-3">
                            <div class="h-8 w-8 bg-blue-600 rounded-lg flex items-center justify-center">
                                <span class="text-white font-bold text-sm">EFSU</span>
                            </div>
                            <span class="text-xl font-semibold text-gray-900">Engineering Faculty Students Union</span>
                        </a>
                    </div>

                    <!-- Desktop Navigation -->
                    <div class="hidden md:flex items-center space-x-8">
                        <x-nav-item link="{{ route('home') }}" text="Home" />
                        <x-nav-item link="{{ route('about') }}" text="About" />
                        <x-nav-item link="{{ route('events') }}" text="Events" />
                        <x-nav-item link="{{ route('news') }}" text="News" />
                        <x-nav-item link="{{ route('resources') }}" text="Resources" />
                        <x-nav-item link="{{ route('forum') }}" text="Forum" />
                        <x-nav-item link="{{ route('gallery') }}" text="Gallery" />
                        <x-nav-item link="{{ route('alumni') }}" text="Alumni" />
                        <x-nav-item link="{{ route('contact') }}" text="Contact" />
                        
                        @auth
                            <a href="{{ route('dashboard') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors">
                                Dashboard
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="text-gray-600 hover:text-gray-900 transition-colors">
                                Login
                            </a>
                            <a href="{{ route('register') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors">
                                Register
                            </a>
                        @endauth
                    </div>

                    <!-- Mobile menu button -->
                    <div class="md:hidden">
                        <button type="button" class="text-gray-600 hover:text-gray-900 focus:outline-none focus:text-gray-900">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                            </svg>
                        </button>
                    </div>
                </div>
            </nav>
        </header>

        <!-- Main Content -->
        <main class="min-h-screen">
            {{ $slot }}
        </main>

        <!-- Footer -->
        <footer class="bg-white border-t border-gray-200">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="py-12">
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                        <div class="col-span-1 md:col-span-2">
                            <div class="flex items-center space-x-3 mb-4">
                                <div class="h-10 w-10 bg-blue-600 rounded-lg flex items-center justify-center">
                                    <span class="text-white font-bold">EFSU</span>
                                </div>
                                <span class="text-lg font-semibold text-gray-900">Engineering Faculty Students Union</span>
                            </div>
                            <p class="text-gray-600 mb-4 max-w-md">
                                Connecting engineering students, faculty, and alumni through academic excellence, 
                                social engagement, and professional development.
                            </p>
                            <div class="flex space-x-4">
                                <a href="#" class="text-gray-400 hover:text-blue-600 transition-colors">
                                    <span class="sr-only">Facebook</span>
                                    <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                                    </svg>
                                </a>
                                <a href="#" class="text-gray-400 hover:text-blue-600 transition-colors">
                                    <span class="sr-only">Instagram</span>
                                    <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M12.017 0C5.396 0 .029 5.367.029 11.987c0 6.62 5.367 11.987 11.988 11.987s11.987-5.367 11.987-11.987C24.014 5.367 18.647.001 12.017.001zM8.449 16.988c-1.297 0-2.448-.49-3.33-1.297C4.198 14.553 3.5 13.26 3.5 11.987c0-1.273.698-2.566 1.619-3.704.881-.807 2.033-1.297 3.33-1.297 1.297 0 2.448.49 3.33 1.297.921 1.138 1.619 2.431 1.619 3.704 0 1.273-.698 2.566-1.619 3.704-.882.807-2.033 1.297-3.33 1.297zm7.072 0c-1.297 0-2.448-.49-3.33-1.297-.921-1.138-1.619-2.431-1.619-3.704 0-1.273.698-2.566 1.619-3.704.882-.807 2.033-1.297 3.33-1.297s2.448.49 3.33 1.297c.921 1.138 1.619 2.431 1.619 3.704 0 1.273-.698 2.566-1.619 3.704-.882.807-2.033 1.297-3.33 1.297z"/>
                                    </svg>
                                </a>
                            </div>
                        </div>
                        
                        <div>
                            <h3 class="text-sm font-semibold text-gray-900 tracking-wider uppercase mb-4">Quick Links</h3>
                            <ul class="space-y-2">
                                <li><a href="{{ route('events') }}" class="text-gray-600 hover:text-blue-600 transition-colors">Upcoming Events</a></li>
                                <li><a href="{{ route('news') }}" class="text-gray-600 hover:text-blue-600 transition-colors">Latest News</a></li>
                                <li><a href="{{ route('resources') }}" class="text-gray-600 hover:text-blue-600 transition-colors">Student Resources</a></li>
                                <li><a href="{{ route('forum') }}" class="text-gray-600 hover:text-blue-600 transition-colors">Discussion Forum</a></li>
                            </ul>
                        </div>
                        
                        <div>
                            <h3 class="text-sm font-semibold text-gray-900 tracking-wider uppercase mb-4">Connect</h3>
                            <ul class="space-y-2">
                                <li><a href="{{ route('contact') }}" class="text-gray-600 hover:text-blue-600 transition-colors">Contact Us</a></li>
                                <li><a href="{{ route('alumni') }}" class="text-gray-600 hover:text-blue-600 transition-colors">Alumni Network</a></li>
                                <li><a href="{{ route('gallery') }}" class="text-gray-600 hover:text-blue-600 transition-colors">Photo Gallery</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                
                <div class="border-t border-gray-200 py-8 text-center">
                    <p class="text-gray-600">
                        &copy; {{ date('Y') }} Engineering Faculty Students Union. All rights reserved.
                    </p>
                </div>
            </div>
        </footer>

        @livewireScripts
    </body>
</html>