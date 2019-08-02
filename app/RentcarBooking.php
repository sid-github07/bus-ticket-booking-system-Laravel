<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RentcarBooking extends Model
{
    protected $guarded = [];

    public function rent_car() {
      return $this->belongsTo('App\RentCar');
    }

    public function user() {
      return $this->belongsTo('App\User');
    }
}
