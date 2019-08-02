<?php

namespace App\Http\Controllers\Admin\InterfaceControl;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\GeneralSetting as GS;
use Session;

class fbCommentController extends Controller
{
    public function index() {
        return view('admin.interfaceControl.fbComment.index');
    }

    public function update(Request $request) {
      $gs = GS::first();
      $gs->comment_script = $request->comment_script;
      $gs->save();
      Session::flash('success', 'Comment script updated successfully!');
      return redirect()->back();
    }
}
