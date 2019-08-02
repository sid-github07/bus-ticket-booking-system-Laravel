<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use App\DropoffLocation;
use Session;

class DropoffController extends Controller
{
    public function index($id) {
      $data['term'] = '';
      $data['dropoffs'] = DropoffLocation::where('pickup_car_id', $id)->paginate(10);
      return view('admin.dropoff.index', $data);
    }

    public function create($pickupid) {
      $data['pickup_car_id'] = $pickupid;
      return view('admin.dropoff.create', $data);
    }

    public function edit($id) {
      $data['dropoff'] = DropoffLocation::find($id);
      return view('admin.dropoff.edit', $data);
    }

    public function store(Request $request) {
      $validator = $request->validate([
        'location' => 'required',
        'price' => 'required'
      ]);

      $in = Input::except('_token');
      DropoffLocation::create($in);

      Session::flash('success', 'Dropoff location added');
      return back();
    }

    public function update(Request $request) {
      $dropoff = DropoffLocation::find($request->dropoffid);

      $validator = $request->validate([
        'location' => 'required',
        'price' => 'required',
      ]);

      $in = Input::except('_token', 'dropoffid');
      $dropoff->fill($in)->save();

      Session::flash('success', 'Dropoff location updated');
      return back();
    }

    public function hide(Request $request) {
        $dropoffID = $request->id;
        $dropoff = DropoffLocation::find($dropoffID);
        $dropoff->a_hidden = 1;
        $dropoff->save();
        return "success";
    }

    public function show(Request $request) {
        $dropoffID = $request->id;
        $dropoff = DropoffLocation::find($dropoffID);
        $dropoff->a_hidden = 0;
        $dropoff->save();
        return "success";
    }
}
