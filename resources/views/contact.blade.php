<x-layouts.public>

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
                            'name' => 'Maleesha Kavinda',
                            'position' => 'President',
                            'email' => 'president@efsu-uom.lk',
                            'phone' => '+94 70 449 8462',
                            'image' => '/people/maleesha.avif',
                            'bg' => 'bg-primary'
                        ],
                        [
                            'name' => 'Sivamynthan Nadesamoorthy',
                            'position' => 'Secretary',
                            'email' => 'secretary@efsu-uom.lk',
                            'phone' => '+94 76 637 0873',
                            'image' => '/people/shiva.avif',
                            'bg' => 'bg-secondary'
                        ],
                        [
                            'name' => 'Kaveesha Nirmal',
                            'position' => 'Vice President',
                            'email' => 'vicepresident@efsu-uom.lk',
                            'phone' => '+94 77 690 7920',
                            'image' => '/people/kaveesha.avif',
                            'bg' => 'bg-accent'
                        ],
                        [
                            'name' => 'Pivithuru Hasintha',
                            'position' => 'Vice Secretary',
                            'email' => 'vicesecretary@efsu-uom.lk',
                            'phone' => '+94 71 787 5495',
                            'image' => '/people/pivithuru.avif',
                            'bg' => 'bg-info'
                        ],
                        [
                            'name' => 'Gishan Chamith',
                            'position' => 'Treasurer',
                            'email' => 'treasurer@efsu-uom.lk',
                            'phone' => '+94 76 351 0388',
                            'image' => '/people/gishan.avif',
                            'bg' => 'bg-success'
                        ],
                        [
                            'name' => 'Sehandu Diyanaka',
                            'position' => 'Editor',
                            'email' => 'editor@efsu-uom.lk',
                            'phone' => '+94 70 532 0290',
                            'image' => '/people/sehandu.avif',
                            'bg' => 'bg-warning'
                        ],
                    ];

                    $committeeMembers = [
                        [
                            'name' => 'Chanuka Maneesha',
                            'position' => 'Committee Member',
                            'email' => 'chanuka@efsu-uom.lk',
                            'phone' => '+94 70 237 3026',
                            'image' => '/people/chanuka.avif',
                            'bg' => 'bg-orange-400'
                        ],
                        [
                            'name' => 'Sahan Cooray',
                            'position' => 'Committee Member',
                            'email' => 'cooraymst.22@uom.lk',
                            'phone' => '+94 76 699 0124',
                            'image' => '/people/sahan.avif',
                            'bg' => 'bg-purple-500'
                        ],
                        [
                            'name' => 'Lasidu Induwara',
                            'position' => 'Committee Member',
                            'email' => 'herathhmli.23@uom.lk',
                            'phone' => '+94 71 115 4940',
                            'image' => '/people/lasindu.avif',
                            'bg' => 'bg-teal-500'
                        ],
                        [
                            'name' => 'Lahiru Gunasekara',
                            'position' => 'Committee Member',
                            'email' => 'gunasekaraklm.24@uom.lk',
                            'phone' => '+94 71 351 3157',
                            'image' => '/people/lahiru.avif',
                            'bg' => 'bg-indigo-500'
                        ],
                        [
                            'name' => 'Anjana Imantha',
                            'position' => 'Committee Member',
                            'email' => 'imanthabua.24@uom.lk',
                            'phone' => '+94 74 269 9320',
                            'image' => '/people/anjana.avif',
                            'bg' => 'bg-pink-500'
                        ],
                        [
                            'name' => 'Waruni Wasana',
                            'position' => 'Committee Member',
                            'email' => 'nethminigvww.24@uom.lk',
                            'phone' => '+94 77 058 0943',
                            'image' => '/people/waruni.avif',
                            'bg' => 'bg-emerald-500'
                        ],
                        [
                            'name' => 'Nithira Pawan',
                            'position' => 'Committee Member',
                            'email' => 'hansarahdnp.24@uom.lk',
                            'phone' => '+94 72 556 4798',
                            'image' => '/people/nithira.avif',
                            'bg' => 'bg-red-500'
                        ]
                    ];

                    $subCommittees = [
                        [
                            'title' => 'E-Frames',
                            'subtitle' => 'EFSU Media Subcommittee',
                            'members' => [
                                ['name' => 'Sahan Cooray', 'position' => 'Director of Media', 'image' => '/people/sahan.avif'],
                                ['name' => 'Sehandu Diyanaka', 'position' => 'Co-Director of Media', 'image' => '/people/sehandu.avif'],
                                ['name' => 'Senuja Wathsilu', 'position' => 'Pillar Head - Visual Media', 'image' => '/people/senuja.avif'],
                                ['name' => 'Sithuka Abinuka', 'position' => 'Pillar Head - Creative Media', 'image' => '/people/sithuka.avif'],
                            ],
                        ],
                        [
                            'title' => 'E-Voice',
                            'subtitle' => 'EFSU Literature and Art Subcommittee',
                            'members' => [
                                ['name' => 'Sithum Ransindu', 'position' => 'Director', 'image' => '/people/sithum.avif'],
                                ['name' => 'Vidura Prasanna', 'position' => 'Director', 'image' => '/people/vidura.avif'],
                                ['name' => 'Avishka Theshan', 'position' => 'Pillar Head - Publications', 'image' => '/people/avishka.avif'],
                                ['name' => 'Dineth Maduhansa', 'position' => 'Pillar Head - Literary Affairs', 'image' => '/people/dineth.avif'],
                                ['name' => 'Oska Hidmi', 'position' => 'Pillar Head - Performing Arts', 'image' => '/people/oska.avif'],
                                ['name' => 'Themiya Rajarathna', 'position' => 'Pillar Head - Creative Arts', 'image' => '/people/themiya.avif'],
                            ],
                        ],
                    ];
                @endphp

                {{-- Senior Treasurer --}}
                <div class="mb-10">
                    <x-mary-card class="w-full md:w-2/3 mx-auto p-6 text-center" shadow>
                        <div class="flex justify-center">
                            <x-mary-avatar class="!w-20 !h-20" image="/people/luminda.avif" />
                        </div>
                        <h2 class="mt-4 text-2xl font-bold">Dr. Luminda Gunawardhana</h2>
                        <p class="text-lg text-base-content/70">Senior Treasurer, EFSU</p>
                        <p class="text-sm text-base-content/60">Senior Lecturer</p>
                        <div class="mt-4 text-sm text-base-content/60">
                            <div class="flex justify-center items-center gap-2">
                                <x-mary-icon name="o-envelope" class="w-4 h-4" />
                                <a href="mailto:lumindang@uom.lk" class="hover:text-primary">lumindang@uom.lk</a>
                            </div>
                        </div>
                    </x-mary-card>
                </div>

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

                {{-- Sub-committees --}}
                @foreach($subCommittees as $subCommittee)
                    <h3 class="text-xl font-semibold mt-12">{{ $subCommittee['title'] }}</h3>
                    <p class="text-sm text-base-content/70 mb-6">{{ $subCommittee['subtitle'] }}</p>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                        @foreach($subCommittee['members'] as $member)
                            <x-mary-card class="w-full" shadow>
                                <div class="flex items-center gap-3">
                                    <x-mary-avatar class="!w-12 !h-12" :image="$member['image']" />
                                    <div>
                                        <h3 class="font-semibold text-base-content">{{ $member['name'] }}</h3>
                                        <p class="text-sm text-base-content/70">{{ $member['position'] }}</p>
                                    </div>
                                </div>
                            </x-mary-card>
                        @endforeach
                    </div>
                @endforeach
            </div>
        </section>
    <section class="py-10">
        <div class="container mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                {{-- <!-- Contact Form -->
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
                </x-mary-card> --}}

                <!-- Contact Information -->
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
    </section>
    
</x-layouts.public>