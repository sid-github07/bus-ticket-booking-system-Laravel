<?php

namespace App\Http\Controllers\Admin\InterfaceControl;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\GeneralSetting as GS;
use Session;


class LoungeController extends Controller
{
    public function index() {
      return view('admin.interfaceControl.lounge.index');
    }

    public function update(Request $request) {
        $validatedRequest = $request->validate([
            'lounge_title' => 'required',
            'lounge_details' => 'required',
        ]);
        // return $request->all();
        $gs = GS::first();
        $gs->lounge_title = $request->lounge_title;
        $gs->lounge_details = $request->lounge_details;
        $gs->save();
        Session::flash('success', 'Updated successfully!');
        return redirect()->back();
    }
}
