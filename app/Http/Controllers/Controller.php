<?php

namespace App\Http\Controllers;

use App\Http\Traits\AppTrait;
use Exception;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests, AppTrait;

    protected $title;
    protected $table;
    protected $campos;
    protected $repository;

    public function index()
    {
        return view('cms.' . slug_fix($this->title, '-') . '.index', ['title' => $this->title]);
    }

    public function indexAPI()
    {
        $user = Auth::user();
        $canEdit = $user ? $user->can('update_'. slug_fix($this->title)) : false;
        $canDelete = $user ? $user->can('delete_' . slug_fix($this->title)) : false;

        $formattedColumns = $this->formatColumns($this->campos);

        return response()->json([
            'content' => $this->table
                ->orderBy('id', 'DESC')
                ->select($formattedColumns)
                ->get(),
            'tableName' => $this->table->getTable(),
            'perm_edit' => $canEdit,
            'perm_delete' => $canDelete
        ], 200);
    }

    public function create()
    {
        return view('cms.' . slug_fix($this->title, '-') . '.create', ['title' => $this->title]);
    }

    
    public function edit($id)
    {
        return view('cms.' . slug_fix($this->title, '-') . '.create', [
            'title' => $this->title,
            'data' => $this->table->where('id', $id)->first()
        ]);
    }

    public function storehas(Request $request)
    {
        try {
            $resultado = $this->repository->upInsert($request);
            if ($resultado) {
                return redirect()
                    ->route(slug_fix($this->title, '-') . '.index', [$resultado])
                    ->with('success', 'Registro cadastrado com sucesso');
            }
        } catch (Exception $exception) {
            // Log de erro ou tratativa específica
        }
        return redirect()->back();
    }

    public function updatehas(Request $request, $id)
    {
        try {
            if ($this->repository->upInsert($request, $id)) {
                return redirect()
                    ->route(slug_fix($this->title, '-') . '.index', [$id])
                    ->with('success', 'Registro atualizado com sucesso');
            }
        } catch (Exception $exception) {
            // Log de erro ou tratativa específica
        }
        return redirect()->back();
    }
}
