<x-layouts.public>
    <!-- Hero Section -->
    <section class="bg-white">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-20">
            <div class="text-center">
                <h1 class="text-4xl sm:text-6xl font-bold tracking-tight text-gray-900 mb-8">
                    Engineering Faculty 
                    <span class="text-blue-600">Students Union</span>
                </h1>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto mb-12">
                    Connecting engineering students, faculty, and alumni through academic excellence, 
                    social engagement, and professional development opportunities.
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <x-mary-button link="{{ route('events') }}" class="btn-primary">
                        Upcoming Events
                    </x-mary-button>

                    <x-mary-button link="{{ route('resources') }}">
                        Student Resources
                    </x-mary-button>
                </div>
            </div>
        </div>
    </section>

    <!-- Quick Access Section -->
    <section class="bg-gray-50 py-16">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-900 mb-4">Quick Access</h2>
                <p class="text-gray-600 max-w-2xl mx-auto">
                    Find what you need quickly with easy access to our most popular services and resources.
                </p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                <!-- Events Card -->
                <div class="bg-white p-6 rounded-xl shadow-sm hover:shadow-md transition-shadow">
                    <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center mb-4">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Events & Calendar</h3>
                    <p class="text-gray-600 mb-4">View upcoming events, workshops, and important dates.</p>
                    <a href="{{ route('events') }}" class="text-blue-600 hover:text-blue-700 font-medium">View Events →</a>
                </div>

                <!-- News Card -->
                <div class="bg-white p-6 rounded-xl shadow-sm hover:shadow-md transition-shadow">
                    <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center mb-4">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Latest News</h3>
                    <p class="text-gray-600 mb-4">Stay updated with faculty news and announcements.</p>
                    <a href="{{ route('news') }}" class="text-green-600 hover:text-green-700 font-medium">Read News →</a>
                </div>

                <!-- Forum Card -->
                <div class="bg-white p-6 rounded-xl shadow-sm hover:shadow-md transition-shadow">
                    <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center mb-4">
                        <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2v4l-4-4H9a2 2 0 01-2-2v-6a2 2 0 012-2h2m2-4h4a2 2 0 012 2v6a2 2 0 01-2 2h-3l-4 4V10a2 2 0 012-2z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Discussion Forum</h3>
                    <p class="text-gray-600 mb-4">Connect with peers and discuss academic topics.</p>
                    <a href="{{ route('forum') }}" class="text-purple-600 hover:text-purple-700 font-medium">Join Discussion →</a>
                </div>

                <!-- Resources Card -->
                <div class="bg-white p-6 rounded-xl shadow-sm hover:shadow-md transition-shadow">
                    <div class="w-12 h-12 bg-orange-100 rounded-lg flex items-center justify-center mb-4">
                        <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Student Resources</h3>
                    <p class="text-gray-600 mb-4">Access study materials, guides, and useful links.</p>
                    <a href="{{ route('resources') }}" class="text-orange-600 hover:text-orange-700 font-medium">Browse Resources →</a>
                </div>
            </div>
        </div>
    </section>

    <!-- Latest Announcements Section -->
    <section class="bg-white py-16">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <x-mary-header title="Latest Announcements" subtitle="Stay informed with the latest updates from EFSU" separator>
                <x-slot:actions>
                    <a href="{{ route('news') }}" class="text-blue-600 hover:text-blue-700 font-medium">
                    View All →
                </a>
                </x-slot:actions>
            </x-mary-header>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Sample Announcement Cards -->
                <x-mary-card class="bg-blue-50 border-blue-200">
                    <div class="flex items-start justify-between mb-3">
                        <x-mary-badge value="Urgent" class="bg-blue-600" />
                        <span class="text-sm text-gray-500">2 hours ago</span>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Registration Deadline Extended</h3>
                    <p class="text-gray-600 mb-4">The registration deadline for the upcoming Tech Symposium has been extended to next Friday.</p>
                    <x-mary-button link="#" variant="ghost" color="blue" size="sm" class="p-0 h-auto font-medium">
                        Read More →
                    </x-mary-button>
                </x-mary-card>

                <x-mary-card>
                    <div class="flex items-start justify-between mb-3">
                        <x-mary-badge value="Event" class="bg-green-600" />
                        <span class="text-sm text-gray-500">1 day ago</span>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Annual Career Fair 2024</h3>
                    <p class="text-gray-600 mb-4">Join us for the biggest career fair of the year with 50+ companies participating.</p>
                    <x-mary-button link="#" variant="ghost" color="blue" size="sm" class="p-0 h-auto font-medium">
                        Read More →
                    </x-mary-button>
                </x-mary-card>

                <x-mary-card>
                    <div class="flex items-start justify-between mb-3">
                        <x-mary-badge value="Academic" class="bg-purple-600" />
                        <span class="text-sm text-gray-500">3 days ago</span>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">New Online Learning Resources</h3>
                    <p class="text-gray-600 mb-4">We've added new online courses and study materials to help with your academic journey.</p>
                    <x-mary-button link="#" variant="ghost" color="blue" size="sm" class="p-0 h-auto font-medium">
                        Read More →
                    </x-mary-button>
                </x-mary-card>
            </div>
        </div>
    </section>
</x-layouts.public>