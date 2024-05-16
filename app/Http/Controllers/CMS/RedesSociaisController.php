<?php

namespace App\Http\Controllers\CMS;

use App\Models\CMS\RedesSociais;
use App\Http\Controllers\Controller;
use App\Http\Requests\RedesSociaisRequest;
use App\Repositories\Contracts\IRedesSociaisRepository;
use App\Repositories\Eloquent\RedesSociais\RedesSociaisRepository;

class RedesSociaisController extends Controller
{
    public $title, $repository, $table, $campos, $path;

    public function __construct(RedesSociaisRepository $repository)
    {
        $this->title = 'Redes Sociais';
        $this->repository = $repository;
        $this->table = new RedesSociais();
        $this->campos = [ 'id', 'nome as Nome', 'link as Link'];
    }

    public function store(RedesSociaisRequest $request): \Illuminate\Http\RedirectResponse
    {
        return parent::storehas($request);
    }

    public function update(RedesSociaisRequest $request, $id): \Illuminate\Http\RedirectResponse
    {
        return parent::updatehas($request, $id);
    }
}
