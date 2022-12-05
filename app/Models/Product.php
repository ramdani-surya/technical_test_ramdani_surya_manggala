<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'category_product_id',
        'name',
        'price',
        'image',
    ];

    function categoryProduct()
    {
        return $this->belongsTo(CategoryProduct::class);
    }
}
