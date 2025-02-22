<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/*атрибуты товаров*/
class Attribute extends Model
{
    protected $fillable = ['id','name'];

    public function values()
    {
        return $this->hasMany(AttributeValue::class);
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'attribute_values')->withPivot('value');
    }
    use HasFactory;
}
