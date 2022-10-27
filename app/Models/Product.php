<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    public $timestamps = false;

    /**
     * Get the promotions for the product.
     */
    public function promotions()
    {
        return $this->hasMany(Promotion::class);
    }
}
