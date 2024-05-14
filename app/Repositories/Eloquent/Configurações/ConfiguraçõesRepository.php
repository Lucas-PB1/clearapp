<?php

namespace App\Repositories\Eloquent\Configurações;

use App\Repositories\Contracts\IConfiguraçõesRepository;
use App\Models\CMS\Configurações;
use App\Repositories\Repository;

class ConfiguraçõesRepository extends Repository
{
    public function __construct()
    {
        $this->model = new Configurações();
    }

    protected function structureUpInsert($request): array
    {
        $fields = array_keys($request);
        return $this->filter_request($request, $fields);
    }
}