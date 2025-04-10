<x-layouts.public>
    <!-- Page Header -->
    <section class="bg-white py-16">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 text-center">
            <h1 class="text-4xl font-bold text-gray-900 mb-4">Discussion Forum</h1>
            <p class="text-xl text-gray-600 max-w-2xl mx-auto">
                Connect with fellow engineering students, ask questions, share knowledge, and participate in meaningful discussions.
            </p>
        </div>
    </section>

    <!-- Forum Categories -->
    <section class="bg-gray-50 py-16">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between mb-8">
                <h2 class="text-2xl font-bold text-gray-900">Forum Categories</h2>
                <button class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition-colors">
                    New Discussion
                </button>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-12">
                <div class="bg-white p-6 rounded-xl shadow-sm hover:shadow-md transition-shadow">
                    <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center mb-4">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">General</h3>
                    <p class="text-gray-600 text-sm mb-4">General discussions and community topics</p>
                    <div class="flex items-center justify-between text-sm text-gray-500">
                        <span>245 topics</span>
                        <span>1.2k posts</span>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-xl shadow-sm hover:shadow-md transition-shadow">
                    <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center mb-4">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Academic</h3>
                    <p class="text-gray-600 text-sm mb-4">Course help, study tips, and academic discussions</p>
                    <div class="flex items-center justify-between text-sm text-gray-500">
                        <span>189 topics</span>
                        <span>856 posts</span>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-xl shadow-sm hover:shadow-md transition-shadow">
                    <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center mb-4">
                        <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Technical</h3>
                    <p class="text-gray-600 text-sm mb-4">Programming, projects, and technical help</p>
                    <div class="flex items-center justify-between text-sm text-gray-500">
                        <span>156 topics</span>
                        <span>742 posts</span>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-xl shadow-sm hover:shadow-md transition-shadow">
                    <div class="w-12 h-12 bg-orange-100 rounded-lg flex items-center justify-center mb-4">
                        <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Social</h3>
                    <p class="text-gray-600 text-sm mb-4">Events, meetups, and social discussions</p>
                    <div class="flex items-center justify-between text-sm text-gray-500">
                        <span>87 topics</span>
                        <span>523 posts</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Recent Discussions -->
    <section class="bg-white py-16">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between mb-8">
                <h2 class="text-2xl font-bold text-gray-900">Recent Discussions</h2>
                <div class="flex space-x-4">
                    <select class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                        <option>All Categories</option>
                        <option>General</option>
                        <option>Academic</option>
                        <option>Technical</option>
                        <option>Social</option>
                    </select>
                </div>
            </div>

            <div class="bg-gray-50 rounded-xl overflow-hidden">
                <!-- Discussion Items -->
                <div class="divide-y divide-gray-200">
                    <!-- Pinned Discussion -->
                    <div class="p-6 bg-blue-50 border-l-4 border-blue-400">
                        <div class="flex items-start justify-between">
                            <div class="flex-1">
                                <div class="flex items-center mb-2">
                                    <span class="bg-blue-600 text-white text-xs px-2 py-1 rounded-full mr-2">Pinned</span>
                                    <span class="bg-green-100 text-green-800 text-xs px-2 py-1 rounded-full mr-2">Academic</span>
                                    <h3 class="text-lg font-semibold text-gray-900">Welcome to the Engineering Forum - Guidelines & Rules</h3>
                                </div>
                                <p class="text-gray-600 mb-3">Please read these important guidelines before posting to ensure a positive experience for everyone...</p>
                                <div class="flex items-center text-sm text-gray-500 space-x-4">
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
                                <div class="w-10 h-10 bg-gray-300 rounded-full flex items-center justify-center">
                                    <span class="text-sm font-semibold">A</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Regular Discussion -->
                    <div class="p-6 hover:bg-gray-50 transition-colors">
                        <div class="flex items-start justify-between">
                            <div class="flex-1">
                                <div class="flex items-center mb-2">
                                    <span class="bg-green-100 text-green-800 text-xs px-2 py-1 rounded-full mr-2">Academic</span>
                                    <h3 class="text-lg font-semibold text-gray-900 hover:text-blue-600 cursor-pointer">Help with Data Structures Assignment - Binary Trees</h3>
                                </div>
                                <p class="text-gray-600 mb-3">I'm struggling with implementing binary tree traversal algorithms. Could someone explain the difference between in-order, pre-order, and post-order traversal?</p>
                                <div class="flex items-center text-sm text-gray-500 space-x-4">
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
                                <div class="w-10 h-10 bg-pink-300 rounded-full flex items-center justify-center">
                                    <span class="text-sm font-semibold text-white">S</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Regular Discussion -->
                    <div class="p-6 hover:bg-gray-50 transition-colors">
                        <div class="flex items-start justify-between">
                            <div class="flex-1">
                                <div class="flex items-center mb-2">
                                    <span class="bg-purple-100 text-purple-800 text-xs px-2 py-1 rounded-full mr-2">Technical</span>
                                    <h3 class="text-lg font-semibold text-gray-900 hover:text-blue-600 cursor-pointer">Python vs MATLAB for Signal Processing</h3>
                                </div>
                                <p class="text-gray-600 mb-3">Which tool would you recommend for digital signal processing projects? I'm comfortable with both but wondering about performance and library support...</p>
                                <div class="flex items-center text-sm text-gray-500 space-x-4">
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
                                <div class="w-10 h-10 bg-blue-400 rounded-full flex items-center justify-center">
                                    <span class="text-sm font-semibold text-white">M</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Regular Discussion -->
                    <div class="p-6 hover:bg-gray-50 transition-colors">
                        <div class="flex items-start justify-between">
                            <div class="flex-1">
                                <div class="flex items-center mb-2">
                                    <span class="bg-orange-100 text-orange-800 text-xs px-2 py-1 rounded-full mr-2">Social</span>
                                    <h3 class="text-lg font-semibold text-gray-900 hover:text-blue-600 cursor-pointer">Study Group for Final Exams - Anyone Interested?</h3>
                                </div>
                                <p class="text-gray-600 mb-3">Looking to form a study group for final exams in Thermodynamics and Fluid Mechanics. Planning to meet at the library on weekends...</p>
                                <div class="flex items-center text-sm text-gray-500 space-x-4">
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
                                <div class="w-10 h-10 bg-green-400 rounded-full flex items-center justify-center">
                                    <span class="text-sm font-semibold text-white">A</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Regular Discussion -->
                    <div class="p-6 hover:bg-gray-50 transition-colors">
                        <div class="flex items-start justify-between">
                            <div class="flex-1">
                                <div class="flex items-center mb-2">
                                    <span class="bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded-full mr-2">General</span>
                                    <h3 class="text-lg font-semibold text-gray-900 hover:text-blue-600 cursor-pointer">Internship Experience at Tech Companies - AMA</h3>
                                </div>
                                <p class="text-gray-600 mb-3">Just finished my summer internship at a major tech company. Happy to answer questions about the application process, interview tips, and what to expect...</p>
                                <div class="flex items-center text-sm text-gray-500 space-x-4">
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
                                <div class="w-10 h-10 bg-purple-400 rounded-full flex items-center justify-center">
                                    <span class="text-sm font-semibold text-white">J</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Pagination -->
            <div class="flex justify-center mt-8">
                <nav class="flex space-x-2">
                    <button class="px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">Previous</button>
                    <button class="px-4 py-2 bg-blue-600 text-white rounded-lg">1</button>
                    <button class="px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">2</button>
                    <button class="px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">3</button>
                    <button class="px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">Next</button>
                </nav>
            </div>
        </div>
    </section>

    <!-- Forum Guidelines -->
    <section class="bg-gray-50 py-16">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-8">
                <h2 class="text-2xl font-bold text-gray-900 mb-4">Forum Guidelines</h2>
                <p class="text-gray-600">Help us maintain a respectful and productive community</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <div class="bg-white p-6 rounded-xl shadow-sm">
                    <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center mb-4">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Be Respectful</h3>
                    <p class="text-gray-600 text-sm">Treat all community members with respect and courtesy. No harassment or offensive language.</p>
                </div>

                <div class="bg-white p-6 rounded-xl shadow-sm">
                    <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center mb-4">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Stay On Topic</h3>
                    <p class="text-gray-600 text-sm">Keep discussions relevant to the category and avoid off-topic conversations.</p>
                </div>

                <div class="bg-white p-6 rounded-xl shadow-sm">
                    <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center mb-4">
                        <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Search First</h3>
                    <p class="text-gray-600 text-sm">Before posting, search existing discussions to avoid duplicates.</p>
                </div>
            </div>
        </div>
    </section>
</x-layouts.public>