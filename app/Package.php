<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    protected $guarded = [];

    public function packageimgs() {
      return $this->hasMany('App\PackageImg');
    }

    public function buypackages() {
      return $this->hasMany('App\BuyPackage');
    }
}
