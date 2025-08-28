<x-layouts.public>
    <!-- Page Header -->
    <x-mary-card class="bg-base-100 py-16 border-0 shadow-none">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 text-center">
            <h1 class="text-4xl font-bold text-base-content mb-4">Photo Gallery</h1>
            <p class="text-xl text-base-content/70 max-w-2xl mx-auto">
                Explore memorable moments from our events, seminars, trips, and student activities within the Engineering Faculty.
            </p>
        </div>
    </x-mary-card>

    <!-- Gallery Categories -->
    <section class="bg-base-200 py-8">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="flex flex-wrap justify-center gap-4">
                <x-mary-button color="primary" class="rounded-full">All</x-mary-button>
                <x-mary-button color="neutral" variant="outline" class="rounded-full">Events</x-mary-button>
                <x-mary-button color="neutral" variant="outline" class="rounded-full">Seminars</x-mary-button>
                <x-mary-button color="neutral" variant="outline" class="rounded-full">Trips</x-mary-button>
                <x-mary-button color="neutral" variant="outline" class="rounded-full">Activities</x-mary-button>
            </div>
        </div>
    </section>

    <!-- Photo Gallery Grid -->
    <section class="bg-base-100 py-16">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">

                <x-mary-card class="group cursor-pointer relative overflow-hidden rounded-xl p-0 border-0">
                    <img src="https://images.unsplash.com/photo-1540575467063-178a50c2df87?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2070&q=80"
                         alt="Tech Conference 2024"
                         class="w-full h-64 object-cover group-hover:scale-105 transition-transform duration-300">
                    <div class="absolute inset-0 bg-black/0 group-hover:bg-black/40 transition-all duration-300 flex items-end">
                        <div class="p-4 text-white opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                            <h3 class="font-semibold">Tech Conference 2024</h3>
                            <p class="text-sm">Annual technology symposium</p>
                        </div>
                    </div>
                </x-mary-card>

                <x-mary-card class="group cursor-pointer relative overflow-hidden rounded-xl p-0 border-0">
                    <img src="https://images.unsplash.com/photo-1531482615713-2afd69097998?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2070&q=80"
                         alt="AI Workshop"
                         class="w-full h-64 object-cover group-hover:scale-105 transition-transform duration-300">
                    <div class="absolute inset-0 bg-black/0 group-hover:bg-black/40 transition-all duration-300 flex items-end">
                        <div class="p-4 text-white opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                            <h3 class="font-semibold">AI Workshop</h3>
                            <p class="text-sm">Machine learning hands-on session</p>
                        </div>
                    </div>
                </x-mary-card>

                <x-mary-card class="group cursor-pointer relative overflow-hidden rounded-xl p-0 border-0">
                    <img src="https://images.unsplash.com/photo-1511632765486-a01980e01a18?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2070&q=80"
                         alt="Engineering Gala"
                         class="w-full h-64 object-cover group-hover:scale-105 transition-transform duration-300">
                    <div class="absolute inset-0 bg-black/0 group-hover:bg-black/40 transition-all duration-300 flex items-end">
                        <div class="p-4 text-white opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                            <h3 class="font-semibold">Engineering Gala</h3>
                            <p class="text-sm">Annual celebration night</p>
                        </div>
                    </div>
                </x-mary-card>

                <x-mary-card class="group cursor-pointer relative overflow-hidden rounded-xl p-0 border-0">
                    <img src="https://images.unsplash.com/photo-1522202176988-66273c2fd55f?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2071&q=80"
                         alt="Study Session"
                         class="w-full h-64 object-cover group-hover:scale-105 transition-transform duration-300">
                    <div class="absolute inset-0 bg-black/0 group-hover:bg-black/40 transition-all duration-300 flex items-end">
                        <div class="p-4 text-white opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                            <h3 class="font-semibold">Study Session</h3>
                            <p class="text-sm">Group study preparation</p>
                        </div>
                    </div>
                </x-mary-card>

                <x-mary-card class="group cursor-pointer relative overflow-hidden rounded-xl p-0 border-0">
                    <img src="https://images.unsplash.com/photo-1581092795360-fd1ca04f0952?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2070&q=80"
                         alt="Research Lab"
                         class="w-full h-64 object-cover group-hover:scale-105 transition-transform duration-300">
                    <div class="absolute inset-0 bg-black/0 group-hover:bg-black/40 transition-all duration-300 flex items-end">
                        <div class="p-4 text-white opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                            <h3 class="font-semibold">Research Lab Opening</h3>
                            <p class="text-sm">New facility inauguration</p>
                        </div>
                    </div>
                </x-mary-card>

                <x-mary-card class="group cursor-pointer relative overflow-hidden rounded-xl p-0 border-0">
                    <img src="https://images.unsplash.com/photo-1552664730-d307ca884978?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2069&q=80"
                         alt="Team Meeting"
                         class="w-full h-64 object-cover group-hover:scale-105 transition-transform duration-300">
                    <div class="absolute inset-0 bg-black/0 group-hover:bg-black/40 transition-all duration-300 flex items-end">
                        <div class="p-4 text-white opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                            <h3 class="font-semibold">Project Meeting</h3>
                            <p class="text-sm">Student collaboration session</p>
                        </div>
                    </div>
                </x-mary-card>

                <x-mary-card class="group cursor-pointer relative overflow-hidden rounded-xl p-0 border-0">
                    <img src="https://images.unsplash.com/photo-1573164713714-d95e436ab8d6?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2069&q=80"
                         alt="Career Workshop"
                         class="w-full h-64 object-cover group-hover:scale-105 transition-transform duration-300">
                    <div class="absolute inset-0 bg-black/0 group-hover:bg-black/40 transition-all duration-300 flex items-end">
                        <div class="p-4 text-white opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                            <h3 class="font-semibold">Career Workshop</h3>
                            <p class="text-sm">Professional development session</p>
                        </div>
                    </div>
                </x-mary-card>

                <x-mary-card class="group cursor-pointer relative overflow-hidden rounded-xl p-0 border-0">
                    <img src="https://images.unsplash.com/photo-1556075798-4825dfaaf498?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2076&q=80"
                         alt="Awards Ceremony"
                         class="w-full h-64 object-cover group-hover:scale-105 transition-transform duration-300">
                    <div class="absolute inset-0 bg-black/0 group-hover:bg-black/40 transition-all duration-300 flex items-end">
                        <div class="p-4 text-white opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                            <h3 class="font-semibold">Awards Ceremony</h3>
                            <p class="text-sm">Excellence recognition event</p>
                        </div>
                    </div>
                </x-mary-card>

            </div>

            <!-- Load More Button -->
            <div class="text-center mt-12">
                <x-mary-button color="primary" size="lg">
                    Load More Photos
                </x-mary-button>
            </div>
        </div>
    </section>
</x-layouts.public>
