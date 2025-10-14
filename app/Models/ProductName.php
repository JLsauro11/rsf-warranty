<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductName extends Model
{
    use SoftDeletes;

    protected $table = 'product_name';

    protected $fillable = ['product_id', 'model_code', 'model_label'];

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}
