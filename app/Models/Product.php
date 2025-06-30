<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'name', 'description', 'price', 'discount_price', 'brand', 'specs', 'image', 'category_id',
    ];

    protected $casts = [
        'specs' => 'array', // Для JSON-поля specs
    ];

    // Определяем отношение с категорией
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}