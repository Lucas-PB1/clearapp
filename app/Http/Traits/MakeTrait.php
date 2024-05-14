<?php

namespace App\Http\Traits;

use Illuminate\Support\Str;
use App\Http\Traits\FileTrait;
use Exception;

trait MakeTrait
{
    use FileTrait;

    protected function makeInterface($path, $name)
    {
        $name = str_replace(' ', '', $name);
        $file = $this->getFile(app_path() . "/Http/Generator/Cruds/ITemplateRepository.txt");
        $context = str_replace('<name>', $name, $file);

        $this->createFileOrBreak($path, $context, 'Interface');
    }

    protected function makeModel($path, $name, $dados)
    {
        $nameWithoutSpace = str_replace(' ', '', $name);

        $info = "\n";
        foreach ($dados as $value) {
            $slug = slug_fix($value['title']);
            $info = $info . "        '" . $slug . "'" . ",\n";
        }

        $file = $this->getFile(app_path() . "/Http/Generator/Cruds/Template.txt");
        $context = str_replace('<name>', $nameWithoutSpace, $file);
        $context = str_replace('<name_min>', Str::plural(slug_fix($name)), $context);
        $context = str_replace('<fields>', $info, $context);

        $this->createFileOrBreak($path, $context, 'Model');
    }

    protected function makeRepository($path, $name)
    {
        $file = $this->getFile(app_path() . "/Http/Generator/Cruds/TemplateRepository.txt");
        $name = str_replace(' ', '', $name);
        $context = str_replace('<name>', $name, $file);
        $this->createFileOrBreak($path, $context, 'Repository');
    }

    protected function makeController($path, $name, $dados, $nameWithoutSpace)
    {
        $data = '';
        foreach ($dados as $value) {
            $title = $value['title'];
            $slug = slug_fix($title);
            $data .=  "'$slug as $title',";
        }

        $file = $this->getFile(app_path() . "/Http/Generator/Cruds/TemplateController.txt");
        $context = str_replace('<name>', $nameWithoutSpace, $file);
        $context = str_replace('<name-title>', $name, $context);
        $context = str_replace('<name_min>', slug_fix($name), $context);
        $context = str_replace('<dados>', $data, $context);

        $this->createFileOrBreak($path, $context, 'Controller');
    }

    protected function makeMigration($path, $name, $dados, $normal_name)
    {
        $file = $this->getFile(app_path() . "/Http/Generator/Cruds/2000_00_00_000000_create_template_table.txt");
        $context = str_replace('<name>', $name, $file);

        $info = "\n";
        foreach ($dados as $value) {
            $mandatory = $value['required'] == 'optional' ? "->nullable()" : '';
            $slug = slug_fix($value['title']);
            if ($value['type'] == 'select') $value['type'] = 'integer';
            $info = $info . '            $table->' . $value['type'] . "('" . $slug . "')$mandatory;\n";
        }

        $context = str_replace('<fields>', $info, $context);

        $insert = "DB::table('cruds')->insert(['titulo' => '$normal_name']);";
        $context = str_replace('<insert>', $insert, $context);

        $this->createFileOrBreak($path, $context, 'Migration');
    }

    protected function makeRequest($path, $name, $dados)
    {
        $file = $this->getFile(app_path() . "/Http/Generator/Cruds/TemplateRequest.txt");
        $name = str_replace(' ', '', $name);
        $context = str_replace('<name>', $name, $file);

        $laws = $messages = "\n";

        foreach ($dados as $value) {
            $slug = slug_fix($value['title']);
            if ($value['required'] != 'optional') {
                $laws = $laws . "            '" . $slug . "' => ['required'],\n";
                $messages = $messages . "            '" . $slug . ".required' => 'Este campo é obrigatório.',\n";
            }
        }

        $context = str_replace('<laws>', $laws, $context);
        $context = str_replace('<messages>', $messages, $context);

        $this->createFileOrBreak($path, $context, 'Request');
    }

    public function addRoute($path, $name, $nameWithoutSpace)
    {
        $file_path = base_path('routes/web.php');
        $file_contents = file_get_contents($file_path);
        $controller_use = "use App\Http\Controllers\CMS\\" . $nameWithoutSpace . "Controller;\n";

        if (strpos($file_contents, $controller_use) === false) {
            $last_use_position = strrpos($file_contents, 'use App\Http\Controllers');
            $end_of_last_use_line = strpos($file_contents, ";\n", $last_use_position) + 2;
            $file_contents = substr_replace($file_contents, $controller_use, $end_of_last_use_line, 0);
        }

        $new_route = "Route::resource('/" . slug_fix($name) . "', $nameWithoutSpace" . "Controller::class);\n";
        if (strpos($file_contents, $new_route) === false) $file_contents .= $new_route;

        $apiRoute = "Route::get('api/" . slug_fix($name) . "', [$nameWithoutSpace" . "Controller::class, 'indexAPI']);\n";
        if (strpos($file_contents, $apiRoute) === false) $file_contents .= $apiRoute;

        file_put_contents($file_path, $file_contents);
    }

    public function makeViews($path, $name, $valores)
    {
        // CREATE
        $file = $this->getFile(app_path() . "/Http/Generator/Views/create.blade.php");
        $edit_view = str_replace('<include-form>', "@include('cms.$name.form')", $file);
        $this->createFileOrBreak("$path" . "create.blade.php", $edit_view, 'View Create');

        // INDEX
        $file = $this->getFile(app_path() . "/Http/Generator/Views/index.blade.php");
        $index_view = str_replace('<nome-do-crud>', "$name", $file);
        $this->createFileOrBreak("$path" . "index.blade.php", $index_view, 'View Index');

        // FORM
        $file = $this->getFile(app_path() . "/Http/Generator/Views/form.blade.php");
        $index_view = str_replace('<nome-do-crud>', "$name", $file);

        $fields = '';
        foreach ($valores as $value) {
            $tipo = $value['type'];

            if ($tipo == 'text') $tipo = 'text';
            if ($tipo == 'integer') $tipo = 'number';

            $slug = slug_fix($value['title']);

            $id = 'id="' . $slug . '"';
            $titulo = 'titulo="' . $value['title'] . '"';
            $size = 'size="' . $value['size'] . '"';
            $dados = 'dados="{{ isset($data) ? $data->{' . "'$slug'" . '} : null }}"';

            if ($tipo == 'text' ||  $tipo == 'number') {
                $input = "<x-generator.input $id $titulo $size tipo='$tipo' $dados />";
            } elseif ($tipo == 'select') {
                $input = "<x-generator.select $id $titulo $size >";
                foreach ($value['options'] as $item) {
                    $input .= "\n       <option value='$item'>$item</option>";
                }
                $input .= "\n    </x-generator.select>";
            } elseif ($tipo == 'boolean') {
                $input = "<x-generator.input $id $titulo $size tipo='checkbox' $dados />";
            }

            $fields = $fields . "\n    " . $input;
        }

        $index_view = str_replace('<include-campos>', "$fields", $index_view);
        $this->createFileOrBreak("$path" . "form.blade.php", $index_view, 'View Form');
    }

    public function makeMigrationName($name)
    {
        return date("Y_m_d_His") . "_create_" . $name . "_table.php";
    }

    function verifyDIR($path)
    {
        if (!is_dir($path))
            mkdir($path, 0755, true);
    }

    function createFileOrBreak($path, $data, $item)
    {
        if (!file_exists($path))
            $this->createfile($path, $data);
        else
            throw new Exception("$item com esse nome já existe.");
    }
}
