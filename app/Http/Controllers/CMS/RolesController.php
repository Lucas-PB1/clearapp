<?php

namespace App\Http\Controllers\CMS;

use Exception;
use Illuminate\Http\Request;
use App\Http\Traits\AppTrait;
use App\Http\Traits\LogTrait;
use Spatie\Permission\Models\Role;
use App\Http\Requests\RolesRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Permission;
use App\Repositories\Eloquent\Roles\RolesRepository;

class RolesController extends Controller
{
    use LogTrait, AppTrait;
    public $table, $title, $repository;

    public function __construct(RolesRepository $repository)
    {
        $this->repository = $repository;
        $this->table = new Role();
        $this->title = 'Cargos';
    }

    public function index()
    {
        $this->generateLog($this->title, __FUNCTION__);
        return view('cms.profile.roles.index');
    }

    public function indexAPI()
    {
        $user = Auth::user();
        $canEdit = $user ? $user->can('update_cargos') : false;
        $canDelete = $user ? $user->can('delete_cargos') : false;

        return response()->json(
            [
                'content' => $this->table
                    ->orderBy('id', "DESC")
                    ->get(
                        [
                            'id',
                            'name as Nome'
                        ]
                    ),
                'tableName' => $this->table->getTable(),
                'perm_edit' => $canEdit,
                'perm_delete' => $canDelete
            ],
            200
        );
    }

    public function create()
    {
        $this->generateLog($this->title, __FUNCTION__);
        return view('cms.profile.roles.create', ['title' => $this->title]);
    }

    public function store(RolesRequest $request)
    {
        try {
            $resultado = $this->repository->upInsert($request);
            if ($resultado) {
                $this->generateLog($this->title, __FUNCTION__, $request);

                return redirect()
                    ->route('cargos.index', [$resultado])
                    ->with('success', 'Registro cadastro com sucesso');
            }
        } catch (Exception $exception) {
        }

        // $this->error($this->title, __FUNCTION__);
        return redirect()->back();
    }

    public function edit($id)
    {
        $this->generateLog($this->title, __FUNCTION__, null, $id);

        $permissions = [];
        foreach (Permission::all() as $perm) {
            array_push($permissions, $perm->desc);
        }
        $permissions = array_unique($permissions);

        return view('cms.profile.roles.create', [
            'roles' => Role::all(),
            'title' => $this->title,
            'permissions' => $permissions,
            'data' => $this->table->where('id', $id)->first(),
        ]);
    }

    public function update(RolesRequest $request, $id)
    {
        try {
            if ($this->repository->upInsert($request, $id)) {
                $this->generateLog($this->title, __FUNCTION__, $request, $id);

                // $this->success($this->title, __FUNCTION__);
                return redirect()->route('cargos.index');
            }
        } catch (Exception $exception) {
        }

        // $this->error($this->title, __FUNCTION__);
        return redirect()->back();
    }

    public function managePerms(Request $request)
    {
        try {
            $role = Role::find($request->cargo_id);
            if ($request->checked) {
                $role->givePermissionTo($request->perm);
            } else {
                $role->revokePermissionTo($request->perm);
            }

            return response()->json(['success' => 'Registro atualizado com sucesso.'], 200);
        } catch (\Throwable $th) {
            return response()->json(['erro' => 'Ocorreu um erro! Por favor entre em contato com o suporte técnico.'], 500);
        }
    }
}
