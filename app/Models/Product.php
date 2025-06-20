<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'color',
        'price',
        'image',
        'image_hover',
        'in_stock'
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'in_stock' => 'boolean'
    ];

    public function getImageUrlAttribute()
    {
        return $this->image ? asset($this->image) : null;
    }

    public function getImageHoverUrlAttribute()
    {
        return $this->image_hover ? asset($this->image_hover) : null;
    }

    public function scopeInStock($query)
    {
        return $query->where('in_stock', true);
    }
}