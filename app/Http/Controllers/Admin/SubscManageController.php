<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Subscriber;
use Session;

class SubscManageController extends Controller
{
    public function subscribers() {
      $data['subscribers'] = Subscriber::all();
      return view('admin.subscribers.index', $data);
    }

    public function mailtosubsc(Request $request) {
      $validatedRequest = $request->validate([
        'subject' => 'required',
        'message' => 'required'
      ]);
      $subscribers = Subscriber::all();
      foreach ($subscribers as $subscriber) {
        $to = $subscriber->email;
        $name = $subscriber->firstname;
        $subject = $request->subject;
        $message = $request->message;
        send_email( $to, $name, $subject, $message);
      }
      Session::flash('success', 'Mail sent to all subscribers.');
      return redirect()->back();
    }
}
