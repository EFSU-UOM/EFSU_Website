<?php

use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\DB;
use function Livewire\Volt\{state, computed, mount};

state([
    'first_name' => '',
    'last_name' => '',
    'email' => '',
    'phone' => '',
    'address' => '',
    'city' => '',
    'processing' => false,
]);

mount(function () {
    if (!auth()->check()) {
        return redirect('/login');
    }
    
    // Pre-fill with user data if available
    $user = auth()->user();
    $nameParts = $user->name ? explode(' ', trim($user->name), 2) : [];
    $this->first_name = $nameParts[0] ?? '';
    $this->last_name = $nameParts[1] ?? '';
    $this->email = $user->email;
});

$serviceChargeRate = function () {
    return config('payhere.service_charge_rate');
};

$cartItems = computed(function () {
    return Cart::with('merch')
               ->where('user_id', auth()->id())
               ->get()
               ->filter(fn ($item) => $item->merch)
               ->values();
});

$getSubtotal = function () {
    return $this->cartItems->sum(function ($item) {
        return $item->merch->price * $item->quantity;
    });
};

$getServiceCharge = function () {
    return $this->getSubtotal() * $this->serviceChargeRate();
};

$getTotalPrice = function () {
    return $this->getSubtotal() + $this->getServiceCharge();
};

$proceedToPayment = function () {
    $this->validate([
        'first_name' => 'required|string|max:255',
        'last_name' => 'required|string|max:255',
        'email' => 'required|email|max:255',
        'phone' => 'required|string|max:20',
        'address' => 'required|string',
        'city' => 'required|string|max:255',
    ]);
    
    if ($this->processing) {
        return;
    }
    
    if (auth()->user()->isBanned()) {
        session()->flash('error', 'Your account is banned.');
        return;
    }
    
    if ($this->cartItems->isEmpty()) {
        session()->flash('error', 'Your cart is empty!');
        return redirect('/cart');
    }
    
    if ($this->cartItems->contains(fn ($item) => !$item->merch->is_available)) {
        session()->flash('error', 'Some items in your cart are no longer available. Please remove them.');
        return redirect('/cart');
    }
    
    $this->processing = true;
    
    $order = DB::transaction(function () {
        $order = Order::create([
            'order_id' => Order::generateOrderId(),
            'user_id' => auth()->id(),
            'subtotal' => $this->getSubtotal(),
            'service_charge' => $this->getServiceCharge(),
            'total_amount' => $this->getTotalPrice(),
            'status' => 'pending',
            'currency' => 'LKR',
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'email' => $this->email,
            'phone' => $this->phone,
            'address' => $this->address,
            'city' => $this->city,
            'country' => 'Sri Lanka',
        ]);
        
        foreach ($this->cartItems as $cartItem) {
            OrderItem::create([
                'order_id' => $order->id,
                'merch_id' => $cartItem->merch_id,
                'quantity' => $cartItem->quantity,
                'unit_price' => $cartItem->merch->price,
                'total_price' => $cartItem->merch->price * $cartItem->quantity,
            ]);
        }
        
        return $order;
    });
    
    // Redirect to payment
    return redirect('/payment/' . $order->id);
};

?>

<div class="min-h-screen bg-base-200 py-8">
    <div class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8">
        <x-mary-header title="Checkout" subtitle="Review your order and provide shipping details">
            <x-slot:actions>
                <x-mary-button label="Back to Cart" class="btn-outline" link="{{ route('cart') }}" />
            </x-slot:actions>
        </x-mary-header>

        <!-- Flash Messages -->
        @if (session('success'))
            <x-mary-alert title="Success!" description="{{ session('success') }}" icon="o-check-circle" class="alert-success mb-6" />
        @endif
        @if (session('error'))
            <x-mary-alert title="Error!" description="{{ session('error') }}" icon="o-x-circle" class="alert-error mb-6" />
        @endif

        @if($this->cartItems->isEmpty())
            <!-- Empty Cart -->
            <div class="text-center py-16">
                <x-mary-icon name="o-shopping-cart" class="w-24 h-24 mx-auto text-base-content/30 mb-4" />
                <h3 class="text-xl font-semibold text-base-content mb-2">Your cart is empty</h3>
                <p class="text-base-content/60 mb-6">Add items to your cart before checking out</p>
                <x-mary-button label="Browse Merchandise" class="btn-primary" link="{{ route('store') }}" />
            </div>
        @else
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <!-- Shipping Form -->
                <div class="card bg-base-100 shadow-xl">
                    <div class="card-body">
                        <h2 class="card-title mb-4">Shipping Information</h2>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <x-mary-input wire:model="first_name" label="First Name" required />
                            <x-mary-input wire:model="last_name" label="Last Name" required />
                            <x-mary-input wire:model="email" label="Email" type="email" required />
                            <x-mary-input wire:model="phone" label="Phone" placeholder="07XXXXXXXX" required />
                            <div class="md:col-span-2">
                                <x-mary-textarea wire:model="address" label="Address" rows="3" required />
                            </div>
                            <x-mary-input wire:model="city" label="City" required />
                            <div class="flex items-center mt-6">
                                <span class="text-base-content/70">Country: Sri Lanka</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Order Summary -->
                <div class="card bg-base-100 shadow-xl">
                    <div class="card-body">
                        <h2 class="card-title mb-4">Order Summary</h2>
                        
                        <!-- Order Items -->
                        <div class="space-y-3 mb-6">
                            @foreach($this->cartItems as $item)
                                <div class="flex items-center gap-3 p-3 bg-base-200 rounded-lg">
                                    <div class="avatar">
                                        <div class="w-12 h-12 rounded">
                                            <img src="{{ $item->merch->image_url ? Storage::url($item->merch->image_url) : 'https://images.unsplash.com/photo-1521572163474-6864f9cf17ab' }}"
                                                 alt="{{ $item->merch->name }}" />
                                        </div>
                                    </div>
                                    <div class="flex-1">
                                        <h4 class="font-semibold text-sm">{{ $item->merch->name }}</h4>
                                        <p class="text-xs text-base-content/70">{{ $item->merch->category->label() }}</p>
                                    </div>
                                    <div class="text-right">
                                        <p class="text-sm">{{ $item->quantity }}x</p>
                                        <p class="font-semibold text-sm">LKR {{ number_format($item->merch->price * $item->quantity, 0) }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        
                        <!-- Price Breakdown -->
                        <div class="space-y-2 mb-6">
                            <div class="flex justify-between text-base-content/70">
                                <span>Subtotal ({{ $this->cartItems->sum('quantity') }} items)</span>
                                <span>LKR {{ number_format($this->getSubtotal(), 0) }}</span>
                            </div>
                            <div class="flex justify-between text-base-content/70">
                                <span>Shipping</span>
                                <span>Free</span>
                            </div>
                            <div class="flex justify-between text-base-content/70">
                                <span>Service Charge ({{ number_format($this->serviceChargeRate() * 100, 1) }}%)</span>
                                <span>LKR {{ number_format($this->getServiceCharge(), 0) }}</span>
                            </div>
                            <div class="divider"></div>
                            <div class="flex justify-between font-bold text-lg">
                                <span>Total</span>
                                <span class="text-primary">LKR {{ number_format($this->getTotalPrice(), 0) }}</span>
                            </div>
                        </div>
                        
                        <x-mary-button 
                            label="Proceed to Payment"
                            class="btn-primary w-full"
                            wire:click="proceedToPayment"
                            wire:loading.attr="disabled"
                            spinner="proceedToPayment"
                        />
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>