<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WarrantyRegistration extends Model
{
    use HasFactory;

    protected $table = 'warranty_registrations';

    // Specify which fields are mass assignable
    protected $fillable = [
        'first_name',
        'last_name',
        'contact_no',
        'product',
        'product_name',
        'serial_no',
        'purchase_date',
        'receipt_no',
        'receipt_image_path',
        'product_image_path',
//        'video_path',
        'store_name',
        'facebook_account_link',
        'status',
    ];

    protected $casts = [
        'purchase_date' => 'datetime:Y-m-d',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function productName()
    {
        return $this->belongsTo(ProductName::class, 'product_name_id');
    }
}
