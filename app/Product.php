<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $guarded = [];

    public function productimgs() {
      return $this->hasMany('App\ProductImg');
    }

    public function user() {
      return $this->belongsTo('App\User');
    }

    public function reports() {
      return $this->hasMany('App\Report');
    }
}
