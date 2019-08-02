<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Image as Img;
use App\User;
use App\Transaction;
use App\Sale;
use Auth;
use Session;

class ImgController extends Controller
{
    public function show($id) {
      $data['img'] = Img::find($id);
      $tagString = $data['img']->tags;
      $data['tagArr'] = explode(',', $tagString);
      return view('user.img.show', $data);
    }

    public function buy(Request $request) {
      $img = Img::find($request->imgID);
      $buyer = User::find(Auth::user()->id);

      // check user has enough balance
      if ($buyer->balance < $img->price) {
        Session::flash('alert', 'You dont have enough balance to buy this image.');
        return redirect()->back();
      }

      // cut buyer balance
      $buyer->balance = $buyer->balance - $img->price;
      $buyer->save();
      // save into transaction table for buyer
      $tr = new Transaction;
      $tr->user_id = $buyer->id;
      $tr->details = "Bought Image";
      $tr->amount = $img->price;
      $tr->trx_id = str_random(16);
      $tr->after_balance = $buyer->balance;
      $tr->save();


      // add seller balance
      $seller = User::find($img->user->id);
      $seller->balance = $seller->balance + $img->price;
      $seller->save();
      // save into transaction table for seller
      $tr = new Transaction;
      $tr->user_id = $seller->id;
      $tr->details = "Sold Image";
      $tr->amount = $img->price;
      $tr->trx_id = str_random(16);
      $tr->after_balance = $seller->balance;
      $tr->save();


      // store in sales table
      $sale = new Sale;
      $sale->buyer_id = $buyer->id;
      $sale->seller_id = $seller->id;
      $sale->image_id = $img->id;
      $sale->price = $img->price;
      $sale->save();


      // download image
      Session::flash('success', 'You have bought image successfully. Wait till the file is being downloaded...');
      Session::flash('download', 'You have bought this image');
      return redirect()->back();
      // make button downloaded for that buyer who bought this image
    }

    public function download(Request $request) {
      $img = Img::find($request->imgID);
      return response()->download('assets/user/sel_zip/'.$img->zip, $img->original_zip);
    }
}
