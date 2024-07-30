<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
/*статус */
class Status extends Model
{
    protected $table = 'status';
    protected $fillable = ['id','name'];

    public function review()
    {
        return $this->hasMany(Review::class);
    }
    public function order()
    {
        return $this->hasMany(Order::class);
    }
    use HasFactory;
}
