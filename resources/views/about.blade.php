<x-layouts.public>
    <!-- Hero Section -->
    <section class="bg-base-100 py-20">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 text-center">
            <h1 class="text-4xl sm:text-5xl font-bold tracking-tight text-base-content mb-6">
                About <span class="text-primary">EFSU</span>
            </h1>
            <p class="text-xl text-base-content/70 max-w-3xl mx-auto">
                The Engineering Faculty Students Union is dedicated to fostering a thriving community 
                of engineering students through academic excellence, professional development, and meaningful connections.
            </p>
        </div>
    </section>

    <!-- Mission, Vision, Goals Section -->
    <section class="bg-base-200 py-16">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Mission -->
                <x-mary-card class="p-8 rounded-xl">
                    <div class="w-16 h-16 bg-primary/10 rounded-xl flex items-center justify-center mb-6">
                        <svg class="w-8 h-8 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                        </svg>
                    </div>
                    <h2 class="text-2xl font-bold text-base-content mb-4">Our Mission</h2>
                    <p class="text-base-content/70">
                        To empower engineering students by providing a comprehensive platform for academic support, 
                        professional development, and community building. We strive to bridge the gap between 
                        academic learning and real-world application.
                    </p>
                </x-mary-card>

                <!-- Vision -->
                <x-mary-card class="p-8 rounded-xl">
                    <div class="w-16 h-16 bg-primary/10 rounded-xl flex items-center justify-center mb-6">
                        <svg class="w-8 h-8 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                    </div>
                    <h2 class="text-2xl font-bold text-base-content mb-4">Our Vision</h2>
                    <p class="text-base-content/70">
                        To be the leading student union that creates innovative engineers equipped with technical 
                        expertise, leadership skills, and social responsibility to shape the future of technology 
                        and society.
                    </p>
                </x-mary-card>

                <!-- Goals -->
                <x-mary-card class="p-8 rounded-xl">
                    <div class="w-16 h-16 bg-primary/10 rounded-xl flex items-center justify-center mb-6">
                        <svg class="w-8 h-8 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z" />
                        </svg>
                    </div>
                    <h2 class="text-2xl font-bold text-base-content mb-4">Our Goals</h2>
                    <p class="text-base-content/70">
                        Foster academic excellence, provide professional networking opportunities, organize 
                        meaningful events, maintain strong alumni relationships, and create a supportive 
                        environment for all engineering students.
                    </p>
                </x-mary-card>
            </div>
        </div>
    </section>

    <!-- Key Initiatives Section -->
    <section class="bg-base-100 py-16">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-base-content mb-4">Key Initiatives</h2>
                <p class="text-base-content/70 max-w-2xl mx-auto">
                    Our comprehensive programs and initiatives are designed to support every aspect of 
                    your engineering journey.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <x-mary-card class="text-center p-8">
                    <div class="w-20 h-20 bg-primary/10 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-10 h-10 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-base-content mb-2">Academic Support</h3>
                    <p class="text-base-content/70">
                        Comprehensive resources, study groups, and tutoring programs to ensure academic success.
                    </p>
                </x-mary-card>

                <x-mary-card class="text-center p-8">
                    <div class="w-20 h-20 bg-primary/10 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-10 h-10 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2-2v2m8 0V6a2 2 0 012 2v6a2 2 0 01-2 2H8a2 2 0 01-2-2V8a2 2 0 012-2V6" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-base-content mb-2">Professional Development</h3>
                    <p class="text-base-content/70">
                        Workshops, career fairs, and networking events to prepare you for your professional journey.
                    </p>
                </x-mary-card>

                <x-mary-card class="text-center p-8">
                    <div class="w-20 h-20 bg-primary/10 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-10 h-10 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-base-content mb-2">Community Building</h3>
                    <p class="text-base-content/70">
                        Social events, clubs, and activities that foster friendships and lifelong connections.
                    </p>
                </x-mary-card>

                <x-mary-card class="text-center p-8">
                    <div class="w-20 h-20 bg-primary/10 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-10 h-10 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-base-content mb-2">Innovation Hub</h3>
                    <p class="text-base-content/70">
                        Project spaces, hackathons, and innovation challenges to foster creativity and problem-solving.
                    </p>
                </x-mary-card>

                <x-mary-card class="text-center p-8">
                    <div class="w-20 h-20 bg-primary/10 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-10 h-10 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-base-content mb-2">Student Welfare</h3>
                    <p class="text-base-content/70">
                        Mental health support, counseling services, and wellness programs for holistic development.
                    </p>
                </x-mary-card>

                <x-mary-card class="text-center p-8">
                    <div class="w-20 h-20 bg-primary/10 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-10 h-10 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-base-content mb-2">Alumni Network</h3>
                    <p class="text-base-content/70">
                        Strong connections with successful alumni who provide mentorship and career guidance.
                    </p>
                </x-mary-card>
            </div>
        </div>
    </section>

    <!-- History Section -->
    <section class="bg-base-200 py-16">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="lg:grid lg:grid-cols-2 lg:gap-8 lg:items-center">
                <div>
                    <h2 class="text-3xl font-bold text-base-content mb-6">Our History</h2>
                    <div class="space-y-6">
                        <p class="text-base-content/70">
                            Founded in 1985, the Engineering Faculty Students Union has been a cornerstone 
                            of student life for nearly four decades. What began as a small group of passionate 
                            engineering students has grown into a comprehensive organization serving thousands 
                            of students across all engineering disciplines.
                        </p>
                        <p class="text-base-content/70">
                            Throughout our history, we've consistently adapted to meet the evolving needs 
                            of engineering students, from the early days of basic academic support to today's 
                            comprehensive digital platform that connects students, faculty, and industry professionals.
                        </p>
                        <p class="text-base-content/70">
                            Our alumni network spans the globe, with graduates working at leading technology 
                            companies, research institutions, and innovative startups. Many have returned 
                            to contribute as mentors, speakers, and supporters of our ongoing initiatives.
                        </p>
                    </div>
                </div>
                <div class="mt-8 lg:mt-0">
                    <x-mary-card class="p-0 rounded-xl overflow-hidden">
                        <img class="w-full"
                             src="https://images.unsplash.com/photo-1523050854058-8df90110c9f1?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2070&q=80"
                             alt="Historical photo of engineering students">
                    </x-mary-card>
                </div>
            </div>
        </div>
    </section>

    <!-- Role of Student Union Section -->
    <section class="bg-base-100 py-16">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-base-content mb-4">The Role of Student Union</h2>
                <p class="text-base-content/70 max-w-3xl mx-auto">
                    As your representatives and advocates, we play a crucial role in enhancing 
                    your academic experience and preparing you for professional success.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <x-mary-card class="bg-base-200 p-8 rounded-xl">
                    <h3 class="text-xl font-semibold text-base-content mb-4">Student Representation</h3>
                    <ul class="space-y-3 text-base-content/70">
                        <li class="flex items-start">
                            <span class="w-2 h-2 bg-primary rounded-full mt-2 mr-3"></span>
                            Advocate for student interests in faculty meetings and university committees
                        </li>
                        <li class="flex items-start">
                            <span class="w-2 h-2 bg-primary rounded-full mt-2 mr-3"></span>
                            Facilitate communication between students, faculty, and administration
                        </li>
                        <li class="flex items-start">
                            <span class="w-2 h-2 bg-primary rounded-full mt-2 mr-3"></span>
                            Address academic concerns and policy recommendations
                        </li>
                    </ul>
                </x-mary-card>

                <x-mary-card class="bg-base-200 p-8 rounded-xl">
                    <h3 class="text-xl font-semibold text-base-content mb-4">Services & Support</h3>
                    <ul class="space-y-3 text-base-content/70">
                        <li class="flex items-start">
                            <span class="w-2 h-2 bg-success rounded-full mt-2 mr-3"></span>
                            Organize academic workshops and study sessions
                        </li>
                        <li class="flex items-start">
                            <span class="w-2 h-2 bg-success rounded-full mt-2 mr-3"></span>
                            Provide career counseling and job placement assistance
                        </li>
                        <li class="flex items-start">
                            <span class="w-2 h-2 bg-success rounded-full mt-2 mr-3"></span>
                            Maintain resource libraries and study materials
                        </li>
                    </ul>
                </x-mary-card>

                <x-mary-card class="bg-base-200 p-8 rounded-xl">
                    <h3 class="text-xl font-semibold text-base-content mb-4">Community Building</h3>
                    <ul class="space-y-3 text-base-content/70">
                        <li class="flex items-start">
                            <span class="w-2 h-2 bg-secondary rounded-full mt-2 mr-3"></span>
                            Plan and execute social events, conferences, and seminars
                        </li>
                        <li class="flex items-start">
                            <span class="w-2 h-2 bg-secondary rounded-full mt-2 mr-3"></span>
                            Foster connections between different engineering disciplines
                        </li>
                        <li class="flex items-start">
                            <span class="w-2 h-2 bg-secondary rounded-full mt-2 mr-3"></span>
                            Create networking opportunities with alumni and industry
                        </li>
                    </ul>
                </x-mary-card>

                <x-mary-card class="bg-base-200 p-8 rounded-xl">
                    <h3 class="text-xl font-semibold text-base-content mb-4">Innovation & Growth</h3>
                    <ul class="space-y-3 text-base-content/70">
                        <li class="flex items-start">
                            <span class="w-2 h-2 bg-warning rounded-full mt-2 mr-3"></span>
                            Support student research projects and competitions
                        </li>
                        <li class="flex items-start">
                            <span class="w-2 h-2 bg-warning rounded-full mt-2 mr-3"></span>
                            Facilitate entrepreneurship and startup initiatives
                        </li>
                        <li class="flex items-start">
                            <span class="w-2 h-2 bg-warning rounded-full mt-2 mr-3"></span>
                            Organize technical workshops and skill development programs
                        </li>
                    </ul>
                </x-mary-card>
            </div>
        </div>
    </section>
</x-layouts.public>