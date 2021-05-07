<?php

namespace App\Http\Requests;

use http\Env\Request;
use Illuminate\Foundation\Http\FormRequest;

class StoreValidationRequest5 extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(\Illuminate\Http\Request $request)
    {
        return [
            'color_code'=>'unique:colors,color_code,'.$request->id.',id,deleted_at,NULL',
        ];
    }

    public function messages()
    {
        return [
            'color_code.unique' => 'This code has already been taken.',
        ];
    }
}
