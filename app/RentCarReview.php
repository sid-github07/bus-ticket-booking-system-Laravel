<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RentCarReview extends Model
{
    public function rentcar() {
      return $this->belongsTo('App\RentCar');
    }

    public function user() {
      return $this->belongsTo('App\User');
    }
}
