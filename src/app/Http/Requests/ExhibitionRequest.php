<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ExhibitionRequest extends FormRequest
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
            'name' => 'required',
            'price' => 'required|numeric|min:0',
            'image' => 'required|mimes:jpeg,png',
            'description' => 'required|max:255',
            'condition' => 'required',
            'categories' => 'required|array',
            'categories.*' => 'integer|exists:categories,id',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => '商品名を入力してください',
            'price.required' => '商品価格を入力してください',
            'price.numeric' => '商品価格は数値型で入力してください',
            'price.min' => '商品価格は0円以上で入力してください',
            'image.required' => '商品画像を選択してください',
            'image.mimes' => '拡張子が.jpegもしくは.pngのファイルにしてください',
            'description.required' => '商品説明を入力してください',
            'description.max' => '商品説明は255文字以下で入力してください',
            'condition.required' => '商品の状態を選択してください',
            'categories.required' => 'カテゴリーを選択してください',
        ];
    }
}
