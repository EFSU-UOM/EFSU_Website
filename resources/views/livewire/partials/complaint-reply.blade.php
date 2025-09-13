<x-mary-card class="ml-{{ $depth * 8 }}">
    <div class="flex items-start space-x-3">
        <!-- User Avatar -->
        <div class="flex-shrink-0">
            <div class="w-8 h-8 bg-primary/10 rounded-full flex items-center justify-center">
                <x-mary-icon name="o-user" class="w-4 h-4 text-primary" />
            </div>
        </div>

        <div class="flex-1">
            <div class="flex items-center space-x-2 mb-2">
                <strong class="text-sm text-base-content">{{ $reply->user->name ?? 'Anonymous' }}</strong>
                @if($reply->user && $reply->user->isAdmin())
                    <x-mary-badge value="Admin" class="badge-primary badge-xs" />
                @endif
                <span class="text-xs text-base-content/60">{{ $reply->created_at->diffForHumans() }}</span>
            </div>
            
            <div class="prose prose-sm max-w-none mb-3">
                {!! nl2br(e($reply->content)) !!}
            </div>
            
            <div class="flex items-center space-x-4">
                @if($reply->replies && $reply->replies->count() > 0 && $depth === 0)
                    <button wire:click="toggleReplies({{ $reply->id }})" class="text-xs text-base-content/60 hover:text-base-content">
                        @if(in_array($reply->id, $expandedReplies))
                            Hide {{ $reply->replies->count() }} {{ Str::plural('reply', $reply->replies->count()) }}
                        @else
                            Show {{ $reply->replies->count() }} {{ Str::plural('reply', $reply->replies->count()) }}
                        @endif
                    </button>
                @endif
                @auth
                    @if($replyingTo === $reply->id)
                        <button wire:click="cancelReply" class="text-xs text-base-content/60 hover:text-base-content">
                            Cancel
                        </button>
                    @else
                        <x-mary-button wire:click="setReplyingTo({{ $reply->id }})" class="btn-ghost btn-xs">
                            <x-mary-icon name="o-chat-bubble-left" class="w-4 h-4" />
                            Reply
                        </x-mary-button>
                    @endif

                    <!-- Delete Button (for reply owner or admin) -->
                    @if ($reply->user_id === auth()->id() || auth()->user()->isAdmin())
                        <x-mary-button 
                            wire:click="deleteReply({{ $reply->id }})"
                            wire:confirm="Are you sure you want to delete this reply?"
                            class="btn-ghost btn-xs text-error">
                            <x-mary-icon name="o-trash" class="w-4 h-4" />
                            Delete
                        </x-mary-button>
                    @endif
                @endauth
            </div>

            <!-- Reply Form -->
            @if($replyingTo === $reply->id)
                <div class="mt-4 p-4 bg-base-200 rounded-lg">
                    <form wire:submit="postReply({{ $reply->id }})">
                        <x-mary-textarea 
                            wire:model="replyContent"
                            placeholder="Write a reply..."
                            rows="3"
                            class="w-full mb-3" />
                        <div class="flex justify-end space-x-2">
                            <x-mary-button wire:click="cancelReply" class="btn-outline btn-sm">
                                Cancel
                            </x-mary-button>
                            <x-mary-button type="submit" class="btn-primary btn-sm">
                                Post Reply
                            </x-mary-button>
                        </div>
                    </form>
                </div>
            @endif
        </div>
    </div>

    <!-- Nested Replies -->
    @if($reply->replies && $reply->replies->count() > 0 && $depth < 4)
        @if($depth === 0)
            @if(in_array($reply->id, $expandedReplies))
                <div class="mt-4 space-y-4">
                    @foreach($reply->replies as $nestedReply)
                        @include('livewire.partials.complaint-reply', ['reply' => $nestedReply, 'depth' => $depth + 1])
                    @endforeach
                </div>
            @endif
        @else
            <div class="mt-4 space-y-4">
                @foreach($reply->replies as $nestedReply)
                    @include('livewire.partials.complaint-reply', ['reply' => $nestedReply, 'depth' => $depth + 1])
                @endforeach
            </div>
        @endif
    @endif
</x-mary-card>