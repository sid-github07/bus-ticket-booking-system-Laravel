<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PickupCarImg extends Model
{
    public function pickupcar() {
      return $this->belongsTo('App\PickupCar');
    }
}
