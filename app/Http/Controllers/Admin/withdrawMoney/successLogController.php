<?php

namespace App\Http\Controllers\Admin\withdrawMoney;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Withdraw as Withdraw;

class successLogController extends Controller
{
    public function successLog() {
      $data['withdraws'] = Withdraw::where('status', 'processed')->latest()->paginate(15);
      return view('admin.withdrawMoney.successLog.successLog', $data);
    }
}
