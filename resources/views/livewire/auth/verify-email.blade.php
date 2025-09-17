<?php

use App\Livewire\Actions\Logout;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('components.layouts.auth')] class extends Component {
    public $canResend = false;
    public $timeRemaining = 120;
    public $lastSentAt = null;

    public function mount()
    {
        $this->lastSentAt = session('last_verification_sent', null);
        $this->updateResendStatus();
    }

    public function updateResendStatus()
    {
        if ($this->lastSentAt) {
            $elapsed = now()->diffInSeconds($this->lastSentAt);
            if ($elapsed < 120) {
                $this->timeRemaining = 120 - $elapsed;
                $this->canResend = false;
            } else {
                $this->canResend = true;
                $this->timeRemaining = 0;
            }
        } else {
            $this->canResend = false;
            $this->timeRemaining = 120;
        }
    }

    /**
     * Send an email verification notification to the user.
     */
    public function sendVerification(): void
    {
        if (!$this->canResend) {
            return;
        }

        if (Auth::user()->hasVerifiedEmail()) {
            $this->redirectIntended(default: route('home', absolute: false), navigate: true);

            return;
        }

        Auth::user()->sendEmailVerificationNotification();

        $this->lastSentAt = now();
        session(['last_verification_sent' => $this->lastSentAt]);
        
        $this->canResend = false;
        $this->timeRemaining = 120;

        Session::flash('status', 'verification-link-sent');
        
        $this->dispatch('verification-sent');
    }

    /**
     * Log the current user out of the application.
     */
    public function logout(Logout $logout): void
    {
        $logout();

        $this->redirect('/', navigate: true);
    }
}; ?>

<div class="mt-4 flex flex-col gap-6">
    <x-mary-alert class="alert-info text-center">
        {{ __('Please verify your email address by clicking on the link we just emailed to you.') }}
    </x-mary-alert>

    <x-mary-alert class="alert-warning text-center">
        <div class="space-y-2">
            <p>{{ __('Please check your mailbox at') }} <a href="https://web.mail.uom.lk" target="_blank" class="font-bold text-white hover:text-white underline">web.mail.uom.lk</a></p>
            <p class="text-sm">{{ __('Look for the verification email in your inbox or spam folder. The email will be from the EFSU Portal system.') }}</p>
        </div>
    </x-mary-alert>

    @if (session('status') == 'verification-link-sent')
        <x-mary-alert class="alert-success text-center font-medium">
            {{ __('A new verification link has been sent to the email address you provided during registration.') }}
        </x-mary-alert>
    @endif

    <div class="flex flex-col items-center justify-between space-y-3 w-full">
        <x-mary-button 
            wire:click="sendVerification" 
            class="btn-primary w-full" 
            :disabled="!$canResend"
            id="resend-button"
        >
            @if(!$canResend && $timeRemaining > 0)
                <span id="button-text">{{ __('Resend in') }} <span id="timer-display">{{ gmdate('i:s', $timeRemaining) }}</span></span>
            @else
                <span id="button-text">{{ __('Resend verification email') }}</span>
            @endif
        </x-mary-button>

        <x-mary-button wire:click="logout" class="btn-link text-sm">
            {{ __('Log out') }}
        </x-mary-button>
    </div>
</div>

<script>
    document.addEventListener('livewire:navigated', function() {
        let timer = null;
        
        function startTimer() {
            if (timer) clearInterval(timer);
            
            let startTime = Date.now();
            let initialTimeRemaining = @this.timeRemaining;
            
            timer = setInterval(function() {
                let elapsed = Math.floor((Date.now() - startTime) / 1000);
                let currentTimeRemaining = Math.max(0, initialTimeRemaining - elapsed);
                
                if (currentTimeRemaining > 0) {
                    // Update only the DOM, no server requests
                    let minutes = Math.floor(currentTimeRemaining / 60);
                    let seconds = currentTimeRemaining % 60;
                    let timeString = minutes.toString().padStart(2, '0') + ':' + seconds.toString().padStart(2, '0');
                    
                    let timerDisplay = document.getElementById('timer-display');
                    if (timerDisplay) {
                        timerDisplay.textContent = timeString;
                    }
                } else {
                    // Timer finished, update server state once
                    clearInterval(timer);
                    @this.timeRemaining = 0;
                    @this.canResend = true;
                    @this.$refresh();
                }
            }, 1000);
        }
        
        // Start timer if there's time remaining
        if (@this.timeRemaining > 0 && !@this.canResend) {
            startTimer();
        }
        
        // Listen for when verification is sent to restart timer
        @this.on('verification-sent', function() {
            startTimer();
        });
    });
</script>
