<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;

class Compare extends Model
{
    use HasFactory;

    // category relation with product fatch from db
    public function product()
    {
        return $this->belongsTo('App\Product', 'product_id');
    }
}
