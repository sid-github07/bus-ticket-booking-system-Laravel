<?php

namespace App\Http\Controllers\Admin\InterfaceControl;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\GeneralSetting as GS;
use Session;
use Image;

class ContactController extends Controller
{
    public function index() {
      return view('admin.interfaceControl.contact.index');
    }

    public function update(Request $request) {
      $messages = [
        'con_title.required' => 'Title is required',
      ];

      $validatedData = $request->validate([
        'con_title' => 'required',
        'address' => 'required',
        'phone' => 'required',
        'email' => 'required',
        'latitude' => 'required',
        'longitude' => 'required',
      ], $messages);

      $gs = GS::first();
      $gs->con_title = $request->con_title;
      $gs->con_sdetails = $request->con_sdetails;
      $gs->address = $request->address;
      $gs->phone = $request->phone;
      $gs->email = $request->email;
      $gs->latitude = $request->latitude;
      $gs->longitude = $request->longitude;
      $gs->save();

      Session::flash('success', 'Contact updated successfully!');
      return redirect()->back();
    }
}
