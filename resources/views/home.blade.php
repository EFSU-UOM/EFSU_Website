<x-layouts.public>
    <!-- Hero Section -->
    <section class="bg-base-100">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-20">
            <div class="text-center flex flex-col items-center gap-6">
                <h1 class="text-4xl sm:text-6xl font-bold tracking-tight">
                    <span class="text-primary"> Engineering Faculty Students' Union </span></br>
                    University of Moratuwa
                </h1>

                <p class="text-lg sm:text-xl text-base-content/70 max-w-3xl mx-auto">
                    Connecting engineering students, faculty, and alumni through academic excellence,
                    social engagement, and professional development opportunities.
                </p>

                <div class="w-full border-t border-base-200"></div>

                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <x-mary-button link="{{ route('events') }}" color="primary">
                        Upcoming Events
                    </x-mary-button>

                    <x-mary-button link="{{ route('resources') }}" color="secondary" variant="outline">
                        Student Resources
                    </x-mary-button>
                </div>
            </div>
        </div>
    </section>

    <!-- Quick Access Section -->
    <section class="bg-base-200 py-16">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <x-mary-header title="Quick Access"
                subtitle="Find what you need quickly with easy access to our most popular services and resources."
                class="text-center mb-12" />

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                <!-- Events Card -->
                <x-mary-card class="shadow-sm hover:shadow-md transition-shadow">
                    <div class="w-12 h-12 bg-primary/10 rounded-lg flex items-center justify-center mb-4">
                        <x-mary-icon name="o-calendar" class="w-6 h-6 text-primary" />
                    </div>
                    <h3 class="text-lg font-semibold text-base-content mb-2">Events & Calendar</h3>
                    <p class="text-base-content/70 mb-4">View upcoming events, workshops, and important dates.</p>
                    <x-mary-button link="{{ route('events') }}" variant="link" color="primary" size="sm">
                        View Events →
                    </x-mary-button>
                </x-mary-card>

                <!-- News Card -->
                <x-mary-card class="shadow-sm hover:shadow-md transition-shadow">
                    <div class="w-12 h-12 bg-primary/10 rounded-lg flex items-center justify-center mb-4">
                        <x-mary-icon name="o-newspaper" class="w-6 h-6 text-primary" />
                    </div>
                    <h3 class="text-lg font-semibold text-base-content mb-2">Latest News</h3>
                    <p class="text-base-content/70 mb-4">Stay updated with faculty news and announcements.</p>
                    <x-mary-button link="{{ route('news') }}" variant="link" color="success" size="sm">
                        Read News →
                    </x-mary-button>
                </x-mary-card>

                <!-- Forum Card -->
                <x-mary-card class="shadow-sm hover:shadow-md transition-shadow">
                    <div class="w-12 h-12 bg-primary/10 rounded-lg flex items-center justify-center mb-4">
                        <x-mary-icon name="o-chat-bubble-left-right" class="w-6 h-6 text-primary" />
                    </div>
                    <h3 class="text-lg font-semibold text-base-content mb-2">Discussion Forum</h3>
                    <p class="text-base-content/70 mb-4">Connect with peers and discuss academic topics.</p>
                    <x-mary-button link="{{ route('forum') }}" variant="link" color="secondary" size="sm">
                        Join Discussion →
                    </x-mary-button>
                </x-mary-card>

                <!-- Resources Card -->
                <x-mary-card class="shadow-sm hover:shadow-md transition-shadow">
                    <div class="w-12 h-12 bg-primary/10 rounded-lg flex items-center justify-center mb-4">
                        <x-mary-icon name="o-book-open" class="w-6 h-6 text-primary" />
                    </div>
                    <h3 class="text-lg font-semibold text-base-content mb-2">Student Resources</h3>
                    <p class="text-base-content/70 mb-4">Access study materials, guides, and useful links.</p>
                    <x-mary-button link="{{ route('resources') }}" variant="link" color="warning" size="sm">
                        Browse Resources →
                    </x-mary-button>
                </x-mary-card>
            </div>
        </div>
    </section>

    <!-- Latest Announcements Section -->
    <section class="bg-base-100 py-16">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <x-mary-header title="Latest Announcements" subtitle="Stay informed with the latest updates from EFSU"
                separator>
                <x-slot:actions>
                    <x-mary-button link="{{ route('news') }}" variant="link" color="primary" size="sm">
                        View All →
                    </x-mary-button>
                </x-slot:actions>
            </x-mary-header>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Sample Announcement Cards -->
                <x-mary-card class="border border-primary/20 bg-primary/5">
                    <div class="flex items-start justify-between mb-3">
                        <x-mary-badge value="Urgent" color="primary" />
                        <span class="text-sm text-base-content/60">2 hours ago</span>
                    </div>
                    <h3 class="text-lg font-semibold text-base-content mb-2">Registration Deadline Extended</h3>
                    <p class="text-base-content/70 mb-4">The registration deadline for the upcoming Tech Symposium has
                        been extended to next Friday.</p>
                    <x-mary-button link="#" variant="link" color="primary" size="sm">
                        Read More →
                    </x-mary-button>
                </x-mary-card>

                <x-mary-card>
                    <div class="flex items-start justify-between mb-3">
                        <x-mary-badge value="Event" color="primary" />
                        <span class="text-sm text-base-content/60">1 day ago</span>
                    </div>
                    <h3 class="text-lg font-semibold text-base-content mb-2">Annual Career Fair 2024</h3>
                    <p class="text-base-content/70 mb-4">Join us for the biggest career fair of the year with 50+
                        companies participating.</p>
                    <x-mary-button link="#" variant="link" color="primary" size="sm">
                        Read More →
                    </x-mary-button>
                </x-mary-card>

                <x-mary-card>
                    <div class="flex items-start justify-between mb-3">
                        <x-mary-badge value="Academic" color="primary" />
                        <span class="text-sm text-base-content/60">3 days ago</span>
                    </div>
                    <h3 class="text-lg font-semibold text-base-content mb-2">New Online Learning Resources</h3>
                    <p class="text-base-content/70 mb-4">We've added new online courses and study materials to help with
                        your academic journey.</p>
                    <x-mary-button link="#" variant="link" color="primary" size="sm">
                        Read More →
                    </x-mary-button>
                </x-mary-card>
            </div>
        </div>
    </section>
</x-layouts.public>
