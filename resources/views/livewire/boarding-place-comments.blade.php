<?php

use Livewire\Volt\Component;
use App\Models\BoardingPlaceComment;
use App\Models\BoardingPlace;

new class extends Component {
    public $boardingPlaceId;
    public $newComment = '';
    public $replyingTo = null;
    public $replyContent = '';

    protected $rules = [
        'newComment' => 'required|string|max:1000',
        'replyContent' => 'required|string|max:1000',
    ];

    public function mount($boardingPlaceId)
    {
        $this->boardingPlaceId = $boardingPlaceId;
    }

    public function getCommentsProperty()
    {
        return BoardingPlaceComment::with(['user', 'replies.user'])
            ->where('boarding_place_id', $this->boardingPlaceId)
            ->topLevel()
            ->orderedByScore()
            ->get();
    }

    public function postComment()
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $this->validate(['newComment' => 'required|string|max:1000']);

        BoardingPlaceComment::create([
            'user_id' => auth()->id(),
            'boarding_place_id' => $this->boardingPlaceId,
            'content' => $this->newComment,
        ]);

        $this->newComment = '';
        session()->flash('comment-success', 'Comment posted successfully!');
    }

    public function postReply()
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $this->validate(['replyContent' => 'required|string|max:1000']);

        BoardingPlaceComment::create([
            'user_id' => auth()->id(),
            'boarding_place_id' => $this->boardingPlaceId,
            'parent_id' => $this->replyingTo,
            'content' => $this->replyContent,
        ]);

        $this->replyContent = '';
        $this->replyingTo = null;
        session()->flash('comment-success', 'Reply posted successfully!');
    }

    public function startReply($commentId)
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }
        $this->replyingTo = $commentId;
    }

    public function cancelReply()
    {
        $this->replyingTo = null;
        $this->replyContent = '';
        $this->resetValidation(['replyContent']);
    }

    public function upvoteComment($commentId)
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $comment = BoardingPlaceComment::findOrFail($commentId);
        $comment->upvote(auth()->user());
    }

    public function downvoteComment($commentId)
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $comment = BoardingPlaceComment::findOrFail($commentId);
        $comment->downvote(auth()->user());
    }

    public function deleteComment($commentId)
    {
        $comment = BoardingPlaceComment::findOrFail($commentId);
        
        if ($comment->user_id === auth()->id()) {
            $comment->delete();
            session()->flash('comment-success', 'Comment deleted successfully!');
        }
    }
}; ?>

<div class="space-y-6">
    <!-- Comments Header -->
    <div class="flex items-center justify-between">
        <h3 class="text-lg font-semibold text-base-content">
            Comments ({{ $this->comments->count() }})
        </h3>
    </div>

    <!-- Success Message -->
    @if (session('comment-success'))
        <x-mary-alert icon="o-check-circle" class="alert-success">
            {{ session('comment-success') }}
        </x-mary-alert>
    @endif

    <!-- New Comment Form -->
    @auth
        <div class="bg-base-200 rounded-lg p-4">
            <div class="flex items-start space-x-3">
                <div class="flex-shrink-0">
                    <div class="w-8 h-8 bg-primary/10 rounded-full flex items-center justify-center">
                        <x-mary-icon name="o-user" class="w-4 h-4 text-primary" />
                    </div>
                </div>
                <div class="flex-1">
                    <x-mary-textarea 
                        wire:model="newComment" 
                        placeholder="Add a comment about this boarding place..." 
                        rows="3" 
                        class="w-full" />
                    @error('newComment')
                        <span class="text-error text-sm">{{ $message }}</span>
                    @enderror
                    <div class="flex justify-end mt-2">
                        <x-mary-button wire:click="postComment" class="btn-primary btn-sm">
                            Post Comment
                        </x-mary-button>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="bg-base-200 rounded-lg p-4 text-center">
            <p class="text-base-content/70">
                <a href="{{ route('login') }}" class="link link-primary">Sign in</a> to post comments
            </p>
        </div>
    @endauth

    <!-- Comments List -->
    <div class="space-y-4">
        @forelse ($this->comments as $comment)
            <div class="comment-thread">
                <!-- Main Comment -->
                <div class="flex items-start space-x-3 p-4 bg-base-100 rounded-lg">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-primary/10 rounded-full flex items-center justify-center">
                            <x-mary-icon name="o-user" class="w-4 h-4 text-primary" />
                        </div>
                    </div>
                    <div class="flex-1 min-w-0">
                        <div class="flex items-center space-x-2 mb-2">
                            <span class="font-medium text-base-content">{{ $comment->user->name }}</span>
                            <span class="text-xs text-base-content/60">{{ $comment->created_at->diffForHumans() }}</span>
                        </div>
                        <p class="text-base-content/80 mb-3">{{ $comment->content }}</p>
                        
                        <div class="flex items-center space-x-4">
                            @auth
                                <!-- Voting -->
                                <div class="flex items-center space-x-1">
                                    <x-mary-button wire:click="upvoteComment({{ $comment->id }})" class="btn-ghost btn-xs">
                                        <x-mary-icon name="o-chevron-up" class="w-4 h-4" />
                                    </x-mary-button>
                                    <span class="text-sm font-medium text-base-content/70">{{ $comment->score }}</span>
                                    <x-mary-button wire:click="downvoteComment({{ $comment->id }})" class="btn-ghost btn-xs">
                                        <x-mary-icon name="o-chevron-down" class="w-4 h-4" />
                                    </x-mary-button>
                                </div>

                                <!-- Reply Button -->
                                <x-mary-button wire:click="startReply({{ $comment->id }})" class="btn-ghost btn-xs">
                                    <x-mary-icon name="o-chat-bubble-left" class="w-4 h-4" />
                                    Reply
                                </x-mary-button>

                                <!-- Delete Button (only for comment owner) -->
                                @if ($comment->user_id === auth()->id())
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
                        @if ($replyingTo === $comment->id)
                            <div class="mt-4 bg-base-200 rounded-lg p-3">
                                <div class="flex items-start space-x-3">
                                    <div class="flex-shrink-0">
                                        <div class="w-6 h-6 bg-primary/10 rounded-full flex items-center justify-center">
                                            <x-mary-icon name="o-user" class="w-3 h-3 text-primary" />
                                        </div>
                                    </div>
                                    <div class="flex-1">
                                        <x-mary-textarea 
                                            wire:model="replyContent" 
                                            placeholder="Write your reply..." 
                                            rows="2" 
                                            class="w-full" />
                                        @error('replyContent')
                                            <span class="text-error text-sm">{{ $message }}</span>
                                        @enderror
                                        <div class="flex justify-end gap-2 mt-2">
                                            <x-mary-button wire:click="cancelReply" class="btn-ghost btn-sm">
                                                Cancel
                                            </x-mary-button>
                                            <x-mary-button wire:click="postReply" class="btn-primary btn-sm">
                                                Post Reply
                                            </x-mary-button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <!-- Replies -->
                        @if ($comment->replies->count() > 0)
                            <div class="mt-4 space-y-3">
                                @foreach ($comment->replies as $reply)
                                    <div class="flex items-start space-x-3 pl-4 border-l-2 border-base-300">
                                        <div class="flex-shrink-0">
                                            <div class="w-6 h-6 bg-primary/10 rounded-full flex items-center justify-center">
                                                <x-mary-icon name="o-user" class="w-3 h-3 text-primary" />
                                            </div>
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <div class="flex items-center space-x-2 mb-2">
                                                <span class="text-sm font-medium text-base-content">{{ $reply->user->name }}</span>
                                                <span class="text-xs text-base-content/60">{{ $reply->created_at->diffForHumans() }}</span>
                                            </div>
                                            <p class="text-sm text-base-content/80 mb-2">{{ $reply->content }}</p>
                                            
                                            @auth
                                                <div class="flex items-center space-x-2">
                                                    <!-- Voting for replies -->
                                                    <div class="flex items-center space-x-1">
                                                        <x-mary-button wire:click="upvoteComment({{ $reply->id }})" class="btn-ghost btn-xs">
                                                            <x-mary-icon name="o-chevron-up" class="w-3 h-3" />
                                                        </x-mary-button>
                                                        <span class="text-xs font-medium text-base-content/70">{{ $reply->score }}</span>
                                                        <x-mary-button wire:click="downvoteComment({{ $reply->id }})" class="btn-ghost btn-xs">
                                                            <x-mary-icon name="o-chevron-down" class="w-3 h-3" />
                                                        </x-mary-button>
                                                    </div>

                                                    <!-- Delete Button for reply owner -->
                                                    @if ($reply->user_id === auth()->id())
                                                        <x-mary-button 
                                                            wire:click="deleteComment({{ $reply->id }})"
                                                            wire:confirm="Are you sure you want to delete this reply?"
                                                            class="btn-ghost btn-xs text-error">
                                                            <x-mary-icon name="o-trash" class="w-3 h-3" />
                                                        </x-mary-button>
                                                    @endif
                                                </div>
                                            @endauth
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <div class="text-center py-8">
                <x-mary-icon name="o-chat-bubble-left" class="w-12 h-12 text-base-content/40 mx-auto mb-4" />
                <h4 class="text-lg font-medium text-base-content mb-2">No comments yet</h4>
                <p class="text-base-content/70">
                    Be the first to share your thoughts about this boarding place.
                </p>
            </div>
        @endforelse
    </div>
</div>