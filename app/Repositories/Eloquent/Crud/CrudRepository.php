<?php

namespace App\Repositories\Eloquent\Crud;

use App\Repositories\Contracts\ICrudRepository;
use App\Models\CMS\Crud;
use App\Repositories\Repository;

class CrudRepository extends Repository
{
    public function __construct()
    {
        $this->model = new Crud();
    }

    protected function structureUpInsert($request): array
    {
        $fields = array_keys($request);
        return $this->filter_request($request, $fields);
    }
}