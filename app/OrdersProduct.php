<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrdersProduct extends Model
{
    use HasFactory;
    public function order_details()
    {
        return $this->belongsTo('App\Order', 'order_id');
    }
}
