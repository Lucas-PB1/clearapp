<?php

namespace App\Http\Requests;

use App\Http\Traits\AppTrait;
use Illuminate\Foundation\Http\FormRequest;

class ConfiguraçõesRequest extends FormRequest
{
    use AppTrait;

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [];
    }

    public function messages(): array
    {
        return [];
    }
}
