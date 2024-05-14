<?php

namespace App\Http\Requests;

use App\Http\Traits\AppTrait;
use Illuminate\Foundation\Http\FormRequest;

class RolesRequest extends FormRequest
{
    use AppTrait;

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [

            'name' => ['required'],

        ];
    }

    public function messages(): array
    {
        return [
            '*.required' => 'Este campo é obrigatório.',
        ];
    }
}
