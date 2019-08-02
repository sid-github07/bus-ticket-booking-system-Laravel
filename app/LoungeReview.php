<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LoungeReview extends Model
{
    public function lounge() {
      return $this->belongsTo('App\Lounge');
    }

    public function user() {
      return $this->belongsTo('App\User');
    }
}
