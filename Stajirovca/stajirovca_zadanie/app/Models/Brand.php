<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
/*бренды*/
class Brand extends Model
{
    protected $table = 'brands';
    protected $fillable = ['id','name'];
    public function products()
    {
        return $this->hasMany(Product::class);
    }
    use HasFactory;
}
