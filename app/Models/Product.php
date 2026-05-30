<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'price',
        'stock',
        'rating',
        'status',
        'category_id',
    ];

    protected $casts = [
        'price' => 'float',
        'stock' => 'integer',
        'rating' => 'decimal:2',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];


    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_id');
    }


    public function orders(): BelongsToMany
    {
        return $this->belongsToMany(Order::class, 'order_products');
    }


    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }


    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }


    public function isInStock(): bool
    {
        return $this->stock > 0;
    }

    public function cartItems()
    {
        return $this->hasMany(CartItem::class);
    }
}
