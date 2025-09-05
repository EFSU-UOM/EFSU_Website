<x-layouts.public>
    <div class="min-h-screen bg-base-200 py-8">
        <div class="mx-auto max-w-2xl px-4 sm:px-6 lg:px-8">
            <div class="card bg-base-100 shadow-xl">
                <div class="card-body text-center">
                    <div class="mb-6">
                        <x-mary-icon name="o-check-circle" class="w-24 h-24 mx-auto text-success mb-4" />
                        <h1 class="text-3xl font-bold text-success mb-2">Payment Successful!</h1>
                        <p class="text-base-content/70 mb-4">
                            Thank you for your order. Your payment has been processed successfully.
                        </p>
                    </div>

                    @if (request()->has('order_id'))
                        <div class="bg-success/10 border border-success/20 rounded-lg p-4 mb-6">
                            <p class="font-semibold text-success">Order ID: {{ request('order_id') }}</p>
                            <p class="text-sm text-base-content/70">
                                You will receive an email confirmation shortly.
                            </p>
                        </div>
                    @endif

                    <div class="space-y-4">
                        <x-mary-button label="View Orders" class="btn-primary" link="{{ route('store') }}" />
                        <x-mary-button label="Continue Shopping" class="btn-outline" link="{{ route('store') }}" />
                    </div>

                    <div class="mt-6 text-center">
                        <p class="text-xs text-base-content/60">
                            For any inquiries about your order, please contact our support team.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.public>
