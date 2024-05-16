<?php

namespace App\Repositories\Eloquent\Configurações;

use App\Repositories\Contracts\IConfigurationRepository;
use App\Models\CMS\Configuracoes;
use App\Repositories\Repository;

class ConfiguracoesRepository extends Repository
{
    public function __construct()
    {
        $this->model = new Configuracoes();
    }

    protected function structureUpInsert($request): array
    {
        $fields = array_keys($request);
        return $this->filter_request($request, $fields);
    }
}
