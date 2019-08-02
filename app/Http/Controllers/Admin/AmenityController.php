<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Amenity;
use Session;

class AmenityController extends Controller
{
    public function index() {
      $data['ams'] = Amenity::latest()->paginate(10);
      return view('admin.amenity.index', $data);
    }

    public function store(Request $request) {
      $validatedRequest = $request->validate([
        'code' => 'required',
        'name' => 'required',
        'status' => 'required',
      ]);

      $am = new Amenity;
      $am->name = $request->name;
      $am->code = $request->code;
      $am->status = $request->status;
      $am->save();

      Session::flash('success', 'Amenity added successfully');
      return redirect()->back();
    }

    public function update(Request $request) {
      $validatedRequest = $request->validate([
        'code' => 'required',
        'name' => 'required',
      ]);

      $am = Amenity::find($request->statusId);
      $am->name = $request->name;
      $am->code = $request->code;
      $am->status = $request->status;
      $am->save();

      Session::flash('success', 'Amenity updated successfully');
      return redirect()->back();
    }

}
