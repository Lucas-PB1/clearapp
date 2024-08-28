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

    protected function makeMigration($name, $dados, $normal_name)
    {
        $pathToMigration = database_path() . "/migrations";
        $migration_name = $this->makeMigrationName($name);
        $path = "$pathToMigration/$migration_name";

        $file = $this->getFile(app_path() . "/Http/Generator/Cruds/2000_00_00_000000_create_template_table.txt");

        // Substitui o placeholder <name> no template pelo nome real
        $context = str_replace('<name>', $name, $file);
        
        // Inicializa a variável para armazenar as definições de colunas
        $info = "\n";
        
        // Itera sobre cada dado de campo e constrói a definição de coluna
        foreach ($dados as $value) {
            // Determina se o campo é opcional
            $mandatory = $value['required'] == 'optional' ? "->nullable()" : '';
        
            // Gera um slug para o nome da coluna
            $slug = slug_fix($value['title']);
            
            // Ajusta o tipo do campo se for do tipo select
            if ($value['type'] == 'select' || $value['type'] == 'icon') 
                $value['type'] = 'text';
        
            // Constrói a definição da coluna e adiciona à variável $info
            $info .= '            $table->' . $value['type'] . "('" . $slug . "')$mandatory;\n";
        
            // Interrompe a execução e exibe o conteúdo de $info para debug
        }

        // Substitui o placeholder <fields> no template pelas definições de colunas
        $context = str_replace('<fields>', $info, $context);
        
        // Constrói a instrução de inserção no banco de dados
        $insert = "DB::table('cruds')->insert(['titulo' => '$normal_name']);";
        $context = str_replace('<insert>', $insert, $context);
        
        // Cria o arquivo ou interrompe a execução se houver algum erro
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

        $fields = ''; // Inicialização da variável que armazenará todos os campos gerados

        foreach ($valores as $value) { // Loop através de cada item em $valores
            $tipo = $value['type']; // Captura o tipo de dado do campo atual
        
            // Conversão de tipos de campo para o componente de entrada
            if ($tipo == 'integer') $tipo = 'number'; // Convertendo 'integer' para 'number' para ser usado como input de número
        
            // Geração do slug a partir do título
            $slug = slug_fix($value['title']);
        
            // Construção de atributos HTML com base nos dados do campo
            $id = 'id="' . $slug . '"';
            $titulo = 'titulo="' . $value['title'] . '"';
            $size = 'size="' . $value['size'] . '"';
            $dados = 'dados="{{ isset($data) ? $data->{' . "'$slug'" . '} : null }}"';
        
            // Inicialização da variável $input para o campo gerado
            $input = '';
        
            // Verifica o tipo e gera o componente correspondente
            if ($tipo == 'text' ||  $tipo == 'number') {
                // Para campos de texto e número
                $input = "<x-generator.input $id $titulo $size tipo='$tipo' $dados />";
            } elseif ($tipo == 'select') {
                // Para campos de seleção
                $input = "<x-generator.select $id $titulo $size>";
                $input .= "\n       <option selected>Selecione</option>";
                foreach ($value['options'] as $item) {
                    $input .= "\n       <option value='$item'>$item</option>";
                }
                $input .= "\n    </x-generator.select>";
            } elseif ($tipo == 'boolean') {
                // Para campos booleanos (checkbox)
                $input = "<x-generator.input $id $titulo $size tipo='checkbox' $dados value='1'/>";
            } elseif ($tipo == 'date') {
                // Para campos de data
                $input = "<x-generator.input $id $titulo $size tipo='date' $dados />";
            } elseif ($tipo == 'icon') {
                // Para campos de ícone, assumindo um campo de entrada especial para ícones
                $input = "<x-generator.input-icon $id $titulo $size $dados />";
            }
        
            // Adiciona o campo gerado ao conjunto de campos ($fields)
            $fields .= "\n    " . $input;
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
