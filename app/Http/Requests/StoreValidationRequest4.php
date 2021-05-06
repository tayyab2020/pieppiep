<?php

namespace App\Http\Requests;

use http\Env\Request;
use Illuminate\Foundation\Http\FormRequest;

class StoreValidationRequest4 extends FormRequest
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
            'slug'=>'unique:services,slug,'.$request->service_id.',id,deleted_at,NULL',
            'photo' => 'mimes:jpeg,jpg,png',
            'email' => 'unique:users|unique:admins',
            'logo'  => 'mimes:jpeg,jpg,png',
            'favicon'  => 'mimes:ico'
        ];
    }

    public function messages()
    {
        return [
            'title.unique' => 'This title has already been taken.',
            'slug.unique' => 'This slug has already been taken.',
        ];
    }
}
