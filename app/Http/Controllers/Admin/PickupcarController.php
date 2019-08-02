<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use App\PickupCarImg;
use App\Transaction;
use Image;
use Validator;
use Session;
use App\PickupCar;
use App\PickupBooking;
use App\User;

class PickupcarController extends Controller
{

    public function index(Request $request) {
      if (empty($request->term)) {
        $data['term'] = '';
        $data['pickups'] = PickupCar::orderBy('id', 'DESC')->paginate(10);
      } else {
        $data['term'] = $request->term;
        $data['pickups'] = PickupCar::where('title', 'like', '%'.$request->term.'%')->orderBy('id', 'DESC')->paginate(10);
      }

      return view('admin.pickup.index', $data);
    }

    public function create() {
      return view('admin.pickup.create');
    }

    public function edit($id) {
      $data['pickup'] = PickupCar::find($id);
      return view('admin.pickup.edit', $data);
    }

    public function store(Request $request) {
      $imgs = $request->file('images');
      $allowedExts = array('jpg', 'png', 'jpeg');

      $validator = Validator::make($request->all(), [
        'title' => 'required',
        'overview' => 'required',
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
        'capacity' => 'required',
        'pickup_location' => 'required',
      ]);

      if($validator->fails()) {
          $validator->errors()->add('error', 'true');
          return response()->json($validator->errors());
      }

      $in = Input::except('_token', 'images', 'amenities');
      $pickupid = PickupCar::create($in)->id;

      foreach($imgs as $img) {
          $filename = uniqid() . '.jpg';
          $location = 'assets/user/img/pickup_imgs/' . $filename;

          $resizedImage = Image::make($img)->resize(750, 475)->save($location);

          $pi = new PickupCarImg;
          $pi->pickup_car_id = $pickupid;
          $pi->image = $filename;
          $pi->save();
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
        'title' => 'required',
        'overview' => 'required',
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
        'capacity' => 'required',
        'pickup_location' => 'required',
      ]);

      if($validator->fails()) {
          $validator->errors()->add('error', 'true');
          return response()->json($validator->errors());
      }

      $in = Input::except('_token', 'images', 'imgs_helper', 'pickupid', 'imgsdb');
      $pickup = PickupCar::find($request->pickupid);
      $pickup->fill($in)->save();
      $pickupid = $request->pickupid;


      // bring all the product images of that product
      $pimgs = PickupCarImg::where('pickup_car_id', $pickupid)->get();

      // then check whether a filename is missing in imgsdb if it is missing remove it from database and unlink it
      foreach($pimgs as $pimg) {
        if(!in_array($pimg->image, $request->imgsdb)) {
            @unlink('assets/user/img/pickup_imgs/'.$pimg->image);
            $pimg->delete();
        }
      }

      foreach ($imgs as $img) {
          $filename = uniqid() . '.jpg';
          $location = 'assets/user/img/pickup_imgs/' . $filename;

          $resizedImage = Image::make($img)->resize(750, 475)->save($location);

          $pi = new PickupCarImg;
          $pi->pickup_car_id = $pickupid;
          $pi->image = $filename;
          $pi->save();

      }

      return "success";
    }


    public function hide(Request $request) {
        $pickupID = $request->id;
        $pickup = PickupCar::find($pickupID);
        $pickup->a_hidden = 1;
        $pickup->save();
        return "success";
    }

    public function show(Request $request) {
        $pickupID = $request->id;
        $pickup = PickupCar::find($pickupID);
        $pickup->a_hidden = 0;
        $pickup->save();
        return "success";
    }

    public function getimgs($id) {
      $pimgs = PickupCarImg::select('id', 'image')->where('pickup_car_id', $id)->get();
      return $pimgs;
    }

    public function all() {
      $data['pickupcarbookings'] = PickupBooking::orderBy('id', 'DESC')->paginate(10);
      return view('admin.pickup.bookings', $data);
    }

    public function rejrequest() {
      $data['pickupcarbookings'] = PickupBooking::orderBy('id', 'DESC')->whereNotNull('message')->paginate(10);
      return view('admin.pickup.bookings', $data);
    }

    public function rejected() {
      $data['pickupcarbookings'] = PickupBooking::where('status', -1)->orderBy('id', 'DESC')->paginate(10);
      return view('admin.pickup.bookings', $data);
    }

    public function accept(Request $request) {
      // 0 for Accept and -1 for Reject
      $pickupcarbooking = PickupBooking::find($request->pickupcarbookingid);
      $pickupcarbooking->status = 0;
      $pickupcarbooking->save();

      $user = User::find($request->userid);
      $pickupcar = PickupCar::find($request->pickupcarid);

      $user->balance = floatval($user->balance) - floatval($pickupcarbooking->price);
      $user->save();

      // saving to transactions table
      $tr = new Transaction;
      $tr->user_id = $user->id;
      $tr->details = "Pickup Car Booking re-accepted";
      $tr->amount = floatval($pickupcarbooking->price);
      $tr->trx_id = str_random(16);
      $tr->after_balance = $user->balance;
      $tr->save();

      Session::flash('success', 'Accepted Successfuly!');
      return back();
    }

    public function reject(Request $request) {
      // 0 for Accept and -1 for Reject
      $pickupcarbooking = PickupBooking::find($request->pickupcarbookingid);
      $pickupcarbooking->status = -1;
      $pickupcarbooking->save();

      $user = User::find($request->userid);
      $pickupcar = PickupCar::find($request->pickupcarid);

      $user->balance = floatval($user->balance) + floatval($pickupcarbooking->price);
      $user->save();

      // saving to transactions table
      $tr = new Transaction;
      $tr->user_id = $user->id;
      $tr->details = "Pickup Car Booking rejected";
      $tr->amount = floatval($pickupcarbooking->price);
      $tr->trx_id = str_random(16);
      $tr->after_balance = $user->balance;
      $tr->save();

      Session::flash('success', 'Rejected Successfuly!');
      return back();
    }
}
