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
    public $showComplaintModal = false;
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

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 sm:py-8 space-y-8" wire:loading.class="opacity-75 pointer-events-none transition-opacity duration-300">
    @auth
        <!-- Header -->
        <div class="p-6 sm:p-8">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-6">
                <div>
                    <h1 class="text-4xl font-bold text-base-content mb-2">Complaints Dashboard</h1>
                    <p class="text-base-content/70 text-lg">Submit new complaints and track existing ones</p>
                </div>
                <x-mary-button wire:click="openCreateForm" class="btn-primary shadow-lg hover:shadow-xl transition-all duration-300">
                    <x-mary-icon name="o-plus" class="w-5 h-5" />
                    Submit New Complaint
                </x-mary-button>
            </div>
        </div>
    @else
        <!-- Login Prompt Header -->
        <div class="text-center bg-gradient-to-r from-primary/5 to-secondary/5 rounded-2xl p-8">
            <h1 class="text-4xl font-bold text-base-content mb-2">Complaints Dashboard</h1>
            <p class="text-base-content/70 text-lg">Submit new complaints and track existing ones</p>
        </div>
    @endauth

    @auth
        <!-- Create Complaint Modal -->
        <x-mary-modal wire:model="showCreateForm" title="Submit a Complaint" class="backdrop-blur" box-class="max-w-2xl">
            <livewire:create-complaint-form />
            
            <x-slot:actions>
                <x-mary-button label="Close" wire:click="closeCreateForm" class="btn-outline hover:btn-primary transition-colors duration-200" />
            </x-slot:actions>
        </x-mary-modal>

        <!-- Filters -->
        <x-mary-card class="shadow-lg border-0 bg-base-100">
            <div class="p-2">
                <h3 class="text-lg font-semibold text-base-content mb-4 flex items-center gap-2">
                    <x-mary-icon name="o-funnel" class="w-5 h-5 text-primary" />
                    Filter & Search
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="relative">
                        <x-mary-input 
                            wire:model.live.debounce.300ms="search" 
                            placeholder="Search complaints..." 
                            icon="o-magnifying-glass" 
                            class="input-bordered"
                        />
                    </div>
                    
                    <div class="relative">
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
                            class="select-bordered"
                        />
                    </div>

                    <x-mary-button wire:click="clearFilters" class="btn-outline hover:btn-primary transition-colors duration-200">
                        <x-mary-icon name="o-x-mark" class="w-4 h-4" />
                        Clear Filters
                    </x-mary-button>
                </div>
            </div>
        </x-mary-card>

    <!-- Complaints List -->
    @if($this->complaints->count() > 0)
        <div class="space-y-4">
            @foreach($this->complaints as $complaint)
                <x-mary-card class="border-0 shadow-md hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 bg-base-100">
                    <div class="flex flex-col lg:flex-row lg:items-start gap-6 p-2">
                        <!-- Main Content -->
                        <div class="flex-1 space-y-3">
                            <!-- Header with Category and Status -->
                            <div class="flex flex-wrap items-center justify-between gap-3">
                                <div class="flex items-center gap-2">
                                    <x-mary-badge :value="ucwords(str_replace('_', ' ', $complaint->category))" class="badge-primary badge-outline font-medium" />
                                    @if($complaint->is_anonymous)
                                        <x-mary-badge value="Anonymous" class="badge-ghost font-medium" />
                                    @endif
                                </div>
                                <div class="flex items-center gap-2">
                                    @php
                                        $statusConfig = [
                                            'delivered' => ['icon' => 'o-paper-airplane', 'class' => 'badge-info'],
                                            'viewed' => ['icon' => 'o-eye', 'class' => 'badge-secondary'],
                                            'in_progress' => ['icon' => 'o-clock', 'class' => 'badge-warning'],
                                            'action_taken' => ['icon' => 'o-check-circle', 'class' => 'badge-success'],
                                            'rejected' => ['icon' => 'o-x-circle', 'class' => 'badge-error'],
                                            'incomplete' => ['icon' => 'o-exclamation-triangle', 'class' => 'badge-warning']
                                        ];
                                        $config = $statusConfig[$complaint->status] ?? ['icon' => 'o-question-mark-circle', 'class' => 'badge-ghost'];
                                    @endphp
                                    <x-mary-icon name="{{ $config['icon'] }}" class="w-4 h-4 text-base-content/60" />
                                    <x-mary-badge 
                                        :value="$complaint->formatted_status" 
                                        class="{{ $config['class'] }} font-medium"
                                    />
                                </div>
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
                            <div class="flex items-center justify-between pt-4 border-t border-base-200">
                                <div class="flex flex-wrap items-center gap-4 text-sm text-base-content/70">
                                    <span class="flex items-center gap-1">
                                        <x-mary-icon name="o-clock" class="w-4 h-4" />
                                        {{ $complaint->created_at->diffForHumans() }}
                                    </span>
                                    @if($complaint->topLevelReplies->count() > 0)
                                        <span class="flex items-center gap-1">
                                            <x-mary-icon name="o-chat-bubble-left" class="w-4 h-4 text-primary" />
                                            {{ $complaint->topLevelReplies->count() }} {{ Str::plural('reply', $complaint->topLevelReplies->count()) }}
                                        </span>
                                    @endif
                                    <span class="flex items-center gap-1">
                                        <x-mary-icon name="o-hashtag" class="w-4 h-4" />
                                        {{ $complaint->id }}
                                    </span>
                                </div>
                                <div class="flex items-center gap-2">
                                    <x-mary-button 
                                        wire:click="viewComplaint({{ $complaint->id }})" 
                                        class="btn-primary btn-sm shadow-sm hover:shadow-md transition-all duration-200">
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
        <div class="mt-8 flex justify-center">
            <div class="bg-base-100 rounded-xl shadow-lg p-4">
                {{ $this->complaints->links() }}
            </div>
        </div>
    @else
        <!-- Empty State -->
        <x-mary-card class="text-center py-16 shadow-lg border-0 bg-gradient-to-br from-base-100 to-base-200">
            <div class="space-y-6">
                <div class="relative">
                    <x-mary-icon name="o-inbox" class="w-20 h-20 text-base-content/30 mx-auto" />
                    <div class="absolute -top-2 -right-2 w-8 h-8 bg-primary/20 rounded-full animate-pulse"></div>
                </div>
                <div>
                    <h3 class="text-2xl font-bold text-base-content mb-2">No complaints found</h3>
                    <p class="text-base-content/70 text-lg max-w-md mx-auto">
                        @if($search || $selectedStatus)
                            No complaints match your current filters. Try adjusting your search criteria.
                        @else
                            You haven't submitted any complaints yet. Get started by creating your first complaint.
                        @endif
                    </p>
                </div>
                @if($search || $selectedStatus)
                    <x-mary-button wire:click="clearFilters" class="btn-outline btn-lg hover:btn-primary transition-all duration-300">
                        <x-mary-icon name="o-arrow-path" class="w-5 h-5" />
                        Clear Filters
                    </x-mary-button>
                @else
                    <x-mary-button wire:click="openCreateForm" class="btn-primary btn-lg shadow-lg hover:shadow-xl transition-all duration-300">
                        <x-mary-icon name="o-plus" class="w-5 h-5" />
                        Submit Your First Complaint
                    </x-mary-button>
                @endif
            </div>
        </x-mary-card>
    @endif
    @else
        <!-- Login Prompt for Guests -->
        <x-mary-card class="text-center py-16 shadow-lg border-0 bg-gradient-to-br from-primary/5 to-secondary/5">
            <div class="space-y-8">
                <div class="relative">
                    <x-mary-icon name="o-lock-closed" class="w-20 h-20 text-primary mx-auto" />
                    <div class="absolute -top-2 -right-2 w-6 h-6 bg-primary rounded-full flex items-center justify-center">
                        <x-mary-icon name="o-key" class="w-3 h-3 text-white" />
                    </div>
                </div>
                <div>
                    <h3 class="text-3xl font-bold text-base-content mb-3">Access Required</h3>
                    <p class="text-base-content/70 text-xl max-w-lg mx-auto">
                        Please log in to submit and track your complaints with our secure portal.
                    </p>
                </div>
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <x-mary-button link="{{ route('login') }}" class="btn-primary btn-lg shadow-lg hover:shadow-xl transition-all duration-300">
                        <x-mary-icon name="o-arrow-right-on-rectangle" class="w-5 h-5" />
                        Login to Continue
                    </x-mary-button>
                    <x-mary-button link="{{ route('register') }}" class="btn-outline btn-lg hover:btn-primary transition-all duration-300">
                        <x-mary-icon name="o-user-plus" class="w-5 h-5" />
                        Create Account
                    </x-mary-button>
                </div>
            </div>
        </x-mary-card>
    @endauth

    <!-- Complaint Detail Modal -->
    <x-mary-modal wire:model="showComplaintModal" title="{{ $viewingComplaint ? 'Complaint Details #' . $viewingComplaint->id : '' }}" class="backdrop-blur-md" box-class="max-w-5xl shadow-2xl border-0">
        @if($viewingComplaint)
            <div class="space-y-6">
                <!-- Complaint Header -->
                <div class="bg-gradient-to-r from-primary/5 to-secondary/5 rounded-xl p-6 mb-6">
                    <div class="flex flex-wrap items-center justify-between gap-3">
                        <div class="flex items-center gap-3">
                            <x-mary-badge :value="ucwords(str_replace('_', ' ', $viewingComplaint->category))" class="badge-primary badge-outline font-medium text-sm" />
                            @if($viewingComplaint->is_anonymous)
                                <x-mary-badge value="Anonymous" class="badge-ghost font-medium" />
                            @endif
                        </div>
                        <div class="flex items-center gap-2">
                            @php
                                $statusConfig = [
                                    'delivered' => ['icon' => 'o-paper-airplane', 'class' => 'badge-info'],
                                    'viewed' => ['icon' => 'o-eye', 'class' => 'badge-secondary'],
                                    'in_progress' => ['icon' => 'o-clock', 'class' => 'badge-warning'],
                                    'action_taken' => ['icon' => 'o-check-circle', 'class' => 'badge-success'],
                                    'rejected' => ['icon' => 'o-x-circle', 'class' => 'badge-error'],
                                    'incomplete' => ['icon' => 'o-exclamation-triangle', 'class' => 'badge-warning']
                                ];
                                $config = $statusConfig[$viewingComplaint->status] ?? ['icon' => 'o-question-mark-circle', 'class' => 'badge-ghost'];
                            @endphp
                            <x-mary-icon name="{{ $config['icon'] }}" class="w-5 h-5 text-base-content/60" />
                            <x-mary-badge 
                                :value="$viewingComplaint->formatted_status" 
                                class="{{ $config['class'] }} font-medium text-sm"
                            />
                        </div>
                    </div>
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
                <div class="bg-base-200/50 rounded-xl p-4 mt-6">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div class="flex items-center gap-3">
                            <x-mary-icon name="o-calendar" class="w-5 h-5 text-primary" />
                            <div>
                                <label class="font-semibold text-sm text-base-content/70">Submitted</label>
                                <div class="text-sm font-medium">{{ $viewingComplaint->created_at->format('M d, Y H:i') }}</div>
                            </div>
                        </div>
                        <div class="flex items-center gap-3">
                            <x-mary-icon name="o-clock" class="w-5 h-5 text-secondary" />
                            <div>
                                <label class="font-semibold text-sm text-base-content/70">Last Updated</label>
                                <div class="text-sm font-medium">{{ $viewingComplaint->updated_at->format('M d, Y H:i') }}</div>
                            </div>
                        </div>
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
                        <div class="bg-gradient-to-r from-primary/5 to-secondary/5 p-6 rounded-xl mb-6 border border-primary/20">
                            <form wire:submit="postReply" class="space-y-4">
                                <div class="flex items-center gap-2 mb-3">
                                    <x-mary-icon name="o-pencil" class="w-5 h-5 text-primary" />
                                    <h4 class="font-semibold text-base-content">Add Your Reply</h4>
                                </div>
                                <x-mary-textarea 
                                    wire:model="replyContent"
                                    placeholder="Write your reply..."
                                    rows="4"
                                    class="w-full textarea-bordered" />
                                @error('replyContent')
                                    <span class="text-error text-sm flex items-center gap-1">
                                        <x-mary-icon name="o-exclamation-circle" class="w-4 h-4" />
                                        {{ $message }}
                                    </span>
                                @enderror
                                <div class="flex justify-end space-x-3">
                                    <x-mary-button wire:click="cancelReply" class="btn-outline hover:btn-error transition-colors duration-200">
                                        <x-mary-icon name="o-x-mark" class="w-4 h-4" />
                                        Cancel
                                    </x-mary-button>
                                    <x-mary-button type="submit" class="btn-primary shadow-lg hover:shadow-xl transition-all duration-200">
                                        <x-mary-icon name="o-paper-airplane" class="w-4 h-4" />
                                        Post Reply
                                    </x-mary-button>
                                </div>
                            </form>
                        </div>
                    @else
                        <div class="mb-6">
                            <x-mary-button wire:click="setReplyingTo({{ $viewingComplaint->id }})" class="btn-primary shadow-md hover:shadow-lg transition-all duration-200">
                                <x-mary-icon name="o-chat-bubble-left" class="w-4 h-4" />
                                Add Reply
                            </x-mary-button>
                        </div>
                    @endif

                    <!-- Replies List -->
                    <div class="space-y-4 max-h-96 overflow-y-auto custom-scrollbar">
                        @forelse($viewingComplaint->topLevelReplies as $reply)
                            @include('livewire.partials.complaint-reply', ['reply' => $reply, 'depth' => 0])
                        @empty
                            <div class="text-center py-12 bg-base-200/30 rounded-xl">
                                <div class="relative">
                                    <x-mary-icon name="o-chat-bubble-left" class="w-12 h-12 mx-auto mb-3 text-base-content/30" />
                                    <div class="absolute -top-1 -right-1 w-4 h-4 bg-primary/20 rounded-full animate-pulse"></div>
                                </div>
                                <p class="text-base-content/60 font-medium">No replies yet</p>
                                <p class="text-base-content/40 text-sm mt-1">Be the first to respond and start the conversation!</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>

            </div>
        @endif

        <x-slot:actions>
            <x-mary-button label="Close" wire:click="closeComplaintView" class="btn-outline hover:btn-primary transition-colors duration-200" />
        </x-slot:actions>
    </x-mary-modal>
</div>