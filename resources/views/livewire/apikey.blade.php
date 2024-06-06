<?php

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Volt\Component;

new class extends Component {

    public $apiKey = '';
    public $user;

    public function mount()
    {
        $this->apiKey = auth()->user()->api_key;
        $userDetails = Auth::user();  // To get the logged-in user details
        $this->user = $user = User::find(\auth()->id());
    }

    public function refreshKey()
    {
        $newKey = \Illuminate\Support\Str::random(32);
        $this->user->api_key = $newKey;
        $this->user->save();
        $this->redirect('dashboard');
    }

}; ?>

<div class="flex gap-x-4 items-end">
    <x-mary-input class="flex-initial w-96" label="API Key" wire:model="apiKey" disabled="true"/>
    <x-mary-button wire:click="refreshKey" icon="o-arrow-path" class="btn btn-primary"/>
</div>
