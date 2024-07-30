<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
/*статус отзывов*/
class StatusReview extends Model
{
    protected $table = 'status_reviews';
    protected $fillable = ['id','name'];
    public function review()
    {
        return $this->hasMany(Review::class);
    }
    use HasFactory;
}
