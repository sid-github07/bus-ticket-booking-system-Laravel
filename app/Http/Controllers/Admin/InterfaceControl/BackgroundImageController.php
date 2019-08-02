<?php

namespace App\Http\Controllers\Admin\InterfaceControl;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\GeneralSettings as GS;
use Session;

class BackgroundImageController extends Controller
{
  public function background()
  {
      return view('admin.interfaceControl.background.index');
  }

  public function backgroundUpdate(Request $request)
  {

        $validatedRequest = $request->validate([
          'page_header' => 'image|mimes:jpeg,png,jpg,gif,svg|max:8048',
          'slider_area' => 'image|mimes:jpeg,png,jpg,gif,svg|max:8048',
          'subscription' => 'image|mimes:jpeg,png,jpg,gif,svg|max:8048',
          'package' => 'image|mimes:jpeg,png,jpg,gif,svg|max:8048',
          'lounge' => 'image|mimes:jpeg,png,jpg,gif,svg|max:8048',
        ]);

         if($request->hasFile('page_header')) {
           $pageheaderpath = './assets/user/interfaceControl/backgroundImage/pageheader.jpg';
           @unlink($pageheaderpath);
           $request->file('page_header')->move('assets/user/interfaceControl/backgroundImage/','pageheader.jpg');
         }

         if($request->hasFile('slider_area')) {
           $sliderareapath = './assets/user/interfaceControl/backgroundImage/sliderarea.jpg';
           @unlink($sliderareapath);
           $request->file('slider_area')->move('assets/user/interfaceControl/backgroundImage/','sliderarea.jpg');
         }

         if($request->hasFile('subscription')) {
           $subscareapath = './assets/user/interfaceControl/backgroundImage/subscription.jpg';
           @unlink($subscareapath);
           $request->file('subscription')->move('assets/user/interfaceControl/backgroundImage/','subscription.jpg');
         }

         if($request->hasFile('package')) {
           $packageareapath = './assets/user/interfaceControl/backgroundImage/package.jpg';
           @unlink($packageareapath);
           $request->file('package')->move('assets/user/interfaceControl/backgroundImage/','package.jpg');
         }

         if($request->hasFile('lounge')) {
           $loungeareapath = './assets/user/interfaceControl/backgroundImage/lounge.jpg';
           @unlink($loungeareapath);
           $request->file('lounge')->move('assets/user/interfaceControl/backgroundImage/','lounge.jpg');
         }

        return back()->with('success', 'Background Image  Updated');
    }
}
