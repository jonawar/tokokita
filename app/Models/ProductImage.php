<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductImage extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'image_url',
        'is_primary',
    ];

    /**
     * Auto-convert Google Drive links to direct display links.
     */
    public function getImageUrlAttribute($value)
    {
        if (!$value) return null;
        
        if (strpos($value, 'drive.google.com') !== false) {
            if (preg_match('/(?:\/d\/|id=)([\w-]+)/', $value, $matches)) {
                return "https://drive.google.com/thumbnail?id=" . $matches[1] . "&sz=w1000";
            }
        }
        
        return $value;
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
