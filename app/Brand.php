<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    //
    public static function brands()
    {
        $getBrands = Brand::get()->where('status', 1);

        $getBrands = json_decode(json_encode($getBrands), true);
        return $getBrands;
    }
}
