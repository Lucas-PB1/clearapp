<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

class TimelineLayout extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct()
    {
      // Code
    }

    /**
     * Get the view / contents that represents the component.
     */
    public function render(): View
    {
        return view('layouts.timeline');
    }
}
