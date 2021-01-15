<?php

namespace App\Services\Interfaces;
use App\Models\Product;

/**
 * Class ProductService
 * @package App\Services\Interfaces
 */
interface ProductService
{
    /**
     * @param array $productData
     * @return Product
     */
    public function create(array $productData) : Product;

    /**
     * @param Product $product
     * @param array $productData
     * @return Product
     */
    public function update(Product $product, array $productData) : Product;

    /**
     * @param Product $product
     * @return bool|null
     * @throws \Exception
     */
    public function delete(Product $product): ?bool;
}