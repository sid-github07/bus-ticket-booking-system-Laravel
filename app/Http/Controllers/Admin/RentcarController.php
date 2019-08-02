<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use App\RentCar;
use App\RentCarImg;
use App\RentcarBooking;
use App\User;
use App\Transaction;
use Image;
use Session;
use Validator;

class RentcarController extends Controller
{
    public function index(Request $request) {
      if (empty($request->term)) {
        $data['term'] = '';
        $data['rentcars'] = RentCar::orderBy('id', 'DESC')->paginate(10);
      } else {
        $data['term'] = $request->term;
        $data['rentcars'] = RentCar::where('title', 'like', '%'.$request->term.'%')->orderBy('id', 'DESC')->paginate(10);
      }

      return view('admin.rentcar.index', $data);
    }

    public function create() {
      return view('admin.rentcar.create');
    }

    public function edit($id) {
      $data['rentcar'] = RentCar::find($id);
      return view('admin.rentcar.edit', $data);
    }


    public function store(Request $request) {
      $imgs = $request->file('images');
      $allowedExts = array('jpg', 'png', 'jpeg');

      $validator = Validator::make($request->all(), [
        'title' => 'required',
        'overview' => 'required',
        'address' => 'required',
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
        'payment' => 'required',
      ]);

      if($validator->fails()) {
          $validator->errors()->add('error', 'true');
          return response()->json($validator->errors());
      }

      $in = Input::except('_token', 'images');
      $rentcarid = RentCar::create($in)->id;

      foreach($imgs as $img) {
          $filename = uniqid() . '.jpg';
          $location = 'assets/user/img/rentcar_imgs/' . $filename;

          $resizedImage = Image::make($img)->resize(750, 475)->save($location);

          $pi = new RentCarImg;
          $pi->rent_car_id = $rentcarid;
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
        'address' => 'required',
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
        'payment' => 'required',
      ]);

      if($validator->fails()) {
          $validator->errors()->add('error', 'true');
          return response()->json($validator->errors());
      }

      $in = Input::except('_token', 'images', 'imgs_helper', 'rentcarid', 'imgsdb');
      $rentcar = RentCar::find($request->rentcarid);
      $rentcar->fill($in)->save();
      $rentcarid = $request->rentcarid;


      // bring all the product images of that product
      $pimgs = RentCarImg::where('rent_car_id', $rentcarid)->get();

      // then check whether a filename is missing in imgsdb if it is missing remove it from database and unlink it
      foreach($pimgs as $pimg) {
        if(!in_array($pimg->image, $request->imgsdb)) {
            @unlink('assets/user/img/rentcar_imgs/'.$pimg->image);
            $pimg->delete();
        }
      }

      foreach ($imgs as $img) {
          $filename = uniqid() . '.jpg';
          $location = 'assets/user/img/rentcar_imgs/' . $filename;

          $resizedImage = Image::make($img)->resize(750, 475)->save($location);

          $pi = new RentCarImg;
          $pi->rent_car_id = $rentcarid;
          $pi->image = $filename;
          $pi->save();

      }

      return "success";
    }

    public function hide(Request $request) {
        $rentcarID = $request->id;
        $rentcar = RentCar::find($rentcarID);
        $rentcar->a_hidden = 1;
        $rentcar->save();
        return "success";
    }

    public function show(Request $request) {
        $rentcarID = $request->id;
        $rentcar = RentCar::find($rentcarID);
        $rentcar->a_hidden = 0;
        $rentcar->save();
        return "success";
    }


    public function getimgs($id) {
      $rimgs = RentCarImg::select('id', 'image')->where('rent_car_id', $id)->get();
      return $rimgs;
    }


    public function all() {
      $data['rentcarbookings'] = RentcarBooking::orderBy('id', 'DESC')->paginate(10);
      return view('admin.rentcar.bookings', $data);
    }

    public function rejrequest() {
      $data['rentcarbookings'] = RentcarBooking::orderBy('id', 'DESC')->whereNotNull('message')->paginate(10);
      return view('admin.rentcar.bookings', $data);
    }

    public function rejected() {
      $data['rentcarbookings'] = RentcarBooking::where('status', -1)->orderBy('id', 'DESC')->paginate(10);
      return view('admin.rentcar.bookings', $data);
    }

    public function accept(Request $request) {
      // 0 for Accept and -1 for Reject
      $rentcarbooking = RentcarBooking::find($request->rentcarbookingid);
      $rentcarbooking->status = 0;
      $rentcarbooking->save();

      $user = User::find($request->userid);
      $rentcar = RentCar::find($request->rentcarid);

      $user->balance = floatval($user->balance) - (floatval($rentcarbooking->payment)*$rentcarbooking->duration);
      $user->save();

      // saving to transactions table
      $tr = new Transaction;
      $tr->user_id = $user->id;
      $tr->details = "Rent Car Booking re-accepted";
      $tr->amount = floatval($rentcarbooking->payment)*$rentcarbooking->duration;
      $tr->trx_id = str_random(16);
      $tr->after_balance = $user->balance;
      $tr->save();

      Session::flash('success', 'Accepted Successfuly!');
      return back();
    }

    public function reject(Request $request) {
      // 0 for Accept and -1 for Reject
      $rentcarbooking = RentcarBooking::find($request->rentcarbookingid);
      $rentcarbooking->status = -1;
      $rentcarbooking->save();

      $user = User::find($request->userid);
      $rentcar = RentCar::find($request->rentcarid);

      $user->balance = floatval($user->balance) + (floatval($rentcarbooking->payment)*$rentcarbooking->duration);
      $user->save();

      // saving to transactions table
      $tr = new Transaction;
      $tr->user_id = $user->id;
      $tr->details = "Rent Car Booking rejected";
      $tr->amount = floatval($rentcarbooking->payment)*$rentcarbooking->duration;
      $tr->trx_id = str_random(16);
      $tr->after_balance = $user->balance;
      $tr->save();

      Session::flash('success', 'Rejected Successfuly!');
      return back();
    }
}
