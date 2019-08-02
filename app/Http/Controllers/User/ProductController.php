<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Carbon\Carbon;
use App\Category;
use App\Product;
use App\Shop;
use App\ProductImg;
use App\Report;
use App\User;
use App\Favorite;
use Session;
use Validator;
use Image;
use Auth;

class ProductController extends Controller
{
    public function details($id) {
      $data['pro'] = Product::find($id);
      return view('user.product.details', $data);
    }

    public function create() {
      $data['cats'] = Category::where('status', 1)->get();
      return view('user.product.create', $data);
    }

    public function store(Request $request) {
      if (empty(Auth::user()->ads)) {
        Session::flash('alert', 'You have to buy package to post an Ad');
        return back();
      }
      $allowedExts = array('jpg', 'png', 'jpeg');
      $imgs = $request->file('images');
      $conCount = substr_count($request->contact_number, ",") + 1;

      $messages = [
        'status.required' => 'The condition field is required',
      ];
      $validatedRequest = $request->validate([
        'title' => [
          'required',
          'max:50'
        ],
        'category' => 'required',
        'images' => [
          'required',
          function($attribute, $value, $fail) use ($imgs, $allowedExts) {
              foreach($imgs as $img) {
                  $ext = $img->getClientOriginalExtension();
                  if(!in_array($ext, $allowedExts)) {
                      return $fail("Only png, jpg, jpeg images are allowed");
                  }
              }
              if (sizeof($imgs) > 5) {
                return $fail("Maximum 5 images can be uploaded");
              }
          },
        ],
        'price' => 'required',
        'status' => 'required',
        'contact_number' => [
          'required',
          function($attribute, $value, $fail) use ($conCount) {
              if ($conCount > 5) {
                  return $fail('You can add maximum 5 contact numbers');
              }
          },
        ],
        'type' => 'required',
        'description' => 'required'
      ], $messages);

      $in = Input::except('_token', 'images');
      $in['user_id'] = Auth::user()->id;
      $pro = Product::create($in);

      foreach ($imgs as $img) {
          $filename = uniqid() . '.jpg';
          $location = 'assets/user/product_images/' . $filename;

          $background = Image::canvas(750, 475);
          $resizedImage = Image::make($img)->resize(750, 475, function ($c) {
              $c->aspectRatio();
              $c->upsize();
          });
          $background->insert($resizedImage, 'center');
          $background->save($location);

          $proimg = new ProductImg;
          $proimg->product_id = $pro->id;
          $proimg->name = $filename;
          $proimg->save();

      }

      $user = User::find(Auth::user()->id);
      $user->ads = $user->ads - 1;
      $user->save();

      Session::flash('success', 'Your post will be reviewed by Admin');
      return redirect()->back();

    }

    public function manage() {
      $data['pros'] = Product::where('user_id', Auth::user()->id)->latest()->get();
      return view('user.product.manage', $data);
    }

    public function edit($id) {
      $data['pro'] = Product::find($id);
      $data['cats'] = Category::where('status', 1)->get();
      return view('user.product.edit', $data);
    }

    public function update(Request $request) {
      $allowedExts = array('jpg', 'png', 'jpeg');
      if ($request->hasFile('imgs')) {
        $imgs = $request->file('imgs');
      } else {
        $imgs = [];
      }
      if (!$request->has('imgsdb')) {
        $request->imgsdb = [];
      }
      $product = Product::find($request->proid);
      $conCount = substr_count($request->contact_number, ",") + 1;

      $messages = [
        'status.required' => 'The condition field is required',
      ];
      $validator = Validator::make($request->all(), [
        'title' => [
          'required',
          'max:50'
        ],
        'category' => 'required',
        'imgs_helper' => [
          function($attribute, $value, $fail) use ($allowedExts, $request, $imgs) {
              if (count($request->imgsdb) == 0 && count($imgs) == 0) {
                return $fail("Items image is required");
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
        'status' => 'required',
        'contact_number' => [
          'required',
          function($attribute, $value, $fail) use ($conCount) {
              if ($conCount > 5) {
                  return $fail('You can add maximum 5 contact numbers');
              }
          },
        ],
        'type' => 'required',
        'description' => 'required'
      ], $messages);

      if ($validator->fails()) {
        $validator->getMessageBag()->add('error', 'true');
        return response()->json($validator->errors());
      }

      $in = Input::except('_token', 'proid', 'imgs_helper', 'imgs', 'imgsdb');
      $product->fill($in)->save();

      // bring all the product images of that product
      $proimgs = ProductImg::where('product_id', $product->id)->get();

      // then check whether a filename is missing in imgsdb if it is missing remove it from database and unlink it
      foreach($proimgs as $proimg) {
        if(!in_array($proimg->name, $request->imgsdb)) {
            @unlink('assets/user/product_images/'.$proimg->name);
            $proimg->delete();
        }
      }

      foreach ($imgs as $img) {
          $filename = uniqid() . '.jpg';
          $location = 'assets/user/product_images/' . $filename;

          $background = Image::canvas(750, 475);
          $resizedImage = Image::make($img)->resize(750, 475, function ($c) {
              $c->aspectRatio();
              $c->upsize();
          });
          $background->insert($resizedImage, 'center');
          $background->save($location);

          $proimg = new ProductImg;
          $proimg->product_id = $product->id;
          $proimg->name = $filename;
          $proimg->save();

      }

      // Session::flash('success', 'Your post will be reviewed by Admin');
      return "success";

    }

    public function getimgs($id) {
      $proimgs = ProductImg::select('id', 'name')->where('product_id', $id)->get();
      return $proimgs;
    }

    public function delete(Request $request) {
      $proid = $request->id;
      $proimgs = ProductImg::where('product_id', $proid);
      foreach ($proimgs->get() as $proimg) {
        @unlink('assets/user/product_images/'.$proimg->name);
      }
      $proimgs->delete();
      Product::find($proid)->delete();
      return "success";
    }

    public function report(Request $request) {
      $report = new Report;
      $report->user_id = Auth::user()->id;
      $report->product_id = $request->proid;
      $report->reason = $request->reason;
      $report->save();
      Session::flash('success', 'You have reported successfully');
      return back();
    }

    public function feature(Request $request) {
      if (empty(Auth::user()->feature)) {
        Session::flash('alert', 'You have to buy package to feature ad/unfeature any of your ad');
        return back();
      }
      $pro = Product::find($request->proid);

      if ($pro->featured == 1) {
        Session::flash('alert', 'This ad is already featured');
        return back();
      }

      $pro->featured = 1;
      $pro->save();

      $user = User::find(Auth::user()->id);
      $user->feature = $user->feature - 1;
      $user->save();

      Session::flash('success', 'Featured this Ad');
      return back();
    }

    public function unfeature(Request $request) {
      $pro = Product::find($request->proid);

      $today = new \Carbon\Carbon(Carbon::now());
      $existingVal = new \Carbon\Carbon($pro->user->expired_date);
      if ($today->gt($existingVal)) {
        Session::flash('alert', 'Your ad is no longer featured anymore. You have to buy package to feature your ads.');
        return back();
      }


      if ($pro->featured == 0) {
        Session::flash('alert', 'This ad is already unfeatured');
        return back();
      }

      if ($pro->featured == 1) {
        $pro->featured = 0;
        $pro->save();

        $user = User::find(Auth::user()->id);
        $user->feature = $user->feature + 1;
        $user->save();
      }

      Session::flash('success', 'Unfeatured this Ad');
      return back();
    }

    public function favorite(Request $request) {
      $fav = new Favorite;
      $fav->user_id = Auth::user()->id;
      $fav->product_id = $request->proid;
      $fav->save();

      Session::flash('success', 'Kept in your favorite ads list');
      return back();
    }

    public function unfavorite(Request $request) {
      $fav = Favorite::where('user_id', Auth::user()->id)->where('product_id', $request->proid)->first()->delete();

      Session::flash('success', 'Removed from your favorite ads list');
      return back();
    }
}
