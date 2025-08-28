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
                                        Engineering Faculty Building<br>
                                        Room 205, Second Floor<br>
                                        University Campus, Main Block
                                    </p>
                                </div>
                            </div>

                            <div class="flex items-start">
                                <div class="w-12 h-12 rounded-lg flex items-center justify-center mr-4 bg-success/10">
                                    <x-mary-icon name="o-phone" class="w-6 h-6 text-success" />
                                </div>
                                <div>
                                    <h3 class="text-lg font-semibold text-base-content">Phone</h3>
                                    <p class="text-base-content/70 mt-1">
                                        +1 (555) 123-4567<br>
                                        +1 (555) 123-4568 (Emergency)
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
                                        info@efsu.edu<br>
                                        president@efsu.edu
                                    </p>
                                </div>
                            </div>

                            <div class="flex items-start">
                                <div class="w-12 h-12 rounded-lg flex items-center justify-center mr-4 bg-warning/10">
                                    <x-mary-icon name="o-clock" class="w-6 h-6 text-warning" />
                                </div>
                                <div>
                                    <h3 class="text-lg font-semibold text-base-content">Office Hours</h3>
                                    <p class="text-base-content/70 mt-1">
                                        Monday - Friday: 9:00 AM - 5:00 PM<br>
                                        Saturday: 10:00 AM - 2:00 PM<br>
                                        Sunday: Closed
                                    </p>
                                </div>
                            </div>
                        </div>
                    </x-mary-card>

                    <!-- Social Media -->
                    <x-mary-card title="Follow Us" shadow class="bg-base-100">
                        <div class="flex gap-3">
                            <x-mary-button class="btn-primary btn-circle">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                                </svg>
                            </x-mary-button>
                            <x-mary-button class="btn-info btn-circle">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/>
                                </svg>
                            </x-mary-button>
                            <x-mary-button class="btn-secondary btn-circle">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path d="M12.017 0C5.396 0 .029 5.367.029 11.987c0 5.079 3.158 9.417 7.618 11.174-.105-.949-.199-2.403.042-3.441.219-.937 1.407-5.965 1.407-5.965s-.359-.719-.359-1.782c0-1.668.967-2.914 2.171-2.914 1.023 0 1.518.769 1.518 1.69 0 1.029-.655 2.568-.994 3.995-.283 1.194.599 2.169 1.777 2.169 2.133 0 3.772-2.249 3.772-5.495 0-2.873-2.064-4.882-5.012-4.882-3.414 0-5.418 2.561-5.418 5.207 0 1.031.397 2.138.893 2.738a.36.36 0 01.083.345l-.333 1.36c-.053.22-.174.267-.402.161-1.499-.698-2.436-2.889-2.436-4.649 0-3.785 2.75-7.262 7.929-7.262 4.163 0 7.398 2.967 7.398 6.931 0 4.136-2.607 7.464-6.227 7.464-1.216 0-2.357-.631-2.75-1.378l-.748 2.853c-.271 1.043-1.002 2.35-1.492 3.146C9.57 23.812 10.763 24.009 12.017 24.009c6.624 0 11.99-5.367 11.99-11.988C24.007 5.367 18.641.001.012 12.017z"/>
                                </svg>
                            </x-mary-button>
                            <x-mary-button class="btn-accent btn-circle">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
                                </svg>
                            </x-mary-button>
                        </div>
                    </x-mary-card>
                </div>
            </div>
        </div>
    </section>
</x-layouts.public>