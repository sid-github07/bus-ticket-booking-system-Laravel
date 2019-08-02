<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PickupCarReview extends Model
{
    public function pickupcar() {
      return $this->belongsTo('App\PickupCar');
    }

    public function user() {
      return $this->belongsTo('App\User');
    }
}
