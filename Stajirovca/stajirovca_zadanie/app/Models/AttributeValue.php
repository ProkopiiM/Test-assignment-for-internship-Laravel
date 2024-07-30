<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
/*связь атрибутов и товаров*/
class AttributeValue extends Model
{
    protected $fillable = ['product_id', 'attribute_id', 'value'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function attribute()
    {
        return $this->belongsTo(Attribute::class);
    }
    use HasFactory;
}
