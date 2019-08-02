<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use App\PackageImg;
use App\BuyPackage;
use App\Transaction;
use App\Package;
use App\User;
use Image;
use Validator;
use Session;

class PackageController extends Controller
{
    public function index(Request $request) {
      if (empty($request->term)) {
        $data['term'] = '';
        $data['packages'] = Package::orderBy('id', 'DESC')->paginate(10);
      } else {
        $data['term'] = $request->term;
        $data['packages'] = Package::where('name', 'like', '%'.$request->term.'%')->orderBy('id', 'DESC')->paginate(10);
      }

      return view('admin.package.index', $data);
    }

    public function create() {
      return view('admin.package.create');
    }

    public function edit($id) {
      $data['package'] = Package::find($id);
      return view('admin.package.edit', $data);
    }

    public function store(Request $request) {
      $imgs = $request->file('images');
      $allowedExts = array('jpg', 'png', 'jpeg');

      $validator = Validator::make($request->all(), [
        'name' => 'required',
        'price' => 'required',
        'duration' => 'required|integer',
        'start_date' => 'required',
        'closing_date' => 'required',
        'minimum_persons' => 'required',
        'maximum_persons' => 'required',
        'leaving_from' => 'required',
        'leaving_to' => 'required',
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
        'program_schedule' => 'required',
      ]);

      if($validator->fails()) {
          $validator->errors()->add('error', 'true');
          return response()->json($validator->errors());
      }

      $in = Input::except('_token', 'images');
      $packid = Package::create($in)->id;

      foreach($imgs as $img) {
          $pi = new PackageImg;
          $filename = uniqid() . '.jpg';
          $location = 'assets/user/img/package_imgs/' . $filename;

          $background = Image::canvas(750, 475);
          $resizedImage = Image::make($img)->resize(750, 475, function ($c) {
              $c->aspectRatio();
              $c->upsize();
          });
          $background->insert($resizedImage, 'center');
          $background->save($location);

          $pi = new PackageImg;
          $pi->package_id = $packid;
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
        'name' => 'required',
        'price' => 'required',
        'duration' => 'required|integer',
        'start_date' => 'required',
        'closing_date' => 'required',
        'minimum_persons' => 'required',
        'maximum_persons' => 'required',
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
        'program_schedule' => 'required',
      ]);

      if($validator->fails()) {
          $validator->errors()->add('error', 'true');
          return response()->json($validator->errors());
      }

      $in = Input::except('_token', 'images', 'imgs_helper', 'packageid', 'imgsdb');
      $package = Package::find($request->packageid);
      $package->fill($in)->save();
      $packageid = $request->packageid;


      // bring all the product images of that product
      $pimgs = PackageImg::where('package_id', $packageid)->get();

      // then check whether a filename is missing in imgsdb if it is missing remove it from database and unlink it
      foreach($pimgs as $pimg) {
        if(!in_array($pimg->image, $request->imgsdb)) {
            @unlink('assets/user/img/package_imgs/'.$pimg->image);
            $pimg->delete();
        }
      }

      foreach ($imgs as $img) {
          $filename = uniqid() . '.jpg';
          $location = 'assets/user/img/package_imgs/' . $filename;

          $background = Image::canvas(750, 475);
          $resizedImage = Image::make($img)->resize(750, 475, function ($c) {
              $c->aspectRatio();
              $c->upsize();
          });
          $background->insert($resizedImage, 'center');
          $background->save($location);

          $pi = new PackageImg;
          $pi->package_id = $packageid;
          $pi->image = $filename;
          $pi->save();

      }

      return "success";
    }


    public function hide(Request $request) {
        $packageId = $request->id;
        $package = Package::find($packageId);
        $package->a_hidden = 1;
        $package->save();
        return "success";
    }

    public function show(Request $request) {
        $packageId = $request->id;
        $package = Package::find($packageId);
        $package->a_hidden = 0;
        $package->save();
        return "success";
    }

    public function getimgs($id) {
      $pimgs = PackageImg::select('id', 'image')->where('package_id', $id)->get();
      return $pimgs;
    }

    public function all() {
      $data['buypackages'] = BuyPackage::orderBy('id', 'DESC')->paginate(10);
      return view('admin.package.bookings', $data);
    }

    public function rejrequest() {
      $data['buypackages'] = BuyPackage::orderBy('id', 'DESC')->whereNotNull('message')->paginate(10);
      return view('admin.package.bookings', $data);
    }

    public function rejected() {
      $data['buypackages'] = BuyPackage::where('status', -1)->orderBy('id', 'DESC')->paginate(10);
      return view('admin.package.bookings', $data);
    }

    public function accept(Request $request) {
      // 0 for Accept and -1 for Reject

      $buypackage = BuyPackage::find($request->buypackageid);
      $buypackage->status = 0;
      $buypackage->save();

      $user = User::find($request->userid);
      $package = Package::find($request->packageid);

      $user->balance = floatval($user->balance) - (floatval($package->price)*$buypackage->persons);
      $user->save();

      // saving to transactions table
      $tr = new Transaction;
      $tr->user_id = $user->id;
      $tr->details = "Package Booking re-accepted";
      $tr->amount = floatval($package->price)*$buypackage->persons;
      $tr->trx_id = str_random(16);
      $tr->after_balance = $user->balance;
      $tr->save();

      Session::flash('success', 'Accepted Successfuly!');
      return back();
    }

    public function reject(Request $request) {
      // 0 for Accept and -1 for Reject
      $buypackage = BuyPackage::find($request->buypackageid);
      $buypackage->status = -1;
      $buypackage->save();

      $user = User::find($request->userid);
      $package = Package::find($request->packageid);

      $user->balance = floatval($user->balance) + (floatval($package->price)*$buypackage->persons);
      $user->save();

      // saving to transactions table
      $tr = new Transaction;
      $tr->user_id = $user->id;
      $tr->details = "Package Booking Rejected";
      $tr->amount = floatval($package->price)*$buypackage->persons;
      $tr->trx_id = str_random(16);
      $tr->after_balance = $user->balance;
      $tr->save();

      Session::flash('success', 'Rejected Successfuly!');
      return back();
    }


}
