<?php

namespace App\Http\Controllers\Admin\InterfaceControl;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\GeneralSetting as GS;
use Session;

class HeaderTextController extends Controller
{
    public function index() {
      return view('admin.interfaceControl.headerText.index');
    }

    public function update(Request $request) {
      $messages = [
          'sText.required' => 'Small Text field is required',
          'bText.required' => 'Bold Text field is required',
      ];
      $validatedRequest = $request->validate([
          'sText' => 'required',
          'bText' => 'required',
      ], $messages);
      // return $request->all();
      $gs = GS::first();
      $gs->header_stext = $request->sText;
      $gs->header_btext = $request->bText;
      $gs->save();
      Session::flash('success', 'Header text updated successfully!');
      return redirect()->back();
    }
}
