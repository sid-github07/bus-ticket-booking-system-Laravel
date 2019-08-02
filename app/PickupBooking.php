<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PickupBooking extends Model
{
    protected $guarded = [];

    public function pickup_car() {
      return $this->belongsTo('App\PickupCar');
    }

    public function user() {
      return $this->belongsTo('App\User');
    }
}
