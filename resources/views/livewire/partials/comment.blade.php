<x-mary-card class="ml-{{ $depth * 8 }}">
    <div class="flex items-start space-x-3">
        <!-- Vote buttons -->
        <div class="flex flex-col items-center space-y-1">
            <button 
                wire:click="upvoteComment({{ $comment->id }})"
                class="flex items-center justify-center w-6 h-6 rounded-full hover:bg-success/10 transition-colors
                       {{ auth()->check() && $comment->getUserVote(auth()->user()) === true ? 'bg-success/20 text-success' : 'text-base-content/60' }}">
                <x-mary-icon name="o-chevron-up" class="w-4 h-4" />
            </button>
            <span class="text-xs font-semibold text-base-content">{{ $comment->score }}</span>
            <button 
                wire:click="downvoteComment({{ $comment->id }})"
                class="flex items-center justify-center w-6 h-6 rounded-full hover:bg-error/10 transition-colors
                       {{ auth()->check() && $comment->getUserVote(auth()->user()) === false ? 'bg-error/20 text-error' : 'text-base-content/60' }}">
                <x-mary-icon name="o-chevron-down" class="w-4 h-4" />
            </button>
        </div>

        <div class="flex-1">
            <div class="flex items-center space-x-2 mb-2">
                <strong class="text-sm text-base-content">{{ $comment->user->name ?? 'Anonymous' }}</strong>
                <span class="text-xs text-base-content/60">{{ $comment->created_at->diffForHumans() }}</span>
            </div>
            
            <div class="prose prose-sm max-w-none mb-3">
                {!! nl2br(e($comment->content)) !!}
            </div>
            
            <div class="flex items-center space-x-4">
                @if($comment->replies && $comment->replies->count() > 0 && $depth === 0)
                    <button wire:click="toggleReplies({{ $comment->id }})" class="text-xs text-base-content/60 hover:text-base-content">
                        @if(in_array($comment->id, $expandedComments))
                            Hide {{ $comment->replies->count() }} {{ Str::plural('reply', $comment->replies->count()) }}
                        @else
                            Show {{ $comment->replies->count() }} {{ Str::plural('reply', $comment->replies->count()) }}
                        @endif
                    </button>
                @endif
                @auth
                    @if($replyingTo === $comment->id)
                        <button wire:click="cancelReply" class="text-xs text-base-content/60 hover:text-base-content">
                            Cancel
                        </button>
                    @else
                        <x-mary-button wire:click="setReplyingTo({{ $comment->id }})" class="btn-ghost btn-xs">
                            <x-mary-icon name="o-chat-bubble-left" class="w-4 h-4" />
                            Reply
                        </x-mary-button>
                    @endif

                    <!-- Delete Button (for comment owner or admin) -->
                    @if ($comment->user_id === auth()->id() || auth()->user()->isAdmin())
                        <x-mary-button 
                            wire:click="deleteComment({{ $comment->id }})"
                            wire:confirm="Are you sure you want to delete this comment?"
                            class="btn-ghost btn-xs text-error">
                            <x-mary-icon name="o-trash" class="w-4 h-4" />
                            Delete
                        </x-mary-button>
                    @endif
                @endauth
            </div>

            <!-- Reply Form -->
            @if($replyingTo === $comment->id)
                <div class="mt-4 p-4 bg-base-200 rounded-lg">
                    <form wire:submit="postReply({{ $comment->id }})">
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
    @if($comment->replies && $comment->replies->count() > 0 && $depth < 4)
        @if($depth === 0)
            @if(in_array($comment->id, $expandedComments))
                <div class="mt-4 space-y-4">
                    @foreach($comment->replies as $reply)
                        @include('livewire.partials.comment', ['comment' => $reply, 'depth' => $depth + 1])
                    @endforeach
                </div>
            @endif
        @else
            <div class="mt-4 space-y-4">
                @foreach($comment->replies as $reply)
                    @include('livewire.partials.comment', ['comment' => $reply, 'depth' => $depth + 1])
                @endforeach
            </div>
        @endif
    @endif
</x-mary-card>