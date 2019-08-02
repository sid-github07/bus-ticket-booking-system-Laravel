<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use App\Amenity;
use App\AmenityLounge;
use App\LoungeImg;
use App\LoungeClosingDay;
use App\Lounge;
use App\LoungeBooking;
use App\Transaction;
use App\User;
use Image;
use Validator;
use Session;

class LoungeController extends Controller
{
    public function index(Request $request) {
      if (empty($request->term)) {
        $data['term'] = '';
        $data['lounges'] = Lounge::orderBy('id', 'DESC')->paginate(10);
      } else {
        $data['term'] = '';
        $data['lounges'] = Lounge::where('name', 'like', '%'.$request->term.'%')->orderBy('id', 'DESC')->paginate(10);
      }

      return view('admin.lounge.index', $data);
    }

    public function create() {
      $data['ams'] = Amenity::where('status', 1)->get();
      return view('admin.lounge.create', $data);
    }

    public function edit($id) {
      $data['ams'] = Amenity::where('status', 1)->get();
      $data['lounge'] = Lounge::find($id);
      return view('admin.lounge.edit', $data);
    }

    public function store(Request $request) {
      $imgs = $request->file('images');
      $allowedExts = array('jpg', 'png', 'jpeg');

      $validator = Validator::make($request->all(), [
        'name' => 'required',
        'location' => 'required',
        'price' => 'required',
        'images' => [
          'required',
          function($attribute, $value, $fail) use ($imgs, $allowedExts) {
              foreach($imgs as $img) {
                  $ext = $img->getClientOriginalExtension();
                  if(!in_array($ext, $allowedExts)) {
                      return $fail("Only png, jpg, jpeg images are allowed");
                  }
              }
              if (count($imgs) > 5) {
                return $fail("Maximum 5 images can be uploaded");
              }
          },
        ],
        'opening_hour' => 'required',
        'closing_hour' => 'required',
        'closing_days' => 'required',
        'amenities' => 'required',
        'condition_of_entry' => 'required',
        'overview' => 'required',
        'persons' => 'required',
        'hours' => 'required',
      ]);

      if($validator->fails()) {
          $validator->errors()->add('error', 'true');
          return response()->json($validator->errors());
      }

      $in = Input::except('_token', 'images', 'amenities', 'closing_days');
      $loungeid = Lounge::create($in)->id;

      foreach ($request->amenities as $amenity) {
        $al = new AmenityLounge;
        $al->lounge_id = $loungeid;
        $al->amenity_id = $amenity;
        $al->save();
      }

      foreach($imgs as $img) {
          $filename = uniqid() . '.jpg';
          $location = 'assets/user/img/lounge_imgs/' . $filename;

          $background = Image::canvas(750, 475);
          $resizedImage = Image::make($img)->resize(750, 475)->save($location);

          $li = new LoungeImg;
          $li->lounge_id = $loungeid;
          $li->image = $filename;
          $li->save();
      }

      foreach ($request->closing_days as $closing_day) {
        $closingday = new LoungeClosingDay;
        $closingday->lounge_id = $loungeid;
        $closingday->closing_day = $closing_day;
        $closingday->save();
      }

      return "success";
    }


    public function update(Request $request) {
      $allowedExts = array('jpg', 'png', 'jpeg');
      if ($request->hasFile('images')) {
        $imgs = $request->file('images');
      } else {
        $imgs = [];
      }
      if (!$request->has('imgsdb')) {
        $request->imgsdb = [];
      }

      $validator = Validator::make($request->all(), [
        'name' => 'required',
        'location' => 'required',
        'imgs_helper' => [
          function($attribute, $value, $fail) use ($allowedExts, $request, $imgs) {
              if (count($request->imgsdb) == 0 && count($imgs) == 0) {
                return $fail("Preview image is required");
              }
              foreach($imgs as $img) {
                  $ext = $img->getClientOriginalExtension();
                  if(!in_array($ext, $allowedExts)) {
                      return $fail("Only png, jpg, jpeg images are allowed");
                  }
              }
              if ((count($imgs)+count($request->imgsdb)) > 5) {
                return $fail("Maximum 5 images can be uploaded");
              }
          },
        ],
        'price' => 'required',
        'opening_hour' => 'required',
        'closing_hour' => 'required',
        'closing_days' => 'required',
        'amenities' => 'required',
        'condition_of_entry' => 'required',
        'overview' => 'required',
        'persons' => 'required',
        'hours' => 'required',
      ]);

      if($validator->fails()) {
          $validator->errors()->add('error', 'true');
          return response()->json($validator->errors());
      }

      $in = Input::except('_token', 'images', 'amenities', 'imgs_helper', 'loungeid', 'imgsdb', 'closing_days');
      $lounge = Lounge::find($request->loungeid);
      $lounge->fill($in)->save();
      $loungeid = $request->loungeid;

      $deleteam = AmenityLounge::where('lounge_id', $lounge->id)->delete();
      foreach ($request->amenities as $amenity) {
        $ha = new AmenityLounge;
        $ha->lounge_id = $loungeid;
        $ha->amenity_id = $amenity;
        $ha->save();
      }

      // bring all the product images of that product
      $limgs = LoungeImg::where('lounge_id', $loungeid)->get();

      // then check whether a filename is missing in imgsdb if it is missing remove it from database and unlink it
      foreach($limgs as $limg) {
        if(!in_array($limg->image, $request->imgsdb)) {
            @unlink('assets/user/img/lounge_imgs/'.$limg->image);
            $limg->delete();
        }
      }

      foreach ($imgs as $img) {
          $filename = uniqid() . '.jpg';
          $location = 'assets/user/img/lounge_imgs/' . $filename;

          $background = Image::canvas(750, 475);
          $resizedImage = Image::make($img)->resize(750, 475)->save($location);

          $hi = new LoungeImg;
          $hi->lounge_id = $loungeid;
          $hi->image = $filename;
          $hi->save();

      }

      LoungeClosingDay::where('lounge_id', $loungeid)->delete();

      foreach ($request->closing_days as $closing_day) {
        $closingday = new LoungeClosingDay;
        $closingday->lounge_id = $loungeid;
        $closingday->closing_day = $closing_day;
        $closingday->save();
      }

      return "success";
    }


    public function hide(Request $request) {
        $loungeID = $request->id;
        $lounge = Lounge::find($loungeID);
        $lounge->a_hidden = 1;
        $lounge->save();
        return "success";
    }

    public function show(Request $request) {
        $loungeID = $request->id;
        $lounge = Lounge::find($loungeID);
        $lounge->a_hidden = 0;
        $lounge->save();
        return "success";
    }

    public function getimgs($id) {
      $limgs = LoungeImg::select('id', 'image')->where('lounge_id', $id)->get();
      return $limgs;
    }

    public function all() {
      $data['loungebookings'] = LoungeBooking::orderBy('id', 'DESC')->paginate(10);
      return view('admin.lounge.bookings', $data);
    }

    public function rejrequest() {
      $data['loungebookings'] = LoungeBooking::orderBy('id', 'DESC')->whereNotNull('message')->paginate(10);
      return view('admin.lounge.bookings', $data);
    }

    public function rejected() {
      $data['loungebookings'] = LoungeBooking::where('status', -1)->orderBy('id', 'DESC')->paginate(10);
      return view('admin.lounge.bookings', $data);
    }

    public function accept(Request $request) {
      // 0 for Accept and -1 for Reject
      $loungebooking = LoungeBooking::find($request->loungebookingid);
      $loungebooking->status = 0;
      $loungebooking->save();

      $user = User::find($request->userid);
      $lounge = Lounge::find($request->loungeid);

      $user->balance = floatval($user->balance) - (floatval($lounge->price)*$loungebooking->persons);
      $user->save();

      // saving to transactions table
      $tr = new Transaction;
      $tr->user_id = $user->id;
      $tr->details = "Lounge Booking re-accepted";
      $tr->amount = floatval($lounge->price)*$loungebooking->persons;
      $tr->trx_id = str_random(16);
      $tr->after_balance = $user->balance;
      $tr->save();

      Session::flash('success', 'Accepted Successfuly!');
      return back();
    }

    public function reject(Request $request) {
      // 0 for Accept and -1 for Reject
      $loungebooking = LoungeBooking::find($request->loungebookingid);
      $loungebooking->status = -1;
      $loungebooking->save();

      $user = User::find($request->userid);
      $lounge = Lounge::find($request->loungeid);

      $user->balance = floatval($user->balance) + (floatval($lounge->price)*$loungebooking->persons);
      $user->save();

      // saving to transactions table
      $tr = new Transaction;
      $tr->user_id = $user->id;
      $tr->details = "Lounge Booking rejected";
      $tr->amount = floatval($lounge->price)*$loungebooking->persons;
      $tr->trx_id = str_random(16);
      $tr->after_balance = $user->balance;
      $tr->save();

      Session::flash('success', 'Rejected Successfuly!');
      return back();
    }
}
