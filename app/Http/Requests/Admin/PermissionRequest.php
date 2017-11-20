<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
class PermissionRequest extends FormRequest
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
        // 添加权限
        if (request()->isMethod('POST')) {
            $rules['slug'] = 'required|unique:permissions,slug';
        }else{
            // 修改时 request()->method() 方法返回的是 PUT或PATCH
            $rules['slug'] = [
                'required',
                Rule::unique('permissions')->ignore(decodeId(request()->route('permission'), 'permission')),
            ];
        }
        return $rules;
    }

    /**
     * 验证信息
     * @Author   晚黎
     * @DateTime 2017-07-26T22:24:11+0800
     * @return   [type]                   [description]
     */
    public function messages()
    {
        return [
            'required'  => trans('validation.required'),
            'unique'    => trans('validation.unique'),
        ];
    }
    
    /**
     * 字段名称
     * @Author   晚黎
     * @DateTime 2017-07-26T22:24:19+0800
     * @return   [type]                   [description]
     */
    public function attributes()
    {
        return [
            'name'  => trans('permission.name'),
            'slug'  => trans('permission.slug'),
        ];
    }
}
