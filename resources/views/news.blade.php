<x-layouts.public>
    <!-- Page Header -->
    <section class="bg-base-100 py-20">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 text-center">
            <h1 class="text-4xl sm:text-5xl font-bold tracking-tight text-base-content mb-6">
                News & Announcements
            </h1>
            <p class="text-xl text-base-content/70 max-w-3xl mx-auto">
                Stay updated with all the latest news, updates, and important announcements from EFSU and the Engineering Faculty.
            </p>
        </div>
    </section>

    <!-- Latest Articles -->
    <section class="bg-base-100 py-16">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between mb-8">
                <h2 class="text-2xl font-bold text-base-content">Latest Articles</h2>
                <div class="flex space-x-4">
                    <x-mary-select
                        class="w-48"
                        placeholder="All Categories"
                        :options="[
                            ['label' => 'All Categories', 'value' => ''],
                            ['label' => 'Academic', 'value' => 'academic'],
                            ['label' => 'Events', 'value' => 'events'],
                            ['label' => 'Achievements', 'value' => 'achievements'],
                            ['label' => 'General', 'value' => 'general'],
                        ]"
                    />
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Article Cards -->
                <x-mary-card class="bg-base-100 border border-base-200 rounded-xl overflow-hidden hover:shadow-lg transition-shadow">
                    <img src="https://images.unsplash.com/photo-1581092795360-fd1ca04f0952?auto=format&fit=crop&w=2070&q=80"
                         alt="Research Lab" class="w-full h-48 object-cover">
                    <div class="p-6">
                        <div class="flex items-center mb-3">
                            <x-mary-badge value="Academic" color="primary" class="mr-3" />
                            <span class="text-sm text-base-content/60">March 8, 2024</span>
                        </div>
                        <h3 class="text-lg font-semibold text-base-content mb-2">New Research Lab Opens for Student Projects</h3>
                        <p class="text-base-content/70 mb-4">State-of-the-art research facility now available for undergraduate and graduate student research projects.</p>
                        <x-mary-button link="#" label="Read More" color="primary" variant="link" size="sm" right-icon="o-arrow-right" class="px-0" />
                    </div>
                </x-mary-card>

                <x-mary-card class="bg-base-100 border border-base-200 rounded-xl overflow-hidden hover:shadow-lg transition-shadow">
                    <img src="https://images.unsplash.com/photo-1552664730-d307ca884978?auto=format&fit=crop&w=2069&q=80"
                         alt="Team Meeting" class="w-full h-48 object-cover">
                    <div class="p-6">
                        <div class="flex items-center mb-3">
                            <x-mary-badge value="General" color="neutral" class="mr-3" />
                            <span class="text-sm text-base-content/60">March 5, 2024</span>
                        </div>
                        <h3 class="text-lg font-semibold text-base-content mb-2">Student Union Elections: Meet Your Candidates</h3>
                        <p class="text-base-content/70 mb-4">Get to know the candidates running for student union positions in this year's elections.</p>
                        <x-mary-button link="#" label="Read More" color="neutral" variant="link" size="sm" right-icon="o-arrow-right" class="px-0" />
                    </div>
                </x-mary-card>

                <x-mary-card class="bg-base-100 border border-base-200 rounded-xl overflow-hidden hover:shadow-lg transition-shadow">
                    <img src="https://images.unsplash.com/photo-1573164713714-d95e436ab8d6?auto=format&fit=crop&w=2069&q=80"
                         alt="Workshop" class="w-full h-48 object-cover">
                    <div class="p-6">
                        <div class="flex items-center mb-3">
                            <x-mary-badge value="Event" color="success" class="mr-3" />
                            <span class="text-sm text-base-content/60">March 3, 2024</span>
                        </div>
                        <h3 class="text-lg font-semibold text-base-content mb-2">Career Development Workshop Series Begins</h3>
                        <p class="text-base-content/70 mb-4">Weekly workshops focused on resume building, interview skills, and professional networking.</p>
                        <x-mary-button link="#" label="Read More" color="success" variant="link" size="sm" right-icon="o-arrow-right" class="px-0" />
                    </div>
                </x-mary-card>

                <x-mary-card class="bg-base-100 border border-base-200 rounded-xl overflow-hidden hover:shadow-lg transition-shadow">
                    <img src="https://images.unsplash.com/photo-1556075798-4825dfaaf498?auto=format&fit=crop&w=2076&q=80"
                         alt="Awards Ceremony" class="w-full h-48 object-cover">
                    <div class="p-6">
                        <div class="flex items-center mb-3">
                            <x-mary-badge value="Achievement" color="warning" class="mr-3" />
                            <span class="text-sm text-base-content/60">February 28, 2024</span>
                        </div>
                        <h3 class="text-lg font-semibold text-base-content mb-2">Dean's List Recipients Announced</h3>
                        <p class="text-base-content/70 mb-4">Congratulations to all students who achieved academic excellence this semester.</p>
                        <x-mary-button link="#" label="Read More" color="warning" variant="link" size="sm" right-icon="o-arrow-right" class="px-0" />
                    </div>
                </x-mary-card>

                <x-mary-card class="bg-base-100 border border-base-200 rounded-xl overflow-hidden hover:shadow-lg transition-shadow">
                    <img src="https://images.unsplash.com/photo-1517077304055-6e89abbf09b0?auto=format&fit=crop&w=2069&q=80"
                         alt="Student Activities" class="w-full h-48 object-cover">
                    <div class="p-6">
                        <div class="flex items-center mb-3">
                            <x-mary-badge value="Event" color="secondary" class="mr-3" />
                            <span class="text-sm text-base-content/60">February 25, 2024</span>
                        </div>
                        <h3 class="text-lg font-semibold text-base-content mb-2">Spring Festival Planning Updates</h3>
                        <p class="text-base-content/70 mb-4">Latest updates on our upcoming spring festival including activities, food, and entertainment.</p>
                        <x-mary-button link="#" label="Read More" color="secondary" variant="link" size="sm" right-icon="o-arrow-right" class="px-0" />
                    </div>
                </x-mary-card>

                <x-mary-card class="bg-base-100 border border-base-200 rounded-xl overflow-hidden hover:shadow-lg transition-shadow">
                    <img src="https://images.unsplash.com/photo-1522202176988-66273c2fd55f?auto=format&fit=crop&w=2071&q=80"
                         alt="Study Group" class="w-full h-48 object-cover">
                    <div class="p-6">
                        <div class="flex items-center mb-3">
                            <x-mary-badge value="Academic" color="info" class="mr-3" />
                            <span class="text-sm text-base-content/60">February 22, 2024</span>
                        </div>
                        <h3 class="text-lg font-semibold text-base-content mb-2">Peer Tutoring Program Expansion</h3>
                        <p class="text-base-content/70 mb-4">We're expanding our peer tutoring program to cover more subjects and offer flexible scheduling.</p>
                        <x-mary-button link="#" label="Read More" color="info" variant="link" size="sm" right-icon="o-arrow-right" class="px-0" />
                    </div>
                </x-mary-card>
            </div>

            <!-- Pagination -->
            {{-- <div class="flex justify-center mt-12">
                <x-mary-pagination :links="[
                    ['label' => 'Previous', 'url' => '#', 'active' => false],
                    ['label' => '1', 'url' => '#', 'active' => true],
                    ['label' => '2', 'url' => '#', 'active' => false],
                    ['label' => '3', 'url' => '#', 'active' => false],
                    ['label' => 'Next', 'url' => '#', 'active' => false],
                ]" />
            </div> --}}
        </div>
    </section>
</x-layouts.public>
