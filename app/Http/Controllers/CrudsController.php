<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\CMS\Crud;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Traits\AppTrait;
use App\Http\Traits\MakeTrait;
use App\Http\Traits\FileTrait;
use App\Http\Requests\CrudRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Artisan;
use App\Repositories\Contracts\ICrudRepository;
use App\Repositories\Eloquent\Crud\CrudRepository;

class CrudsController extends Controller
{
    use AppTrait;
    use FileTrait;
    use MakeTrait;

    public $title, $repository, $table;

    public function __construct(CrudRepository $repository)
    {
        $this->title = 'Crud';
        $this->repository = $repository;
        $this->table = new Crud();
    }

    public function index()
    {
        return view('cms.cruds.index', ['title' => $this->title]);
    }

    public function indexAPI()
    {
        return response()->json(['content' => $this->table->get(['titulo',])], 200);
    }

    public function create()
    {
        return view('cms.cruds.create', ['title' => $this->title]);
    }

    public function store(CrudRequest $request)
    {
        try {
            $name = ucfirst($request->titulo);
            $nameWithoutSpace = clean_slug($name);
            $nameWithoutSpace = str_replace(' ', '', $nameWithoutSpace);
        
            $path = "Eloquent/" . $nameWithoutSpace;
            $explodedPath = explode('/', $path);
            $collectPath = collect($explodedPath);
            $repoName = $collectPath->last();
            $repoName = str_replace(' ', '', $repoName);
            
            // Model
            $pathToModel = app_path() . "/Models/CMS";
            $this->verifyDIR($pathToModel);
            $this->makeModel("$pathToModel/$nameWithoutSpace.php", $nameWithoutSpace, $request->generator);
            
            // Interface
            $pathToContract = app_path() . "/Repositories/Contracts";
            $this->verifyDIR($pathToContract);
            $this->makeInterface("$pathToContract/I$repoName"."Repository.php", $repoName);

            // Repository
            $pathToRepo = app_path() . "/Repositories/$path";
            $this->verifyDIR($pathToRepo);
            $this->makeRepository("$pathToRepo/$repoName"."Repository.php", $nameWithoutSpace);

            // Controller
            $pathToController = app_path() . "/Http/Controllers/CMS";
            $this->verifyDIR($pathToController);
            $this->makeController("$pathToController/$nameWithoutSpace" . "Controller.php", $name, $request->generator, $nameWithoutSpace);

            // Migration
            $slug = slug_fix($request->titulo);
            $table_name = Str::plural($slug);
            $this->makeMigration($table_name, $request->generator, $name);

            // // Request
            $pathToRequest = app_path() . "/Http/Requests";
            $this->makeRequest("$pathToRequest/$nameWithoutSpace" . 'Request.php', $nameWithoutSpace, $request->generator);

            // // Adicionando a routes
            $this->addRoute($name, $nameWithoutSpace);

            // Adicionando a routes
            $pathToView = resource_path() . "/views/cms/$slug";
            $this->verifyDIR($pathToView);
            $this->makeViews("$pathToView/", $slug, $request->generator);

            Artisan::call('migrate');
        } catch (Exception $exception) {
            dd($exception);
        }

        return redirect()->route('cruds.index');
    }

    public function edit($id)
    {
        return view('cms.cruds.create', [
            'title' => $this->title,
            'data' => $this->table->where('id', $id)->first()
        ]);
    }

    public function update(CrudRequest $request, $id)
    {
        try {
            if ($this->repository->upInsert($request, $id)) {
                // flash('Registro atualizado com sucesso.')->success();
                return redirect()
                    ->route('cruds.index', [$id])
                    ->with('success', 'Registro cadastro com sucesso');
            }
        } catch (Exception $exception) {
            // flash($exception->getMessage())->error();
        }
        // flash('Ocorreu um erro ao tentar cadastrar o registro.')->error();
        return redirect()->back();
    }
}
