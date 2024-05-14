<?php
namespace App\Services;

use Illuminate\Support\Facades\Cache;

class ModelResolver
{
    public function getModelClassFromTableName($tableName)
    {
        return Cache::remember('model_map.' . $tableName, 60 * 24, function () use ($tableName) {
            $models = $this->getAllModelsFromDirectory(app_path('Models'));

            foreach ($models as $modelPath) {
                $relativePath = str_replace([app_path() . DIRECTORY_SEPARATOR, '.php', '/'], ['', '', '\\'], $modelPath);
                $class = "\\App\\{$relativePath}";

                if (class_exists($class)) {
                    $modelInstance = new $class;
                    if (isset($modelInstance) && $modelInstance->getTable() == $tableName)
                        return $class;
                }
            }

            return null;
        });
    }

    private function getAllModelsFromDirectory($directory)
    {
        $models = [];

        foreach (scandir($directory) as $file) {
            if ($file === '.' || $file === '..')
                continue;

            $filePath = $directory . '/' . $file;

            if (is_dir($filePath)) {
                $models = array_merge($models, $this->getAllModelsFromDirectory($filePath));
            } elseif (pathinfo($filePath, PATHINFO_EXTENSION) === 'php') {
                $models[] = $filePath;
            }
        }

        return $models;
    }
}


