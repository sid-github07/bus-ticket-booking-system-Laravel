<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\GeneralSetting as GS;
use Session;

class TosController extends Controller
{
    public function index() {
      return view('admin.tos.index');
    }

    public function update(Request $request) {
      $messages = [
        'tos.required' => 'Terms & Privacy field is required'
      ];

      $validatedRequest = $request->validate([
        'tos' => 'required'
      ], $messages);

      $gs = GS::first();
      $gs->tos = $request->tos;
      $gs->save();
      Session::flash('success', 'Terms and Privacy updated successfully!');

      return redirect()->back();
    }
}
