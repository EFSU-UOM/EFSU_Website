<?php

use App\Models\Complaint;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Livewire\Volt\Component;
use Livewire\WithPagination;

new class extends Component {
    use WithPagination;

    public $selectedStatus = '';
    public $search = '';
    public $showCreateForm = false;
    public $viewingComplaint = null;
    public $replyingTo = null;
    public $replyContent = '';
    public $expandedReplies = [];

    public function mount()
    {
        $this->search = request('search', '');
        $this->selectedStatus = request('status', '');
    }

    public function getComplaintsProperty()
    {
        $query = Complaint::with(['topLevelReplies'])
            ->where('user_id', Auth::id())
            ->orderBy('created_at', 'desc');

        if (!empty($this->search)) {
            $query->where(function ($q) {
                $q->where('category', 'like', "%{$this->search}%")
                    ->orWhere('complaint_text', 'like', "%{$this->search}%");
            });
        }

        if (!empty($this->selectedStatus)) {
            $query->where('status', $this->selectedStatus);
        }

        return $query->paginate(10);
    }

    public function openCreateForm()
    {
        $this->showCreateForm = true;
    }

    public function closeCreateForm()
    {
        $this->showCreateForm = false;
    }

    protected $listeners = ['complaint-submitted' => 'handleComplaintSubmitted'];

    public function handleComplaintSubmitted()
    {
        $this->showCreateForm = false;
        $this->resetPage(); // Refresh the complaints list
    }

    public function clearFilters()
    {
        $this->reset(['search', 'selectedStatus']);
        $this->resetPage();
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingSelectedStatus()
    {
        $this->resetPage();
    }

    public function viewComplaint($complaintId)
    {
        $this->viewingComplaint = Complaint::with(['topLevelReplies'])->findOrFail($complaintId);
        $this->showComplaintModal = true;
    }

    public function closeComplaintView()
    {
        $this->showComplaintModal = false;
        $this->viewingComplaint = null;
        $this->replyingTo = null;
        $this->replyContent = '';
        $this->expandedReplies = [];
        $this->resetValidation();
    }

    public function postReply($parentId = null)
    {
        if (!auth()->check()) {
            return;
        }

        if (empty(trim($this->replyContent))) {
            return;
        }

        // Find the complaint ID from parent reply or use replyingTo as complaint ID
        if ($parentId) {
            $parentReply = \App\Models\ComplaintReply::findOrFail($parentId);
            $complaintId = $parentReply->complaint_id;
        } else {
            $complaintId = $this->replyingTo;
            $parentId = null;
        }

        \App\Models\ComplaintReply::create([
            'complaint_id' => $complaintId,
            'user_id' => auth()->id(),
            'parent_id' => $parentId,
            'content' => $this->replyContent,
        ]);

        $this->replyContent = '';
        $this->replyingTo = null;
        
        // Refresh the viewing complaint
        if ($this->viewingComplaint) {
            $this->viewingComplaint = Complaint::with(['topLevelReplies'])->findOrFail($this->viewingComplaint->id);
        }
    }

    public function setReplyingTo($id)
    {
        $this->replyingTo = $id;
        $this->replyContent = '';
    }

    public function cancelReply()
    {
        $this->replyingTo = null;
        $this->replyContent = '';
    }

    public function toggleReplies($replyId)
    {
        if (in_array($replyId, $this->expandedReplies)) {
            $this->expandedReplies = array_values(array_diff($this->expandedReplies, [$replyId]));
        } else {
            $this->expandedReplies[] = $replyId;
        }
    }

    public function deleteReply($replyId)
    {
        if (!auth()->check()) {
            return;
        }
        
        $reply = \App\Models\ComplaintReply::findOrFail($replyId);
        
        // Check if user is admin or reply owner
        if (!auth()->user()->isAdmin() && $reply->user_id !== auth()->id()) {
            return;
        }
        
        $reply->delete();
        
        // Refresh the viewing complaint
        if ($this->viewingComplaint) {
            $this->viewingComplaint = Complaint::with(['topLevelReplies'])->findOrFail($this->viewingComplaint->id);
        }
    }
};
?>

<div class="max-w-7xl mx-auto px-4 py-8 space-y-6">
    @auth
        <!-- Header -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-3xl font-bold text-base-content">Complaints</h1>
                <p class="text-base-content/70 mt-1">Submit new complaints and track existing ones</p>
            </div>
            <x-mary-button wire:click="openCreateForm" class="btn-primary">
                <x-mary-icon name="o-plus" class="w-5 h-5" />
                Submit New Complaint
            </x-mary-button>
        </div>
    @else
        <!-- Login Prompt Header -->
        <div class="text-center">
            <h1 class="text-3xl font-bold text-base-content">Complaints</h1>
            <p class="text-base-content/70 mt-1">Submit new complaints and track existing ones</p>
        </div>
    @endauth

    @auth
        <!-- Create Complaint Modal -->
        <x-mary-modal wire:model="showCreateForm" title="Submit a Complaint" class="backdrop-blur" box-class="max-w-2xl">
            <livewire:create-complaint-form />
            
            <x-slot:actions>
                <x-mary-button label="Close" wire:click="closeCreateForm" />
            </x-slot:actions>
        </x-mary-modal>

        <!-- Filters -->
        <x-mary-card>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <x-mary-input 
                wire:model.live.debounce.300ms="search" 
                placeholder="Search complaints..." 
                icon="o-magnifying-glass" 
            />
            
            <x-mary-select 
                wire:model.live="selectedStatus" 
                placeholder="Filter by status"
                :options="[
                    ['name' => 'Delivered', 'id' => 'delivered'],
                    ['name' => 'Viewed', 'id' => 'viewed'],
                    ['name' => 'In Progress', 'id' => 'in_progress'],
                    ['name' => 'Action Taken', 'id' => 'action_taken'],
                    ['name' => 'Rejected', 'id' => 'rejected'],
                    ['name' => 'Incomplete', 'id' => 'incomplete'],
                ]"
            />

            <x-mary-button wire:click="clearFilters" class="btn-ghost">
                Clear Filters
            </x-mary-button>
        </div>
    </x-mary-card>

    <!-- Complaints List -->
    @if($this->complaints->count() > 0)
        <div class="space-y-4">
            @foreach($this->complaints as $complaint)
                <x-mary-card class="hover:shadow-lg transition-shadow">
                    <div class="flex flex-col lg:flex-row lg:items-start gap-4">
                        <!-- Main Content -->
                        <div class="flex-1 space-y-3">
                            <!-- Header with Category and Status -->
                            <div class="flex flex-wrap items-center justify-between gap-2">
                                <div class="flex items-center gap-2">
                                    <x-mary-badge :value="ucwords(str_replace('_', ' ', $complaint->category))" class="badge-outline" />
                                    @if($complaint->is_anonymous)
                                        <x-mary-badge value="Anonymous" class="badge-ghost" />
                                    @endif
                                </div>
                                <x-mary-badge 
                                    :value="$complaint->formatted_status" 
                                    class="badge-{{ $complaint->status_badge_color }}"
                                />
                            </div>

                            <!-- Complaint Text -->
                            <div class="prose max-w-none">
                                <p class="text-base-content/90 leading-relaxed">
                                    {{ $complaint->complaint_text }}
                                </p>
                            </div>

                            <!-- Images -->
                            @if($complaint->images && count($complaint->images) > 0)
                                <div class="flex gap-2 flex-wrap">
                                    @foreach($complaint->images as $image)
                                        <div class="w-20 h-20 rounded-lg overflow-hidden bg-base-200">
                                            <img 
                                                src="{{ Storage::url($image) }}" 
                                                alt="Complaint image" 
                                                class="w-full h-full object-cover cursor-pointer hover:opacity-75 transition-opacity"
                                                onclick="document.getElementById('modal_{{ $loop->parent->index }}_{{ $loop->index }}').showModal()"
                                            >
                                        </div>
                                        
                                        <!-- Image Modal -->
                                        <dialog id="modal_{{ $loop->parent->index }}_{{ $loop->index }}" class="modal">
                                            <div class="modal-box max-w-4xl">
                                                <img src="{{ Storage::url($image) }}" alt="Complaint image" class="w-full">
                                            </div>
                                            <form method="dialog" class="modal-backdrop">
                                                <button>close</button>
                                            </form>
                                        </dialog>
                                    @endforeach
                                </div>
                            @endif

                            <!-- Actions and Metadata -->
                            <div class="flex items-center justify-between pt-3 border-t border-base-300">
                                <div class="flex items-center gap-4 text-sm text-base-content/60">
                                    <span>Submitted {{ $complaint->created_at->diffForHumans() }}</span>
                                    @if($complaint->topLevelReplies->count() > 0)
                                        <span class="flex items-center gap-1">
                                            <x-mary-icon name="o-chat-bubble-left" class="w-4 h-4" />
                                            {{ $complaint->topLevelReplies->count() }} {{ Str::plural('reply', $complaint->topLevelReplies->count()) }}
                                        </span>
                                    @endif
                                    <span>ID: #{{ $complaint->id }}</span>
                                </div>
                                <div class="flex items-center gap-2">
                                    <x-mary-button 
                                        wire:click="viewComplaint({{ $complaint->id }})" 
                                        class="btn-ghost btn-sm">
                                        <x-mary-icon name="o-eye" class="w-4 h-4" />
                                        View Details
                                    </x-mary-button>
                                </div>
                            </div>
                        </div>
                    </div>
                </x-mary-card>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="mt-6">
            {{ $this->complaints->links() }}
        </div>
    @else
        <!-- Empty State -->
        <x-mary-card class="text-center py-12">
            <div class="space-y-4">
                <x-mary-icon name="o-inbox" class="w-16 h-16 text-base-content/40 mx-auto" />
                <div>
                    <h3 class="text-xl font-semibold text-base-content">No complaints found</h3>
                    <p class="text-base-content/70 mt-1">
                        @if($search || $selectedStatus)
                            No complaints match your current filters.
                        @else
                            You haven't submitted any complaints yet.
                        @endif
                    </p>
                </div>
                @if($search || $selectedStatus)
                    <x-mary-button wire:click="clearFilters" class="btn-ghost">
                        Clear Filters
                    </x-mary-button>
                @else
                    <x-mary-button wire:click="openCreateForm" class="btn-primary">
                        Submit Your First Complaint
                    </x-mary-button>
                @endif
            </div>
        </x-mary-card>
    @endif
    @else
        <!-- Login Prompt for Guests -->
        <x-mary-card class="text-center py-12">
            <div class="space-y-6">
                <x-mary-icon name="o-lock-closed" class="w-16 h-16 text-primary mx-auto" />
                <div>
                    <h3 class="text-2xl font-semibold text-base-content mb-2">Login Required</h3>
                    <p class="text-base-content/70 text-lg">
                        You need to be logged in to submit and view complaints.
                    </p>
                </div>
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <x-mary-button link="{{ route('login') }}" class="btn-primary">
                        <x-mary-icon name="o-arrow-right-on-rectangle" class="w-5 h-5" />
                        Login to Continue
                    </x-mary-button>
                    <x-mary-button link="{{ route('register') }}" class="btn-outline">
                        Don't have an account? Register
                    </x-mary-button>
                </div>
            </div>
        </x-mary-card>
    @endauth

    <!-- Complaint Detail Modal -->
    <x-mary-modal wire:model="showComplaintModal" title="{{ $viewingComplaint ? 'Complaint Details #' . $viewingComplaint->id : '' }}" class="backdrop-blur" box-class="max-w-4xl">
        @if($viewingComplaint)
            <div class="space-y-6">
                <!-- Complaint Header -->
                <div class="flex flex-wrap items-center justify-between gap-2">
                    <div class="flex items-center gap-2">
                        <x-mary-badge :value="ucwords(str_replace('_', ' ', $viewingComplaint->category))" class="badge-outline" />
                        @if($viewingComplaint->is_anonymous)
                            <x-mary-badge value="Anonymous" class="badge-ghost" />
                        @endif
                    </div>
                    <x-mary-badge 
                        :value="$viewingComplaint->formatted_status" 
                        class="badge-{{ $viewingComplaint->status_badge_color }}"
                    />
                </div>

                <!-- Complaint Content -->
                <div class="prose max-w-none">
                    <p class="text-base-content/90 leading-relaxed">
                        {{ $viewingComplaint->complaint_text }}
                    </p>
                </div>

                <!-- Images -->
                @if($viewingComplaint->images && count($viewingComplaint->images) > 0)
                    <div>
                        <label class="font-semibold text-sm opacity-70 block mb-2">Attachments</label>
                        <div class="grid grid-cols-3 gap-2">
                            @foreach($viewingComplaint->images as $image)
                                <div class="aspect-square rounded-lg overflow-hidden bg-base-200">
                                    <img 
                                        src="{{ Storage::url($image) }}" 
                                        alt="Complaint image" 
                                        class="w-full h-full object-cover cursor-pointer hover:opacity-75 transition-opacity"
                                        onclick="imageModal{{ $viewingComplaint->id }}_{{ $loop->index }}.showModal()"
                                    >
                                </div>

                                <!-- Image Modal -->
                                <dialog id="imageModal{{ $viewingComplaint->id }}_{{ $loop->index }}" class="modal">
                                    <div class="modal-box max-w-4xl">
                                        <img src="{{ Storage::url($image) }}" alt="Complaint image" class="w-full">
                                    </div>
                                    <form method="dialog" class="modal-backdrop">
                                        <button>close</button>
                                    </form>
                                </dialog>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- Metadata -->
                <div class="grid grid-cols-2 gap-4 pt-4 border-t">
                    <div>
                        <label class="font-semibold text-sm opacity-70">Submitted</label>
                        <div class="text-sm">{{ $viewingComplaint->created_at->format('M d, Y H:i') }}</div>
                    </div>
                    <div>
                        <label class="font-semibold text-sm opacity-70">Last Updated</label>
                        <div class="text-sm">{{ $viewingComplaint->updated_at->format('M d, Y H:i') }}</div>
                    </div>
                </div>

                <!-- Replies Section -->
                <div class="border-t pt-4">
                    <!-- Success/Error Messages -->
                    @if (session('reply-success'))
                        <x-mary-alert icon="o-check-circle" class="alert-success mb-4">
                            {{ session('reply-success') }}
                        </x-mary-alert>
                    @endif

                    @if (session('error'))
                        <x-mary-alert icon="o-x-circle" class="alert-error mb-4">
                            {{ session('error') }}
                        </x-mary-alert>
                    @endif

                    <div class="flex items-center justify-between mb-4">
                        <label class="font-semibold text-sm opacity-70">
                            Replies ({{ $viewingComplaint->topLevelReplies->count() }})
                        </label>
                    </div>

                    <!-- New Reply Form -->
                    @if($replyingTo === $viewingComplaint->id)
                        <div class="bg-base-200 p-4 rounded-lg mb-4">
                            <form wire:submit="postReply">
                                <x-mary-textarea 
                                    wire:model="replyContent"
                                    placeholder="Write your reply..."
                                    rows="3"
                                    class="w-full mb-3" />
                                @error('replyContent')
                                    <span class="text-error text-sm mb-2 block">{{ $message }}</span>
                                @enderror
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
                    @else
                        <div class="mb-4">
                            <x-mary-button wire:click="setReplyingTo({{ $viewingComplaint->id }})" class="btn-primary btn-sm">
                                <x-mary-icon name="o-chat-bubble-left" class="w-4 h-4" />
                                Add Reply
                            </x-mary-button>
                        </div>
                    @endif

                    <!-- Replies List -->
                    <div class="space-y-3 max-h-96 overflow-y-auto">
                        @forelse($viewingComplaint->topLevelReplies as $reply)
                            @include('livewire.partials.complaint-reply', ['reply' => $reply, 'depth' => 0])
                        @empty
                            <div class="text-center py-4 text-base-content/60">
                                <x-mary-icon name="o-chat-bubble-left" class="w-8 h-8 mx-auto mb-2 opacity-40" />
                                <p class="text-sm">No replies yet. Be the first to respond!</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>

            </div>
        @endif

        <x-slot:actions>
            <x-mary-button label="Close" wire:click="closeComplaintView" />
        </x-slot:actions>
    </x-mary-modal>
</div>