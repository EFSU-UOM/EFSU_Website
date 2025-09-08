<x-layouts.public>
    <!-- Page Header -->
    <section class="bg-base-100 py-16">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 text-center">
            <x-mary-card class="bg-base-100 shadow-none border-0">
                <h1 class="text-4xl font-bold text-base-content mb-4">Discussion Forum</h1>
                <p class="text-xl text-base-content/70 max-w-2xl mx-auto">
                    Connect with fellow engineering students, ask questions, share knowledge, and participate in meaningful discussions.
                </p>
            </x-mary-card>
        </div>
    </section>

    <!-- Forum Categories -->
    <livewire:forum-categories />

    <!-- Recent Discussions -->
    <livewire:forum-posts />

    <!-- Forum Guidelines -->
    <section class="bg-base-200 py-16">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-8">
                <h2 class="text-2xl font-bold text-base-content mb-4">Forum Guidelines</h2>
                <p class="text-base-content/70">Help us maintain a respectful and productive community</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <x-mary-card class="bg-base-100">
                    <div class="w-12 h-12 bg-success/10 rounded-lg flex items-center justify-center mb-4">
                        <x-mary-icon name="o-check-circle" class="w-6 h-6 text-success" />
                    </div>
                    <h3 class="text-lg font-semibold text-base-content mb-2">Be Respectful</h3>
                    <p class="text-base-content/70 text-sm">Treat all community members with respect and courtesy. No harassment or offensive language.</p>
                </x-mary-card>

                <x-mary-card class="bg-base-100">
                    <div class="w-12 h-12 bg-primary/10 rounded-lg flex items-center justify-center mb-4">
                        <x-mary-icon name="o-clipboard-document-list" class="w-6 h-6 text-primary" />
                    </div>
                    <h3 class="text-lg font-semibold text-base-content mb-2">Stay On Topic</h3>
                    <p class="text-base-content/70 text-sm">Keep discussions relevant to the category and avoid off-topic conversations.</p>
                </x-mary-card>

                <x-mary-card class="bg-base-100">
                    <div class="w-12 h-12 bg-secondary/10 rounded-lg flex items-center justify-center mb-4">
                        <x-mary-icon name="o-magnifying-glass" class="w-6 h-6 text-secondary" />
                    </div>
                    <h3 class="text-lg font-semibold text-base-content mb-2">Search First</h3>
                    <p class="text-base-content/70 text-sm">Before posting, search existing discussions to avoid duplicates.</p>
                </x-mary-card>
            </div>
        </div>
    </section>
</x-layouts.public>
