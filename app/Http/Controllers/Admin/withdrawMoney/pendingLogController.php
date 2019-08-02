<?php

namespace App\Http\Controllers\Admin\withdrawMoney;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\GeneralSettings as GS;
use App\Withdraw as Withdraw;


class pendingLogController extends Controller
{
    public function pendingLog() {
      $data['withdraws'] = Withdraw::where('status', 'pending')->latest()->paginate(15);
      return view('admin.withdrawMoney.PendingLog.PendingRequests', $data);
    }
}
