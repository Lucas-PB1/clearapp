<?php

namespace App\Repositories\Contents\ExampleRepository;

use App\Repositories\Repository;

class ExampleRepository extends Repository
{

    public function __construct()
    {
        // $this->model = new Model();
    }

    /**
     * @inheritDoc
     */
    protected function structureUpInsert($request): array
    {
        return [];
    }

}
