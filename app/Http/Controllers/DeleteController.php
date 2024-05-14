<?php

namespace App\Http\Controllers;

use Exception;
use PDOException;
use App\Http\Traits\LogTrait;
use App\Services\ModelResolver;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class DeleteController extends Controller
{
    use LogTrait;
    public function delete($tabela, $id)
    {
        try {
            $modelResolver = new ModelResolver();
            $modelClass = $modelResolver->getModelClassFromTableName($tabela);
            if (!$modelClass) return response()->json(['erro' => 'Tabela não suportada ou Model não encontrada.'], 400);

            $modelClass = resolve($modelClass);
            $data = $modelClass->where('id', $id)->first();

            $this->generateLog($tabela, __FUNCTION__, $data, $id);

            if ($modelClass->destroy($id))
                return response()->json(['success' => 'Deletado com sucesso.'], 200);

            return response()->json(['erro' => 'Ocorreu um erro! Por favor entre em contato com o suporte técnico.'], 500);
        } catch (PDOException $exception) {
            return response()->json(['erro' => 'Ocorreu um erro ao tentar salvar no banco de dados.'], 500);
        } catch (Exception $e) {
            return response()->json(['erro' => 'Ocorreu um erro! Por favor entre em contato com o suporte técnico.'], 500);
        }
    }
}
