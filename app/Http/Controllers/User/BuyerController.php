<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use App\Sale;

class BuyerController extends Controller
{
    public function shopping() {
      $data['sales'] = Sale::where('buyer_id', Auth::user()->id)->get();
      return view('user.shopping.shopping', $data);
    }
}
