<?php

namespace App\Models;

use App\Http\Requests\Products\CreateProductRequest;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * Class Product
 * @package App\Models
 * @property int id
 * @property string title
 * @property float price
 * @property int|null eId
 * @property Category[]|Collection|Category categories
 */
class Product extends Model
{
    use HasFactory;

    const MAX_TITLE_LENGTH = 12;
    const MIN_TITLE_LENGTH = 3;
    const MAX_PRICE = 200;
    const MIN_PRICE = 0;

    public static $rules = [
        'eId' => 'nullable|int',
        'title' => 'required|string|min:' . self::MIN_TITLE_LENGTH . '|max:' . self::MAX_TITLE_LENGTH,
        'price' => 'required|numeric|min:' . self::MIN_PRICE . '|max:' . self::MAX_PRICE,
    ];

    protected $fillable = [
        'title',
        'price',
        'eId',
    ];

    /**
     * @return BelongsToMany
     */
    public function categories() : BelongsToMany
    {
        return $this->belongsToMany(Category::class, 'product_categories', 'product_id', 'category_id');
    }

    /**
     * Listen for save event
     */
    protected static function boot()
    {
        parent::boot();

        static::saving(function($model)
        {
            $result = ($validtor = app('validator')->make($model->attributes, self::$rules))->passes();
            return $result;
        });
    }

}
