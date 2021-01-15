<?php

namespace App\Services;
use App\Models\Category;

/**
 * Class CategoryService
 * @package App\Services
 */
class CategoryService implements \App\Services\Interfaces\CategoryService
{

    /**
     * @param array $categoryData
     * @return Category
     */
    public function create(array $categoryData): Category
    {
        return Category::query()->create($categoryData);
    }
}