<?php

namespace Database\Seeders;

use App\Models\CMS\Archives;
use Illuminate\Database\Seeder;
use App\Models\CMS\Configurações;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ConfigurationSeed extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(Configurações $config, Archives $archives): void
    {

        $configs = [
            ['Logo', ''],
            ['Nome do site', 'Leapp']
        ];

        $logo = $archives->create([
            'title' => 'logo',
            'name' => 'logo',
            'path' => '',
            'extension' => 'webp',
            'highlight' => true,
            'desc' => 'Logo',
            'table' => 'configuracoes',
            'reference_id' => 1
        ]);

        foreach ($configs as $value) {
            $config->create([
                'nome' => $value[0],
                'valor' => $value[1],
                'slug' => slug_fix($value[0]),
            ]);
        }

    }
}
