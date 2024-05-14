<?php

namespace App\Http\Controllers\CMS;

use Exception;
use Illuminate\Http\Request;
use App\Http\Traits\LogTrait;
use App\Http\Traits\AppTrait;
use App\Models\CMS\RedesSociais;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Http\Requests\RedesSociaisRequest;
use App\Repositories\Contracts\IRedesSociaisRepository;
use App\Repositories\Eloquent\RedesSociais\RedesSociaisRepository;

class RedesSociaisController extends Controller
{
    use LogTrait, AppTrait;

    public $title, $repository, $table;

    public function __construct(RedesSociaisRepository $repository)
    {
        $this->title = 'Redes Sociais';
        $this->repository = $repository;
        $this->table = new RedesSociais();
    }

    public function index()
    {
        $this->generateLog($this->title, __FUNCTION__);
        return view('cms.redes-sociais.index', ['title' => $this->title]);
    }

    public function indexAPI()
    {
        $user = Auth::user();
        $canEdit = $user ? $user->can('update_redes-sociais') : false;
        $canDelete = $user ? $user->can('delete_redes-sociais') : false;

        $columns = [
            'id',
            'nome as Nome',
            'link as Link'
        ];

        $formattedColumns = $this->formatColumns($columns);

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
        $this->generateLog($this->title, __FUNCTION__);
        return view('cms.redes-sociais.create', ['title' => $this->title]);
    }

    public function store(RedesSociaisRequest $request)
    {
        try {
            $resultado = $this->repository->upInsert($request);
            if ($resultado) {
                $this->generateLog($this->title, __FUNCTION__, $request);

                return redirect()
                    ->route('redes-sociais.index', [$resultado])
                    ->with('success', 'Registro cadastro com sucesso');
            }
        } catch (Exception $exception) {
        }
        return redirect()->back();
    }

    public function edit($id)
    {
        $this->generateLog($this->title, __FUNCTION__, null, $id);
        return view('cms.redes-sociais.create', [
            'title' => $this->title,
            'data' => $this->table->where('id', $id)->first()
        ]);
    }

    public function update(RedesSociaisRequest $request, $id)
    {
        try {
            if ($this->repository->upInsert($request, $id)) {
                $this->generateLog($this->title, __FUNCTION__, $request, $id);

                return redirect()
                    ->route('redes-sociais.index', [$id])
                    ->with('success', 'Registro cadastro com sucesso');
            }
        } catch (Exception $exception) {
        }
        return redirect()->back();
    }
}
