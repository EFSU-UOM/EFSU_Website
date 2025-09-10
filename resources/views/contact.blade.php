<x-layouts.public>
    <!-- Header -->
    <div class="container mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 pt-10">
        <x-mary-header
            title="Contact Us"
            subtitle="Get in touch with the Engineering Faculty Students Union. We're here to help and answer your questions."
            size="xl"
        />
    </div>

    <section class="py-10">
        <div class="container mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <!-- Contact Form -->
                <x-mary-card title="Send us a Message" shadow separator class="bg-base-100">
                    <form method="POST" action="#">
                        @csrf
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                            <x-mary-input
                                name="name"
                                label="Name"
                                placeholder="Your name"
                                icon="o-user"
                                required
                            />
                            <x-mary-input
                                type="email"
                                name="email"
                                label="Email"
                                placeholder="you@example.com"
                                icon="o-envelope"
                                required
                            />
                        </div>

                        <div class="mt-6">
                            <x-mary-input
                                name="subject"
                                label="Subject"
                                placeholder="What's this about?"
                                icon="o-chat-bubble-left-right"
                                required
                            />
                        </div>

                        <div class="mt-6">
                            <x-mary-select
                                name="type"
                                label="Message Type"
                                placeholder="Select a type"
                                :options="[
                                    ['id' => 'general', 'name' => 'General Inquiry'],
                                    ['id' => 'feedback', 'name' => 'Feedback'],
                                    ['id' => 'assistance', 'name' => 'Request Assistance'],
                                ]"
                                option-value="id"
                                option-label="name"
                                icon="o-list-bullet"
                            />
                        </div>

                        <div class="mt-6">
                            <x-mary-textarea
                                name="message"
                                label="Message"
                                placeholder="Tell us how we can help you..."
                                rows="6"
                                icon="o-pencil-square"
                                required
                            />
                        </div>

                        <div class="mt-6">
                            <x-mary-button type="submit" class="btn-primary w-full" label="Send Message" />
                        </div>
                    </form>
                </x-mary-card>

                <!-- Contact Information -->
                <div class="space-y-8">
                    <x-mary-card title="Get in Touch" shadow separator class="bg-base-100">
                        <div class="space-y-6">
                            <div class="flex items-start">
                                <div class="w-12 h-12 rounded-lg flex items-center justify-center mr-4 bg-primary/10">
                                    <x-mary-icon name="o-map-pin" class="w-6 h-6 text-primary" />
                                </div>
                                <div>
                                    <h3 class="text-lg font-semibold text-base-content">Office Address</h3>
                                    <p class="text-base-content/70 mt-1">
                                        ESFU office,<br>
                                        First Floor,<br>
                                        Wala canteen Building
                                    </p>
                                </div>
                            </div>

                            <div class="flex items-start">
                                <div class="w-12 h-12 rounded-lg flex items-center justify-center mr-4 bg-success/10">
                                    <x-mary-icon name="o-phone" class="w-6 h-6 text-success" />
                                </div>
                                <div>
                                    <h3 class="text-lg font-semibold text-base-content">Phone Contacts</h3>
                                    <p class="text-base-content/70 mt-1">
                                        21 Batch - Samitha: 0717910819<br>
                                        22 Batch - Chanuka: 0775681545<br>
                                        23 Batch - Gishan: 0763510388
                                    </p>
                                </div>
                            </div>

                            <div class="flex items-start">
                                <div class="w-12 h-12 rounded-lg flex items-center justify-center mr-4 bg-info/10">
                                    <x-mary-icon name="o-envelope" class="w-6 h-6 text-info" />
                                </div>
                                <div>
                                    <h3 class="text-lg font-semibold text-base-content">Email</h3>
                                    <p class="text-base-content/70 mt-1">
                                        contact@efsu-uom.lk<br>
                                        efsu@uom.lk
                                    </p>
                                </div>
                            </div>

                            
                        </div>
                    </x-mary-card>

                    <!-- Social Media -->
                    <x-mary-card title="Follow Us" shadow class="bg-base-100">
                        <div class="flex gap-3">
                            <a href="https://www.facebook.com/efsuuom" target="_blank" rel="noopener noreferrer">
                                <x-mary-button class="btn-primary btn-circle">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                        <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                                    </svg>
                                </x-mary-button>
                            </a>
                        </div>
                    </x-mary-card>
                    
                </div>
            </div>
        </div>
    </section>
    <!-- Committee Members -->
        <section class="py-10 bg-base-200">
            <div class="container mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <x-mary-header
                    title="Our Team"
                    subtitle="Meet the Engineering Faculty Students Union committee members"
                    size="lg"
                    class="mb-12"
                />

                @php
                    $leaders = [
                        [
                            'name' => 'Charuka Dissanayeke',
                            'position' => 'President',
                            'email' => 'president@efsu-uom.lk',
                            'phone' => '+94 71 711 4853',
                            'image' => '/people/charuka.avif',
                            'bg' => 'bg-primary'
                        ],
                        [
                            'name' => 'Pramodya Meegalle',
                            'position' => 'Secretary',
                            'email' => 'secretary@efsu-uom.lk',
                            'phone' => '+94 78 531 3027',
                            'image' => '/people/meegalle.avif',
                            'bg' => 'bg-secondary'
                        ],
                        [
                            'name' => 'Maleesha Kavinda',
                            'position' => 'Vice President',
                            'email' => 'vicepresident@efsu-uom.lk',
                            'phone' => '+94 70 449 8462',
                            'image' => '/people/maleesha.avif',
                            'bg' => 'bg-accent'
                        ],
                        [
                            'name' => 'Sahan Cooray',
                            'position' => 'Vice Secretary',
                            'email' => 'vicesecretary@efsu-uom.lk',
                            'phone' => '+94 76 699 0124',
                            'image' => '/people/sahan.avif',
                            'bg' => 'bg-info'
                        ],
                        [
                            'name' => 'Pivithuru Hasintha',
                            'position' => 'Treasurer',
                            'email' => 'treasurer@efsu-uom.lk',
                            'phone' => '+94 71 787 5495',
                            'image' => '/people/pivithuru.avif',
                            'bg' => 'bg-success'
                        ],
                        [
                            'name' => 'Lasindu Induwara',
                            'position' => 'Editor',
                            'email' => 'editor@efsu-uom.lk',
                            'phone' => '+94 78 584 9870',
                            'image' => '/people/lasindu.avif',
                            'bg' => 'bg-warning'
                        ],
                    ];

                    $committeeMembers = [
                        [
                            'name' => 'Kaveesha Gimhana',
                            'position' => 'Committee Member',
                            'email' => 'kaveeshag@efsu-uom.lk',
                            'phone' => '+94 70 207 5700',
                            'image' => '/people/gimhana.avif',
                            'bg' => 'bg-orange-400'
                        ],
                        [
                            'name' => 'Shamitha Maduwantha',
                            'position' => 'Committee Member',
                            'email' => 'shamitha@efsu-uom.lk',
                            'phone' => '+94 71 791 0819',
                            'image' => '/people/shamitha.avif',
                            'bg' => 'bg-purple-500'
                        ],
                        [
                            'name' => 'Chanuka Maneesha',
                            'position' => 'Committee Member',
                            'email' => 'chanuka@efsu-uom.lk',
                            'phone' => '+94 77 568 1545',
                            'image' => '/people/chanuka.avif',
                            'bg' => 'bg-teal-500'
                        ],
                        [
                            'name' => 'Shivamayinthan Nadeshamurthi',
                            'position' => 'Committee Member',
                            'email' => 'shivamayinthan@efsu-uom.lk',
                            'phone' => '+94 76 637 0873',
                            'image' => '/people/shiva.avif',
                            'bg' => 'bg-indigo-500'
                        ],
                        [
                            'name' => 'Kaveesha Nirmal',
                            'position' => 'Committee Member',
                            'email' => 'kaveesha@efsu-uom.lk',
                            'phone' => '+94 77 690 7920',
                            'image' => '/people/kaveesha.avif',
                            'bg' => 'bg-pink-500'
                        ],
                        [
                            'name' => 'Gishan Chamith',
                            'position' => 'Committee Member',
                            'email' => 'gishan@efsu-uom.lk',
                            'phone' => '+94 76 351 0388',
                            'image' => '/people/gishan.avif',
                            'bg' => 'bg-emerald-500'
                        ],
                        [
                            'name' => 'Sithum Ransidu',
                            'position' => 'Committee Member',
                            'email' => 'sithum@efsu-uom.lk',
                            'phone' => '+94 70 163 2029',
                            'image' => '/people/sithum.avif',
                            'bg' => 'bg-red-500'
                        ]
                    ];
                @endphp

                {{-- Top Leader (President only) --}}
                <div class="mb-10">
                    @php $president = $leaders[0]; @endphp
                    <x-mary-card class="w-full md:w-2/3 mx-auto p-6 text-center" shadow>
                        <div class="flex justify-center">
                            <x-mary-avatar class="!w-20 !h-20" :image="$president['image']" />
                        </div>
                        <h2 class="mt-4 text-2xl font-bold">{{ $president['name'] }}</h2>
                        <p class="text-lg text-base-content/70">{{ $president['position'] }}</p>
                        <div class="mt-4 space-y-2 text-sm text-base-content/60">
                            <div class="flex justify-center items-center gap-2">
                                <x-mary-icon name="o-envelope" class="w-4 h-4" />
                                <a href="mailto:{{ $president['email'] }}" class="hover:text-primary">
                                    {{ $president['email'] }}
                                </a>
                            </div>
                            <div class="flex justify-center items-center gap-2">
                                <x-mary-icon name="o-phone" class="w-4 h-4" />
                                <a href="tel:{{ $president['phone'] }}" class="hover:text-primary">
                                    {{ $president['phone'] }}
                                </a>
                            </div>
                        </div>
                    </x-mary-card>
                </div>

                {{-- Other Main Leaders --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-12">
                    @foreach(array_slice($leaders, 1) as $leader)
                        <x-mary-card class="p-4" shadow>
                            <div class="flex items-center gap-3 mb-4">
                                <x-mary-avatar class="!w-14 !h-14" :image="$leader['image']" />
                                <div>
                                    <h3 class="font-semibold text-lg">{{ $leader['name'] }}</h3>
                                    <p class="text-sm text-base-content/70">{{ $leader['position'] }}</p>
                                </div>
                            </div>
                            <div class="space-y-2 text-sm text-base-content/60">
                                <div class="flex items-center gap-2">
                                    <x-mary-icon name="o-envelope" class="w-4 h-4" />
                                    <a href="mailto:{{ $leader['email'] }}" class="hover:text-primary">
                                        {{ $leader['email'] }}
                                    </a>
                                </div>
                                <div class="flex items-center gap-2">
                                    <x-mary-icon name="o-phone" class="w-4 h-4" />
                                    <a href="tel:{{ $leader['phone'] }}" class="hover:text-primary">
                                        {{ $leader['phone'] }}
                                    </a>
                                </div>
                            </div>
                        </x-mary-card>
                    @endforeach
                </div>

                {{-- Committee Members --}}
                <h3 class="text-xl font-semibold mb-6">Committee Members</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                    @foreach($committeeMembers as $member)
                        <x-mary-card class="w-full" shadow>
                            <div class="flex items-center gap-3 mb-4">
                                <x-mary-avatar class="!w-12 !h-12" :image="$member['image']" />
                                <div>
                                    <h3 class="font-semibold text-base-content">{{ $member['name'] }}</h3>
                                    <p class="text-sm text-base-content/70">{{ $member['position'] }}</p>
                                </div>
                            </div>
                            <div class="space-y-2 text-sm text-base-content/60">
                                <div class="flex items-center gap-2">
                                    <x-mary-icon name="o-envelope" class="w-4 h-4" />
                                    <a href="mailto:{{ $member['email'] }}" class="hover:text-primary">
                                        {{ $member['email'] }}
                                    </a>
                                </div>
                                <div class="flex items-center gap-2">
                                    <x-mary-icon name="o-phone" class="w-4 h-4" />
                                    <a href="tel:{{ $member['phone'] }}" class="hover:text-primary">
                                        {{ $member['phone'] }}
                                    </a>
                                </div>
                            </div>
                        </x-mary-card>
                    @endforeach
                </div>
            </div>
        </section>

    
</x-layouts.public>