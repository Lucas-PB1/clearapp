<?php

namespace App\Http\Controllers\CMS;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Traits\AppTrait;
use App\Http\Traits\LogTrait;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\ProfileUpdateRequest;

class UserController extends Controller
{
    use AppTrait, LogTrait;
    public $table, $title;

    public function __construct()
    {
        $this->table = new User();
        $this->title = 'Usuário';
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->generateLog($this->title, __FUNCTION__);
        return view('cms.profile.index');
    }

    public function indexAPI()
    {
        $user = Auth::user();
        $canEdit = $user ? $user->can('update_usuarios') : false;
        $canDelete = $user ? $user->can('delete_usuarios') : false;

        $items = ['id', 'name as Nome', 'email as E-mail'];
        $data = $this->table
            ->orderBy('id', "DESC")
            ->get($items);

        $newData = [];
        foreach ($data as $item) {
            $item['Perfis'] = User::find($item['id'])->getRoleNames();
            $newData[] = $item;
        }

        return response()->json(
            [
                'content' => $newData,
                'tableName' => $this->table->getTable(),
                'perm_edit' => $canEdit,
                'perm_delete' => $canDelete
            ],
            200
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->generateLog($this->title, __FUNCTION__);
        return view('cms.profile.create', ['roles' => Role::all()]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'password' => ['required', 'string', 'min:8', 'confirmed'],
                'roles' => ['required', 'array'],
                'roles.*' => ['exists:roles,name']
            ]);

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            $user->assignRole($request->roles);
            $this->generateLog($this->title, __FUNCTION__, $request);

            // $this->success($this->title, __FUNCTION__);
            return redirect()->route('usuarios.index');
        } catch (\Throwable $th) {
        }

        // $this->error($this->title, __FUNCTION__);
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $roles = Role::all();
        $this->generateLog($this->title, __FUNCTION__, null, $id);

        return view('cms.profile.edit', [
            'user' => User::find($id),
            'roles' => $roles,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProfileUpdateRequest $request, string $id)
    {
        $user = User::find($id);
        $user->fill($request->validated());

        if ($user->isDirty('email'))
            $user->email_verified_at = null;

        $roles = $request->input('roles');
        $user->syncRoles($roles);

        if ($user->save()) {
            // $this->success($this->title, __FUNCTION__);
            // $this->generateLog($this->title, __FUNCTION__, $request, $id);
            return Redirect::route('usuarios.edit', $id);
        }

        // $this->error($this->title, __FUNCTION__);
        return Redirect::route('usuarios.edit', $id);
    }

    public function destroy(Request $request, $id)
    {
        $user = User::find($id);
        $request->validateWithBag('userDeletion', ['password' => ['required', 'current_password']]);

        if ($user->id == Auth::user()->id) {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
        }

        $user->delete();
        return Redirect::to('/');
    }
}
