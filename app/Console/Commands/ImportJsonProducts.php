<?php

namespace App\Console\Commands;

use App\Http\Requests\Products\CreateProductRequest;
use App\Models\Category;
use Facades\App\Services\Interfaces\CategoryService;
use Facades\App\Services\Interfaces\ProductService;
use Illuminate\Console\Command;
use Illuminate\Support\Arr;

class ImportJsonProducts extends Command
{
    const CATEGORIES_FILE = 'categories.json';
    const PRODUCTS_FILE = 'products.json';
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'parse:json';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Parse '. self::PRODUCTS_FILE .' and '. self::CATEGORIES_FILE .' and saving to DB';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $categories = $this->parseCategories();
        $this->parseProducts($categories);
        return 0;
    }

    private function parseCategories() : array
    {
        $categories = json_decode(file_get_contents(self::CATEGORIES_FILE), true)?: [];
        foreach ($categories as $i => $category) {
            $categories[$i] = CategoryService::create($category);
        }
        return $categories;
    }

    private function parseProducts(array $categories)
    {
        $products = json_decode(file_get_contents(self::PRODUCTS_FILE), true)?: [];
        foreach ($products as $i => $product) {
            $products[$i] = $p = ProductService::create($product);
            if ($p->exists) $p->categories()->saveMany(
                Arr::where($categories, function($c) use ($product) {
                    return array_search($c->eId, dump($product)['categoriesEId']);
            }));
        }
    }
}
