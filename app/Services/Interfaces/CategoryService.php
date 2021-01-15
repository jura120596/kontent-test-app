<?php

namespace App\Services\Interfaces;
use App\Models\Category;

/**
 * Interface CategoryService
 * @package App\Services\Interfaces
 */
interface CategoryService
{
    /**
     * @param array $categoryData
     * @return Category
     */
    public function create(array $categoryData) : Category;
}