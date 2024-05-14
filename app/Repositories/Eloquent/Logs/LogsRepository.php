<?php

namespace App\Repositories\Eloquent\Logs;

use App\Repositories\Contracts\ILogsRepository;
use App\Models\CMS\Logs;
use App\Repositories\Repository;

class LogsRepository extends Repository
{
    public function __construct()
    {
        $this->model = new Logs();
    }

    protected function structureUpInsert($request): array
    {
        $fields = array_keys($request);
        return $this->filter_request($request, $fields);
    }
}