<x-layouts.public>
    <!-- Store Hero Section -->
    <section class="bg-base-100 py-20">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 text-center">
            <h1 class="text-4xl sm:text-5xl font-bold tracking-tight text-base-content mb-6">
                <span class="text-primary">EFSU</span> Store
            </h1>
            <p class="text-xl text-base-content/70 max-w-3xl mx-auto">
                Official merchandise from the Engineering Faculty Students' Union
            </p>
        </div>
    </section>


    <!-- Store Items Section -->
    <livewire:union-merchandise />

    <!-- Contact Information -->
    <section class="py-8 md:py-16">
        <div class="text-center bg-base-100 rounded-lg p-8">
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
    </section>
</x-layouts.public>