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
    <livewire:quick-access />

    <!-- Latest News Section -->
    <livewire:latest-news />

    <!-- Latest Announcements Section -->
    <livewire:latest-announcements />
</x-layouts.public>
