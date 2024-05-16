<?php

namespace App\View\Components\Cms\Includes;

use Closure;
use Illuminate\View\Component;
use App\Models\CMS\Configuracoes;
use Illuminate\Contracts\View\View;

class Metatags extends Component
{
    public $siteName, $logo;
    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        $this->siteName = Configuracoes::where('slug', 'nome-do-site')->first()->valor;
        $this->logo = Configuracoes::where('slug', 'logo')->first()->destaque->path;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.cms.includes.metatags');
    }
}
