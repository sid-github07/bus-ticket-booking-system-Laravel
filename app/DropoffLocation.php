<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DropoffLocation extends Model
{
    protected $guarded = [];

    public function pickupcar() {
      return $this->belongsTo('App\PickupCar');
    }
}
