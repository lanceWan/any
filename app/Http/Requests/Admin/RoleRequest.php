<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class RoleRequest extends FormRequest
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
        $rules['name'] = 'required';
        // 添加角色
        if (request()->isMethod('POST')) {
            $rules['slug'] = 'required|unique:roles,slug';
        }else{
            // 修改时 request()->method() 方法返回的是 PUT或PATCH
            $rules['slug'] = [
                'required',
                Rule::unique('roles')->ignore(decodeId(request()->route('role'), 'role')),
            ];
        }
        return $rules;
    }
    
    public function messages()
    {
        return [
            'required'  => trans('validation.required'),
            'unique'    => trans('validation.unique'),
        ];
    }
    
    public function attributes()
    {
        return [
            'name'  => trans('role.name'),
            'slug'  => trans('role.slug'),
        ];
    }
}
