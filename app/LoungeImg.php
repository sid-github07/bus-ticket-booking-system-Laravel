<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LoungeImg extends Model
{
    public function lounge() {
      return $this->belongsTo('App\Lounge');
    }
}
