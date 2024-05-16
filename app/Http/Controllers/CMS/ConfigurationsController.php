<?php

namespace App\Http\Controllers\CMS;

use Exception;
use App\Http\Traits\LogTrait;
use App\Http\Traits\FileTrait;
use App\Models\CMS\Configuracoes;
use App\Http\Controllers\Controller;
use App\Http\Requests\ConfiguracoesRequest;
use App\Repositories\Eloquent\Configurações\ConfiguracoesRepository;

class ConfigurationsController extends Controller
{
    use FileTrait, LogTrait;

    public $title, $repository, $table;

    public function __construct(ConfiguracoesRepository $repository)
    {
        $this->title = 'Configurações';
        $this->repository = $repository;
        $this->table = new Configuracoes();
    }

    public function index()
    {
        $this->generateLog($this->title, __FUNCTION__);
        return view('cms.configuracoes.index', ['title' => $this->title, 'config' => $this->table->with('destaque')->get()]);
    }

    public function update(ConfiguracoesRequest $request)
    {
        try {
            foreach ($request->all() as $key => $value) {
                $data = $this->table->where('slug', $key)->first();

                if ($data) {
                    $this->generateLog($this->title, __FUNCTION__, $request, $data->id);

                    if ($key == 'logo')
                        $this->fileSaveDestaque($request, $data->id, 'logo', $this->table->getTable());

                    $data->valor = $value;
                    $data->save();
                }
            }

            return redirect()->route('config.index');
        } catch (Exception $exception) {
        }
        return redirect()->back();
    }
}
