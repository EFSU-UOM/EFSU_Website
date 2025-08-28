<x-layouts.public>
    <!-- Page Header -->
    <section class="bg-base-100 py-16">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <x-mary-card class="shadow-none border-0 bg-base-100 text-center">
                <h1 class="text-4xl font-bold text-base-content mb-4">Alumni Network</h1>
                <p class="text-lg text-base-content/70 max-w-2xl mx-auto">
                    Connect with our distinguished alumni, share experiences, and access mentorship opportunities from successful engineering professionals worldwide.
                </p>
            </x-mary-card>
        </div>
    </section>

    <!-- Alumni Stats -->
    <section class="bg-base-200 py-16">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                <x-mary-card class="text-center">
                    <div class="text-4xl font-bold text-primary mb-2">2,500+</div>
                    <div class="text-base-content/70">Total Alumni</div>
                </x-mary-card>

                <x-mary-card class="text-center">
                    <div class="text-4xl font-bold text-success mb-2">45</div>
                    <div class="text-base-content/70">Countries</div>
                </x-mary-card>

                <x-mary-card class="text-center">
                    <div class="text-4xl font-bold text-secondary mb-2">150+</div>
                    <div class="text-base-content/70">Companies</div>
                </x-mary-card>

                <x-mary-card class="text-center">
                    <div class="text-4xl font-bold text-info mb-2">85%</div>
                    <div class="text-base-content/70">Employment Rate</div>
                </x-mary-card>
            </div>
        </div>
    </section>

    <!-- Featured Alumni -->
    <section class="bg-base-100 py-16">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-base-content mb-2">Featured Alumni</h2>
                <p class="text-base-content/70">Meet some of our distinguished graduates who are making a difference in the world</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <x-mary-card class="text-center bg-base-200">
                    <div class="w-24 h-24 rounded-full mx-auto mb-6 flex items-center justify-center bg-gradient-to-r from-primary to-primary-focus text-primary-content">
                        <span class="text-2xl font-bold">DR</span>
                    </div>
                    <h3 class="text-xl font-bold text-base-content mb-1">Dr. Rachel Kim</h3>
                    <p class="text-primary font-medium mb-1">Senior Software Engineer</p>
                    <p class="text-base-content/70 mb-4">Google • Class of 2015</p>
                    <p class="text-base-content/80 text-sm mb-6">"The engineering program provided me with strong fundamentals that helped me excel in the tech industry. Always happy to mentor current students!"</p>
                    <x-mary-button color="primary" label="Connect" />
                </x-mary-card>

                <x-mary-card class="text-center bg-base-200">
                    <div class="w-24 h-24 rounded-full mx-auto mb-6 flex items-center justify-center bg-gradient-to-r from-success to-success-focus text-success-content">
                        <span class="text-2xl font-bold">MP</span>
                    </div>
                    <h3 class="text-xl font-bold text-base-content mb-1">Michael Parker</h3>
                    <p class="text-success font-medium mb-1">Engineering Manager</p>
                    <p class="text-base-content/70 mb-4">Tesla • Class of 2012</p>
                    <p class="text-base-content/80 text-sm mb-6">"Working on sustainable technology has been incredibly rewarding. The problem-solving skills I learned here are invaluable in tackling complex challenges."</p>
                    <x-mary-button color="success" label="Connect" />
                </x-mary-card>

                <x-mary-card class="text-center bg-base-200">
                    <div class="w-24 h-24 rounded-full mx-auto mb-6 flex items-center justify-center bg-gradient-to-r from-secondary to-secondary-focus text-secondary-content">
                        <span class="text-2xl font-bold">AS</span>
                    </div>
                    <h3 class="text-xl font-bold text-base-content mb-1">Dr. Aisha Sharma</h3>
                    <p class="text-secondary font-medium mb-1">Research Scientist</p>
                    <p class="text-base-content/70 mb-4">MIT • Class of 2018</p>
                    <p class="text-base-content/80 text-sm mb-6">"Currently pursuing groundbreaking research in AI and machine learning. The analytical thinking skills from our program opened many doors."</p>
                    <x-mary-button color="secondary" label="Connect" />
                </x-mary-card>
            </div>
        </div>
    </section>

    <!-- Mentorship Program -->
    <section class="bg-base-200 py-16">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="lg:grid lg:grid-cols-2 lg:gap-8 lg:items-center">
                <div>
                    <h2 class="text-3xl font-bold text-base-content mb-6">Alumni Mentorship Program</h2>
                    <x-mary-card class="bg-base-100">
                        <div class="space-y-6">
                            <p class="text-base-content/80">
                                Our mentorship program connects current students with experienced alumni professionals 
                                who provide guidance, career advice, and industry insights.
                            </p>

                            <div class="space-y-3">
                                <div class="flex items-start gap-3">
                                    <x-mary-icon name="o-check" class="w-5 h-5 text-success mt-0.5" />
                                    <span class="text-base-content/90">One-on-one mentorship matching</span>
                                </div>
                                <div class="flex items-start gap-3">
                                    <x-mary-icon name="o-check" class="w-5 h-5 text-success mt-0.5" />
                                    <span class="text-base-content/90">Career guidance and industry insights</span>
                                </div>
                                <div class="flex items-start gap-3">
                                    <x-mary-icon name="o-check" class="w-5 h-5 text-success mt-0.5" />
                                    <span class="text-base-content/90">Networking opportunities</span>
                                </div>
                                <div class="flex items-start gap-3">
                                    <x-mary-icon name="o-check" class="w-5 h-5 text-success mt-0.5" />
                                    <span class="text-base-content/90">Resume review and interview preparation</span>
                                </div>
                            </div>

                            <div class="pt-2">
                                <x-mary-button color="primary" label="Apply for Mentorship" />
                            </div>
                        </div>
                    </x-mary-card>
                </div>
                <div class="mt-8 lg:mt-0">
                    <x-mary-card class="overflow-hidden p-0">
                        <img class="w-full rounded-xl" 
                             src="https://images.unsplash.com/photo-1521737711867-e3b97375f902?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2047&q=80" 
                             alt="Alumni mentoring students">
                    </x-mary-card>
                </div>
            </div>
        </div>
    </section>

    <!-- Alumni Directory -->
    <section class="bg-base-100 py-16">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-base-content mb-2">Alumni Directory</h2>
                <p class="text-base-content/70">Search and connect with alumni by industry, location, or graduation year</p>
            </div>

            <!-- Search Filters -->
            <x-mary-card class="bg-base-200 mb-8">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <x-mary-select label="Industry" placeholder="All Industries"
                                   :options="['Technology','Manufacturing','Consulting','Research']" />

                    <x-mary-select label="Location" placeholder="All Locations"
                                   :options="['United States','Canada','Europe','Asia']" />

                    <x-mary-select label="Graduation Year" placeholder="All Years"
                                   :options="['2020-2024','2015-2019','2010-2014','Before 2010']" />

                    <div class="flex items-end">
                        <x-mary-button class="w-full" color="primary" label="Search" />
                    </div>
                </div>
            </x-mary-card>

            <!-- Alumni List Preview -->
            <div class="text-center">
                <x-mary-card class="inline-block p-8 border-2 border-dashed border-base-300 bg-base-100">
                    <x-mary-icon name="o-user-group" class="w-12 h-12 text-base-content/40 mx-auto mb-4" />
                    <h3 class="text-lg font-medium text-base-content mb-2">Alumni Directory</h3>
                    <p class="text-base-content/70 mb-4">Full alumni directory will be available to registered users</p>
                    <a href="{{ route('register') }}" class="link link-primary font-medium">
                        Register to Access →
                    </a>
                </x-mary-card>
            </div>
        </div>
    </section>

    <!-- Success Stories -->
    <section class="bg-base-200 py-16">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-base-content mb-2">Success Stories</h2>
                <p class="text-base-content/70">Inspiring stories from our alumni community</p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <x-mary-card class="overflow-hidden p-0">
                    <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2070&q=80" 
                         alt="Success Story" class="w-full h-48 object-cover">
                    <div class="p-6">
                        <h3 class="text-xl font-bold text-base-content mb-3">From Student to Startup Founder</h3>
                        <p class="text-base-content/70 mb-4">
                            "The entrepreneurial mindset and technical skills I developed during my time at EFSU gave me 
                            the confidence to start my own tech company. Today, we're helping thousands of businesses..."
                        </p>
                        <div class="flex items-center">
                            <div class="w-10 h-10 rounded-full bg-primary text-primary-content flex items-center justify-center mr-3">
                                <span class="font-semibold text-sm">JD</span>
                            </div>
                            <div>
                                <p class="font-semibold text-base-content">James Davidson</p>
                                <p class="text-sm text-base-content/70">Founder & CEO, TechFlow • Class of 2016</p>
                            </div>
                        </div>
                    </div>
                </x-mary-card>

                <x-mary-card class="overflow-hidden p-0">
                    <img src="https://images.unsplash.com/photo-1494790108755-2616c2f00d72?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2070&q=80" 
                         alt="Success Story" class="w-full h-48 object-cover">
                    <div class="p-6">
                        <h3 class="text-xl font-bold text-base-content mb-3">Leading Innovation in Renewable Energy</h3>
                        <p class="text-base-content/70 mb-4">
                            "The strong foundation in engineering principles I received here prepared me for the challenges 
                            in renewable energy. Now I lead a team developing next-generation solar technology..."
                        </p>
                        <div class="flex items-center">
                            <div class="w-10 h-10 rounded-full bg-success text-success-content flex items-center justify-center mr-3">
                                <span class="font-semibold text-sm">LM</span>
                            </div>
                            <div>
                                <p class="font-semibold text-base-content">Lisa Martinez</p>
                                <p class="text-sm text-base-content/70">Principal Engineer, SolarTech • Class of 2013</p>
                            </div>
                        </div>
                    </div>
                </x-mary-card>
            </div>
        </div>
    </section>
</x-layouts.public>
