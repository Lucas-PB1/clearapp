<?php

namespace App\Http\Requests;

use App\Http\Traits\AppTrait;
use Illuminate\Foundation\Http\FormRequest;

class CrudRequest extends FormRequest
{
    use AppTrait;

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [

            'titulo' => ['required'],

        ];
    }

    public function messages(): array
    {
        return [

            'titulo.required' => 'Este campo é obrigatório.',

        ];
    }
}
