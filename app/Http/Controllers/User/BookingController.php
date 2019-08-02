<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use App\BuyPackage;
use App\RoomBooking;
use App\PickupBooking;
use App\RentcarBooking;
use App\LoungeBooking;
use Auth;
use Session;

class BookingController extends Controller
{
    public function package() {
      $data['buypackages'] = BuyPackage::where('user_id', Auth::user()->id)->where('status', 0)->orderBy('id', 'DESC')->get();
      return view('user.bookings.package', $data);
    }

    public function room() {
      $data['roombookings'] = RoomBooking::where('user_id', Auth::user()->id)->where('status', 0)->orderBy('id', 'DESC')->get();
      return view('user.bookings.room', $data);
    }

    public function pickup() {
      $data['pickupbookings'] = PickupBooking::where('user_id', Auth::user()->id)->where('status', 0)->orderBy('id', 'DESC')->get();
      return view('user.bookings.pickup', $data);
    }

    public function rentcar() {
      $data['rentbookings'] = RentcarBooking::where('user_id', Auth::user()->id)->where('status', 0)->orderBy('id', 'DESC')->get();
      return view('user.bookings.rentcar', $data);
    }

    public function lounge() {
      $data['loungebookings'] = LoungeBooking::where('user_id', Auth::user()->id)->where('status', 0)->orderBy('id', 'DESC')->get();
      return view('user.bookings.lounge', $data);
    }

    public function loungemessage(Request $request) {
      $request->validate([
        'reason' => 'required',
      ]);
      $loungebooking = LoungeBooking::where('user_id', Auth::user()->id)->where('lounge_id', $request->lounge_id)->first();
      $loungebooking->message = $request->reason;
      $loungebooking->save();
      Session::flash('success', 'Request Sent');
      return back();
    }

    public function roommessage(Request $request) {
      $request->validate([
        'reason' => 'required',
      ]);
      $roombooking = RoomBooking::where('user_id', Auth::user()->id)->where('room_id', $request->room_id)->first();
      $roombooking->message = $request->reason;
      $roombooking->save();
      Session::flash('success', 'Request Sent');
      return back();
    }

    public function packagemessage(Request $request) {
      $request->validate([
        'reason' => 'required',
      ]);
      $packagebooking = BuyPackage::where('user_id', Auth::user()->id)->where('package_id', $request->package_id)->first();
      $packagebooking->message = $request->reason;
      $packagebooking->save();
      Session::flash('success', 'Request Sent');
      return back();
    }

    public function pickupmessage(Request $request) {
      $request->validate([
        'reason' => 'required',
      ]);
      $pickupbooking = PickupBooking::where('user_id', Auth::user()->id)->where('pickup_car_id', $request->pickup_car_id)->first();
      $pickupbooking->message = $request->reason;
      $pickupbooking->save();
      Session::flash('success', 'Request Sent');
      return back();
    }

    public function rentmessage(Request $request) {
      $request->validate([
        'reason' => 'required',
      ]);
      $rentbooking = RentcarBooking::where('user_id', Auth::user()->id)->where('rent_car_id', $request->rent_car_id)->first();
      $rentbooking->message = $request->reason;
      $rentbooking->save();
      Session::flash('success', 'Request Sent');
      return back();
    }
}
