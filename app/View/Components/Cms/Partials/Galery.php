<?php

namespace App\View\Components\Cms\Partials;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Galery extends Component
{
    public $id, $table;
    /**
     * Create a new component instance.
     */
    public function __construct($id, $table)
    {
        $this->id = $id;
        $this->table = $table;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.cms.partials.galery');
    }
}
