<?php

namespace App\Http\Requests\Products;

use App\Models\Product;
use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends CreateProductRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'eId' => 'nullable|int',
            'title' => str_replace('required|', '', parent::rules()['title']),
            'price' => str_replace('required|', '', parent::rules()['price']),
        ];
    }
}
