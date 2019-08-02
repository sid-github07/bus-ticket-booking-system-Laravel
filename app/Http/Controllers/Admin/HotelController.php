<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use App\Amenity;
use App\AmenityHotel;
use App\HotelImg;
use App\RoomBooking;
use App\Transaction;
use App\Hotel;
use App\Room;
use App\User;
use Image;
use Validator;
use Session;

class HotelController extends Controller
{
    public function index(Request $request) {
      if (empty($request->term)) {
        $data['term'] = '';
        $data['hotels'] = Hotel::orderBy('id', 'DESC')->paginate(10);
      } else {
        $data['term'] = $request->term;
        $data['hotels'] = Hotel::where('name', 'like', '%'.$request->term.'%')->orderBy('id', 'DESC')->paginate(10);
      }
      return view('admin.hotel.index', $data);
    }

    public function create() {
      $data['ams'] = Amenity::where('status', 1)->get();
      return view('admin.hotel.create', $data);
    }

    public function edit($id) {
      $data['ams'] = Amenity::where('status', 1)->get();
      $data['hotel'] = Hotel::find($id);
      return view('admin.hotel.edit', $data);
    }

    public function store(Request $request) {
      $imgs = $request->file('images');
      return $imgs;
      $allowedExts = array('jpg', 'png', 'jpeg');

      $validator = Validator::make($request->all(), [
        'name' => 'required',
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
        'amenities' => 'required',
        'phone' => 'required',
        'email' => 'required|email',
        'address' => 'required',
      ]);

      if($validator->fails()) {
          $validator->errors()->add('error', 'true');
          return response()->json($validator->errors());
      }

      $in = Input::except('_token', 'images', 'amenities');
      $hotelid = Hotel::create($in)->id;

      foreach ($request->amenities as $amenity) {
        $ha = new AmenityHotel;
        $ha->hotel_id = $hotelid;
        $ha->amenity_id = $amenity;
        $ha->save();
      }

      foreach($imgs as $img) {
          $hi = new HotelImg;
          $filename = uniqid() . '.jpg';
          $location = 'assets/user/img/hotel_imgs/' . $filename;

          $background = Image::canvas(750, 475);
          $resizedImage = Image::make($img)->resize(750, 475)->save($location);

          $hi = new HotelImg;
          $hi->hotel_id = $hotelid;
          $hi->image = $filename;
          $hi->save();
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
        'amenities' => 'required',
        'phone' => 'required',
        'email' => 'required|email',
        'address' => 'required',
      ]);

      if($validator->fails()) {
          $validator->errors()->add('error', 'true');
          return response()->json($validator->errors());
      }

      $in = Input::except('_token', 'images', 'amenities', 'imgs_helper', 'hotelid', 'imgsdb');
      $hotel = Hotel::find($request->hotelid);
      $hotel->fill($in)->save();
      $hotelid = $request->hotelid;

      $deleteam = AmenityHotel::where('hotel_id', $hotel->id)->delete();
      foreach ($request->amenities as $amenity) {
        $ha = new AmenityHotel;
        $ha->hotel_id = $hotelid;
        $ha->amenity_id = $amenity;
        $ha->save();
      }

      // bring all the product images of that product
      $himgs = HotelImg::where('hotel_id', $hotelid)->get();

      // then check whether a filename is missing in imgsdb if it is missing remove it from database and unlink it
      foreach($himgs as $himg) {
        if(!in_array($himg->image, $request->imgsdb)) {
            @unlink('assets/user/img/hotel_imgs/'.$himg->image);
            $himg->delete();
        }
      }

      foreach ($imgs as $img) {
          $filename = uniqid() . '.jpg';
          $location = 'assets/user/img/hotel_imgs/' . $filename;

          $background = Image::canvas(750, 475);
          $resizedImage = Image::make($img)->resize(750, 475)->save($location);

          $hi = new HotelImg;
          $hi->hotel_id = $hotelid;
          $hi->image = $filename;
          $hi->save();

      }

      return "success";
    }


    public function hide(Request $request) {
        $hotelID = $request->id;
        $hotel = Hotel::find($hotelID);
        $hotel->a_hidden = 1;
        $hotel->save();
        return "success";
    }

    public function show(Request $request) {
        $hotelID = $request->id;
        $hotel = Hotel::find($hotelID);
        $hotel->a_hidden = 0;
        $hotel->save();
        return "success";
    }

    public function getimgs($id) {
      $himgs = HotelImg::select('id', 'image')->where('hotel_id', $id)->get();
      return $himgs;
    }

    public function all() {
      $data['roombookings'] = RoomBooking::orderBy('id', 'DESC')->paginate(10);
      return view('admin.hotel.bookings', $data);
    }

    public function rejrequest() {
      $data['roombookings'] = RoomBooking::orderBy('id', 'DESC')->whereNotNull('message')->paginate(10);
      return view('admin.hotel.bookings', $data);
    }

    public function rejected() {
      $data['roombookings'] = RoomBooking::where('status', -1)->orderBy('id', 'DESC')->paginate(10);
      return view('admin.hotel.bookings', $data);
    }

    public function accept(Request $request) {
      // 0 for Accept and -1 for Reject

      $roombooking = RoomBooking::find($request->roombookingid);
      $roombooking->status = 0;
      $roombooking->save();

      $user = User::find($request->userid);
      $room = Room::find($request->roomid);

      $user->balance = floatval($user->balance) - (floatval($room->payment)*$roombooking->duration);
      $user->save();

      // saving to transactions table
      $tr = new Transaction;
      $tr->user_id = $user->id;
      $tr->details = "Room Booking re-accepted";
      $tr->amount = floatval($room->payment)*$roombooking->duration;
      $tr->trx_id = str_random(16);
      $tr->after_balance = $user->balance;
      $tr->save();

      Session::flash('success', 'Accepted Successfuly!');
      return back();
    }

    public function reject(Request $request) {
      // 0 for Accept and -1 for Reject
      $roombooking = RoomBooking::find($request->roombookingid);
      $roombooking->status = -1;
      $roombooking->save();

      $user = User::find($request->userid);
      $room = Room::find($request->roomid);

      $user->balance = floatval($user->balance) + (floatval($room->payment)*$roombooking->duration);
      $user->save();

      // saving to transactions table
      $tr = new Transaction;
      $tr->user_id = $user->id;
      $tr->details = "Room Booking rejected";
      $tr->amount = floatval($room->payment)*$roombooking->duration;
      $tr->trx_id = str_random(16);
      $tr->after_balance = $user->balance;
      $tr->save();

      Session::flash('success', 'Rejected Successfuly!');

      // send_email( $user->email, $user->name, 'Room Booking Rejection', "Room booking has been rejected.<br/><strong>Room Name:</strong> ".."")

      return back();
    }
}
