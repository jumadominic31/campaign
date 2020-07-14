<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contactgroupcombo extends Model
{
    public function contact()
    {
        return $this->belongsTo('App\Contact', 'contact_id');
    }
}
