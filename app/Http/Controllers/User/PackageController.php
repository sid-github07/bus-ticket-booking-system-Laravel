<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use App\Package;
use App\Transaction;
use App\User;
use App\BuyPackage;
use Auth;
use Session;

class PackageController extends Controller
{
    public function index() {
      $data['packages'] = Package::where('a_hidden', 0)->orderBy('id', 'DESC')->paginate(9);
      return view('user.package.index', $data);
    }

    public function show($id) {
      $data['package'] = Package::find($id);
      return view('user.package.show', $data);
    }

    public function buy(Request $request) {

      $package = Package::find($request->package_id);
      if (Auth::user()->balance < ($package->price*$request->persons)) {
        Session::flash('alert', 'Sorry you dont enough balance');
        return back();
      }

      $in = Input::all();
      BuyPackage::create($in);

      $user = User::find(Auth::user()->id);
      $user->balance = $user->balance - ($package->price*$request->persons);
      $user->save();

      // saving to transactions table
      $tr = new Transaction;
      $tr->user_id = $user->id;
      $tr->details = "Booked Package";
      $tr->amount = $package->price*$request->persons;
      $tr->trx_id = str_random(16);
      $tr->after_balance = $user->balance;
      $tr->save();

      Session::flash('success', 'Package has been booked. Admin will contact you later.');
      return back();
    }

    public function search(Request $request) {
      $data['packages'] = Package::when($request->leaving_from, function ($query) use ($request) {
                          return $query->where('leaving_from', 'like', '%'.$request->leaving_from.'%');
                      })
                      ->when($request->leaving_to, function ($query) use ($request) {
                          return $query->where('leaving_to', 'like', '%'.$request->leaving_to.'%');
                      })
                      ->when($request->duration, function ($query) use ($request) {
                          return $query->where('duration', $request->duration);
                      })
                      ->when($request->persons, function ($query) use ($request) {
                          return $query->where('minimum_persons', '<=', $request->persons)->where('maximum_persons', '>=', $request->persons);
                      })
                      ->get();
      return view('user.search.package', $data);
    }
}
