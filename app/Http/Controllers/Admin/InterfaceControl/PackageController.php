<?php

namespace App\Http\Controllers\Admin\InterfaceControl;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\GeneralSetting as GS;
use Session;


class PackageController extends Controller
{
    public function index() {
      return view('admin.interfaceControl.package.index');
    }

    public function update(Request $request) {
        $validatedRequest = $request->validate([
            'package_title' => 'required',
            'package_details' => 'required',
        ]);
        // return $request->all();
        $gs = GS::first();
        $gs->package_title = $request->package_title;
        $gs->package_details = $request->package_details;
        $gs->save();
        Session::flash('success', 'Updated successfully!');
        return redirect()->back();
    }
}
