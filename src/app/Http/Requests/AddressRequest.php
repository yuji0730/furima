<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddressRequest extends FormRequest
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
        $rules = [
            'postal' => 'required|size:8',
            'address' => 'required',
            'building' => 'required',
        ];

        if ($this->routeIs('profile.update')) {
            $rules['name'] = 'required';
        } else {
            $rules['item_id'] = 'required|integer|exists:items,id';
        }

        return $rules;
    }

    public function messages()
    {
        return [
            'name.required' => 'お名前を入力してください',
            'postal.required' => '郵便番号を入力してください',
            'postal.size' => '郵便番号はハイフンありの8文字で入力してください',
            'address.required' => '住所を入力してください',
            'building.required' => '建物名を入力してください',
        ];
    }
}
