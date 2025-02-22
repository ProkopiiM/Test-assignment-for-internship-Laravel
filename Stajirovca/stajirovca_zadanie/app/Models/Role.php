<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
/*роли*/
class Role extends Model
{
    protected $fillable = ['id','name'];
    public function users()
    {
        return $this->hasMany(User::class);
    }
    use HasFactory;
}
