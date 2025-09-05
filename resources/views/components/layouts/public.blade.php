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
                        <img src="{{ asset('android-chrome-192x192.png') }}" alt="EFSU logo"
                            class="h-full w-full object-contain" />
                    </div>
                    <span class="text-xl font-semibold">Engineering Faculty Students Union</span>
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
                        <x-mary-menu class="menu menu-md">
                            <x-mary-menu-item link="{{ route('about') }}">About EFSU</x-mary-menu-item>
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
                        <x-mary-menu class="menu menu-md">
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
                        <x-mary-menu class="menu menu-md">
                            <x-mary-menu-item link="{{ route('resources') }}">Resources</x-mary-menu-item>
                             <x-mary-menu-item link="{{ route('complaints') }}">Complaints</x-mary-menu-item>
                       
                            <x-mary-menu-item link="{{ route('forum') }}">Forum</x-mary-menu-item>
                            <x-mary-menu-item link="{{ route('lost-and-found') }}">Lost & Found</x-mary-menu-item>
                            <x-mary-menu-item link="{{ route('store') }}">Store</x-mary-menu-item>
                        </x-mary-menu>
                    </x-mary-dropdown>
                    @auth
                        <x-mary-dropdown align="end">
                            <x-slot:trigger>
                                <div
                                    class="flex items-center space-x-2 px-3 py-2 rounded-lg border border-primary/20 bg-primary/5 hover:bg-primary/10 transition-colors cursor-pointer">
                                    <div
                                        class="w-8 h-8 rounded-full bg-primary text-primary-content flex items-center justify-center font-semibold text-sm">
                                        {{ auth()->user()->initials() }}
                                    </div>
                                    <div class="hidden sm:block text-left">
                                        <div class="text-sm font-medium">{{ auth()->user()->name }}</div>
                                        <div class="text-xs opacity-60">{{ auth()->user()->getAccessLevelLabel() }}</div>
                                    </div>
                                    <x-mary-icon name="o-chevron-down" class="w-4 h-4 opacity-60" />
                                </div>
                            </x-slot:trigger>
                            <x-mary-menu class="menu menu-md w-56">
                                <div class="px-3 py-3 border-b border-base-200 bg-base-50">
                                    <div class="flex items-center space-x-3">
                                        <div
                                            class="w-10 h-10 rounded-full bg-primary text-primary-content flex items-center justify-center font-semibold">
                                            {{ auth()->user()->initials() }}
                                        </div>
                                        <div>
                                            <div class="font-semibold text-sm">{{ auth()->user()->name }}</div>
                                            <div class="text-xs opacity-70">{{ auth()->user()->email }}</div>
                                            <div class="text-xs text-primary font-medium">{{ auth()->user()->getAccessLevelLabel() }}</div>
                                        </div>
                                    </div>
                                </div>
                                @if (auth()->user()->isAdmin())
                                    <x-mary-menu-item link="{{ route('dashboard') }}" class="py-3">
                                        <x-mary-icon name="o-cog-6-tooth" class="me-3 w-5 h-5" />
                                        <span class="font-medium">Admin Dashboard</span>
                                    </x-mary-menu-item>
                                @endif
                                <x-mary-menu-item link="{{ route('settings.profile') }}" class="py-3">
                                    <x-mary-icon name="o-user-circle" class="me-3 w-5 h-5" />
                                    <span class="font-medium">My Profile</span>
                                </x-mary-menu-item>
                                <x-mary-menu-item class="py-3 text-error hover:bg-error/10">
                                    <form method="POST" action="{{ route('logout') }}" class="w-full">
                                        @csrf
                                        <button type="submit" class="flex items-center w-full text-left">
                                            <x-mary-icon name="o-arrow-right-on-rectangle" class="me-3 w-5 h-5" />
                                            <span class="font-medium">Logout</span>
                                        </button>
                                    </form>
                                </x-mary-menu-item>
                            </x-mary-menu>
                        </x-mary-dropdown>
                    @else
                        <x-mary-button class="btn-primary" link="{{ route('login') }}" label="Login" />
                    @endauth
                </x-mary-menu>
            </div>

            <!-- Mobile menu -->
            <div class="navbar-end md:hidden">
                <x-mary-dropdown align="end">
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
                        <x-mary-menu-item link="{{ route('complaints.create') }}">Complaints</x-mary-menu-item>
                        <x-mary-menu-item link="{{ route('resources') }}">Resources</x-mary-menu-item>
                   
                        <x-mary-menu-item link="{{ route('forum') }}">Forum</x-mary-menu-item>
                        <x-mary-menu-item link="{{ route('lost-and-found') }}">Lost & Found</x-mary-menu-item>
                        <x-mary-menu-item link="{{ route('store') }}">Store</x-mary-menu-item>
                        <x-mary-menu-item link="{{ route('gallery') }}">Gallery</x-mary-menu-item>
                        <x-mary-menu-item link="{{ route('contact') }}">Contact</x-mary-menu-item>

                        @auth
                            @if (auth()->user() && auth()->user()->isAdmin())
                                <x-mary-menu-item link="{{ route('dashboard') }}">Dashboard</x-mary-menu-item>
                            @else
                                <x-mary-menu-item link="{{ route('settings.profile') }}">Profile</x-mary-menu-item>
                                <x-mary-menu-item>
                                    <form method="POST" action="{{ route('logout') }}" class="w-full">
                                        @csrf
                                        <button type="submit" class="w-full text-left">Logout</button>
                                    </form>
                                </x-mary-menu-item>
                            @endif
                        @else
                            <x-mary-menu-item link="{{ route('login') }}">Login</x-mary-menu-item>
                        @endauth
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
                                <img src="{{ asset('android-chrome-192x192.png') }}" alt="EFSU logo"
                                    class="h-full w-full object-contain" />
                            </div>
                            <span class="text-lg font-semibold">Engineering Faculty Students Union</span>
                        </div>
                        <p class="mb-4 max-w-md opacity-70">
                            Connecting engineering students, faculty, and alumni through academic excellence,
                            social engagement, and professional development.
                        </p>
                        <div class="flex space-x-2">
                            <a class="btn-ghost btn-square" href="https://www.facebook.com/efsuuom" aria-label="Facebook">
                                <x-mary-icon name="o-hand-thumb-up" class="h-5 w-5" />
                                <span class="sr-only">Facebook</span>
                            </a>
                            <a class="btn-ghost btn-square" href="https://github.com/EFSU-UOM/EFSU_Website" aria-label="GitHub">
                                <x-mary-icon name="s-code-bracket" class="h-5 w-5" />
                                <span class="sr-only">GitHub</span>
                            </a>
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
                            <x-mary-menu-item link="{{ route('gallery') }}">Photo Gallery</x-mary-menu-item>
                        </x-mary-menu>
                    </div>
                </div>
            </div>

            <div class="border-t border-base-200 py-4">
                <div class="text-center">
                    <p class="opacity-70 mb-2">
                        &copy; {{ date('Y') }} Engineering Faculty Students Union. All rights reserved.
                        @if(Route::currentRouteName() === 'about')
                        <br>
                        Developed by
                        <a href="https://github.com/SuhasDissa" class="link link-hover font-medium" target="_blank"
                            rel="noopener">Suhas Dissanayake</a>
                        and
                        <a href="https://github.com/Kalana-Pankaja" class="link link-hover font-medium"
                            target="_blank" rel="noopener">Kalana Liyanage</a>
                        .

                        This project is licensed under GPL v3.0 |
                        <a href="https://github.com/EFSU-UOM/EFSU_Website" class="link link-hover font-medium"
                            target="_blank" rel="noopener">View Source Code</a>
                        @endif
                    </p>
                </div>
            </div>
        </div>
    </footer>

    @livewireScripts
</body>

</html>
