<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use App\Lounge;
use App\User;
use App\LoungeReview;
use App\LoungeBooking;
use App\Transaction;
use Auth;
use Session;

class LoungeController extends Controller
{
    public function index() {
      $data['lounges'] = Lounge::where('a_hidden', 0)->orderBy('id', 'DESC')->paginate(10);
      return view('user.lounge.index', $data);
    }

    public function show($id) {
      $data['lounge'] = Lounge::find($id);
      return view('user.lounge.show', $data);
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

      $hr = new LoungeReview;
      $hr->lounge_id = $request->lounge_id;
      $hr->user_id = Auth::user()->id;
      $hr->rating = $request->rating;
      $hr->comment = $request->comment;
      $hr->save();

      Session::flash('success', 'You have rated successfully!');
      Session::flash('rating', 'from review');

      return back();
    }

    public function booking(Request $request) {
      // return $request->all();
      $lounge = Lounge::find($request->lounge_id);
      if (Auth::user()->balance < ($lounge->price*$request->persons)) {
        Session::flash('alert', 'Sorry you dont enough balance to book this lounge');
        return back();
      }

      $validatedRequest = $request->validate([
        'checkin_date' => 'required',
        'checkin_time' => 'required',
        'persons' => 'required|integer',
      ]);

      $in = Input::except('_token');
      LoungeBooking::create($in);

      $user = User::find(Auth::user()->id);
      $user->balance = $user->balance - ($lounge->price*$request->persons);
      $user->save();

      // saving to transactions table
      $tr = new Transaction;
      $tr->user_id = $user->id;
      $tr->details = "Booked Lounge";
      $tr->amount = $lounge->price*$request->persons;
      $tr->trx_id = str_random(16);
      $tr->after_balance = $user->balance;
      $tr->save();

      Session::flash('success', 'Lounge has been booked. Admin will contact you later.');

      return back();
    }

    public function search(Request $request) {
      $data['lounges'] = Lounge::when($request->place, function ($query) use ($request) {
                          return $query->where('location', 'like', '%'.$request->place.'%');
                      })
                      ->when($request->persons, function ($query) use ($request) {
                          return $query->where('persons', $request->persons);
                      })
                      ->when($request->checkin_time, function($query) use ($request) {
                        $loungeids = [];
                        foreach(\App\Lounge::all() as $lounge) {
                          if (strtotime($request->checkin_time) >= strtotime($lounge->opening_hour) && strtotime($request->checkin_time) <= strtotime($lounge->closing_hour)) {
                            $loungeids[] = $lounge->id;
                          }
                        }
                        return $query->whereIn('id', $loungeids);
                      })
                      ->when($request->checkin_date, function($query) use ($request) {
                        $day = date('w', strtotime($request->checkin_date));
                        $loungeids = [];

                        foreach(\App\Lounge::all() as $lounge) {
                          $loungeclosingdays = [];
                          foreach($lounge->loungeclosingdays as $loungeclosingday) {
                            $loungeclosingdays[] = $loungeclosingday->closing_day;
                          }
                          if (in_array($day, $loungeclosingdays)) {
                            continue;
                          } else {
                            $loungeids[] = $lounge->id;
                          }
                        }
                        return $query->whereIn('id', $loungeids);
                      })
                      ->get();
      return view('user.search.lounge', $data);
    }
}
