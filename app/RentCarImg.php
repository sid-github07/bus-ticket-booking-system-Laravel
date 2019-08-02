<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RentCarImg extends Model
{
    public function rentcar() {
      return $this->belongsTo('App\RentCar');
    }
}
