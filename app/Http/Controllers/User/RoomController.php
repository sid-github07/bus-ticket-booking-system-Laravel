<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use App\Room;
use App\User;
use App\RoomReview;
use App\RoomBooking;
use App\Transaction;
use Carbon\Carbon;
use Auth;
use Session;

class RoomController extends Controller
{
    public function show($id) {
      $data['room'] = Room::find($id);
      $roombookings = RoomBooking::where('room_id', $id)->where('status', 0)->get();
      $bookingdates = [];
      foreach ($roombookings as $roombooking) {
        for ($i=0; $i < $roombooking->duration; $i++) {
          $date = new \Carbon\Carbon($roombooking->checkin_date);
          $newDate = $date->addDays($i);
          $bookingdates[] = $newDate->format('Y-m-d');
        }
      }
      $data['bookingdates'] = $bookingdates;
      return view('user.room.show', $data);
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

      $rr = new RoomReview;
      $rr->room_id = $request->room_id;
      $rr->user_id = Auth::user()->id;
      $rr->rating = $request->rating;
      $rr->comment = $request->comment;
      $rr->save();

      Session::flash('success', 'You have rated successfully!');
      Session::flash('rating', 'from review');

      return back();
    }

    public function booking(Request $request) {
      $room = Room::find($request->room_id);
      if (Auth::user()->balance < ($room->payment*$request->duration)) {
        Session::flash('alert', 'Sorry you dont enough balance to book this room');
        return back();
      }

      $validatedRequest = $request->validate([
        'checkin_date' => 'required|date',
        'duration' => 'required|integer',
      ]);

      $in = Input::except('_token', 'checkin_date');
      $date = new \Carbon\Carbon($request->checkin_date);
      $in['checkin_date'] = $date->format('Y-m-d');
      RoomBooking::create($in);

      $user = User::find(Auth::user()->id);
      $user->balance = $user->balance - ($room->payment*$request->duration);
      $user->save();

      // saving to transactions table
      $tr = new Transaction;
      $tr->user_id = $user->id;
      $tr->details = "Booked Room";
      $tr->amount = $room->payment*$request->duration;
      $tr->trx_id = str_random(16);
      $tr->after_balance = $user->balance;
      $tr->save();

      Session::flash('success', 'Room has been booked. Admin will contact you later.');

      return back();
    }

    public function search(Request $request) {
      $bookingdates = [];
      $data['bookingdates'] = $bookingdates;
      $data['rooms'] = Room::join('hotels', 'hotels.id', '=', 'rooms.hotel_id')
                      ->when($request->address, function ($query) use ($request) {
                          return $query->where('hotels.address', 'like', '%'.$request->address.'%');
                      })
                      ->when($request->persons, function ($query) use ($request) {
                          return $query->where('no_of_persons', $request->persons);
                      })
                      ->when($request->beds, function ($query) use ($request) {
                          return $query->where('bed', $request->beds);
                      })
                      ->when($request->checkin_date, function ($query) use ($request) {
                        if (empty($request->duration)) {
                          $duration = 1;
                        } else {
                          $duration = $request->duration;
                        }
                        $desireddates = [];
                        for ($i=0; $i < $duration; $i++) {
                          $date = new \Carbon\Carbon($request->checkin_date);
                          $newDate = $date->addDays($i);
                          $desireddates[] = $newDate->format('Y-m-d');
                        }
                        foreach (\App\Room::all() as $room) {
                          $flag = 0;
                          foreach($room->roombookings()->where('status', '<>', -1)->get() as $roombooking) {
                            for ($k=0; $k < $roombooking->duration; $k++) {
                              $date = new \Carbon\Carbon($roombooking->checkin_date);
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
                            $roomids[] = $room->id;
                          }
                        }

                        return $query->whereIn('rooms.id', $roomids);
                      })
                      ->select('*', 'rooms.id as room_id', 'rooms.name as room_name')
                      ->get();
      return view('user.search.room', $data);
    }
}
