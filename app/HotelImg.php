<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HotelImg extends Model
{
    public function hotel() {
      return $this->belongsTo('App\Hotel');
    }
}
