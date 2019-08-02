<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Favorite;
use App\Product;
use Auth;

class FavoriteController extends Controller
{
    public function index() {
      $favs = Favorite::select('product_id')->where('user_id', Auth::user()->id)->orderBy('id', 'DESC')->get();
      $proids = [];
      foreach($favs as $fav) {
        $proids[] = $fav->product_id;
      }
      $data['pros'] = Product::whereIn('id', $proids)->paginate(10);
      return view('user.showmore', $data);
    }
}
