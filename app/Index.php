<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Index extends Model
{
    //
    // Basically these are the Database queries

    public function section()
    {
        //make blongs relation that this subcategory belongs to this category
        return $this->belongsTo('App\Section');
    }
}
