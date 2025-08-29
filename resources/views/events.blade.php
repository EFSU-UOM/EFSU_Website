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
    <livewire:upcoming-events />

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
    <livewire:event-categories />
</x-layouts.public>
