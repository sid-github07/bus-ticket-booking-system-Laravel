<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Amenity extends Model
{
    public function hotels() {
      return $this->belongsToMany('App\Hotel')->withTimestamps();
    }

    public function rooms() {
      return $this->belongsToMany('App\Room')->withTimestamps();
    }

    public function lounges() {
      return $this->belongsToMany('App\Lounge')->withTimestamps();
    }
}
