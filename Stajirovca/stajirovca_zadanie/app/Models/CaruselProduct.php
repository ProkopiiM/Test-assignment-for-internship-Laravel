<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
/*слайдер на главной странице*/
class CaruselProduct extends Model
{
    protected $fillable = ['id','product_id'];
    public $timestamps= false;
    use HasFactory;
}
