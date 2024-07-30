<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
/*заказы*/
class Order extends Model
{
    use HasFactory;
    protected $fillable = ['user_id', 'products', 'total','status_id','payment_type_id','receiving_type_id','phone','email','FIO','address','comment'];

    protected $casts = [
        'items' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function status()
    {
        return $this->belongsTo(Status::class);
    }
    public function paymentType()
    {
        return $this->belongsTo(PaymentType::class);
    }
    public function receivingType()
    {
        return $this->belongsTo(ReceivingType::class);
    }
}
