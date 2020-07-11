<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Smslog extends Model
{
    public function contact()
    {
        return $this->belongsTo('App\Contact', 'contact_id');
    }
}
