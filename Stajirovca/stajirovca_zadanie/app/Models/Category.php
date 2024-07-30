<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
/*категории товаров*/
class Category extends Model
{
    protected $fillable = ['id','name','description'];

    public function products()
    {
        return $this->hasMany(Product::class);
    }
    use HasFactory;
}
