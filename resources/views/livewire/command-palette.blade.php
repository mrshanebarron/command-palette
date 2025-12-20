<div
    x-data
    x-on:keydown.meta.k.window.prevent="$wire.toggle()"
    x-on:keydown.ctrl.k.window.prevent="$wire.toggle()"
    x-on:keydown.escape.window="$wire.set('open', false)"
>
    @if($open)
    <div
        wire:click="$set('open', false)"
        style="position: fixed; inset: 0; background-color: rgba(0,0,0,0.5); z-index: 50;"
    ></div>

    <div style="position: fixed; left: 1rem; right: 1rem; top: 20%; margin-left: auto; margin-right: auto; max-width: 36rem; background-color: white; border-radius: 0.75rem; box-shadow: 0 25px 50px -12px rgba(0,0,0,0.25); z-index: 50; overflow: hidden;">
        <div style="border-bottom: 1px solid #e5e7eb;">
            <div style="display: flex; align-items: center; padding: 0 1rem;">
                <svg style="width: 1.25rem; height: 1.25rem; color: #9ca3af;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                <input
                    type="text"
                    wire:model.live="search"
                    wire:keydown.arrow-down.prevent="selectNext"
                    wire:keydown.arrow-up.prevent="selectPrevious"
                    wire:keydown.enter.prevent="executeSelected"
                    placeholder="Type a command or search..."
                    style="width: 100%; padding: 1rem; font-size: 1rem; color: #111827; border: none; outline: none; background: transparent;"
                    autofocus
                >
            </div>
        </div>

        <div style="max-height: 20rem; overflow-y: auto; padding: 0.5rem;">
            @forelse($this->getFilteredCommands() as $index => $command)
                @php
                    $isSelected = $index === $selectedIndex;
                    $buttonStyle = 'width: 100%; display: flex; align-items: center; gap: 0.75rem; padding: 0.75rem 1rem; border-radius: 0.5rem; text-align: left; border: none; cursor: pointer; transition: background-color 0.15s;';
                    $buttonStyle .= $isSelected ? ' background-color: #eff6ff; color: #1e3a8a;' : ' background-color: transparent; color: #374151;';
                @endphp
                <button
                    wire:click="$set('selectedIndex', {{ $index }}); executeSelected()"
                    style="{{ $buttonStyle }}"
                >
                    @if(isset($command['icon']))
                        <span style="color: #9ca3af; flex-shrink: 0;">{!! $command['icon'] !!}</span>
                    @endif
                    <div style="flex: 1; min-width: 0;">
                        <div style="font-weight: 500;">{{ $command['label'] }}</div>
                        @if(isset($command['description']))
                            <div style="font-size: 0.875rem; color: #6b7280;">{{ $command['description'] }}</div>
                        @endif
                    </div>
                    @if(isset($command['shortcut']))
                        <kbd style="margin-left: auto; padding: 0.25rem 0.5rem; font-size: 0.75rem; background-color: #f3f4f6; border-radius: 0.25rem; font-family: monospace;">{{ $command['shortcut'] }}</kbd>
                    @endif
                </button>
            @empty
                <div style="padding: 2rem 1rem; text-align: center; color: #6b7280;">No commands found</div>
            @endforelse
        </div>

        <div style="border-top: 1px solid #e5e7eb; padding: 0.5rem 1rem; font-size: 0.75rem; color: #9ca3af; display: flex; align-items: center; gap: 1rem;">
            <span><kbd style="padding: 0.125rem 0.375rem; background-color: #f3f4f6; border-radius: 0.25rem;">↑↓</kbd> Navigate</span>
            <span><kbd style="padding: 0.125rem 0.375rem; background-color: #f3f4f6; border-radius: 0.25rem;">↵</kbd> Select</span>
            <span><kbd style="padding: 0.125rem 0.375rem; background-color: #f3f4f6; border-radius: 0.25rem;">esc</kbd> Close</span>
        </div>
    </div>
    @endif
</div>
