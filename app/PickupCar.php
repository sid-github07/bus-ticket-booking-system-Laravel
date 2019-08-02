<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PickupCar extends Model
{
    protected $guarded = [];

    public function pickupcarimgs() {
      return $this->hasMany('App\PickupCarImg');
    }

    public function pickupreviews() {
      return $this->hasMany('App\PickupCarReview');
    }

    public function dropofflocs() {
      return $this->hasMany('App\DropoffLocation');
    }

    public function pickupbookings() {
      return $this->hasMany('App\PickupBooking');
    }    
}
