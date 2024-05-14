<?php

namespace App\View\Components\Generator;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Model;
use Illuminate\View\Component;

class InputIcon extends Component
{
    public $icons, $dados;
    /**
     * Create a new component instance.
     */
    public function __construct($dados)
    {
        $this->icons = json_decode(file_get_contents(public_path() . '/json/icons.json'));

        $this->dados = $dados;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.generator.input-icon');
    }
}
