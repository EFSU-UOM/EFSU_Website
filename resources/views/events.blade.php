<x-layouts.public>
    <!-- Page Header -->
    <section class="bg-base-100 py-20">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 text-center">
            <h1 class="text-4xl sm:text-5xl font-bold tracking-tight text-base-content mb-6">
                Events & Calendar
            </h1>
            <p class="text-xl text-base-content/70 max-w-3xl mx-auto">
                Stay updated with all upcoming academic events, workshops, meetings, and social activities.
            </p>
        </div>
    </section>

    <!-- Upcoming Events -->
    <section class="bg-base-200 py-16">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between mb-8">
                <h2 class="text-2xl font-bold text-base-content">Upcoming Events</h2>
                <div class="flex space-x-4">
                    <x-mary-button label="Add to Calendar" class="btn-primary" />
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <x-mary-card class="shadow-sm hover:shadow-md transition-shadow overflow-hidden bg-base-100">
                    <x-slot name="figure">
                        <img src="https://images.unsplash.com/photo-1540575467063-178a50c2df87?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2070&q=80"
                             alt="Tech Conference" class="w-full h-48 object-cover">
                    </x-slot>

                    <div class="p-6">
                        <div class="flex items-center justify-between mb-2">
                            <x-mary-badge value="Conference" class="badge-primary" />
                            <span class="text-sm text-base-content/60">Sep 15, 2024</span>
                        </div>
                        <h3 class="text-lg font-semibold text-base-content mb-2">Annual Tech Symposium</h3>
                        <p class="text-base-content/70 mb-4">Join industry leaders for insights on emerging technologies and their impact on engineering.</p>
                        <div class="flex items-center text-sm text-base-content/60 mb-4">
                            <x-mary-icon name="o-map-pin" class="w-4 h-4 mr-1" />
                            Main Auditorium
                        </div>
                        <x-mary-button label="Register Now" class="btn-primary w-full" />
                    </div>
                </x-mary-card>

                <x-mary-card class="shadow-sm hover:shadow-md transition-shadow overflow-hidden bg-base-100">
                    <x-slot name="figure">
                        <img src="https://images.unsplash.com/photo-1531482615713-2afd69097998?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2070&q=80"
                             alt="Workshop" class="w-full h-48 object-cover">
                    </x-slot>

                    <div class="p-6">
                        <div class="flex items-center justify-between mb-2">
                            <x-mary-badge value="Workshop" class="badge-success" />
                            <span class="text-sm text-base-content/60">Sep 22, 2024</span>
                        </div>
                        <h3 class="text-lg font-semibold text-base-content mb-2">AI &amp; Machine Learning Workshop</h3>
                        <p class="text-base-content/70 mb-4">Hands-on workshop covering fundamentals of AI and practical machine learning applications.</p>
                        <div class="flex items-center text-sm text-base-content/60 mb-4">
                            <x-mary-icon name="o-map-pin" class="w-4 h-4 mr-1" />
                            Computer Lab 2
                        </div>
                        <x-mary-button label="Register Now" class="btn-success w-full" />
                    </div>
                </x-mary-card>

                <x-mary-card class="shadow-sm hover:shadow-md transition-shadow overflow-hidden bg-base-100">
                    <x-slot name="figure">
                        <img src="https://images.unsplash.com/photo-1511632765486-a01980e01a18?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2070&q=80"
                             alt="Social Event" class="w-full h-48 object-cover">
                    </x-slot>

                    <div class="p-6">
                        <div class="flex items-center justify-between mb-2">
                            <x-mary-badge value="Social" class="badge-accent" />
                            <span class="text-sm text-base-content/60">Oct 5, 2024</span>
                        </div>
                        <h3 class="text-lg font-semibold text-base-content mb-2">Engineering Gala Night</h3>
                        <p class="text-base-content/70 mb-4">Annual celebration bringing together students, faculty, and alumni for an evening of networking.</p>
                        <div class="flex items-center text-sm text-base-content/60 mb-4">
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
    <section class="bg-base-100 py-16">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-base-content mb-4">Event Calendar</h2>
                <p class="text-base-content/70">Interactive calendar view of all upcoming events and important dates.</p>
            </div>

            <div class="max-w-3xl mx-auto">
                <x-mary-alert icon="o-calendar" class="alert-info">
                    <div>
                        <p class="font-semibold">Interactive Calendar Coming Soon</p>
                        <p class="text-base-content/70">Google Calendar integration will be available in the next update.</p>
                    </div>
                </x-mary-alert>
            </div>
        </div>
    </section>

    <!-- Event Categories -->
    <section class="bg-base-200 py-16">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-base-content mb-4">Event Categories</h2>
                <p class="text-base-content/70">Explore different types of events we organize throughout the year.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <x-mary-card class="shadow-sm hover:shadow-md transition-shadow bg-base-100">
                    <div class="p-6 text-center">
                        <div class="w-16 h-16 bg-primary/10 rounded-full flex items-center justify-center mx-auto mb-4">
                            <x-mary-icon name="o-academic-cap" class="w-8 h-8 text-primary" />
                        </div>
                        <h3 class="text-lg font-semibold text-base-content mb-2">Academic</h3>
                        <p class="text-base-content/70 text-sm">Conferences, seminars, and educational workshops</p>
                    </div>
                </x-mary-card>

                <x-mary-card class="shadow-sm hover:shadow-md transition-shadow bg-base-100">
                    <div class="p-6 text-center">
                        <div class="w-16 h-16 bg-success/10 rounded-full flex items-center justify-center mx-auto mb-4">
                            <x-mary-icon name="o-cpu-chip" class="w-8 h-8 text-success" />
                        </div>
                        <h3 class="text-lg font-semibold text-base-content mb-2">Workshops</h3>
                        <p class="text-base-content/70 text-sm">Hands-on training and skill development sessions</p>
                    </div>
                </x-mary-card>

                <x-mary-card class="shadow-sm hover:shadow-md transition-shadow bg-base-100">
                    <div class="p-6 text-center">
                        <div class="w-16 h-16 bg-accent/10 rounded-full flex items-center justify-center mx-auto mb-4">
                            <x-mary-icon name="o-users" class="w-8 h-8 text-accent" />
                        </div>
                        <h3 class="text-lg font-semibold text-base-content mb-2">Social</h3>
                        <p class="text-base-content/70 text-sm">Networking events, celebrations, and community gatherings</p>
                    </div>
                </x-mary-card>

                <x-mary-card class="shadow-sm hover:shadow-md transition-shadow bg-base-100">
                    <div class="p-6 text-center">
                        <div class="w-16 h-16 bg-warning/10 rounded-full flex items-center justify-center mx-auto mb-4">
                            <x-mary-icon name="o-clipboard-document-list" class="w-8 h-8 text-warning" />
                        </div>
                        <h3 class="text-lg font-semibold text-base-content mb-2">Meetings</h3>
                        <p class="text-base-content/70 text-sm">Union meetings, committee sessions, and planning events</p>
                    </div>
                </x-mary-card>
            </div>
        </div>
    </section>
</x-layouts.public>
