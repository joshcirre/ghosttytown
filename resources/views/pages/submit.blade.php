<?php

use Flux\Flux;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Validate;
use Livewire\Volt\Component;
use Livewire\WithFileUploads;

use function Laravel\Folio\middleware;
use function Laravel\Folio\name;

middleware(['auth', 'verified']);
name('submit');

new class extends Component
{
    use WithFileUploads;

    #[Validate('image|max:5048', message: 'Ghostty config images must be less than 5MB')]
    public $photo;

    public $content = '';

    public $description = '';

    public function submit()
    {
        $photoPath = $this->photo->storePublicly('config-photos', 's3');

        Auth::user()->configs()->create([
            'image_url' => $photoPath,
            'description' => $this->pull('description'),
            'content' => $this->pull('content'),
        ]);

        Flux::toast('Thanks for sharing!', variant: 'success');

        $this->redirect('/', navigate: true);
    }
};
?>


<x-layouts.app>
    @volt("pages.submit")
        <div>
            <form wire:submit="submit" class="space-y-6">
                <flux:input
                    type="file"
                    wire:model="photo"
                    label="Show us your Ghostty"
                    description="Only one photo per config currently allowed."
                />
                <flux:textarea wire:model="content" label="Share your Ghostty config text" rows="8" />
                <flux:textarea wire:model="description" placeholder="clean, minimal, gruvbox, macos" rows="auto" />
                <flux:button type="submit">Share with the Town</flux:button>
            </form>
        </div>
    @endvolt
</x-layouts.app>
