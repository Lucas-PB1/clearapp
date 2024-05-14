<?php

namespace App\View\Components\Portal\Layout;

use Closure;
use Illuminate\View\Component;
use App\Models\CMS\RedesSociais;
use Illuminate\Contracts\View\View;

class Footer extends Component
{
    public $redes;
    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        $this->redes = RedesSociais::all();
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.portal.layout.footer');
    }
}
