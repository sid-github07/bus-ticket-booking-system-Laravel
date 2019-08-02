<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Image;
use Session;
use App\Shop;
use App\Product;
use App\User;
use Auth;

class ShopController extends Controller
{
    public function create() {
      if (Shop::where('user_id', Auth::user()->id)->count() > 0) {
        $data['shop'] = Shop::where('user_id', Auth::user()->id)->first();
        return view('user.shop.show', $data);
      } else {
        return view('user.shop.create');
      }
    }

    public function show($id) {
      $data['shop'] = Shop::where('user_id', $id)->first();
      if (Auth::check()) {
        if (Auth::user()->id == $id) {
          $data['pros'] = Product::where('user_id', $id)->latest()->take(5)->get();
        } else {
          $data['pros'] = Product::where('user_id', $id)->where('published', 1)->where('a_hidden', 0)->latest()->take(5)->get();
        }
      } else {
        $data['pros'] = Product::where('user_id', $id)->where('published', 1)->where('a_hidden', 0)->latest()->take(5)->get();
      }
      return view('user.shop.show', $data);
    }

    public function ads($id) {
      $data['username'] = User::find($id)->username;
      if (Auth::check()) {
        if (Auth::user()->id == $id) {
          $data['pros'] = Product::where('user_id', $id)->orderBy('id', 'DESC')->paginate(10);
        } else {
          $data['pros'] = Product::where('user_id', $id)->where('published', 1)->where('a_hidden', 0)->orderBy('id', 'DESC')->paginate(10);
        }
      } else {
        $data['pros'] = Product::where('user_id', $id)->where('published', 1)->where('a_hidden', 0)->orderBy('id', 'DESC')->paginate(10);
      }
      return view('user.showmore', $data);
    }

    public function store(Request $request) {
      if (empty(Auth::user()->expired_date)) {
        Session::flash('alert', 'You have to buy package to create shop page');
        return back();
      }

      $logo = $request->file('logo');
      $cover = $request->file('cover');
      $allowedExts = array('jpg', 'png', 'jpeg');

      $validatedRequest = $request->validate([
        'logo' => [
          'required',
          function($attribute, $value, $fail) use ($logo, $allowedExts) {
              $ext = $logo->getClientOriginalExtension();
              if(!in_array($ext, $allowedExts)) {
                  return $fail("Only png, jpg, jpeg images are allowed");
              }
          },
        ],
        'cover' => [
          'required',
          function($attribute, $value, $fail) use ($cover, $allowedExts) {
              $ext = $cover->getClientOriginalExtension();
              if(!in_array($ext, $allowedExts)) {
                  return $fail("Only png, jpg, jpeg images are allowed");
              }
          },
        ],
        'shop_name' => 'required',
        'email' => 'required',
        'phone' => 'required',
        'opening_hour' => 'required',
        'closing_days' => 'required',
        'address' => 'required',
        'description' => 'required',
      ]);

      $in = Input::except('_token', 'logo', 'cover');
      $in['user_id'] = Auth::user()->id;
      $shop = Shop::create($in);

      if ($request->hasFile('logo')) {
        $logofile = uniqid() . '.jpg';
        $logoloc = 'assets/user/shop_logo/' . $logofile;

        $logobg = Image::canvas(200, 150);
        $resizedlogo = Image::make($logo)->resize(200, 150, function ($c) {
            $c->aspectRatio();
            $c->upsize();
        });
        $logobg->insert($resizedlogo, 'center');
        $logobg->save($logoloc);

        $shop = Shop::find($shop->id);
        $shop->logo = $logofile;
        $shop->save();
      }

      if ($request->hasFile('cover')) {
        $coverfile = uniqid() . '.jpg';
        $coverloc = 'assets/user/shop_cover/' . $coverfile;

        $coverbg = Image::canvas(1130, 415);
        $resizedcover = Image::make($cover)->resize(1130, 415, function ($c) {
            $c->aspectRatio();
            $c->upsize();
        });
        $coverbg->insert($resizedcover, 'center');
        $coverbg->save($coverloc);

        $shop = Shop::find($shop->id);
        $shop->cover = $coverfile;
        $shop->save();
      }

      Session::flash('success', 'Shop created successfully');
      return redirect()->route('user.shop.show', $shop->user_id);
    }

    public function edit($id) {
      $data['shop'] = Shop::where('user_id', Auth::user()->id)->first();
      return view('user.shop.edit', $data);
    }

    public function update(Request $request) {
      $shop = Shop::where('user_id', Auth::user()->id)->first();
      $logo = $request->file('logo');
      $cover = $request->file('cover');
      $allowedExts = array('jpg', 'png', 'jpeg');

      $validatedRequest = $request->validate([
        'logo' => [
          function($attribute, $value, $fail) use ($logo, $allowedExts) {
              $ext = $logo->getClientOriginalExtension();
              if(!in_array($ext, $allowedExts)) {
                  return $fail("Only png, jpg, jpeg images are allowed");
              }
          },
        ],
        'cover' => [
          function($attribute, $value, $fail) use ($cover, $allowedExts) {
              $ext = $cover->getClientOriginalExtension();
              if(!in_array($ext, $allowedExts)) {
                  return $fail("Only png, jpg, jpeg images are allowed");
              }
          },
        ],
        'shop_name' => 'required',
        'email' => 'required',
        'phone' => 'required',
        'opening_hour' => 'required',
        'closing_days' => 'required',
        'address' => 'required',
        'description' => 'required',
      ]);

      $in = Input::except('_token', 'logo', 'cover');
      $shop->fill($in)->save();

      if ($request->hasFile('logo')) {
        @unlink('assets/user/shop_logo/'.$shop->logo);
        $logofile = uniqid() . '.jpg';
        $logoloc = 'assets/user/shop_logo/' . $logofile;

        $logobg = Image::canvas(200, 150);
        $resizedlogo = Image::make($logo)->resize(200, 150, function ($c) {
            $c->aspectRatio();
            $c->upsize();
        });
        $logobg->insert($resizedlogo, 'center');
        $logobg->save($logoloc);

        $shop = Shop::find($shop->id);
        $shop->logo = $logofile;
        $shop->save();
      }

      if ($request->hasFile('cover')) {
        @unlink('assets/user/shop_cover/' . $shop->cover);
        $coverfile = uniqid() . '.jpg';
        $coverloc = 'assets/user/shop_cover/' . $coverfile;

        $coverbg = Image::canvas(1130, 415);
        $resizedcover = Image::make($cover)->resize(1130, 415, function ($c) {
            $c->aspectRatio();
            $c->upsize();
        });
        $coverbg->insert($resizedcover, 'center');
        $coverbg->save($coverloc);

        $shop = Shop::find($shop->id);
        $shop->cover = $coverfile;
        $shop->save();
      }

      Session::flash('success', 'Shop updated successfully');
      return redirect()->back();
    }
}
