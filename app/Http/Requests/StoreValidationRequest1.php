<?php

namespace App\Http\Requests;

use http\Env\Request;
use Illuminate\Foundation\Http\FormRequest;

class StoreValidationRequest1 extends FormRequest
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
            /*'cat_name'=>'unique:brands,cat_name,NULL,id,deleted_at,NULL',*/
            'cat_slug'=>'unique:brands,cat_slug,'.$request->cat_id,
            'photo' => 'mimes:jpeg,jpg,png',
            'email' => 'unique:users|unique:admins',
            'logo'  => 'mimes:jpeg,jpg,png',
            'favicon'  => 'mimes:ico'
        ];
    }

    public function messages()
    {
        return [
            'cat_name.unique' => 'This name has already been taken.',
            'cat_slug.unique' => 'This slug has already been taken.',
        ];
    }
}
