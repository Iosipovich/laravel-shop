<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'items', 'total', 'status', 'name', 'email', 'address'
    ];

    protected $casts = [
        'items' => 'array', // Для хранения товаров в формате JSON
    ];
}
