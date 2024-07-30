<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
/*товары и сопуствтвующие товары*/
class ProductBonds extends Model
{
    protected $fillable = ['product_id', 'bond_id'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
    public function bond()
    {
        return $this->belongsTo(Product::class);
    }

    use HasFactory;
}
