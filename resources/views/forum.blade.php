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
    <section class="bg-base-200 py-16">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between mb-8">
                <h2 class="text-2xl font-bold text-base-content">Forum Categories</h2>
                <x-mary-button class="btn-primary" icon="o-plus" label="New Discussion" />
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-12">
                <x-mary-card class="bg-base-100 hover:shadow-lg transition-shadow">
                    <div class="w-12 h-12 bg-primary/10 rounded-lg flex items-center justify-center mb-4">
                        <x-mary-icon name="o-chat-bubble-left-ellipsis" class="w-6 h-6 text-primary" />
                    </div>
                    <h3 class="text-lg font-semibold text-base-content mb-2">General</h3>
                    <p class="text-base-content/70 text-sm mb-4">General discussions and community topics</p>
                    <div class="flex items-center justify-between text-sm text-base-content/60">
                        <span>245 topics</span>
                        <span>1.2k posts</span>
                    </div>
                </x-mary-card>

                <x-mary-card class="bg-base-100 hover:shadow-lg transition-shadow">
                    <div class="w-12 h-12 bg-success/10 rounded-lg flex items-center justify-center mb-4">
                        <x-mary-icon name="o-book-open" class="w-6 h-6 text-success" />
                    </div>
                    <h3 class="text-lg font-semibold text-base-content mb-2">Academic</h3>
                    <p class="text-base-content/70 text-sm mb-4">Course help, study tips, and academic discussions</p>
                    <div class="flex items-center justify-between text-sm text-base-content/60">
                        <span>189 topics</span>
                        <span>856 posts</span>
                    </div>
                </x-mary-card>

                <x-mary-card class="bg-base-100 hover:shadow-lg transition-shadow">
                    <div class="w-12 h-12 bg-secondary/10 rounded-lg flex items-center justify-center mb-4">
                        <x-mary-icon name="o-cpu-chip" class="w-6 h-6 text-secondary" />
                    </div>
                    <h3 class="text-lg font-semibold text-base-content mb-2">Technical</h3>
                    <p class="text-base-content/70 text-sm mb-4">Programming, projects, and technical help</p>
                    <div class="flex items-center justify-between text-sm text-base-content/60">
                        <span>156 topics</span>
                        <span>742 posts</span>
                    </div>
                </x-mary-card>

                <x-mary-card class="bg-base-100 hover:shadow-lg transition-shadow">
                    <div class="w-12 h-12 bg-warning/10 rounded-lg flex items-center justify-center mb-4">
                        <x-mary-icon name="o-users" class="w-6 h-6 text-warning" />
                    </div>
                    <h3 class="text-lg font-semibold text-base-content mb-2">Social</h3>
                    <p class="text-base-content/70 text-sm mb-4">Events, meetups, and social discussions</p>
                    <div class="flex items-center justify-between text-sm text-base-content/60">
                        <span>87 topics</span>
                        <span>523 posts</span>
                    </div>
                </x-mary-card>
            </div>
        </div>
    </section>

    <!-- Recent Discussions -->
    <section class="bg-base-100 py-16">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between mb-8">
                <h2 class="text-2xl font-bold text-base-content">Recent Discussions</h2>
                <div class="flex space-x-4">
                    <x-mary-select class="w-56" placeholder="All Categories" :options="['All Categories','General','Academic','Technical','Social']" />
                </div>
            </div>

            <x-mary-card class="bg-base-200 rounded-xl p-0 overflow-hidden">
                <div class="divide-y divide-base-300">
                    <!-- Pinned Discussion -->
                    <div class="p-6 bg-primary/5 border-l-4 border-primary">
                        <div class="flex items-start justify-between">
                            <div class="flex-1">
                                <div class="flex items-center mb-2">
                                    <x-mary-badge value="Pinned" class="badge-primary mr-2" />
                                    <x-mary-badge value="Academic" class="badge-success mr-2" />
                                    <h3 class="text-lg font-semibold text-base-content">Welcome to the Engineering Forum - Guidelines & Rules</h3>
                                </div>
                                <p class="text-base-content/70 mb-3">Please read these important guidelines before posting to ensure a positive experience for everyone...</p>
                                <div class="flex items-center text-sm text-base-content/60 space-x-4">
                                    <span>By <strong>Admin</strong></span>
                                    <span>•</span>
                                    <span>2 weeks ago</span>
                                    <span>•</span>
                                    <span>45 replies</span>
                                    <span>•</span>
                                    <span>1.2k views</span>
                                </div>
                            </div>
                            <div class="ml-6 flex-shrink-0">
                                <x-mary-avatar class="w-10 h-10 bg-base-300 text-base-content">A</x-mary-avatar>
                            </div>
                        </div>
                    </div>

                    <!-- Regular Discussion -->
                    <div class="p-6 hover:bg-base-200 transition-colors">
                        <div class="flex items-start justify-between">
                            <div class="flex-1">
                                <div class="flex items-center mb-2">
                                    <x-mary-badge value="Academic" class="badge-success mr-2" />
                                    <h3 class="text-lg font-semibold text-base-content hover:text-primary cursor-pointer">Help with Data Structures Assignment - Binary Trees</h3>
                                </div>
                                <p class="text-base-content/70 mb-3">I'm struggling with implementing binary tree traversal algorithms. Could someone explain the difference between in-order, pre-order, and post-order traversal?</p>
                                <div class="flex items-center text-sm text-base-content/60 space-x-4">
                                    <span>By <strong>sarah_eng2024</strong></span>
                                    <span>•</span>
                                    <span>3 hours ago</span>
                                    <span>•</span>
                                    <span>12 replies</span>
                                    <span>•</span>
                                    <span>156 views</span>
                                </div>
                            </div>
                            <div class="ml-6 flex-shrink-0">
                                <x-mary-avatar class="w-10 h-10 bg-secondary text-secondary-content">S</x-mary-avatar>
                            </div>
                        </div>
                    </div>

                    <!-- Regular Discussion -->
                    <div class="p-6 hover:bg-base-200 transition-colors">
                        <div class="flex items-start justify-between">
                            <div class="flex-1">
                                <div class="flex items-center mb-2">
                                    <x-mary-badge value="Technical" class="badge-secondary mr-2" />
                                    <h3 class="text-lg font-semibold text-base-content hover:text-primary cursor-pointer">Python vs MATLAB for Signal Processing</h3>
                                </div>
                                <p class="text-base-content/70 mb-3">Which tool would you recommend for digital signal processing projects? I'm comfortable with both but wondering about performance and library support...</p>
                                <div class="flex items-center text-sm text-base-content/60 space-x-4">
                                    <span>By <strong>mike_signals</strong></span>
                                    <span>•</span>
                                    <span>6 hours ago</span>
                                    <span>•</span>
                                    <span>8 replies</span>
                                    <span>•</span>
                                    <span>89 views</span>
                                </div>
                            </div>
                            <div class="ml-6 flex-shrink-0">
                                <x-mary-avatar class="w-10 h-10 bg-primary text-primary-content">M</x-mary-avatar>
                            </div>
                        </div>
                    </div>

                    <!-- Regular Discussion -->
                    <div class="p-6 hover:bg-base-200 transition-colors">
                        <div class="flex items-start justify-between">
                            <div class="flex-1">
                                <div class="flex items-center mb-2">
                                    <x-mary-badge value="Social" class="badge-warning mr-2" />
                                    <h3 class="text-lg font-semibold text-base-content hover:text-primary cursor-pointer">Study Group for Final Exams - Anyone Interested?</h3>
                                </div>
                                <p class="text-base-content/70 mb-3">Looking to form a study group for final exams in Thermodynamics and Fluid Mechanics. Planning to meet at the library on weekends...</p>
                                <div class="flex items-center text-sm text-base-content/60 space-x-4">
                                    <span>By <strong>alex_mech</strong></span>
                                    <span>•</span>
                                    <span>1 day ago</span>
                                    <span>•</span>
                                    <span>15 replies</span>
                                    <span>•</span>
                                    <span>234 views</span>
                                </div>
                            </div>
                            <div class="ml-6 flex-shrink-0">
                                <x-mary-avatar class="w-10 h-10 bg-success text-success-content">A</x-mary-avatar>
                            </div>
                        </div>
                    </div>

                    <!-- Regular Discussion -->
                    <div class="p-6 hover:bg-base-200 transition-colors">
                        <div class="flex items-start justify-between">
                            <div class="flex-1">
                                <div class="flex items-center mb-2">
                                    <x-mary-badge value="General" class="badge-info mr-2" />
                                    <h3 class="text-lg font-semibold text-base-content hover:text-primary cursor-pointer">Internship Experience at Tech Companies - AMA</h3>
                                </div>
                                <p class="text-base-content/70 mb-3">Just finished my summer internship at a major tech company. Happy to answer questions about the application process, interview tips, and what to expect...</p>
                                <div class="flex items-center text-sm text-base-content/60 space-x-4">
                                    <span>By <strong>jennifer_cs</strong></span>
                                    <span>•</span>
                                    <span>2 days ago</span>
                                    <span>•</span>
                                    <span>23 replies</span>
                                    <span>•</span>
                                    <span>456 views</span>
                                </div>
                            </div>
                            <div class="ml-6 flex-shrink-0">
                                <x-mary-avatar class="w-10 h-10 bg-secondary text-secondary-content">J</x-mary-avatar>
                            </div>
                        </div>
                    </div>
                </div>
            </x-mary-card>

            <!-- Pagination -->
            <div class="flex justify-center mt-8">
                <nav class="flex space-x-2">
                    <x-mary-button class="btn-outline">Previous</x-mary-button>
                    <x-mary-button class="btn-primary">1</x-mary-button>
                    <x-mary-button class="btn-outline">2</x-mary-button>
                    <x-mary-button class="btn-outline">3</x-mary-button>
                    <x-mary-button class="btn-outline">Next</x-mary-button>
                </nav>
            </div>
        </div>
    </section>

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
