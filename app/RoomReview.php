<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RoomReview extends Model
{
    public function room() {
      return $this->belongsTo('App\Room');
    }

    public function user() {
      return $this->belongsTo('App\User');
    }
}
