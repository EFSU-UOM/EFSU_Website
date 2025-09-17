<?php

use Livewire\Volt\Component;
use Livewire\WithFileUploads;
use App\Models\LostAndFound;
use App\Models\LostAndFoundComment;
use Illuminate\Support\Facades\Storage;

new class extends Component {
    use WithFileUploads;

    public LostAndFound $item;

    // Edit mode
    public $editMode = false;

    // Form fields
    public $type = '';
    public $title = '';
    public $description = '';
    public $location = '';
    public $contact_info = '';
    public $item_date = '';
    public $image = null;
    public $editingStatus = '';

    // Comment functionality
    public $newComment = '';
    public $replyingTo = null;
    public $replyContent = '';

    protected $rules = [
        'type' => 'required|in:lost,found',
        'title' => 'required|string|max:255',
        'description' => 'required|string',
        'location' => 'nullable|string|max:255',
        'contact_info' => 'nullable|string|max:255',
        'item_date' => 'nullable|date',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        'newComment' => 'required|string|max:1000',
        'replyContent' => 'required|string|max:1000',
    ];

    public function mount(LostAndFound $item)
    {
        $this->item = $item;
    }

    public function enableEdit()
    {
        if (!auth()->check() || $this->item->user_id !== auth()->id()) {
            abort(403);
        }

        $this->editMode = true;
        $this->type = $this->item->type;
        $this->title = $this->item->title;
        $this->description = $this->item->description;
        $this->location = $this->item->location;
        $this->contact_info = $this->item->contact_info;
        $this->item_date = $this->item->item_date ? $this->item->item_date->format('Y-m-d') : '';
        $this->editingStatus = $this->item->status;
    }

    public function cancelEdit()
    {
        $this->editMode = false;
        $this->image = null;
        $this->resetValidation();
    }

    public function updateItem()
    {
        if (!auth()->check() || $this->item->user_id !== auth()->id()) {
            abort(403);
        }

        $this->validate();

        $data = [
            'type' => $this->type,
            'title' => $this->title,
            'description' => $this->description,
            'location' => $this->location,
            'contact_info' => $this->contact_info,
            'item_date' => $this->item_date,
            'status' => $this->editingStatus,
        ];

        if ($this->image) {
            if ($this->item->image) {
                Storage::disk('public')->delete($this->item->image);
            }
            $data['image'] = $this->image->store('lost-and-found', 'public');
        }

        $this->item->update($data);
        $this->item->refresh();
        $this->editMode = false;
        $this->image = null;

        session()->flash('success', 'Item updated successfully!');
    }

    public function updateItemStatus($status)
    {
        if (!auth()->check() || $this->item->user_id !== auth()->id()) {
            abort(403);
        }

        $this->item->update(['status' => $status]);
        $this->item->refresh();

        session()->flash('success', 'Status updated successfully!');
    }

    public function deleteItem()
    {
        if (!auth()->check() || $this->item->user_id !== auth()->id()) {
            abort(403);
        }

        if ($this->item->image) {
            Storage::disk('public')->delete($this->item->image);
        }

        $this->item->delete();

        session()->flash('success', 'Item deleted successfully!');
        return redirect()->route('lost-and-found');
    }

    // Comment functionality
    public function getCommentsProperty()
    {
        return LostAndFoundComment::with(['user', 'replies.user'])
            ->where('lost_and_found_id', $this->item->id)
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

        LostAndFoundComment::create([
            'user_id' => auth()->id(),
            'lost_and_found_id' => $this->item->id,
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

        LostAndFoundComment::create([
            'user_id' => auth()->id(),
            'lost_and_found_id' => $this->item->id,
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

        $comment = LostAndFoundComment::findOrFail($commentId);
        $comment->upvote(auth()->user());
    }

    public function downvoteComment($commentId)
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $comment = LostAndFoundComment::findOrFail($commentId);
        $comment->downvote(auth()->user());
    }

    public function deleteComment($commentId)
    {
        $comment = LostAndFoundComment::findOrFail($commentId);
        
        if ($comment->user_id === auth()->id()) {
            $comment->delete();
            session()->flash('comment-success', 'Comment deleted successfully!');
        }
    }
}; ?>

<div>
    <!-- Page Header -->
    <section class="bg-base-100 py-8">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-4">
                    <a href="{{ route('lost-and-found') }}" class="btn btn-ghost btn-sm">
                        <x-mary-icon name="o-arrow-left" class="w-5 h-5" />
                        Back to Lost & Found
                    </a>
                </div>
                <h1 class="text-2xl font-bold text-base-content">{{ $item->title }}</h1>
            </div>
        </div>
    </section>

    <!-- Success Messages -->
    @if (session('success'))
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 mb-4">
            <x-mary-alert icon="o-check-circle" class="alert-success">
                {{ session('success') }}
            </x-mary-alert>
        </div>
    @endif

    <!-- Item Details -->
    <section class="py-8">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            @if ($editMode)
                <!-- Edit Form -->
                <x-mary-card class="max-w-4xl mx-auto">
                    <div class="space-y-6">
                        <h2 class="text-xl font-semibold text-base-content">Edit Item</h2>
                        
                        <form wire:submit.prevent="updateItem" class="space-y-6">
                            <!-- Item Type -->
                            <div>
                                <x-mary-radio wire:model="type" :options="[
                                    ['id' => 'lost', 'name' => 'Lost Item - I lost something'],
                                    ['id' => 'found', 'name' => 'Found Item - I found something'],
                                ]" option-value="id" option-label="name" />
                                @error('type')
                                    <span class="text-error text-sm">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Title -->
                            <x-mary-input wire:model="title" label="Item Title"
                                placeholder="e.g., Black iPhone 14 Pro, Blue Backpack, etc." />
                            @error('title')
                                <span class="text-error text-sm">{{ $message }}</span>
                            @enderror

                            <!-- Description -->
                            <x-mary-textarea wire:model="description" label="Description"
                                placeholder="Provide detailed description including color, brand, distinctive features, etc."
                                rows="4" />
                            @error('description')
                                <span class="text-error text-sm">{{ $message }}</span>
                            @enderror

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <!-- Location -->
                                <div>
                                    <x-mary-input wire:model="location" label="Location"
                                        placeholder="Library, Cafeteria, etc." />
                                    @error('location')
                                        <span class="text-error text-sm">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- Date -->
                                <div>
                                    <x-mary-input wire:model="item_date" label="Date" type="date" />
                                    @error('item_date')
                                        <span class="text-error text-sm">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <!-- Contact Info -->
                            <x-mary-input wire:model="contact_info" label="Contact Information (Optional)"
                                placeholder="Email, phone, or preferred contact method" />
                            @error('contact_info')
                                <span class="text-error text-sm">{{ $message }}</span>
                            @enderror

                            <!-- Status -->
                            <x-mary-select
                                wire:model="editingStatus"
                                label="Status"
                                :options="[
                                    ['name' => 'Active', 'id' => 'active'],
                                    $type === 'lost'
                                        ? ['name' => 'Owner Found', 'id' => 'owner_found']
                                        : ['name' => 'Item Obtained', 'id' => 'lost_item_obtained'],
                                ]"
                                option-label="name"
                                option-value="id"
                            />
                            @error('editingStatus')
                                <span class="text-error text-sm">{{ $message }}</span>
                            @enderror

                            <!-- Image Upload -->
                            <div>
                                <x-mary-file wire:model="image" label="Item Photo (Optional)" accept="image/*"
                                    crop-after-change>
                                    @if (!empty($item->image))
                                        <img src="{{ Storage::url($item->image) }}"
                                            class="h-32 w-32 object-cover rounded-lg">
                                    @endif
                                </x-mary-file>
                            </div>
                        </form>
                        
                        <div class="flex gap-3 pt-6">
                            <x-mary-button label="Cancel" wire:click="cancelEdit" />
                            <x-mary-button label="Update Item" wire:click="updateItem" class="btn-primary" />
                        </div>
                    </div>
                </x-mary-card>
            @else
                <!-- Item Display -->
                <x-mary-card class="max-w-6xl mx-auto">
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                        <!-- Image Section -->
                        <div>
                            @if ($item->image)
                                <div class="aspect-square bg-base-200 rounded-lg overflow-hidden">
                                    <img src="{{ Storage::url($item->image) }}" alt="{{ $item->title }}"
                                        class="w-full h-full object-contain">
                                </div>
                            @else
                                <div class="aspect-square bg-base-200 rounded-lg flex items-center justify-center">
                                    <div class="text-center">
                                        <x-mary-icon name="o-photo" class="w-16 h-16 text-base-content/40 mx-auto mb-2" />
                                        <p class="text-base-content/60">No image available</p>
                                    </div>
                                </div>
                            @endif
                        </div>

                        <!-- Details Section -->
                        <div class="space-y-6">
                            <!-- Type and Status Badges -->
                            <div class="flex gap-3">
                                <x-mary-badge :value="$item->type_label"
                                    class="{{ $item->type === 'lost' ? 'badge-error badge-lg' : 'badge-success badge-lg' }}" />
                                <x-mary-badge :value="$item->status_label"
                                    class="{{ $item->status === 'active' ? 'badge-primary badge-lg' : 'badge-secondary badge-lg' }}" />
                            </div>

                            <!-- User and Date Info -->
                            <div class="flex items-center space-x-4 text-base-content/60">
                                <div class="flex items-center">
                                    <x-mary-icon name="o-user" class="w-5 h-5 mr-2" />
                                    <span>{{ $item->user->name }}</span>
                                </div>
                                <div class="flex items-center">
                                    <x-mary-icon name="o-clock" class="w-5 h-5 mr-2" />
                                    <span>{{ $item->created_at->format('M d, Y') }}</span>
                                </div>
                            </div>

                            <!-- Description -->
                            <div>
                                <h3 class="text-lg font-semibold text-base-content mb-2">Description</h3>
                                <p class="text-base-content/80 leading-relaxed">{{ $item->description }}</p>
                            </div>

                            <!-- Additional Details -->
                            <div class="space-y-4">
                                @if ($item->location)
                                    <div class="flex items-start">
                                        <x-mary-icon name="o-map-pin" class="w-5 h-5 text-base-content/60 mr-3 mt-0.5" />
                                        <div>
                                            <p class="text-sm font-medium text-base-content/60">Location</p>
                                            <p class="text-base-content">{{ $item->location }}</p>
                                        </div>
                                    </div>
                                @endif

                                @if ($item->item_date)
                                    <div class="flex items-start">
                                        <x-mary-icon name="o-calendar-days"
                                            class="w-5 h-5 text-base-content/60 mr-3 mt-0.5" />
                                        <div>
                                            <p class="text-sm font-medium text-base-content/60">
                                                {{ $item->type === 'lost' ? 'Date Lost' : 'Date Found' }}
                                            </p>
                                            <p class="text-base-content">{{ $item->item_date->format('M d, Y') }}</p>
                                        </div>
                                    </div>
                                @endif

                                @if ($item->contact_info)
                                    <div class="flex items-start">
                                        <x-mary-icon name="o-phone" class="w-5 h-5 text-base-content/60 mr-3 mt-0.5" />
                                        <div>
                                            <p class="text-sm font-medium text-base-content/60">Contact Info</p>
                                            <p class="text-base-content">{{ $item->contact_info }}</p>
                                        </div>
                                    </div>
                                @endif
                            </div>

                            <!-- Action Buttons -->
                            <div class="space-y-4 pt-6">
                                @auth
                                    @if ($item->user_id === auth()->id())
                                        <!-- Owner Actions -->
                                        <div class="space-y-3">
                                            <div class="flex gap-3">
                                                <x-mary-button class="btn-secondary flex-1" wire:click="enableEdit">
                                                    <x-mary-icon name="o-pencil" class="w-5 h-5" />
                                                    Edit Post
                                                </x-mary-button>

                                                <x-mary-button class="btn-error flex-1" wire:click="deleteItem"
                                                    wire:confirm="Are you sure you want to delete this post?">
                                                    <x-mary-icon name="o-trash" class="w-5 h-5" />
                                                    Delete
                                                </x-mary-button>
                                            </div>

                                            @if ($item->status === 'active')
                                                <!-- Status Update -->
                                                <x-mary-card class="bg-base-200">
                                                    <h4 class="font-semibold text-base-content mb-3">Update Status</h4>
                                                    <div class="space-y-2">
                                                        @if ($item->type === 'lost')
                                                            <x-mary-button class="btn-success w-full"
                                                                wire:click="updateItemStatus('owner_found')">
                                                                <x-mary-icon name="o-check-circle" class="w-5 h-5" />
                                                                Mark as Found - Owner Located
                                                            </x-mary-button>
                                                        @else
                                                            <x-mary-button class="btn-success w-full"
                                                                wire:click="updateItemStatus('lost_item_obtained')">
                                                                <x-mary-icon name="o-check-circle" class="w-5 h-5" />
                                                                Mark as Returned - Item Claimed
                                                            </x-mary-button>
                                                        @endif
                                                    </div>
                                                </x-mary-card>
                                            @endif
                                        </div>
                                    @else
                                        <!-- Contact Owner -->
                                        <div class="text-center">
                                            <p class="text-base-content/70 mb-4">
                                                @if ($item->type === 'lost')
                                                    Have you found this item? Contact the owner to help them get it back.
                                                @else
                                                    Is this your item? Contact the finder to claim it.
                                                @endif
                                            </p>
                                            <x-mary-button class="btn-primary">
                                                <x-mary-icon name="o-envelope" class="w-5 h-5" />
                                                Contact {{ $item->user->name }}
                                            </x-mary-button>
                                            <p class="text-xs text-base-content/50 mt-2">
                                                Contact functionality will be available soon
                                            </p>
                                        </div>
                                    @endif
                                @else
                                    <!-- Guest Actions -->
                                    <div class="text-center">
                                        <p class="text-base-content/70 mb-4">
                                            <a href="{{ route('login') }}" class="link link-primary">Sign in</a>
                                            to contact the {{ $item->type === 'lost' ? 'owner' : 'finder' }}
                                        </p>
                                    </div>
                                @endauth
                            </div>
                        </div>
                    </div>
                </x-mary-card>
            @endif
        </div>
    </section>

    <!-- Comments Section -->
    <section class="py-8 bg-base-200">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="max-w-4xl mx-auto">
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
                        <div class="bg-base-100 rounded-lg p-4">
                            <div class="flex items-start space-x-3">
                                <div class="flex-shrink-0">
                                    <div class="w-8 h-8 bg-primary/10 rounded-full flex items-center justify-center">
                                        <x-mary-icon name="o-user" class="w-4 h-4 text-primary" />
                                    </div>
                                </div>
                                <div class="flex-1">
                                    <x-mary-textarea 
                                        wire:model="newComment" 
                                        placeholder="Add a comment about this lost/found item..." 
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
                        <div class="bg-base-100 rounded-lg p-4 text-center">
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
                                    Be the first to share your thoughts about this {{ $item->type }} item.
                                </p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>