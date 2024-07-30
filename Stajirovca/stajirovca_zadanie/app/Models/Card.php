<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
/*информационные карточки*/
class Card extends Model
{
    protected $table = 'cards';
    protected $fillable = ['id','title','description','status'];
    public $timestamps = false;
    use HasFactory;
}
