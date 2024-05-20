<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'description',
        'cover',
        'price',
        'compare_price',
        'sku',
        'barcode',
        'track_qty',
        'qty',
        'status',
        'category_id',
        'sub_category_id',
        'brand_id',
        'is_featured',
        'related_product'
    ];

    public function Images()
    {
        return $this->hasMany(Image::class);
    }
}
