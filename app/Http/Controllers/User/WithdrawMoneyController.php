<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\WithdrawMethod as WM;
use App\Withdraw;
use App\Social as Social;
use App\User as User;
use Auth;
use Validator;

class WithdrawMoneyController extends Controller
{
    public function withdrawMoney() {
      $wms = WM::where('deleted', 0)->get();
      $data['wms'] = $wms;
      $data['socials'] = Social::all();

      return view('user.withdrawMoney.withdrawMoney', $data);
    }

    public function store(Request $request) {
      $wm = WM::find($request->wmID);
      // calculating the total charge for this withdraw method and this requested amount...
      $charge = $wm->fixed_charge + (($wm->percentage_charge*$request->amount)/100);

      $rules = [
        'amount' => [
          'required',
          function($attribute, $value, $fail) use ($charge, $wm) {
            // if the amount is greater than maximum limit...
            if ($value > $wm->max_limit) {
              return $fail('Maximum amount limit is '.$wm->max_limit);
            }
            // if user balance is less than (requested amount + charge)...
            if (Auth::user()->balance < ($value + $charge)) {
              return $fail('You dont have enough balance in your account to make this withdraw request!');
            }
            // if the amount is less than minimum limit...
            if ($value < $wm->min_limit) {
              return $fail('Minimum amount limit is '.$wm->min_limit);
            }
          }
        ],
        'details' => 'required'
      ];

      $validator = Validator::make($request->all(), $rules);

      if ($validator->fails()) {
        $validator->getMessageBag()->add('error', 'true');
        return response()->json($validator->errors());
      }

      // if all validation passes then save the withdraw request in the database...
      $withdraw = new Withdraw;
      $withdraw->trx = str_random(12);
      $withdraw->user_id = Auth::user()->id;
      $withdraw->amount = $request->amount;
      $withdraw->withdraw_method_id = $wm->id;
      $withdraw->charge = $charge;
      $withdraw->status = 'pending';
      $withdraw->details = $request->details;
      $withdraw->save();

      // cut user balance..
      $user = User::find(Auth::user()->id);
      $user->balance = $user->balance - ($withdraw->charge + $withdraw->amount);
      $user->save();

      return "success";
    }
}
