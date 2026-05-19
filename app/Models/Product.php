<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $table = 'store_products'; // Updated to reference 'store_products' table  from migration (Table name)
    protected $fillable = ['name', 'description', 'price'];

    public function orders()
    {
        return $this->belongsToMany(Order::class, 'order_products');
    }

    protected function casts(): array
    {
        return [
            'price' => 'float',
        ];
    }
}
