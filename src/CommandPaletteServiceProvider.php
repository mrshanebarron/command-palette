<?php

namespace MrShaneBarron\CommandPalette;

use Illuminate\Support\ServiceProvider;

class CommandPaletteServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        if (class_exists(\Livewire\Livewire::class)) {
            \Livewire\Livewire::component('sb-command-palette', Livewire\CommandPalette::class);
        }
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'sb-command-palette');
    }
}
