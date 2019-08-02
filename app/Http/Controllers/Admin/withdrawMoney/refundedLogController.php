<?php

namespace App\Http\Controllers\Admin\withdrawMoney;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Withdraw as Withdraw;

class refundedLogController extends Controller
{
    public function refundedLog() {
      $data['withdraws'] = Withdraw::where('status', 'refunded')->latest()->paginate(15);
      return view('admin.withdrawMoney.refundedLog.refundedLog', $data);
    }
}
