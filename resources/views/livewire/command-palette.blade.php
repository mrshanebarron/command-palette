<div
    x-data="{ open: @entangle('open') }"
    @keydown.meta.k.window.prevent="open = true"
    @keydown.ctrl.k.window.prevent="open = true"
    @keydown.escape.window="open = false"
>
    <div
        x-show="open"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        @click="open = false"
        class="fixed inset-0 bg-black/50 z-50"
    ></div>

    <div
        x-show="open"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 scale-95"
        x-transition:enter-end="opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100 scale-100"
        x-transition:leave-end="opacity-0 scale-95"
        class="fixed inset-x-4 top-[20%] mx-auto max-w-xl bg-white rounded-xl shadow-2xl z-50 overflow-hidden"
        @click.outside="open = false"
    >
        <div class="border-b">
            <div class="flex items-center px-4">
                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                <input
                    type="text"
                    wire:model.live="search"
                    wire:keydown.arrow-down.prevent="selectNext"
                    wire:keydown.arrow-up.prevent="selectPrevious"
                    wire:keydown.enter.prevent="executeSelected"
                    placeholder="Type a command or search..."
                    class="w-full px-4 py-4 text-gray-900 placeholder-gray-400 focus:outline-none"
                    x-ref="input"
                    x-init="$watch('open', value => value && $nextTick(() => $refs.input.focus()))"
                >
            </div>
        </div>

        <div class="max-h-80 overflow-y-auto p-2">
            @forelse($this->getFilteredCommands() as $index => $command)
                <button
                    wire:click="$set('selectedIndex', {{ $index }}); executeSelected()"
                    @class([
                        'w-full flex items-center gap-3 px-4 py-3 rounded-lg text-left transition-colors',
                        'bg-blue-50 text-blue-900' => $index === $selectedIndex,
                        'hover:bg-gray-50' => $index !== $selectedIndex,
                    ])
                >
                    @if(isset($command['icon']))
                        <span class="text-gray-400">{!! $command['icon'] !!}</span>
                    @endif
                    <div>
                        <div class="font-medium">{{ $command['label'] }}</div>
                        @if(isset($command['description']))
                            <div class="text-sm text-gray-500">{{ $command['description'] }}</div>
                        @endif
                    </div>
                    @if(isset($command['shortcut']))
                        <kbd class="ml-auto px-2 py-1 text-xs bg-gray-100 rounded">{{ $command['shortcut'] }}</kbd>
                    @endif
                </button>
            @empty
                <div class="px-4 py-8 text-center text-gray-500">No commands found</div>
            @endforelse
        </div>

        <div class="border-t px-4 py-2 text-xs text-gray-400 flex items-center gap-4">
            <span><kbd class="px-1.5 py-0.5 bg-gray-100 rounded">↑↓</kbd> Navigate</span>
            <span><kbd class="px-1.5 py-0.5 bg-gray-100 rounded">↵</kbd> Select</span>
            <span><kbd class="px-1.5 py-0.5 bg-gray-100 rounded">esc</kbd> Close</span>
        </div>
    </div>
</div>
