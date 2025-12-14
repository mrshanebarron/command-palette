<?php

namespace MrShaneBarron\command-palette\View\Components;

use Illuminate\View\Component;

class command-palette extends Component
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
