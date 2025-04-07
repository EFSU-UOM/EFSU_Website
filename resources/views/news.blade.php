<x-layouts.public>
    <!-- Page Header -->
    <section class="bg-white py-16">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 text-center">
            <h1 class="text-4xl font-bold text-gray-900 mb-4">News & Announcements</h1>
            <p class="text-xl text-gray-600 max-w-2xl mx-auto">
                Stay informed with the latest news, updates, and important announcements from EFSU and the Engineering Faculty.
            </p>
        </div>
    </section>

    <!-- Featured News -->
    <section class="bg-gray-50 py-16">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="mb-8">
                <h2 class="text-2xl font-bold text-gray-900">Featured News</h2>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-12">
                <!-- Main Featured Article -->
                <div class="bg-white rounded-xl shadow-sm overflow-hidden">
                    <img src="https://images.unsplash.com/photo-1523240795612-9a054b0db644?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2070&q=80" 
                         alt="Engineering Students" class="w-full h-64 object-cover">
                    <div class="p-8">
                        <div class="flex items-center mb-4">
                            <span class="bg-blue-100 text-blue-800 text-xs px-3 py-1 rounded-full mr-3">Featured</span>
                            <span class="text-sm text-gray-500">March 15, 2024</span>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900 mb-4">Engineering Students Win National Innovation Challenge</h3>
                        <p class="text-gray-600 mb-6">A team of final-year engineering students from our faculty has secured first place in the National Innovation Challenge, demonstrating exceptional creativity in sustainable technology solutions.</p>
                        <a href="#" class="text-blue-600 hover:text-blue-700 font-medium">Read Full Story →</a>
                    </div>
                </div>

                <!-- Secondary Featured Articles -->
                <div class="space-y-6">
                    <div class="bg-white p-6 rounded-xl shadow-sm">
                        <div class="flex items-center mb-3">
                            <span class="bg-green-100 text-green-800 text-xs px-3 py-1 rounded-full mr-3">Achievement</span>
                            <span class="text-sm text-gray-500">March 12, 2024</span>
                        </div>
                        <h4 class="text-lg font-semibold text-gray-900 mb-2">New Industry Partnership Announced</h4>
                        <p class="text-gray-600 mb-3">EFSU announces strategic partnership with leading tech companies to provide internships and job opportunities.</p>
                        <a href="#" class="text-green-600 hover:text-green-700 font-medium text-sm">Learn More →</a>
                    </div>

                    <div class="bg-white p-6 rounded-xl shadow-sm">
                        <div class="flex items-center mb-3">
                            <span class="bg-purple-100 text-purple-800 text-xs px-3 py-1 rounded-full mr-3">Event</span>
                            <span class="text-sm text-gray-500">March 10, 2024</span>
                        </div>
                        <h4 class="text-lg font-semibold text-gray-900 mb-2">Annual Tech Symposium Registration Opens</h4>
                        <p class="text-gray-600 mb-3">Join industry leaders and fellow students for our biggest event of the year featuring workshops and networking.</p>
                        <a href="#" class="text-purple-600 hover:text-purple-700 font-medium text-sm">Register Now →</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Latest Articles -->
    <section class="bg-white py-16">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between mb-8">
                <h2 class="text-2xl font-bold text-gray-900">Latest Articles</h2>
                <div class="flex space-x-4">
                    <select class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                        <option>All Categories</option>
                        <option>Academic</option>
                        <option>Events</option>
                        <option>Achievements</option>
                        <option>General</option>
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Article Cards -->
                <article class="bg-white border border-gray-200 rounded-xl overflow-hidden hover:shadow-lg transition-shadow">
                    <img src="https://images.unsplash.com/photo-1581092795360-fd1ca04f0952?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2070&q=80" 
                         alt="Research Lab" class="w-full h-48 object-cover">
                    <div class="p-6">
                        <div class="flex items-center mb-3">
                            <span class="bg-blue-100 text-blue-800 text-xs px-3 py-1 rounded-full mr-3">Academic</span>
                            <span class="text-sm text-gray-500">March 8, 2024</span>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">New Research Lab Opens for Student Projects</h3>
                        <p class="text-gray-600 mb-4">State-of-the-art research facility now available for undergraduate and graduate student research projects.</p>
                        <a href="#" class="text-blue-600 hover:text-blue-700 font-medium text-sm">Read More →</a>
                    </div>
                </article>

                <article class="bg-white border border-gray-200 rounded-xl overflow-hidden hover:shadow-lg transition-shadow">
                    <img src="https://images.unsplash.com/photo-1552664730-d307ca884978?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2069&q=80" 
                         alt="Team Meeting" class="w-full h-48 object-cover">
                    <div class="p-6">
                        <div class="flex items-center mb-3">
                            <span class="bg-orange-100 text-orange-800 text-xs px-3 py-1 rounded-full mr-3">General</span>
                            <span class="text-sm text-gray-500">March 5, 2024</span>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">Student Union Elections: Meet Your Candidates</h3>
                        <p class="text-gray-600 mb-4">Get to know the candidates running for student union positions in this year's elections.</p>
                        <a href="#" class="text-orange-600 hover:text-orange-700 font-medium text-sm">Read More →</a>
                    </div>
                </article>

                <article class="bg-white border border-gray-200 rounded-xl overflow-hidden hover:shadow-lg transition-shadow">
                    <img src="https://images.unsplash.com/photo-1573164713714-d95e436ab8d6?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2069&q=80" 
                         alt="Workshop" class="w-full h-48 object-cover">
                    <div class="p-6">
                        <div class="flex items-center mb-3">
                            <span class="bg-green-100 text-green-800 text-xs px-3 py-1 rounded-full mr-3">Event</span>
                            <span class="text-sm text-gray-500">March 3, 2024</span>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">Career Development Workshop Series Begins</h3>
                        <p class="text-gray-600 mb-4">Weekly workshops focused on resume building, interview skills, and professional networking.</p>
                        <a href="#" class="text-green-600 hover:text-green-700 font-medium text-sm">Read More →</a>
                    </div>
                </article>

                <article class="bg-white border border-gray-200 rounded-xl overflow-hidden hover:shadow-lg transition-shadow">
                    <img src="https://images.unsplash.com/photo-1556075798-4825dfaaf498?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2076&q=80" 
                         alt="Awards Ceremony" class="w-full h-48 object-cover">
                    <div class="p-6">
                        <div class="flex items-center mb-3">
                            <span class="bg-yellow-100 text-yellow-800 text-xs px-3 py-1 rounded-full mr-3">Achievement</span>
                            <span class="text-sm text-gray-500">February 28, 2024</span>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">Dean's List Recipients Announced</h3>
                        <p class="text-gray-600 mb-4">Congratulations to all students who achieved academic excellence this semester.</p>
                        <a href="#" class="text-yellow-600 hover:text-yellow-700 font-medium text-sm">Read More →</a>
                    </div>
                </article>

                <article class="bg-white border border-gray-200 rounded-xl overflow-hidden hover:shadow-lg transition-shadow">
                    <img src="https://images.unsplash.com/photo-1517077304055-6e89abbf09b0?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2069&q=80" 
                         alt="Student Activities" class="w-full h-48 object-cover">
                    <div class="p-6">
                        <div class="flex items-center mb-3">
                            <span class="bg-purple-100 text-purple-800 text-xs px-3 py-1 rounded-full mr-3">Event</span>
                            <span class="text-sm text-gray-500">February 25, 2024</span>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">Spring Festival Planning Updates</h3>
                        <p class="text-gray-600 mb-4">Latest updates on our upcoming spring festival including activities, food, and entertainment.</p>
                        <a href="#" class="text-purple-600 hover:text-purple-700 font-medium text-sm">Read More →</a>
                    </div>
                </article>

                <article class="bg-white border border-gray-200 rounded-xl overflow-hidden hover:shadow-lg transition-shadow">
                    <img src="https://images.unsplash.com/photo-1522202176988-66273c2fd55f?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2071&q=80" 
                         alt="Study Group" class="w-full h-48 object-cover">
                    <div class="p-6">
                        <div class="flex items-center mb-3">
                            <span class="bg-indigo-100 text-indigo-800 text-xs px-3 py-1 rounded-full mr-3">Academic</span>
                            <span class="text-sm text-gray-500">February 22, 2024</span>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">Peer Tutoring Program Expansion</h3>
                        <p class="text-gray-600 mb-4">We're expanding our peer tutoring program to cover more subjects and offer flexible scheduling.</p>
                        <a href="#" class="text-indigo-600 hover:text-indigo-700 font-medium text-sm">Read More →</a>
                    </div>
                </article>
            </div>

            <!-- Pagination -->
            <div class="flex justify-center mt-12">
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

    <!-- Newsletter Signup -->
    <section class="bg-blue-600 py-16">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-3xl font-bold text-white mb-4">Stay Updated</h2>
            <p class="text-blue-100 text-lg mb-8 max-w-2xl mx-auto">
                Subscribe to our newsletter to receive the latest news and announcements directly in your inbox.
            </p>
            <form class="max-w-md mx-auto flex gap-4">
                <input type="email" placeholder="Enter your email" 
                       class="flex-1 px-4 py-3 rounded-lg border-0 focus:ring-2 focus:ring-blue-300 focus:outline-none">
                <button type="submit" 
                        class="bg-white text-blue-600 px-6 py-3 rounded-lg font-medium hover:bg-gray-100 transition-colors">
                    Subscribe
                </button>
            </form>
        </div>
    </section>
</x-layouts.public>