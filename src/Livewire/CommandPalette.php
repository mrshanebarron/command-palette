<?php

namespace MrShaneBarron\CommandPalette\Livewire;

use Livewire\Attributes\On;
use Livewire\Component;

class CommandPalette extends Component
{
    public bool $open = false;
    public string $search = '';
    public array $commands = [];
    public int $selectedIndex = 0;

    public function mount(array $commands = []): void
    {
        $this->commands = $commands;
    }

    #[On('toggle-command-palette')]
    public function openPalette(): void
    {
        $this->open = true;
        $this->search = '';
        $this->selectedIndex = 0;
    }

    public function toggle(): void
    {
        $this->open = !$this->open;
        $this->search = '';
        $this->selectedIndex = 0;
    }

    public function updatedSearch(): void
    {
        $this->selectedIndex = 0;
    }

    public function selectNext(): void
    {
        $filtered = $this->getFilteredCommands();
        $this->selectedIndex = min($this->selectedIndex + 1, count($filtered) - 1);
    }

    public function selectPrevious(): void
    {
        $this->selectedIndex = max($this->selectedIndex - 1, 0);
    }

    public function executeSelected(): void
    {
        $filtered = $this->getFilteredCommands();
        if (isset($filtered[$this->selectedIndex])) {
            $this->dispatch('command-executed', command: $filtered[$this->selectedIndex]);
            $this->open = false;
        }
    }

    public function getFilteredCommands(): array
    {
        if (empty($this->search)) {
            return $this->commands;
        }
        return array_values(array_filter($this->commands, function ($cmd) {
            return stripos($cmd['label'], $this->search) !== false ||
                   (isset($cmd['keywords']) && stripos(implode(' ', $cmd['keywords']), $this->search) !== false);
        }));
    }

    public function render()
    {
        return view('sb-command-palette::livewire.command-palette');
    }
}
