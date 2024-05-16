<?php

namespace Database\Seeders;

use App\Http\Traits\AppTrait;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    use AppTrait;
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $modules = [
            'Cruds',
            'Logs',
            'Cargos',
            'Usuarios',
            'Redes Sociais'
        ];

        collect($modules)->each(
            fn($module) =>
            collect(['create', 'read', 'update', 'delete'])->each(
                fn($action) =>
                Permission::firstOrCreate(
                    ['name' => "{$action}_" . slug_fix($module)],
                    ['desc' => "$module"]
                )
            )
        );

        $this->assignPermissionsToRole('super-admin', Permission::all());
        $this->assignPermissionsToRole('admin', [
            'ebooks',
            'alunos',
            'mentorias',
            'redes-sociais',
        ]);
    }
}
