<?php

namespace MrShaneBarron\CommandPalette\View\Components;

use Illuminate\View\Component;

class CommandPalette extends Component
{
    public function __construct()
    {
        //
    }

    public function render()
    {
        return view('sb-command-palette::components.command-palette');
    }
}
