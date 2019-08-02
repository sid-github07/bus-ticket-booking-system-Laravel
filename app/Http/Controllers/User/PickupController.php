<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\PickupCar;
use App\DropoffLocation;
use App\PickupBooking;
use App\User;
use App\DropoffLocation as DL;
use App\PickupCarReview;
use App\Transaction;
use Carbon\Carbon;
use Illuminate\Support\Facades\Input;
use Auth;
use Session;

class PickupController extends Controller
{
    public function index() {
      $data['pickups'] = PickupCar::where('a_hidden', 0)->orderBy('id', 'DESC')->paginate(10);
      return view('user.pickup.index', $data);
    }

    public function show($id) {
      $data['pickup'] = PickupCar::find($id);
      $pickupbookings = PickupBooking::where('pickup_car_id', $id)->where('status', 0)->get();
      $bookingdates = [];
      foreach ($pickupbookings as $pickupbooking) {
        $date = new \Carbon\Carbon($pickupbooking->pickup_date);
        $bookingdates[] = $date->format('Y-m-d');
      }
      $data['bookingdates'] = $bookingdates;
      return view('user.pickup.show', $data);
    }

    public function review(Request $request) {
      if (!Auth::check()) {
        return redirect()->route('user.showLoginForm');
      }
      Session::flash('ratingerr', 'from review');

      $request->validate([
        'rating' => [
          'required',
          function($attribute, $value, $fail) {
              if ($value < 1 || $value > 5) {
                return $fail('Rating must be a number between 1 & 5!');
              }
          },
        ],
        'comment' => 'required',
      ]);

      $pr = new PickupCarReview;
      $pr->pickup_car_id = $request->pickup_car_id;
      $pr->user_id = Auth::user()->id;
      $pr->rating = $request->rating;
      $pr->comment = $request->comment;
      $pr->save();

      Session::flash('success', 'You have rated successfully!');
      Session::flash('rating', 'from review');

      return back();
    }

    public function booking(Request $request) {
      $pickup = PickupBooking::find($request->pickup_id);
      $dropoff = DL::find($request->dropoff_id);
      if (Auth::user()->balance < $dropoff->price) {
        Session::flash('alert', 'Sorry you dont enough balance to book this pickup car');
        return back();
      }

      $validatedRequest = $request->validate([
        'pickup_date' => 'required',
        'pickup_time' => 'required',
        'dropoff_id' => 'required',
      ]);

      $in = Input::except('_token', 'dropoff_id');
      $in['location'] = $dropoff->location;
      $in['price'] = $dropoff->price;
      PickupBooking::create($in);

      $user = User::find(Auth::user()->id);
      $user->balance = $user->balance - $dropoff->price;
      $user->save();

      // saving to transactions table
      $tr = new Transaction;
      $tr->user_id = $user->id;
      $tr->details = "Booked Pickup Car";
      $tr->amount = $dropoff->price;
      $tr->trx_id = str_random(16);
      $tr->after_balance = $user->balance;
      $tr->save();

      Session::flash('success', 'Pickupcar has been booked. Admin will contact you later.');

      return back();
    }

    public function search(Request $request) {
      $bookingdates = [];
      $data['bookingdates'] = $bookingdates;
      $data['pickups'] = PickupCar::when($request->drop_location, function ($query) use ($request) {
                          return $query->join('dropoff_locations', 'pickup_cars.id', '=', 'dropoff_locations.pickup_car_id');
                      })
                      ->when($request->pickup_location, function ($query) use ($request) {
                          return $query->where('pickup_cars.pickup_location', 'like', '%'.$request->pickup_location.'%');
                      })
                      ->when($request->persons, function ($query) use ($request) {
                          return $query->where('capacity', $request->persons);
                      })
                      ->when($request->drop_location, function ($query) use ($request) {
                          return $query->where('dropoff_locations.location', 'like', '%'.$request->drop_location.'%');
                      })
                      ->when($request->pickup_date, function ($query) use ($request) {
                        $desireddates = [];
                        $date = new \Carbon\Carbon($request->pickup_date);
                        $desireddates[] = $date->format('Y-m-d');

                        foreach (\App\PickupCar::all() as $pickup) {
                          $flag = 0;
                          foreach($pickup->pickupbookings()->where('status', '<>', -1)->get() as $pickupbooking) {

                            $date = new \Carbon\Carbon($pickupbooking->pickup_date);
                            $bookedDate = $date->format('Y-m-d');
                            if (in_array($bookedDate, $desireddates)) {
                              $flag = 1;
                              break;
                            } else {
                              $flag = 0;
                            }
                          }
                          if ($flag == 0) {
                            $pickupids[] = $pickup->id;
                          }
                        }

                        return $query->whereIn('pickup_cars.id', $pickupids);
                      })
                      ->select('*', 'pickup_cars.id as pickup_id')
                      ->orderBy('pickup_cars.id', 'DESC')
                      ->get();
      // return $data['pickups'];
      return view('user.search.pickup', $data);
    }
}
