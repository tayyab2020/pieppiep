<?php

namespace App\Http\Requests;

use http\Env\Request;
use Illuminate\Foundation\Http\FormRequest;

class StoreValidationRequest6 extends FormRequest
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
            'title'=>'unique:price_tables,title,'.$request->id,
        ];
    }

    public function messages()
    {
        return [
            'title.unique' => 'This name has already been taken.',
        ];
    }
}
