<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RentCar extends Model
{
    protected $guarded = [];

    public function rentcarimgs() {
      return $this->hasMany('App\RentCarImg');
    }

    public function rentcarreviews() {
      return $this->hasMany('App\RentCarReview');
    }

    public function rentcarbookings() {
      return $this->hasMany('App\RentcarBooking');
    }
}
