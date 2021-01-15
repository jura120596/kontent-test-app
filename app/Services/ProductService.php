<?php

namespace App\Services;


use App\Models\Product;

/**
 * Class ProductService
 * @package App\Services
 */
class ProductService implements \App\Services\Interfaces\ProductService
{

    /**
     * @param array $productData
     * @return Product
     */
    public function create(array $productData): Product
    {
        return Product::query()->create($productData);
    }

    /**
     * @param Product $product
     * @param array $productData
     * @return Product
     */
    public function update(Product $product, array $productData): Product
    {
        $product->fill($productData)->save();
        return $product;
    }

    /**
     * @param Product $product
     * @return bool|null
     * @throws \Exception
     */
    public function delete(Product $product): ?bool
    {
        return $product->delete();
    }
}