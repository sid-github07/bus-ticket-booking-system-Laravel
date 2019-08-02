<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Shop extends Model
{
    protected $guarded = [];

    public function user() {
      return $this->belongsTo('App\Shop');
    }
}
