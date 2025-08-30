<x-layouts.public>
    <!-- Store Hero Section -->
    <section class="bg-primary py-16">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <h1 class="text-4xl font-bold text-primary-content mb-4">EFSU Store</h1>
                <p class="text-xl text-primary-content/80">
                    Official merchandise from the Engineering Faculty Students' Union
                </p>
            </div>
        </div>
    </section>

    <!-- Store Items Section -->
    <section class="bg-base-200 py-16">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-base-content mb-4">Union Merchandise</h2>
                <p class="text-lg text-base-content/70">
                    Show your EFSU pride with our official merchandise collection
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 justify-center">
                <!-- T-Shirts Card -->
                <x-mary-card class="shadow-sm hover:shadow-md transition-shadow overflow-hidden bg-base-100 max-w-sm mx-auto">
                    <x-slot name="figure">
                        <img src="https://images.unsplash.com/photo-1521572163474-6864f9cf17ab?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80"
                             alt="EFSU T-Shirts" class="w-full h-48 object-cover">
                    </x-slot>

                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-base-content mb-2">Official T-Shirts</h3>
                        <p class="text-base-content/70 mb-4">
                            High-quality cotton t-shirts with the UOM logo and engineering-themed designs.
                        </p>
                        <div class="flex items-center justify-between">
                            <span class="text-lg font-bold text-primary">LKR 1,500</span>
                            <x-mary-button label="Order Now" class="btn-primary btn-sm" />
                        </div>
                    </div>
                </x-mary-card>
            </div>

            <!-- Contact Information -->
            <div class="mt-32 md:mt-48 text-center bg-base-100 rounded-lg p-8">
                <h3 class="text-xl font-semibold text-base-content mb-4">How to Order</h3>
                <p class="text-base-content/70 mb-6">
                    Contact us through WhatsApp or visit our office to place your order. 
                    Payment options include cash, bank transfer, or mobile payments.
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <x-mary-button class="btn-primary">
                        <x-mary-icon name="o-phone" class="w-4 h-4 mr-2" />
                        WhatsApp Order
                    </x-mary-button>
                    <x-mary-button class="btn-outline">
                        <x-mary-icon name="o-map-pin" class="w-4 h-4 mr-2" />
                        Visit Office
                    </x-mary-button>
                </div>
            </div>
        </div>
    </section>
</x-layouts.public>