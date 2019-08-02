<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use App\Room;
use App\Amenity;
use App\AmenityRoom;
use App\RoomImg;
use Image;
use Validator;

class RoomController extends Controller
{
    public function index($id) {
      $data['term'] = '';
      $data['rooms'] = Room::where('hotel_id', $id)->paginate(10);
      return view('admin.room.index', $data);
    }

    public function create($hotelid) {
      $data['hotel_id'] = $hotelid;
      $data['ams'] = Amenity::where('status', 1)->get();
      return view('admin.room.create', $data);
    }

    public function edit($id) {
      $data['rams'] = Amenity::where('status', 1)->get();
      $data['room'] = Room::find($id);
      return view('admin.room.edit', $data);
    }

    public function store(Request $request) {
      $imgs = $request->file('images');
      $allowedExts = array('jpg', 'png', 'jpeg');

      $validator = Validator::make($request->all(), [
        'name' => 'required',
        'overview' => 'required',
        'bed' => 'required',
        'bath' => 'required',
        'no_of_persons' => 'required',
        'payment' => 'required',
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
      ]);

      if($validator->fails()) {
          $validator->errors()->add('error', 'true');
          return response()->json($validator->errors());
      }

      $in = Input::except('_token', 'images', 'amenities');
      $roomid = Room::create($in)->id;

      foreach ($request->amenities as $amenity) {
        $ra = new AmenityRoom;
        $ra->room_id = $roomid;
        $ra->amenity_id = $amenity;
        $ra->save();
      }

      foreach($imgs as $img) {
          $filename = uniqid() . '.jpg';
          $location = 'assets/user/img/room_imgs/' . $filename;

          $background = Image::canvas(750, 475);
          $resizedImage = Image::make($img)->resize(750, 475)->save($location);

          $ri = new RoomImg;
          $ri->room_id = $roomid;
          $ri->image = $filename;
          $ri->save();
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
        'bed' => 'required',
        'bath' => 'required',
        'no_of_persons' => 'required',
        'payment' => 'required',
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
      ]);

      if($validator->fails()) {
          $validator->errors()->add('error', 'true');
          return response()->json($validator->errors());
      }

      $room = Room::find($request->roomid);
      $in = Input::except('_token', 'images', 'amenities', 'imgs_helper', 'roomid', 'imgsdb');
      $room->fill($in)->save();

      $deleteam = AmenityRoom::where('room_id', $room->id)->delete();
      foreach ($request->amenities as $amenity) {
        $ra = new AmenityRoom;
        $ra->room_id = $room->id;
        $ra->amenity_id = $amenity;
        $ra->save();
      }

      // bring all the product images of that product
      $rimgs = RoomImg::where('room_id', $room->id)->get();

      // then check whether a filename is missing in imgsdb if it is missing remove it from database and unlink it
      foreach($rimgs as $rimg) {
        if(!in_array($rimg->image, $request->imgsdb)) {
            @unlink('assets/user/img/room_imgs/'.$rimg->image);
            $rimg->delete();
        }
      }

      foreach($imgs as $img) {
          $filename = uniqid() . '.jpg';
          $location = 'assets/user/img/room_imgs/' . $filename;

          $background = Image::canvas(750, 475);
          $resizedImage = Image::make($img)->resize(750, 475)->save($location);

          $ri = new RoomImg;
          $ri->room_id = $room->id;
          $ri->image = $filename;
          $ri->save();
      }

      return "success";
    }

    public function hide(Request $request) {
        $roomID = $request->id;
        $room = Room::find($roomID);
        $room->a_hidden = 1;
        $room->save();
        return "success";
    }

    public function show(Request $request) {
        $roomID = $request->id;
        $room = Room::find($roomID);
        $room->a_hidden = 0;
        $room->save();
        return "success";
    }

    public function getimgs($id) {
      $rimgs = RoomImg::select('id', 'image')->where('room_id', $id)->get();
      return $rimgs;
    }


}
