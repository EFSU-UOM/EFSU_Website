<?php

use App\Models\ForumPost;
use App\Models\ForumComment;
use function Livewire\Volt\{computed, state, mount};

state([
    'post',
    'newComment' => '',
    'replyingTo' => null,
    'replyContent' => '',
    'expandedComments' => [],
]);

mount(function (ForumPost $post) {
    $this->post = $post->load(['user', 'votes'])->loadCount(['comments']);
});


$comments = computed(function () {
    return ForumComment::with(['user', 'replies.user', 'replies.replies.user'])
        ->where('post_id', $this->post->id)
        ->whereNull('parent_id')
        ->orderBy('score', 'desc')
        ->orderBy('created_at', 'asc')
        ->get();
});

$postComment = function () {
    if (!auth()->check()) {
        $this->js('alert("Please log in to post a comment.")');
        return;
    }
    if (!auth()->user()->hasVerifiedEmail()) {
        $this->js('alert("Please verify your email address to post comments.")');
        return;
    }

    if (empty(trim($this->newComment))) {
        return;
    }

    ForumComment::create([
        'content' => $this->newComment,
        'post_id' => $this->post->id,
        'user_id' => auth()->id(),
        'upvotes' => 0,
        'downvotes' => 0,
        'score' => 0,
    ]);

    $this->newComment = '';
    $this->dispatch('comment-posted');
};

$postReply = function ($parentId) {
    if (!auth()->check()) {
        $this->js('alert("Please log in to reply.")');
        return;
    }

    if (empty(trim($this->replyContent))) {
        return;
    }

    ForumComment::create([
        'content' => $this->replyContent,
        'post_id' => $this->post->id,
        'parent_id' => $parentId,
        'user_id' => auth()->id(),
        'upvotes' => 0,
        'downvotes' => 0,
        'score' => 0,
    ]);

    $this->replyContent = '';
    $this->replyingTo = null;
    $this->dispatch('comment-posted');
};

$upvotePost = function () {
    if (!auth()->check()) {
        $this->js('alert("Please log in to vote.")');
        return;
    }
    if (!auth()->user()->hasVerifiedEmail()) {
        $this->js('alert("Please verify your email address to vote.")');
        return;
    }
    
    $this->post->upvote(auth()->user());
    $this->dispatch('post-voted');
};

$downvotePost = function () {
    if (!auth()->check()) {
        $this->js('alert("Please log in to vote.")');
        return;
    }
    if (!auth()->user()->hasVerifiedEmail()) {
        $this->js('alert("Please verify your email address to vote.")');
        return;
    }
    
    $this->post->downvote(auth()->user());
    $this->dispatch('post-voted');
};

$upvoteComment = function ($commentId) {
    if (!auth()->check()) {
        $this->js('alert("Please log in to vote.")');
        return;
    }
    if (!auth()->user()->hasVerifiedEmail()) {
        $this->js('alert("Please verify your email address to vote.")');
        return;
    }
    
    $comment = ForumComment::find($commentId);
    if ($comment) {
        $comment->upvote(auth()->user());
        $this->dispatch('comment-voted');
    }
};

$downvoteComment = function ($commentId) {
    if (!auth()->check()) {
        $this->js('alert("Please log in to vote.")');
        return;
    }
    if (!auth()->user()->hasVerifiedEmail()) {
        $this->js('alert("Please verify your email address to vote.")');
        return;
    }
    
    $comment = ForumComment::find($commentId);
    if ($comment) {
        $comment->downvote(auth()->user());
        $this->dispatch('comment-voted');
    }
};

$setReplyingTo = function ($commentId) {
    $this->replyingTo = $commentId;
    $this->replyContent = '';
};

$cancelReply = function () {
    $this->replyingTo = null;
    $this->replyContent = '';
};

$toggleReplies = function ($commentId) {
    if (in_array($commentId, $this->expandedComments)) {
        $this->expandedComments = array_values(array_diff($this->expandedComments, [$commentId]));
    } else {
        $this->expandedComments[] = $commentId;
    }
};

$togglePin = function () {
    if (!auth()->check() || !auth()->user()->isAdmin()) {
        $this->js('alert("Only admins can pin posts.")');
        return;
    }
    
    $this->post->togglePin();
    $this->dispatch('post-pinned');
};

$deleteComment = function ($commentId) {
    if (!auth()->check()) {
        $this->js('alert("Please log in to delete comments.")');
        return;
    }
    
    $comment = ForumComment::find($commentId);
    if (!$comment) {
        $this->js('alert("Comment not found.")');
        return;
    }
    
    // Check if user is admin or comment owner
    if (!auth()->user()->isAdmin() && $comment->user_id !== auth()->id()) {
        $this->js('alert("You can only delete your own comments.")');
        return;
    }
    
    $comment->delete();
    $this->dispatch('comment-deleted');
};

$deletePost = function () {
    if (!auth()->check()) {
        $this->js('alert("Please log in to delete posts.")');
        return;
    }
    
    // Check if user is admin or post owner
    if (!auth()->user()->isAdmin() && $this->post->user_id !== auth()->id()) {
        $this->js('alert("You can only delete your own posts.")');
        return;
    }
    
    $this->post->delete();
    return redirect()->route('forum');
};

?>

<section class="bg-base-100 py-16">
    <div class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8">
        <!-- Back to Forum -->
        <div class="mb-6">
            <a href="{{ route('forum') }}" class="inline-flex items-center text-primary hover:text-primary-focus">
                <x-mary-icon name="o-arrow-left" class="w-4 h-4 mr-2" />
                Back to Forum
            </a>
        </div>

        <!-- Post Content -->
        <x-mary-card class="mb-8">
            <div class="flex items-start space-x-4">
                <!-- Vote buttons -->
                <div class="flex flex-col items-center space-y-1">
                    <button 
                        wire:click="upvotePost"
                        class="flex items-center justify-center w-10 h-10 rounded-full hover:bg-success/10 transition-colors
                               {{ auth()->check() && $this->post->getUserVote(auth()->user()) === true ? 'bg-success/20 text-success' : 'text-base-content/60' }}">
                        <x-mary-icon name="o-chevron-up" class="w-6 h-6" />
                    </button>
                    <span class="text-lg font-bold text-base-content">{{ $this->post->score }}</span>
                    <button 
                        wire:click="downvotePost"
                        class="flex items-center justify-center w-10 h-10 rounded-full hover:bg-error/10 transition-colors
                               {{ auth()->check() && $this->post->getUserVote(auth()->user()) === false ? 'bg-error/20 text-error' : 'text-base-content/60' }}">
                        <x-mary-icon name="o-chevron-down" class="w-6 h-6" />
                    </button>
                </div>

                <div class="flex-1">
                    <div class="mb-4">
                        <x-mary-badge 
                            value="{{ $this->post->category->label() }}" 
                            class="badge-{{ $this->post->category->color() }} mb-2" />
                        <div class="flex items-center justify-between">
                            <h1 class="text-3xl font-bold text-base-content">{{ $this->post->title }}</h1>
                            <div class="flex items-center space-x-2">
                                @if(auth()->check() && auth()->user()->isAdmin())
                                    <button 
                                        wire:click="togglePin"
                                        class="flex items-center space-x-2 px-3 py-1 rounded-md text-sm transition-colors
                                               {{ $this->post->is_pinned ? 'bg-warning/20 text-warning hover:bg-warning/30' : 'bg-base-300 text-base-content/60 hover:bg-base-300/80' }}">
                                        <x-mary-icon name="{{ $this->post->is_pinned ? 'o-bookmark-slash' : 'o-bookmark' }}" class="w-4 h-4" />
                                        <span>{{ $this->post->is_pinned ? 'Unpin' : 'Pin' }}</span>
                                    </button>
                                @endif
                                @if(auth()->check() && (auth()->user()->isAdmin() || $this->post->user_id === auth()->id()))
                                    <button 
                                        wire:click="deletePost"
                                        wire:confirm="Are you sure you want to delete this post? This action cannot be undone."
                                        class="flex items-center space-x-2 px-3 py-1 rounded-md text-sm transition-colors bg-error/20 text-error hover:bg-error/30">
                                        <x-mary-icon name="o-trash" class="w-4 h-4" />
                                        <span>Delete</span>
                                    </button>
                                @endif
                            </div>
                        </div>
                        @if($this->post->is_pinned)
                            <x-mary-badge value="Pinned" class="badge-warning mt-2" />
                        @endif
                    </div>
                    
                    <div class="prose prose-lg max-w-none mb-4">
                        {!! nl2br(e($this->post->content)) !!}
                    </div>
                    
                    <div class="flex items-center text-sm text-base-content/60 space-x-4">
                        <span>By <strong>{{ $this->post->user->name ?? 'Anonymous' }}</strong></span>
                        <span>•</span>
                        <span>{{ $this->post->created_at->format('M d, Y \a\t g:i A') }}</span>
                        <span>•</span>
                        <span>{{ $this->post->comments_count }} {{ Str::plural('comment', $this->post->comments_count) }}</span>
                    </div>
                </div>
            </div>
        </x-mary-card>

        <!-- Comments Section -->
        <div class="mb-8">
            <h2 class="text-xl font-bold text-base-content mb-6">
                Comments ({{ $this->post->comments_count }})
            </h2>

            <!-- New Comment Form -->
            @auth
                <x-mary-card class="mb-6">
                    <form wire:submit="postComment">
                        <x-mary-textarea 
                            wire:model="newComment"
                            placeholder="Write a comment..."
                            rows="4"
                            class="w-full mb-4" />
                        <div class="flex justify-end">
                            <x-mary-button type="submit" class="btn-primary">
                                Post Comment
                            </x-mary-button>
                        </div>
                    </form>
                </x-mary-card>
            @else
                <x-mary-card class="mb-6">
                    <div class="text-center py-4">
                        <p class="text-base-content/60">
                            <a href="{{ route('login') }}" class="text-primary hover:text-primary-focus">Log in</a>
                            to join the discussion
                        </p>
                    </div>
                </x-mary-card>
            @endauth

            <!-- Comments List -->
            <div class="space-y-4">
                @forelse($this->comments as $comment)
                    @include('livewire.partials.comment', ['comment' => $comment, 'depth' => 0])
                @empty
                    <x-mary-card>
                        <div class="text-center py-8">
                            <x-mary-icon name="o-chat-bubble-left-ellipsis" class="w-12 h-12 text-base-content/20 mx-auto mb-4" />
                            <p class="text-base-content/60">No comments yet. Be the first to comment!</p>
                        </div>
                    </x-mary-card>
                @endforelse
            </div>
        </div>
    </div>
</section>