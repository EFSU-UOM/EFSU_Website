<x-layouts.public>
    <livewire:boarding-places />
    
    <!-- Guidelines Section -->
    <section class="bg-base-200 py-16">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-8">
                <h2 class="text-2xl font-bold text-base-content mb-4">Boarding Place Guidelines</h2>
                <p class="text-base-content/70">Help maintain a helpful and trustworthy boarding community</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <x-mary-card class="bg-base-100">
                    <div class="w-12 h-12 bg-primary/10 rounded-lg flex items-center justify-center mb-4">
                        <x-mary-icon name="o-camera" class="w-6 h-6 text-primary" />
                    </div>
                    <h3 class="text-lg font-semibold text-base-content mb-2">Include Photos</h3>
                    <p class="text-base-content/70 text-sm">Upload clear photos of the boarding place to help students make informed decisions.</p>
                </x-mary-card>

                <x-mary-card class="bg-base-100">
                    <div class="w-12 h-12 bg-success/10 rounded-lg flex items-center justify-center mb-4">
                        <x-mary-icon name="o-map-pin" class="w-6 h-6 text-success" />
                    </div>
                    <h3 class="text-lg font-semibold text-base-content mb-2">Accurate Location</h3>
                    <p class="text-base-content/70 text-sm">Provide precise location details and distance to university for better visibility.</p>
                </x-mary-card>

                <x-mary-card class="bg-base-100">
                    <div class="w-12 h-12 bg-secondary/10 rounded-lg flex items-center justify-center mb-4">
                        <x-mary-icon name="o-information-circle" class="w-6 h-6 text-secondary" />
                    </div>
                    <h3 class="text-lg font-semibold text-base-content mb-2">Detailed Information</h3>
                    <p class="text-base-content/70 text-sm">Include pricing, capacity, amenities, and contact details for completeness.</p>
                </x-mary-card>

                <x-mary-card class="bg-base-100">
                    <div class="w-12 h-12 bg-warning/10 rounded-lg flex items-center justify-center mb-4">
                        <x-mary-icon name="o-shield-check" class="w-6 h-6 text-warning" />
                    </div>
                    <h3 class="text-lg font-semibold text-base-content mb-2">Verify Authenticity</h3>
                    <p class="text-base-content/70 text-sm">Only post about places you know personally or can verify the information.</p>
                </x-mary-card>

                <x-mary-card class="bg-base-100">
                    <div class="w-12 h-12 bg-info/10 rounded-lg flex items-center justify-center mb-4">
                        <x-mary-icon name="o-chat-bubble-left" class="w-6 h-6 text-info" />
                    </div>
                    <h3 class="text-lg font-semibold text-base-content mb-2">Helpful Comments</h3>
                    <p class="text-base-content/70 text-sm">Share your honest experiences to help fellow students make better choices.</p>
                </x-mary-card>

                <x-mary-card class="bg-base-100">
                    <div class="w-12 h-12 bg-error/10 rounded-lg flex items-center justify-center mb-4">
                        <x-mary-icon name="o-clock" class="w-6 h-6 text-error" />
                    </div>
                    <h3 class="text-lg font-semibold text-base-content mb-2">Keep Updated</h3>
                    <p class="text-base-content/70 text-sm">Update your posts if information changes or remove them if no longer relevant.</p>
                </x-mary-card>
            </div>
        </div>
    </section>
</x-layouts.public>