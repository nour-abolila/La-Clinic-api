<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'price',
        'stock',
        'status',
        'category_id',
    ];

    protected $casts = [
        'price' => 'float',
        'stock' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];


    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    // local scope to filter active products
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    // method to check if product is in stock
    public function isInStock(): bool
    {
        return $this->stock > 0;
    }

    public function cartItems()
    {
        return $this->hasMany(CartItem::class);
    }


    protected static function booted()
    {
        static::creating(function ($product) {
            $product->slug = Str::slug($product->name);
        });

        static::updating(function ($product) {
            $product->slug = Str::slug($product->name);
        });
    }
}
