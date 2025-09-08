<?php

use App\Models\Event;
use function Livewire\Volt\{state};

state(['events' => fn() => Event::orderBy('start_datetime', 'asc')->limit(6)->get()]);

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
            @forelse($events as $event)
                <x-mary-card class="shadow-sm hover:shadow-md transition-shadow overflow-hidden bg-base-100">
                    <x-slot name="figure">
                        <img src="{{ Storage::url($event->image_url) }}"
                             alt="{{ $event->title }}" class="w-full h-48 object-cover">
                    </x-slot>

                    <div class="p-6">
                        <div class="flex items-center justify-between mb-2">
                            <x-mary-badge value="{{ ucfirst($event->type) }}" 
                                class="{{ $event->type === 'cultural' ? 'badge-primary' : ($event->type === 'community' ? 'badge-accent' : 'badge-success') }}" />
                            @if($event->start_datetime)
                                <span class="text-xs text-base-content/60">{{ $event->start_datetime->format('M d, Y') }}</span>
                            @endif
                        </div>
                        <h3 class="text-lg font-semibold text-base-content mb-2">{{ $event->title }}</h3>
                        @if($event->description)
                            <p class="text-sm text-base-content/80 mb-4">{{ Str::limit($event->description, 100) }}</p>
                        @endif
                        
                        <div class="flex flex-col space-y-2 mb-4">
                            @if($event->facebook_page_url)
                                <a href="{{ $event->facebook_page_url }}" target="_blank" class="btn btn-outline btn-sm">
                                    <x-mary-icon name="o-link" class="w-4 h-4 mr-1" />
                                    Facebook Page
                                </a>
                            @endif
                            
                            @if($event->facebook_album_urls && count($event->facebook_album_urls) > 0)
                                @if(count($event->facebook_album_urls) === 1)
                                    <a href="{{ $event->facebook_album_urls[0] }}" target="_blank" class="btn btn-outline btn-sm">
                                        <x-mary-icon name="o-link" class="w-4 h-4 mr-1" />
                                        Event Album
                                    </a>
                                @else
                                    <h4 class="text-sm font-medium text-base-content/80">Event Albums:</h4>
                                    <div class="flex flex-col space-y-1">
                                        @foreach($event->facebook_album_urls as $index => $albumUrl)
                                            <a href="{{ $albumUrl }}" target="_blank" class="btn btn-outline btn-xs">
                                                <x-mary-icon name="o-link" class="w-3 h-3 mr-1" />
                                                Album {{ $index + 1 }}
                                            </a>
                                        @endforeach
                                    </div>
                                @endif
                            @endif
                        </div>
                    </div>
                </x-mary-card>
            @empty
                <div class="col-span-full text-center py-8">
                    <p class="text-base-content/60">No upcoming events available.</p>
                </div>
            @endforelse
        </div>
    </div>
</section>