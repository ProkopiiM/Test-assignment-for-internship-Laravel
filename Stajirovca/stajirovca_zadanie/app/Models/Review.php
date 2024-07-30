<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
/*отзывы*/
class Review extends Model
{
    protected $fillable = ['user_id', 'product_id', 'star', 'review','status_id'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function review()
    {
        return $this->hasMany(Review::class);
    }
    public function status()
    {
        return $this->belongsTo(StatusReview::class);
    }
    use HasFactory;
}
