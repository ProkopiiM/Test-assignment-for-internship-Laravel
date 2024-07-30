<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
/*товары*/
class Product extends Model
{
    protected $fillable = ['name', 'description', 'price', 'discount', 'quantity', 'sku', 'category_id', 'brand_id','manufacture_id','date','main_image'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }
    public function manufacture()
    {
        return $this->belongsTo(Manufacture::class);
    }

    public function images()
    {
        return $this->hasMany(PhotoProduct::class);
    }

    public function attributeValues()
    {
        return $this->hasMany(AttributeValue::class);
    }

    public function attributes()
    {
        return $this->belongsToMany(Attribute::class, 'attribute_values')->withPivot('value');
    }

    public function getAttributesWithNamesAttribute()
    {
        $attributes = $this->attributes()->get();
        $attributes_with_names = $attributes->map(function ($attribute) {
            return [
                'id' => $attribute->id,
                'name' => $attribute->name,
                'value' => $attribute->pivot->value,
                'attribute_id' => $attribute->id,
            ];
        });
        return $attributes_with_names;
    }
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
    public function bond()
    {
        return $this->hasMany(ProductBonds::class);
    }
    public function getReviewsWithUserAttribute()
    {
        return $this->reviews()->with('user')->get()->map(function ($review) {
            return [
                'id' => $review->id,
                'user_id' => $review->user_id,
                'user_name' => $review->user->name,
                'star' => $review->star,
                'review' => $review->review,
                'status' => $review->status_id,
                'created_at' => $review->created_at,
            ];
        });
    }
    public function getBondsWithProductAttribute()
    {
        return $this->bond()->with('product')->get()->map(function ($bond) {
            return [
                'id' => $bond->id,
                'product_id' => $bond->product_id,
                'product_name' => $bond->product->name,
                'bond_id' => $bond->bond_id,
                'bond_name' => $bond->bond->name,
            ];
        });
    }
    public function getManufacturesProduct()
    {
        return $this->manufacture()->with('product')->get()->map(function ($manufactures) {
            return [
                'id' => $manufactures->id,
                'name' => $manufactures->name
            ];
        });
    }
    public function getCategoryProduct()
    {
        return $this->category()->with('products')->get()->map(function ($ca) {
            return [
                'id' => $ca->id,
                'name' => $ca->name
            ];
        });
    }
    public function getBrandProduct()
    {
        return $this->brand()->with('products')->get()->map(function ($brand) {
            return [
                'id' => $brand->id,
                'name' => $brand->name
            ];
        });
    }
    protected $appends = ['attributes_with_names','reviews_with_user','bonds_with_product','manufactures_with_product','category_product','brand_product'];
    use HasFactory;
}
