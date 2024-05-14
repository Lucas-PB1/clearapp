<?php

namespace App\View\Components\Cms\Menu;

use Closure;
use Illuminate\View\Component;
use App\Models\CMS\Configurações;
use Illuminate\Contracts\View\View;

class SidebarMenu extends Component
{
    public $siteName, $menus;

    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        $this->siteName = Configurações::where('slug', 'nome-do-site')->first()->valor;

        $this->menus = [
            ['nome' => 'Usuários', 'link' => route('usuarios.index')],
            ['nome' => 'Redes Sociais', 'link' => route('redes-sociais.index')],
            ['nome' => 'Logs', 'link' => route('logs.index')]
        ];
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.cms.menu.sidebar-menu');
    }
}
