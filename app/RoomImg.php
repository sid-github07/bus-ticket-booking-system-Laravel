<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RoomImg extends Model
{
    public function room() {
      return $this->belongsTo('App\Room');
    }
}
