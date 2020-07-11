<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    public function gender()
    {
        return $this->belongsTo('App\Gender', 'gender_id');
    }
}
