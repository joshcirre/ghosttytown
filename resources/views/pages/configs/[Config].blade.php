<?php

use App\Models\Config;
use Livewire\Volt\Component;

use function Laravel\Folio\name;

name('config.show');

new class extends Component
{
    public Config $config;

    public bool $isStarred = false;

    public int $starsCount = 0;

    public function mount(Config $config)
    {
        $this->config = $config;
        $this->starsCount = $config->fresh()->stars_count;
    }

    public function toggleStar()
    {
        if (! auth()->check()) {
            return redirect('/auth/login');
        }

        $user = auth()->user();

        if ($this->config->isStarredBy($user)) {
            $this->config->starredBy()->detach($user);
            $this->isStarred = false;
        } else {
            $this->config->starredBy()->attach($user);
            $this->isStarred = true;
        }

        $this->starsCount = $this->config->fresh()->stars_count;
    }
};
?>


<x-layouts.app>
    @volt("pages.configs.show")
        <div class="space-y-6">
            <div class="flex items-center justify-between">
                <flux:button wire:navigate href="/">Back</flux:button>
                <div class="flex items-center gap-2">
                    <flux:heading class="underline">Submitted by {{ $config->user->name }}</flux:heading>
                    @auth
                        @if ($config->isStarredBy(auth()->user()))
                            <flux:button
                                icon="star"
                                variant="filled"
                                wire:click="toggleStar"
                                class="!text-yellow-500"
                                size="sm"
                            />
                        @else
                            <flux:button
                                icon="star"
                                wire:click="toggleStar"
                                class="text-yellow-500"
                                size="sm"
                                variant="subtle"
                            />
                        @endif
                    @endauth
                </div>
            </div>
            <image
                class="object-cover w-full h-full rounded-lg"
                src="{{ Storage::disk("public")->url($config->image_url) }}"
                alt="ghostty config image"
            />
            <flux:textarea readonly rows="auto">{{ $config->content }}</flux:textarea>
            <flux:separator />
            <flux:input disabled value="{{ $config->description }}" />
        </div>
    @endvolt
</x-layouts.app>
