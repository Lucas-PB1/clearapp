<?php

namespace App\Http\Traits;

use App\Models\CMS\Logs;
use Illuminate\Support\Facades\Auth;

trait LogTrait
{
    public function generateLog($modulo, $operacao, $dados = null, $registro = false)
    {
        if (isset($dados) && $operacao != 'delete'){
            $dados = $this->returnKeyValueRequest($dados->all());
        }elseif ($operacao == 'delete'){
            $dados = $this->returnKeyValueRequest(get_object_vars($dados));
        }

        $user = Auth::user()->name;

        $operacoesMap = [
            'index' => ['descricao' => 'Listagem', 'msg' => "$user listou os registros em $modulo"],
            'create' => ['descricao' => 'Criação', 'msg' => "$user iniciou o cadastro de um registro em $modulo"],
            'edit' => ['descricao' => 'Edição', 'msg' => "$user editou um registro em $modulo com id: $registro"],
            'store' => ['descricao' => 'Cadastro', 'msg' => "$user cadastrou um registro em $modulo \n$dados"],
            'update' => ['descricao' => 'Atualização', 'msg' => "$user atualizou um registro em $modulo com id: $registro \n$dados"],
            'delete' => ['descricao' => 'Deleção', 'msg' => "$user deletou um registro em $modulo com id: $registro \n$dados"]
        ];

        $descricaoOperacao = $operacoesMap[$operacao]['descricao'] ?? $operacao;
        $msg = $operacoesMap[$operacao]['msg'] ?? '';

        Logs::create([
            'modulo' => $modulo,
            'operacao' => $descricaoOperacao,
            'descricao' => $msg
        ]);
    }


    public function returnKeyValueRequest($array)
    {
        foreach (['_token', '_method', 'files', 'perms'] as $value) {
            unset($array[$value]);
        }

        return implode('', array_map(function ($key, $value) {
            return "$key: $value ";
        }, array_keys($array), $array));
    }
}
