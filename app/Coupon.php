<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Category;

class Coupon extends Model
{
    use HasFactory;
    // Products has many images
    public function category()
    {
        return $this->hasMany('App\Category', 'id');
    }
}
