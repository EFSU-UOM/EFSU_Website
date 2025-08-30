<?php

use function Livewire\Volt\{state};

?>

<section class="bg-base-200 py-16">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between mb-8">
            <h2 class="text-2xl font-bold text-base-content">Events</h2>
            <div class="flex space-x-4">
                <x-mary-button label="Add to Calendar" class="btn-primary" />
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <x-mary-card class="shadow-sm hover:shadow-md transition-shadow overflow-hidden bg-base-100">
                <x-slot name="figure">
                    <img src="https://images.unsplash.com/photo-1540575467063-178a50c2df87?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2070&q=80"
                         alt="Event 1" class="w-full h-48 object-cover">
                </x-slot>

                <div class="p-6">
                    <div class="flex items-center justify-between mb-2">
                        <x-mary-badge value="Event" class="badge-primary" />
                    </div>
                    <h3 class="text-lg font-semibold text-base-content mb-2">සොයුරු සත්කාර </h3>
                    <div class="flex flex-col space-y-2 mb-4">
                        <a href="https://www.facebook.com/share/1YwNzZXVZV/?mibextid=wwXIfr" target="_blank" class="btn btn-outline btn-sm">
                            <x-mary-icon name="o-link" class="w-4 h-4 mr-1" />
                            Facebook Page
                        </a>
                        <a href="https://www.facebook.com/share/1JmDMGDspX/?mibextid=wwXIfr" target="_blank" class="btn btn-outline btn-sm">
                            <x-mary-icon name="o-link" class="w-4 h-4 mr-1" />
                            Event Album
                        </a>
                    </div>
                </div>
            </x-mary-card>

            <x-mary-card class="shadow-sm hover:shadow-md transition-shadow overflow-hidden bg-base-100">
                <x-slot name="figure">
                    <img src="https://images.unsplash.com/photo-1531482615713-2afd69097998?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2070&q=80"
                         alt="Event 2" class="w-full h-48 object-cover">
                </x-slot>

                <div class="p-6">
                    <div class="flex items-center justify-between mb-2">
                        <x-mary-badge value="Event" class="badge-success" />
                    </div>
                    <h3 class="text-lg font-semibold text-base-content mb-2">මැවිසුරු රගසොබා </h3>
                    <div class="flex flex-col space-y-2 mb-4">
                        <h4 class="text-sm font-medium text-base-content/80">2025 Event Album:</h4>
                        <a href="https://www.facebook.com/share/1BdbQNq4KR/?" target="_blank" class="btn btn-outline btn-xs">
                            <x-mary-icon name="o-link" class="w-3 h-3 mr-1" />
                            2025 Album
                        </a>
                        <h4 class="text-sm font-medium text-base-content/80">2023 Event Album:</h4>
                        <a href="https://www.facebook.com/share/19U5ns5xNx/?" target="_blank" class="btn btn-outline btn-xs">
                            <x-mary-icon name="o-link" class="w-3 h-3 mr-1" />
                            2023 Album
                        </a>
                        <h4 class="text-sm font-medium text-base-content/80">2019 Event Albums:</h4>
                        <div class="flex flex-col space-y-1">
                            <a href="https://www.facebook.com/share/16oV77BxNq/?mibextid=wwXIfr" target="_blank" class="btn btn-outline btn-xs">
                                <x-mary-icon name="o-link" class="w-3 h-3 mr-1" />
                                2019 Album 1
                            </a>
                            <a href="https://www.facebook.com/share/1C6b1Fmpr6/?mibextid=wwXIfr" target="_blank" class="btn btn-outline btn-xs">
                                <x-mary-icon name="o-link" class="w-3 h-3 mr-1" />
                                2019 Album 2
                            </a>
                            <a href="https://www.facebook.com/share/1FsGHZK7Wb/?mibextid=wwXIfr" target="_blank" class="btn btn-outline btn-xs">
                                <x-mary-icon name="o-link" class="w-3 h-3 mr-1" />
                                2019 Album 3
                            </a>
                        </div>
                    </div>
                </div>
            </x-mary-card>

            <x-mary-card class="shadow-sm hover:shadow-md transition-shadow overflow-hidden bg-base-100">
                <x-slot name="figure">
                    <img src="https://images.unsplash.com/photo-1511632765486-a01980e01a18?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2070&q=80"
                         alt="Event 3" class="w-full h-48 object-cover">
                </x-slot>

                <div class="p-6">
                    <div class="flex items-center justify-between mb-2">
                        <x-mary-badge value="Event" class="badge-accent" />
                    </div>
                    <h3 class="text-lg font-semibold text-base-content mb-2">දේදුනු ගංතොට  </h3>
                    <div class="flex flex-col space-y-2 mb-4">
                        <a href="https://www.facebook.com/share/1786nUGAkn/?mibextid=wwXIfr" target="_blank" class="btn btn-outline btn-sm">
                            <x-mary-icon name="o-link" class="w-4 h-4 mr-1" />
                            Event Album
                        </a>
                    </div>
                </div>
            </x-mary-card>
        </div>
    </div>
</section>