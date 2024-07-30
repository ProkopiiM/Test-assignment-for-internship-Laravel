<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
/*фотографии товаров*/
class PhotoProduct extends Model
{

    protected $fillable = ['product_id', 'photo_path'];
    use HasFactory;
}
