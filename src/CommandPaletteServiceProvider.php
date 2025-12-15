<?php

namespace MrShaneBarron\CommandPalette;

use Illuminate\Support\ServiceProvider;
use MrShaneBarron\CommandPalette\Livewire\CommandPalette;
use MrShaneBarron\CommandPalette\View\Components\CommandPalette as BladeCommandPalette;

class CommandPaletteServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/sb-command-palette.php', 'sb-command-palette');
    }

    public function boot(): void
    {
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'sb-command-palette');

        if (class_exists(\Livewire\Livewire::class)) {
            \Livewire\Livewire::component('sb-command-palette', CommandPalette::class);
        }

        $this->loadViewComponentsAs('ld', [
            BladeCommandPalette::class,
        ]);

        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../config/sb-command-palette.php' => config_path('sb-command-palette.php'),
            ], 'sb-command-palette-config');

            $this->publishes([
                __DIR__ . '/../resources/views' => resource_path('views/vendor/sb-command-palette'),
            ], 'sb-command-palette-views');
        }
    }
}
