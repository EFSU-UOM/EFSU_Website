<?php

namespace App\Livewire\Actions;

use App\Models\Complaint;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class CreateComplaint extends Component
{
    public string $category = '';
    public string $complaint_text = '';

    protected array $rules = [
        'category' => 'required|string|max:100',
        'complaint_text' => 'required|string|min:10',
    ];

    public function submit()
    {
        $this->validate();

        if (!Auth::check()) {
            session()->flash('error', 'You must be logged in to submit a complaint.');
            return;
        }

        Complaint::create([
            'user_id' => Auth::id(),
            'category' => $this->category,
            'complaint_text' => $this->complaint_text,
        ]);

        session()->flash('success', 'Your complaint has been submitted!');
        $this->reset();
    }

  public function render()
{
    return view('livewire.create-complaint')
        ->layout('components.layouts.auth.simple'); // match folder structure
}

}
