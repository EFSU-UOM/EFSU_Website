<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="light">
    <head>
        @include('partials.head')
    </head>
    <body class="min-h-screen bg-base-100 text-base-content font-sans antialiased">
        <!-- Navigation Header -->
        <header class="bg-base-100 shadow-sm border-b border-base-200">
            <div class="navbar container mx-auto px-4 sm:px-6 lg:px-8">
                <!-- Logo -->
                <div class="navbar-start">
                    <a href="{{ route('home') }}" class="flex items-center space-x-3">
                        <div class="h-8 w-8 rounded-lg overflow-hidden">
                            <img src="{{ asset('android-chrome-192x192.png') }}" alt="EFSU logo" class="h-full w-full object-contain" />
                        </div>
                    <span class="text-base sm:text-xl font-semibold">Engineering Faculty Students Union</span>
                    </a>
                </div>

                <!-- Desktop Navigation -->
                <div class="navbar-end hidden md:flex items-center">
                    <x-mary-menu class="menu menu-horizontal px-1">
                        <x-mary-menu-item link="{{ route('home') }}">Home</x-mary-menu-item>
                    

                    <x-mary-dropdown>
                        <x-slot:trigger>
                            <x-mary-button class="btn-ghost" size="sm">
                                About
                                <x-mary-icon name="o-chevron-down" class="ms-1" />
                            </x-mary-button>
                        </x-slot:trigger>
                        <x-mary-menu class="menu menu-sm">
                            <x-mary-menu-item link="{{ route('about') }}">About EFSU</x-mary-menu-item>
                            <x-mary-menu-item link="{{ route('alumni') }}">Alumni</x-mary-menu-item>
                            <x-mary-menu-item link="{{ route('contact') }}">Contact</x-mary-menu-item>
                        </x-mary-menu>
                    </x-mary-dropdown>

                    <x-mary-dropdown>
                        <x-slot:trigger>
                            <x-mary-button class="btn-ghost" size="sm">
                                Activities
                                <x-mary-icon name="o-chevron-down" class="ms-1" />
                            </x-mary-button>
                        </x-slot:trigger>
                        <x-mary-menu class="menu menu-sm">
                            <x-mary-menu-item link="{{ route('events') }}">Events</x-mary-menu-item>
                            <x-mary-menu-item link="{{ route('news') }}">News</x-mary-menu-item>
                            <x-mary-menu-item link="{{ route('gallery') }}">Gallery</x-mary-menu-item>
                        </x-mary-menu>
                    </x-mary-dropdown>

                    <x-mary-dropdown>
                        <x-slot:trigger>
                            <x-mary-button class="btn-ghost" size="sm">
                                Community
                                <x-mary-icon name="o-chevron-down" class="ms-1" />
                            </x-mary-button>
                        </x-slot:trigger>
                        <x-mary-menu class="menu menu-sm">
                            <x-mary-menu-item link="{{ route('resources') }}">Resources</x-mary-menu-item>
                            <x-mary-menu-item link="{{ route('forum') }}">Forum</x-mary-menu-item>
                        </x-mary-menu>
                    </x-mary-dropdown>
                    </x-mary-menu>
                </div>

                {{-- <div class="navbar-end hidden md:flex items-center gap-3">
                    @auth
                        <x-mary-button class="btn-primary" link="{{ route('dashboard') }}" label="Dashboard" />
                    @else
                        <x-mary-button variant="link" link="{{ route('login') }}" label="Login" />
                        <x-mary-button class="btn-primary" link="{{ route('register') }}" label="Register" />
                    @endauth
                </div> --}}

                <!-- Mobile menu -->
                <div class="navbar-end md:hidden" >
                    <x-mary-dropdown align="end" >
                        <x-slot:trigger>
                            <x-mary-button class="btn-ghost btn-square" aria-label="Open menu">
                                <x-mary-icon name="o-bars-3" />
                            </x-mary-button>
                        </x-slot:trigger>

                        <x-mary-menu class="menu menu-sm">
                            <x-mary-menu-item link="{{ route('home') }}">Home</x-mary-menu-item>
                            <x-mary-menu-item link="{{ route('about') }}">About</x-mary-menu-item>
                            <x-mary-menu-item link="{{ route('events') }}">Events</x-mary-menu-item>
                            <x-mary-menu-item link="{{ route('news') }}">News</x-mary-menu-item>
                            <x-mary-menu-item link="{{ route('resources') }}">Resources</x-mary-menu-item>
                            <x-mary-menu-item link="{{ route('forum') }}">Forum</x-mary-menu-item>
                            <x-mary-menu-item link="{{ route('gallery') }}">Gallery</x-mary-menu-item>
                            <x-mary-menu-item link="{{ route('alumni') }}">Alumni</x-mary-menu-item>
                            <x-mary-menu-item link="{{ route('contact') }}">Contact</x-mary-menu-item>

                            <!-- @auth
                                <x-mary-menu-item link="{{ route('dashboard') }}">Dashboard</x-mary-menu-item>
                            @else
                                <x-mary-menu-item link="{{ route('login') }}">Login</x-mary-menu-item>
                                <x-mary-menu-item link="{{ route('register') }}">Register</x-mary-menu-item>
                            @endauth -->
                        </x-mary-menu>
                    </x-mary-dropdown>
                </div>
            </div>
        </header>

        <!-- Main Content -->
        <main class="min-h-screen">
            {{ $slot }}
        </main>

        <!-- Footer -->
        <footer class="bg-base-100 border-t border-base-200">
            <div class="container mx-auto px-4 sm:px-6 lg:px-8">
                <div class="py-12">
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                        <div class="col-span-1 md:col-span-2">
                            <div class="flex items-center space-x-3 mb-4">
                                <div class="h-10 w-10 rounded-lg overflow-hidden">
                                    <img src="{{ asset('android-chrome-192x192.png') }}" alt="EFSU logo" class="h-full w-full object-contain" />
                                </div>
                                <span class="text-lg font-semibold">Engineering Faculty Students Union</span>
                            </div>
                            <p class="mb-4 max-w-md opacity-70">
                                Connecting engineering students, faculty, and alumni through academic excellence,
                                social engagement, and professional development.
                            </p>
                            <div class="flex space-x-2">
                                <x-mary-button class="btn-ghost btn-square" link="#" aria-label="Facebook">
                                    <x-mary-icon name="o-hand-thumb-up" class="h-5 w-5" />
                                    <span class="sr-only">Facebook</span>
                                </x-mary-button>
                                <x-mary-button class="btn-ghost btn-square" link="#" aria-label="Instagram">
                                    <x-mary-icon name="o-camera" class="h-5 w-5" />
                                    <span class="sr-only">Instagram</span>
                                </x-mary-button>
                            </div>
                        </div>

                        <div>
                            <h3 class="text-sm font-semibold tracking-wider uppercase mb-4 opacity-70">Quick Links</h3>
                            <x-mary-menu class="menu menu-vertical p-0">
                                <x-mary-menu-item link="{{ route('events') }}">Upcoming Events</x-mary-menu-item>
                                <x-mary-menu-item link="{{ route('news') }}">Latest News</x-mary-menu-item>
                                <x-mary-menu-item link="{{ route('resources') }}">Student Resources</x-mary-menu-item>
                                <x-mary-menu-item link="{{ route('forum') }}">Discussion Forum</x-mary-menu-item>
                            </x-mary-menu>
                        </div>

                        <div>
                            <h3 class="text-sm font-semibold tracking-wider uppercase mb-4 opacity-70">Connect</h3>
                            <x-mary-menu class="menu menu-vertical p-0">
                                <x-mary-menu-item link="{{ route('contact') }}">Contact Us</x-mary-menu-item>
                                <x-mary-menu-item link="{{ route('alumni') }}">Alumni Network</x-mary-menu-item>
                                <x-mary-menu-item link="{{ route('gallery') }}">Photo Gallery</x-mary-menu-item>
                            </x-mary-menu>
                        </div>
                    </div>
                </div>

                <div class="border-t border-base-200 py-8 text-center">
                    <p class="opacity-70">
                        &copy; {{ date('Y') }} Engineering Faculty Students Union. All rights reserved.
                    </p>
                </div>
            </div>
        </footer>

        @livewireScripts
    </body>
</html>