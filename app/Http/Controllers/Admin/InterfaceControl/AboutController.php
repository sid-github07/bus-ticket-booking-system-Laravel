<?php

namespace App\Http\Controllers\Admin\InterfaceControl;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\GeneralSetting as GS;
use Session;
use Image;

class AboutController extends Controller
{
    public function index() {
      return view('admin.interfaceControl.about.index');
    }

    public function update(Request $request) {
      $request->validate([
        'content' => 'required',
        'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:8048',
      ]);
      $gs = GS::first();
      $gs->about_content = $request->content;
      if($request->hasFile('image')) {
        $imagePath = 'assets/user/img/' . $gs->about_img;
        @unlink($imagePath);

        $image = $request->file('image');
        $fileName = time() . '.jpg';
        $location = 'assets/user/img/' . $fileName;
        Image::make($image)->resize(555, 325)->save($location);
        $gs->about_img = $fileName;
      }
      $gs->save();
      Session::flash('success', 'About page updated successfully!');
      return redirect()->back();
    }
}
