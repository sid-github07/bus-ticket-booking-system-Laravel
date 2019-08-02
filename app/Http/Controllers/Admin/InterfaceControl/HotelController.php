<?php

namespace App\Http\Controllers\Admin\InterfaceControl;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\GeneralSetting as GS;
use Session;


class HotelController extends Controller
{
    public function index() {
      return view('admin.interfaceControl.hotel.index');
    }

    public function update(Request $request) {
        $validatedRequest = $request->validate([
            'hotel_title' => 'required',
            'hotel_details' => 'required',
        ]);
        // return $request->all();
        $gs = GS::first();
        $gs->hotel_title = $request->hotel_title;
        $gs->hotel_details = $request->hotel_details;
        $gs->save();
        Session::flash('success', 'Updated successfully!');
        return redirect()->back();
    }
}
