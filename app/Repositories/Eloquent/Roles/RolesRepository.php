<?php

namespace App\Repositories\Eloquent\Roles;

use App\Repositories\Contracts\IRolesRepository;
use App\Repositories\Repository;
use Spatie\Permission\Models\Role;

class RolesRepository extends Repository
{
    public function __construct()
    {
        $this->model = new Role();
    }

    protected function structureUpInsert($request): array
    {
        $fields = array_keys($request);
        return $this->filter_request($request, $fields);
    }
}
