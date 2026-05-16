<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Laravel\Scout\Searchable;

class Product extends Model
{
    use HasFactory, Searchable;

    public function searchableAs()
    {
        return 'products_index';
    }

    public function toSearchableArray()
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'price' => $this->price,
            'category_id' => $this->category_id,
        ];
    }

    protected $fillable = [
        'category_id',
        'name',
        'slug',
        'description',
        'price',
        'stock',
        'image_url',
        'video_url',
        'type',
        'supplier_id',
        'promo_price',
        'is_promo',
    ];

    /**
     * Auto-convert Google Drive links to direct display links.
     */
    public function getImageUrlAttribute($value)
    {
        if (!$value) return null;
        
        // PHP 7.4 support: use strpos instead of str_contains
        if (strpos($value, 'drive.google.com') !== false) {
            // Extract file ID using regex
            if (preg_match('/(?:\/d\/|id=)([\w-]+)/', $value, $matches)) {
                // Use thumbnail API for more reliable web embedding
                return "https://drive.google.com/thumbnail?id=" . $matches[1] . "&sz=w1000";
            }
        }
        
        return $value;
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class)->where('is_approved', true);
    }

    public function averageRating()
    {
        return $this->reviews()->avg('rating') ?: 0;
    }

    public function reviewCount()
    {
        return $this->reviews()->count();
    }
}
