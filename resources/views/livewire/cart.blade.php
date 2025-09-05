<?php

use App\Models\Cart;
use App\Models\Merch;
use function Livewire\Volt\{state, computed};

$serviceChargeRate = function () {
    return 0.033;
};

$cartItems = computed(function () {
    if (!auth()->check()) {
        return collect();
    }
    
    return Cart::with('merch')
               ->where('user_id', auth()->id())
               ->get();
});

$updateQuantity = function ($cartId, $quantity) {
    if ($quantity <= 0) {
        Cart::find($cartId)->delete();
        session()->flash('success', 'Item removed from cart!');
    } else {
        Cart::find($cartId)->update(['quantity' => $quantity]);
        session()->flash('success', 'Quantity updated!');
    }
};

$removeItem = function ($cartId) {
    Cart::find($cartId)->delete();
    session()->flash('success', 'Item removed from cart!');
};

$clearCart = function () {
    Cart::where('user_id', auth()->id())->delete();
    session()->flash('success', 'Cart cleared!');
};

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

?>

<div class="min-h-screen bg-base-200 py-8">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <x-mary-header title="Shopping Cart" subtitle="Review your selected merchandise">
            <x-slot:actions>
                @if(!$this->cartItems->isEmpty())
                    <x-mary-button label="Clear Cart" class="btn-outline btn-error" wire:click="clearCart" />
                @endif
                <x-mary-button label="Continue Shopping" class="btn-outline" link="{{ route('store') }}" />
            </x-slot:actions>
        </x-mary-header>

        <!-- Flash Messages -->
        @if (session('success'))
            <x-mary-alert title="Success!" description="{{ session('success') }}" icon="o-check-circle" class="alert-success mb-6" />
        @endif

        @auth
            @if($this->cartItems->isEmpty())
                <!-- Empty Cart -->
                <div class="text-center py-16">
                    <x-mary-icon name="o-shopping-cart" class="w-24 h-24 mx-auto text-base-content/30 mb-4" />
                    <h3 class="text-xl font-semibold text-base-content mb-2">Your cart is empty</h3>
                    <p class="text-base-content/60 mb-6">Start shopping to add items to your cart</p>
                    <x-mary-button label="Browse Merchandise" class="btn-primary" link="{{ route('store') }}" />
                </div>
            @else
                <!-- Cart Items -->
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    <!-- Cart Items List -->
                    <div class="lg:col-span-2">
                        <div class="card bg-base-100 shadow-xl">
                            <div class="card-body">
                                <h2 class="card-title mb-4">Cart Items</h2>
                                <div class="space-y-4">
                                    @foreach($this->cartItems as $item)
                                        <div class="flex items-center gap-4 p-4 border border-base-300 rounded-lg">
                                            <div class="avatar">
                                                <div class="w-16 h-16 rounded">
                                                    <img src="{{ $item->merch->image_url ?: 'https://images.unsplash.com/photo-1521572163474-6864f9cf17ab?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80' }}" 
                                                         alt="{{ $item->merch->name }}" />
                                                </div>
                                            </div>
                                            
                                            <div class="flex-1">
                                                <h3 class="font-semibold text-base-content">{{ $item->merch->name }}</h3>
                                                <p class="text-sm text-base-content/70">{{ $item->merch->category->label() }}</p>
                                                <p class="text-sm text-primary font-semibold">LKR {{ number_format($item->merch->price, 0) }}</p>
                                            </div>
                                            
                                            <div class="flex items-center gap-2">
                                                <x-mary-button 
                                                    icon="o-minus" 
                                                    class="btn-sm btn-outline"
                                                    wire:click="updateQuantity({{ $item->id }}, {{ $item->quantity - 1 }})"
                                                />
                                                <span class="w-8 text-center font-semibold">{{ $item->quantity }}</span>
                                                <x-mary-button 
                                                    icon="o-plus" 
                                                    class="btn-sm btn-outline"
                                                    wire:click="updateQuantity({{ $item->id }}, {{ $item->quantity + 1 }})"
                                                />
                                            </div>
                                            
                                            <div class="text-right">
                                                <p class="font-semibold text-base-content">
                                                    LKR {{ number_format($item->merch->price * $item->quantity, 0) }}
                                                </p>
                                                <x-mary-button 
                                                    icon="o-trash" 
                                                    class="btn-sm btn-ghost text-error mt-1"
                                                    wire:click="removeItem({{ $item->id }})"
                                                />
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Cart Summary -->
                    <div class="lg:col-span-1">
                        <div class="card bg-base-100 shadow-xl">
                            <div class="card-body">
                                <h2 class="card-title mb-4">Order Summary</h2>
                                
                                <div class="space-y-2 mb-4">
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
                                
                                <x-mary-button label="Proceed to Checkout" class="btn-primary w-full" />
                                
                                <div class="mt-4 text-center">
                                    <p class="text-xs text-base-content/60">
                                        Secure checkout powered by EFSU
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        @else
            <!-- Not Logged In -->
            <div class="text-center py-16">
                <x-mary-icon name="o-user-circle" class="w-24 h-24 mx-auto text-base-content/30 mb-4" />
                <h3 class="text-xl font-semibold text-base-content mb-2">Please log in to view your cart</h3>
                <p class="text-base-content/60 mb-6">You need to be logged in to add items to your cart</p>
                <div class="space-x-4">
                    <x-mary-button label="Log In" class="btn-primary" link="/login" />
                    <x-mary-button label="Browse Merchandise" class="btn-outline" link="/union-merchandise" />
                </div>
            </div>
        @endauth
    </div>
</div>