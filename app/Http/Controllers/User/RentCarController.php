<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use App\RentCar;
use App\RentCarReview;
use App\User;
use App\RentcarBooking;
use App\Transaction;
use Auth;
use Session;

class RentCarController extends Controller
{
    public function index() {
      $data['rentcars'] = RentCar::where('a_hidden', 0)->orderBy('id', 'DESC')->paginate(10);
      return view('user.rentcar.index', $data);
    }

    public function show($id) {
      $data['rentcar'] = RentCar::find($id);
      $rentcarbookings = RentcarBooking::where('rent_car_id', $id)->where('status', 0)->get();
      $bookingdates = [];
      foreach ($rentcarbookings as $rentcarbooking) {
        for ($i=0; $i < $rentcarbooking->duration; $i++) {
          $date = new \Carbon\Carbon($rentcarbooking->rent_date);
          $newDate = $date->addDays($i);
          $bookingdates[] = $newDate->format('Y-m-d');
        }
      }
      $data['bookingdates'] = $bookingdates;
      return view('user.rentcar.show', $data);
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

      $rr = new RentCarReview;
      $rr->rent_car_id = $request->rent_car_id;
      $rr->user_id = Auth::user()->id;
      $rr->rating = $request->rating;
      $rr->comment = $request->comment;
      $rr->save();

      Session::flash('success', 'You have rated successfully!');
      Session::flash('rating', 'from review');

      return back();
    }

    public function booking(Request $request) {
      $rentcar = RentCar::find($request->rent_car_id);
      if (Auth::user()->balance < ($rentcar->payment*$request->duration)) {
        Session::flash('alert', 'Sorry you dont have enough balance to book this car');
        return back();
      }

      $validatedRequest = $request->validate([
        'rent_date' => 'required|date',
        'duration' => 'required|integer',
      ]);

      $in = Input::except('_token', 'rent_date');
      $date = new \Carbon\Carbon($request->rent_date);
      $in['rent_date'] = $date->format('Y-m-d');
      RentcarBooking::create($in);

      $user = User::find(Auth::user()->id);
      $user->balance = $user->balance - ($rentcar->payment*$request->duration);
      $user->save();

      // saving to transactions table
      $tr = new Transaction;
      $tr->user_id = $user->id;
      $tr->details = "Booked Rent Car";
      $tr->amount = $rentcar->payment*$request->duration;
      $tr->trx_id = str_random(16);
      $tr->after_balance = $user->balance;
      $tr->save();

      Session::flash('success', 'Car has been booked. Admin will contact you later.');

      return back();
    }

    public function search(Request $request) {
      $bookingdates = [];
      $data['bookingdates'] = $bookingdates;
      $data['rentcars'] = RentCar::when($request->address, function ($query) use ($request) {
                          return $query->where('address', 'like', '%'.$request->address.'%');
                      })
                      ->when($request->persons, function ($query) use ($request) {
                          return $query->where('capacity', $request->persons);
                      })
                      ->when($request->rent_date, function ($query) use ($request) {
                        $desireddates = [];
                        if (empty($request->duration)) {
                          $duration = 1;
                        } else {
                          $duration = $request->duration;
                        }
                        for ($i=0; $i < $duration; $i++) {
                          $date = new \Carbon\Carbon($request->rent_date);
                          $newDate = $date->addDays($i);
                          $desireddates[] = $newDate->format('Y-m-d');
                        }
                        foreach (\App\RentCar::all() as $rentcar) {
                          $flag = 0;
                          foreach($rentcar->rentcarbookings()->where('status', '<>', -1)->get() as $rentcarbooking) {
                            for ($k=0; $k < $rentcarbooking->duration; $k++) {
                              $date = new \Carbon\Carbon($rentcarbooking->rent_date);
                              $bookedDate = $date->addDays($k)->format('Y-m-d');
                              if (in_array($bookedDate, $desireddates)) {
                                $flag = 1;
                                break;
                              } else {
                                $flag = 0;
                              }
                            }
                            if ($flag == 1) {
                              break;
                            }
                          }
                          if ($flag == 0) {
                            $rentcarids[] = $rentcar->id;
                          }
                        }

                        return $query->whereIn('id', $rentcarids);
                      })
                      ->get();
      return view('user.search.rentcar', $data);
    }
}
