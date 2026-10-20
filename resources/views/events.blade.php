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

    <!-- Event Categories -->
    <livewire:event-categories />
</x-layouts.public>
