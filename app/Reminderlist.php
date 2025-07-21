<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Reminderlist extends Model
{
    use HasFactory;

    public function product()
    {
        return $this->belongsTo('App\Product', 'product_id');
    }

    public static function userReminderItems()
    {
        if (Auth::check()) {
            $userReminderItems = Reminderlist::with(['product' => function ($quary) {
                $quary->select('id', 'product_name', 'main_image', 'product_price');
            }])->where('user_id', Auth::user()->id)->orderBy('id', 'Desc')->get()->toArray();
        }
        return $userReminderItems;
    }
}
