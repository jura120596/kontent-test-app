<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * Class Category
 * @package App\Models
 * @property int id
 * @property string title
 * @property int eId
 * @property Product[]|Collection|Product products
 */
class Category extends Model
{
    use HasFactory;

    const MAX_TITLE_LENGTH = 12;

    protected $fillable = [
        'title',
        'eId',
    ];

    /**
     * @return BelongsToMany
     */
    public function products() : BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'product_categories', 'categoty_id', 'product_id');
    }
}
