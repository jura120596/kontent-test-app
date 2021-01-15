<?php

namespace App\Http\Requests\Products;

use App\Models\Product;
use Illuminate\Foundation\Http\FormRequest;

class CreateProductRequest extends FormRequest
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
            'eId' => 'nullable|int',
            'title' => 'required|string|min:' . Product::MIN_TITLE_LENGTH . '|max:' . Product::MAX_TITLE_LENGTH,
            'price' => 'required|numeric|min:' . Product::MIN_PRICE . '|max:' . Product::MAX_PRICE,
        ];
    }
}
