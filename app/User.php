<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function deposits() {
      return $this->hasMany('App\Deposit');
    }

    public function reports() {
      return $this->hasMany('App\Report');
    }

    public function transactions() {
      return $this->hasMany('App\Transaction');
    }

    public function products() {
      return $this->hasMany('App\Product');
    }

    public function shop() {
      return $this->hasOne('App\Shop');
    }

    public function hotelreviews() {
      return $this->hasMany('App\HotelReview');
    }

    public function roomreviews() {
      return $this->hasMany('App\RoomReview');
    }

    public function roombookings() {
      return $this->hasMany('App\RoomBooking');
    }

    public function loungebookings() {
      return $this->hasMany('App\LoungeBooking');
    }

    public function pickupbookings() {
      return $this->hasMany('App\PickupBooking');
    }

    public function rentcarbookings() {
      return $this->hasMany('App\RentcarBooking');
    }

    public function buypackages() {
      return $this->hasMany('App\BuyPackage');
    }
}
