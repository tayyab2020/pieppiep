<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FormValidationRequest extends FormRequest
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
    public function rules()
    {
        return [
            'group_name'=>'unique:bloodgroups',
            'group_slug'=>'unique:bloodgroups',
            'photo' => 'mimes:jpeg,jpg,png',
            'email' => 'unique:donors|unique:admins',

        ];
    }

    public function messages()
    {
    return [
         'group_name.unique' => 'This name has already been taken.',
         'group_slug.unique' => 'This slug has already been taken.',
    ];
    }
}
