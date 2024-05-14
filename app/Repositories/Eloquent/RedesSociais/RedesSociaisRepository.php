<?php

namespace App\Repositories\Eloquent\RedesSociais;

use App\Repositories\Contracts\IRedesSociaisRepository;
use App\Models\CMS\RedesSociais;
use App\Repositories\Repository;

class RedesSociaisRepository extends Repository
{
    public function __construct()
    {
        $this->model = new RedesSociais();
    }

    protected function structureUpInsert($request): array
    {
        $fields = array_keys($request);
        return $this->filter_request($request, $fields);
    }
}