<x-layouts.public>
    <!-- Page Header -->
    <section class="bg-base-100 py-16">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 text-center">
            <h1 class="text-4xl font-bold text-base-content mb-4">Student Resources</h1>
            <p class="text-xl text-base-content/70 max-w-2xl mx-auto">
                Access academic resources, course materials, important guidelines, and useful tools to support your engineering studies.
            </p>
        </div>
    </section>

    {{-- <!-- Resource Categories -->
    <section class="bg-base-200 py-16">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-12">

                <x-mary-card class="bg-base-100 p-6 rounded-xl shadow-sm text-center hover:shadow-md transition-shadow">
                    <div class="w-16 h-16 bg-info/10 rounded-xl flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-info" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-base-content mb-2">Guidelines</h3>
                    <p class="text-base-content/70 text-sm">Academic policies and procedural documents</p>
                </x-mary-card>

                <x-mary-card class="bg-base-100 p-6 rounded-xl shadow-sm text-center hover:shadow-md transition-shadow">
                    <div class="w-16 h-16 bg-secondary/10 rounded-xl flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-secondary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-base-content mb-2">Student Services</h3>
                    <p class="text-base-content/70 text-sm">Links to library, counseling, and support services</p>
                </x-mary-card>

            </div>

            <!-- Search Bar -->
            <div class="max-w-md mx-auto mb-12">
                <x-mary-input placeholder="Search resources..." icon="o-magnifying-glass" />
            </div>
        </div>
    </section> --}}


    <!-- Student Services Section -->
    <section class="bg-base-200 py-16">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <h2 class="text-3xl font-bold text-base-content mb-8">Student Services</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <!-- Service Links -->
                <x-mary-card class="bg-base-100 p-6 rounded-xl shadow-sm hover:shadow-md transition-shadow">
                    <div class="w-12 h-12 bg-primary/10 rounded-lg flex items-center justify-center mb-4">
                        <svg class="w-6 h-6 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-base-content mb-2">University Library</h3>
                    <p class="text-base-content/70 text-sm">Access digital resources, book catalog, and study spaces</p>
                    <a href="https://uom.lk/lib" target="_blank" class="inline-block mt-2 px-4 py-2 text-primary hover:text-primary-focus text-sm font-medium transition-colors">
                        Visit Library →
                    </a>
                </x-mary-card>

                <x-mary-card class="bg-base-100 p-6 rounded-xl shadow-sm hover:shadow-md transition-shadow">
                    <div class="w-12 h-12 bg-success/10 rounded-lg flex items-center justify-center mb-4">
                        <svg class="w-6 h-6 text-success" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-base-content mb-2">Student Counseling</h3>
                    <p class="text-base-content/70 text-sm">Mental health support and academic counseling services</p>
                    <a href="https://uom.lk/scu" target="_blank" class="inline-block mt-2 px-4 py-2 text-success hover:text-success-focus text-sm font-medium transition-colors">
                        Get Support →
                    </a>
                </x-mary-card>

                <x-mary-card class="bg-base-100 p-6 rounded-xl shadow-sm hover:shadow-md transition-shadow">
                    <div class="w-12 h-12 bg-secondary/10 rounded-lg flex items-center justify-center mb-4">
                        <svg class="w-6 h-6 text-secondary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2-2v2m8 0V6a2 2 0 012 2v6a2 2 0 01-2 2H8a2 2 0 01-2-2V8a2 2 0 012-2V6" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-base-content mb-2">Career Services</h3>
                    <p class="text-base-content/70 text-sm">Job placement, internships, and career guidance</p>
                    <a href="https://uom.lk/efac/career" target="_blank" class="inline-block mt-2 px-4 py-2 text-secondary hover:text-secondary-focus text-sm font-medium transition-colors">
                        Learn More →
                    </a>
                </x-mary-card>

                <x-mary-card class="bg-base-100 p-6 rounded-xl shadow-sm hover:shadow-md transition-shadow">
                    <div class="w-12 h-12 bg-error/10 rounded-lg flex items-center justify-center mb-4">
                        <svg class="w-6 h-6 text-error" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-base-content mb-2">Academic Records</h3>
                    <p class="text-base-content/70 text-sm">Transcripts, grades, and academic documentation</p>
                    <a href="https://lms.uom.lk" target="_blank" class="inline-block mt-2 px-4 py-2 text-error hover:text-error-focus text-sm font-medium transition-colors">
                        Access Portal →
                    </a>
                </x-mary-card>

                <x-mary-card class="bg-base-100 p-6 rounded-xl shadow-sm hover:shadow-md transition-shadow">
                    <div class="w-12 h-12 bg-info/10 rounded-lg flex items-center justify-center mb-4">
                        <svg class="w-6 h-6 text-info" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-base-content mb-2">Research Opportunities</h3>
                    <p class="text-base-content/70 text-sm">Undergraduate research programs and faculty projects</p>
                    <a href="https://uom.lk/eru" target="_blank" class="inline-block mt-2 px-4 py-2 text-info hover:text-info-focus text-sm font-medium transition-colors">
                        Explore →
                    </a>
                </x-mary-card>
            </div>
        </div>
    </section>

    <!-- Tools & Software Section -->
    <section class="bg-base-100 py-16 hidden">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <h2 class="text-3xl font-bold text-base-content mb-8">Useful Tools & Software</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Tool Cards -->
                <x-mary-card class="bg-base-200 p-6 rounded-xl text-center">
                    <div class="w-16 h-16 bg-primary/10 rounded-xl flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <h3 class="font-semibold text-base-content mb-2">Engineering Calculator</h3>
                    <p class="text-sm text-base-content/70 mb-4">Advanced calculator for engineering computations</p>
                    <x-mary-button label="Use Tool →" color="primary" href="#" variant="link" />
                </x-mary-card>

                <x-mary-card class="bg-base-200 p-6 rounded-xl text-center">
                    <div class="w-16 h-16 bg-success/10 rounded-xl flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-success" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                        </svg>
                    </div>
                    <h3 class="font-semibold text-base-content mb-2">MATLAB Access</h3>
                    <p class="text-sm text-base-content/70 mb-4">Campus-wide MATLAB license and tutorials</p>
                    <x-mary-button label="Access →" color="success" href="#" variant="link" />
                </x-mary-card>

                <x-mary-card class="bg-base-200 p-6 rounded-xl text-center">
                    <div class="w-16 h-16 bg-secondary/10 rounded-xl flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-secondary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                    </div>
                    <h3 class="font-semibold text-base-content mb-2">AutoCAD Suite</h3>
                    <p class="text-sm text-base-content/70 mb-4">Design and drafting software for engineering</p>
                    <x-mary-button label="Download →" color="secondary" href="#" variant="link" />
                </x-mary-card>

                <x-mary-card class="bg-base-200 p-6 rounded-xl text-center">
                    <div class="w-16 h-16 bg-warning/10 rounded-xl flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-warning" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                        </svg>
                    </div>
                    <h3 class="font-semibold text-base-content mb-2">Unit Converter</h3>
                    <p class="text-sm text-base-content/70 mb-4">Convert between different engineering units</p>
                    <x-mary-button label="Use Tool →" color="warning" href="#" variant="link" />
                </x-mary-card>
            </div>
        </div>
    </section>
</x-layouts.public>