<?php

namespace MrShaneBarron\command-palette;

use Illuminate\Support\ServiceProvider;
use MrShaneBarron\command-palette\Livewire\command-palette;
use MrShaneBarron\command-palette\View\Components\command-palette as Bladecommand-palette;
use Livewire\Livewire;

class command-paletteServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/sb-command-palette.php', 'sb-command-palette');
    }

    public function boot(): void
    {
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'sb-command-palette');

        Livewire::component('sb-command-palette', command-palette::class);

        $this->loadViewComponentsAs('ld', [
            Bladecommand-palette::class,
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
