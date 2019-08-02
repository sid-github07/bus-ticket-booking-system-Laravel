<?php

namespace App\Http\Controllers\Admin\InterfaceControl;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\GeneralSetting as GS;
use App\Choose;
use Session;


class ChooseSectionController extends Controller
{
    public function index() {
      $data['chooses'] = Choose::all();
      return view('admin.interfaceControl.choose.index', $data);
    }

    public function textupdate(Request $request) {
        $validatedRequest = $request->validate([
            'title' => 'required',
            'details' => 'required',
        ]);

        $gs = GS::first();
        $gs->choose_title = $request->title;
        $gs->choose_details = $request->details;
        $gs->save();

        Session::flash('success', 'Updated Successfully');
        return redirect()->back();
    }

    public function store(Request $request) {
        if (Choose::count() == 4) {
          Session::flash('alert', 'You cannot add more than 4 services');
          return back();
        }


        $validatedRequest = $request->validate([
            'icon' => 'required',
            'small_text' => 'required',
            'bold_text' => 'required'
        ]);

        $choose = new Choose;
        $choose->icon = $request->icon;
        $choose->bold_text = $request->bold_text;
        $choose->small_text = $request->small_text;
        $choose->save();

        Session::flash('success', 'Added Successfully');
        return redirect()->back();
    }

    public function update(Request $request, $id) {
        $validatedRequest = $request->validate([
            'bold_text' => 'required',
            'small_text' => 'required',
            'icon' => 'required'
        ]);

        $choose = Choose::find($id);
        $choose->bold_text = $request->bold_text;
        $choose->small_text = $request->small_text;
        $choose->icon = $request->icon;
        $choose->save();

        Session::flash('success', 'Updated Successfully');
        return redirect()->back();
    }

    public function destroy(Request $request) {
        $id = $request->chooseid;
        $choose = Choose::find($id);
        $choose->delete();
        Session::flash('success', 'Deleted Successfully');
        return redirect()->back();
    }
}
