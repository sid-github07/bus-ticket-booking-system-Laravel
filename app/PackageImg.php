<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PackageImg extends Model
{
    public function package() {
      return $this->belongsTo('App\Package');
    }
}
