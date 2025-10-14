<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;

    protected $table = 'product';

    protected $fillable = ['product_code', 'product_label'];

    public function productNames()
    {
        return $this->hasMany(ProductName::class, 'product_id');
    }
}

