<x-layouts.public>
    <livewire:lost-and-found />
    <!-- Guidelines Section -->
    <section class="bg-base-200 py-16">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-8">
                <h2 class="text-2xl font-bold text-base-content mb-4">Lost & Found Guidelines</h2>
                <p class="text-base-content/70">Help us maintain an effective lost and found community</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <x-mary-card class="bg-base-100">
                    <div class="w-12 h-12 bg-primary/10 rounded-lg flex items-center justify-center mb-4">
                        <x-mary-icon name="o-camera" class="w-6 h-6 text-primary" />
                    </div>
                    <h3 class="text-lg font-semibold text-base-content mb-2">Include Photos</h3>
                    <p class="text-base-content/70 text-sm">Upload clear photos of lost or found items to help with
                        identification.</p>
                </x-mary-card>

                <x-mary-card class="bg-base-100">
                    <div class="w-12 h-12 bg-success/10 rounded-lg flex items-center justify-center mb-4">
                        <x-mary-icon name="o-clock" class="w-6 h-6 text-success" />
                    </div>
                    <h3 class="text-lg font-semibold text-base-content mb-2">Update Status</h3>
                    <p class="text-base-content/70 text-sm">Keep your posts updated when items are found or returned.
                    </p>
                </x-mary-card>

                <x-mary-card class="bg-base-100">
                    <div class="w-12 h-12 bg-secondary/10 rounded-lg flex items-center justify-center mb-4">
                        <x-mary-icon name="o-shield-check" class="w-6 h-6 text-secondary" />
                    </div>
                    <h3 class="text-lg font-semibold text-base-content mb-2">Verify Ownership</h3>
                    <p class="text-base-content/70 text-sm">Ask for proof of ownership before returning valuable items.
                    </p>
                </x-mary-card>
            </div>
        </div>
    </section>
</x-layouts.public>
