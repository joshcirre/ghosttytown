<?php

use App\Models\Config;
use Livewire\Attributes\Url;
use Livewire\Volt\Component;
use Livewire\WithPagination;

use function Laravel\Folio\name;

name('dashboard');

new class extends Component
{
    use WithPagination;

    #[Url]
    public string $search = '';

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function with()
    {
        if ($this->search) {
            $searchResults = Config::withCount('starredBy')
                ->where('description', 'like', '%'.$this->search.'%')
                ->where('approved', true)
                ->orderByDesc('created_at')
                ->paginate(12);

            return [
                'searchResults' => $searchResults,
                'isSearching' => true,
            ];
        }

        return [
            'popularConfigs' => Config::withCount('starredBy')
                ->orderByDesc('starred_by_count')
                ->where('approved', true)
                ->limit(8)
                ->get(),
            'latestConfigs' => Config::withCount('starredBy')
                ->orderByDesc('created_at')
                ->where('approved', true)
                ->paginate(12),
            'isSearching' => false,
        ];
    }
};
?>


<x-layouts.app>
    @volt("pages.dashboard")
        <div class="space-y-4">
            <div class="max-w-xl">
                <flux:input wire:model.live="search" type="search" placeholder="Search the town..." />
            </div>

            @if ($isSearching)
                <div>
                    <flux:heading size="lg">Search Results</flux:heading>
                    <div class="grid grid-cols-1 gap-4 mt-4 sm:grid-cols-4 lg:grid-cols-6">
                        @foreach ($searchResults as $config)
                            <a href="/configs/{{ $config->id }}" class="relative group">
                                <image
                                    class="object-cover w-full h-full rounded-lg"
                                    src="{{ Storage::disk("s3")->url($config->image_url) }}"
                                    alt="ghostty config image"
                                />
                                @if ($config->starred_by_count > 0)
                                    <div
                                        class="absolute flex items-center gap-1 px-2 py-1 text-xs text-white rounded bottom-2 right-2 bg-black/50"
                                    >
                                        <flux:icon.star variant="solid" class="text-yellow-500 opacity-70 size-3" />
                                        {{ $config->starred_by_count }}
                                    </div>
                                @endif
                            </a>
                        @endforeach
                    </div>

                    <div class="mt-4">
                        {{ $searchResults->links() }}
                    </div>
                </div>
            @else
                <div>
                    <flux:heading size="lg">Popular Configs</flux:heading>
                    <div class="grid grid-cols-1 gap-4 mt-4 sm:grid-cols-4 lg:grid-cols-6">
                        @foreach ($popularConfigs as $config)
                            <a href="/configs/{{ $config->id }}" class="relative group">
                                <image
                                    class="object-cover w-full h-full rounded-lg"
                                    src="{{ Storage::disk("s3")->url($config->image_url) }}"
                                    alt="ghostty config image"
                                />
                                @if ($config->starred_by_count > 0)
                                    <div
                                        class="absolute flex items-center gap-1 px-2 py-1 text-xs text-white rounded bottom-2 right-2 bg-black/50"
                                    >
                                        <flux:icon.star variant="solid" class="text-yellow-500 size-3" />
                                        {{ $config->starred_by_count }}
                                    </div>
                                @endif
                            </a>
                        @endforeach
                    </div>
                </div>

                <flux:separator />

                <div>
                    <flux:heading size="lg">Latest Configs</flux:heading>
                    <div class="grid grid-cols-1 gap-4 mt-4 sm:grid-cols-4 lg:grid-cols-6">
                        @foreach ($latestConfigs as $config)
                            <a href="/configs/{{ $config->id }}" class="relative group">
                                <image
                                    class="object-cover w-full h-full rounded-lg"
                                    src="{{ Storage::disk("s3")->url($config->image_url) }}"
                                    alt="ghostty config image"
                                />
                                @if ($config->starred_by_count > 0)
                                    <div
                                        class="absolute flex items-center gap-1 px-2 py-1 text-xs text-white rounded bottom-2 right-2 bg-black/50"
                                    >
                                        <flux:icon.star variant="solid" class="text-yellow-500 opacity-70 size-3" />
                                        {{ $config->starred_by_count }}
                                    </div>
                                @endif
                            </a>
                        @endforeach
                    </div>

                    <div class="mt-4">
                        {{ $latestConfigs->links() }}
                    </div>
                </div>
            @endif
        </div>
    @endvolt
</x-layouts.app>
