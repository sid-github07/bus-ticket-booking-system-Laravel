<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Hotel;
use App\HotelReview;
use Auth;
use Session;


class HotelController extends Controller
{
    public function show($id) {
      $data['hotel'] = Hotel::find($id);
      return view('user.hotel.show', $data);
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

      $hr = new HotelReview;
      $hr->hotel_id = $request->hotel_id;
      $hr->user_id = Auth::user()->id;
      $hr->rating = $request->rating;
      $hr->comment = $request->comment;
      $hr->save();

      Session::flash('success', 'You have rated successfully!');
      Session::flash('rating', 'from review');

      return back();
    }
}
