<x-layouts.public>
    <!-- Page Header -->
    <section class="bg-white py-16">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <h1 class="text-4xl font-bold text-gray-900 mb-4">Events & Calendar</h1>
                <p class="text-xl text-gray-600 max-w-2xl mx-auto">
                    Stay updated with all upcoming academic events, workshops, meetings, and social activities.
                </p>
            </div>
        </div>
    </section>

    <!-- Upcoming Events -->
    <section class="bg-gray-50 py-16">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between mb-8">
                <h2 class="text-2xl font-bold text-gray-900">Upcoming Events</h2>
                <div class="flex space-x-4">
                    <x-mary-button label="Add to Calendar" class="btn-primary" />
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <x-mary-card class="shadow-sm hover:shadow-md transition-shadow overflow-hidden">
                    <x-slot name="figure">
                        <img src="https://images.unsplash.com/photo-1540575467063-178a50c2df87?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2070&q=80"
                             alt="Tech Conference" class="w-full h-48 object-cover">
                    </x-slot>

                    <div class="p-6">
                        <div class="flex items-center justify-between mb-2">
                            <x-mary-badge value="Conference" class="badge-primary" />
                            <span class="text-sm text-gray-500">Sep 15, 2024</span>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">Annual Tech Symposium</h3>
                        <p class="text-gray-600 mb-4">Join industry leaders for insights on emerging technologies and their impact on engineering.</p>
                        <div class="flex items-center text-sm text-gray-500 mb-4">
                            <x-mary-icon name="o-map-pin" class="w-4 h-4 mr-1" />
                            Main Auditorium
                        </div>
                        <x-mary-button label="Register Now" class="btn-primary w-full" />
                    </div>
                </x-mary-card>

                <x-mary-card class="shadow-sm hover:shadow-md transition-shadow overflow-hidden">
                    <x-slot name="figure">
                        <img src="https://images.unsplash.com/photo-1531482615713-2afd69097998?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2070&q=80"
                             alt="Workshop" class="w-full h-48 object-cover">
                    </x-slot>

                    <div class="p-6">
                        <div class="flex items-center justify-between mb-2">
                            <x-mary-badge value="Workshop" class="badge-success" />
                            <span class="text-sm text-gray-500">Sep 22, 2024</span>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">AI &amp; Machine Learning Workshop</h3>
                        <p class="text-gray-600 mb-4">Hands-on workshop covering fundamentals of AI and practical machine learning applications.</p>
                        <div class="flex items-center text-sm text-gray-500 mb-4">
                            <x-mary-icon name="o-map-pin" class="w-4 h-4 mr-1" />
                            Computer Lab 2
                        </div>
                        <x-mary-button label="Register Now" class="btn-success w-full" />
                    </div>
                </x-mary-card>

                <x-mary-card class="shadow-sm hover:shadow-md transition-shadow overflow-hidden">
                    <x-slot name="figure">
                        <img src="https://images.unsplash.com/photo-1511632765486-a01980e01a18?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2070&q=80"
                             alt="Social Event" class="w-full h-48 object-cover">
                    </x-slot>

                    <div class="p-6">
                        <div class="flex items-center justify-between mb-2">
                            <x-mary-badge value="Social" class="badge-accent" />
                            <span class="text-sm text-gray-500">Oct 5, 2024</span>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">Engineering Gala Night</h3>
                        <p class="text-gray-600 mb-4">Annual celebration bringing together students, faculty, and alumni for an evening of networking.</p>
                        <div class="flex items-center text-sm text-gray-500 mb-4">
                            <x-mary-icon name="o-map-pin" class="w-4 h-4 mr-1" />
                            Grand Hall
                        </div>
                        <x-mary-button label="Register Now" class="btn-accent w-full" />
                    </div>
                </x-mary-card>
            </div>
        </div>
    </section>

    <!-- Calendar Integration -->
    <section class="bg-white py-16">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-900 mb-4">Event Calendar</h2>
                <p class="text-gray-600">Interactive calendar view of all upcoming events and important dates.</p>
            </div>
            
            <!-- Calendar placeholder -->
            <div class="bg-gray-100 rounded-xl p-8 text-center">
                <div class="text-gray-500 mb-4">
                    <svg class="w-16 h-16 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                </div>
                <p class="text-lg text-gray-600 mb-4">Interactive Calendar Coming Soon</p>
                <p class="text-gray-500">Google Calendar integration will be available in the next update.</p>
            </div>
        </div>
    </section>

    <!-- Event Categories -->
    <section class="bg-gray-50 py-16">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-900 mb-4">Event Categories</h2>
                <p class="text-gray-600">Explore different types of events we organize throughout the year.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <x-mary-card class="shadow-sm hover:shadow-md transition-shadow">
                    <div class="p-6 text-center">
                        <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <x-mary-icon name="o-academic-cap" class="w-8 h-8 text-blue-600" />
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">Academic</h3>
                        <p class="text-gray-600 text-sm">Conferences, seminars, and educational workshops</p>
                    </div>
                </x-mary-card>

                <x-mary-card class="shadow-sm hover:shadow-md transition-shadow">
                    <div class="p-6 text-center">
                        <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <x-mary-icon name="o-cpu-chip" class="w-8 h-8 text-green-600" />
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">Workshops</h3>
                        <p class="text-gray-600 text-sm">Hands-on training and skill development sessions</p>
                    </div>
                </x-mary-card>

                <x-mary-card class="shadow-sm hover:shadow-md transition-shadow">
                    <div class="p-6 text-center">
                        <div class="w-16 h-16 bg-purple-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <x-mary-icon name="o-users" class="w-8 h-8 text-purple-600" />
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">Social</h3>
                        <p class="text-gray-600 text-sm">Networking events, celebrations, and community gatherings</p>
                    </div>
                </x-mary-card>

                <x-mary-card class="shadow-sm hover:shadow-md transition-shadow">
                    <div class="p-6 text-center">
                        <div class="w-16 h-16 bg-orange-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <x-mary-icon name="o-clipboard-document-list" class="w-8 h-8 text-orange-600" />
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">Meetings</h3>
                        <p class="text-gray-600 text-sm">Union meetings, committee sessions, and planning events</p>
                    </div>
                </x-mary-card>
            </div>
        </div>
    </section>
</x-layouts.public>