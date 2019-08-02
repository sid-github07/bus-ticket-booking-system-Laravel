<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BuyPackage extends Model
{
    protected $guarded = [];

    public function user() {
      return $this->belongsTo('App\User');
    }

    public function package() {
      return $this->belongsTo('App\Package');
    }
}
