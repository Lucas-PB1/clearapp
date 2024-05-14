<?php

namespace App\Http\Requests;

use App\Http\Traits\AppTrait;
use Illuminate\Foundation\Http\FormRequest;

class RedesSociaisRequest extends FormRequest
{
    use AppTrait;

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [

            'nome' => ['required'],
            'icone' => ['required'],

        ];
    }

    public function messages(): array
    {
        return [
            '*.required' => 'Este campo é obrigatório.',
        ];
    }
}
