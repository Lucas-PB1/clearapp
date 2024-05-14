<?php

namespace App\Http\Controllers;

use App\Http\Traits\FileTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GaleryController extends Controller
{
    use FileTrait;

    public function store(Request $request, $table, $id)
    {
        $table = resolve("App\\Models\\CMS\\" . ucfirst($table))->getTable();
        if ($this->fileSave($request->file('file'), $id, $table)) {
            return response()->json(['success' => 'Adicionado a galeria com sucesso.'], 200);
        } else {
            return response()->json(['erro' => 'Ocorreu um erro! Por favor entre em contato com o suporte técnico.'], 500);
        }
    }

    public function fileSave($file, $id, $table)
    {
        try {
            $this->uploadFileWithDetails($file, "$table/$id/galeria", $table, $id, 'Imagem de galeria');
            return true;
        } catch (\Throwable $th) {
            return false;
        }
    }

    public function galery($table, $id)
    {
        $modelInstance = resolve("App\\Models\\CMS\\" . ucfirst($table));
        // dd($modelInstance);
        return response()->json($modelInstance::where('id', $id)->with('galeria')->first()->galeria, 200);
    }

}
