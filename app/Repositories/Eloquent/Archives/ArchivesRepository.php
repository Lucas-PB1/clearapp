<?php

namespace App\Repositories\Eloquent\Archives;

use App\Repositories\Contracts\IArchivesRepository;
use App\Models\CMS\Archives;
use App\Repositories\Repository;

class ArchivesRepository extends Repository
{
    public function __construct()
    {
        $this->model = new Archives();
    }

    protected function structureUpInsert($request): array
    {
        $fields = array_keys($request);
        return $this->filter_request($request, $fields);
    }
}