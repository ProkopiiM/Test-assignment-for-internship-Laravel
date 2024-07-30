<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
/*рекомендованные товары*/
class RecommendProduct extends Model
{
    protected $fillable = ['product_id'];
    public $timestamps = false;
    public function products()
    {
        return $this->hasMany(Product::class);
    }
    use HasFactory;
}
