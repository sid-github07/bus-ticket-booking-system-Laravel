<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use App\Menu;
use App\Hotel;
use App\RentCar;
use App\PickupCar;
use App\DropoffLocation;
use App\Testim;
use App\Lounge;
use App\GeneralSetting as GS;
use App\User;
use App\Package;
use App\BuyPackage;
use App\RoomBooking;
use App\LoungeBooking;
use App\Slider;
use App\Choose;
use Session;
use DB;

class PagesController extends Controller
{

    public function home() {
      $data['buypackages'] = BuyPackage::select('package_id')->groupBy('package_id')->orderBy(\DB::raw('count(package_id)'), 'DESC')->take(6)->get();
      $data['roombookings'] = RoomBooking::select('room_id')->groupBy('room_id')->orderBy(DB::raw('count(room_id)'), 'DESC')->take(6)->get();
      $data['loungebookings'] = LoungeBooking::select('lounge_id')->groupBy('lounge_id')->orderBy(DB::raw('count(lounge_id)'), 'DESC')->take(6)->get();
      $data['package_lf'] = Package::groupBy('leaving_from')->select('leaving_from')->orderBy('leaving_from', 'ASC')->get();
      $data['package_lt'] = Package::groupBy('leaving_to')->select('leaving_to')->orderBy('leaving_to', 'ASC')->get();
      $data['hotel_ad'] = Hotel::groupBy('address')->select('address')->orderBy('address', 'ASC')->get();
      $data['rent_ad'] = RentCar::groupBy('address')->select('address')->orderBy('address', 'ASC')->get();
      $data['pickup_loc'] = PickupCar::groupBy('pickup_location')->select('pickup_location')->orderBy('pickup_location', 'ASC')->get();
      $data['drop_loc'] = DropoffLocation::groupBy('location')->select('location')->orderBy('location', 'ASC')->get();
      $data['lounge_loc'] = Lounge::groupBy('location')->select('location')->orderBy('location', 'ASC')->get();
      $data['sliders'] = Slider::all();
      $data['chooses'] = Choose::all();
      return view('user.home', $data);
    }

    public function about() {
      return view('user.about');
    }


    public function hotels() {
      $data['hotels'] = Hotel::where('a_hidden', 0)->orderBy('id', 'DESC')->paginate(10);
      return view('user.hotel.index', $data);
    }

    public function contact() {
      return view('user.contact');
    }

    public function contactMail(Request $request) {
      $validatedRequest = $request->validate([
        'name' => 'required',
        'email' => 'required',
        'subject' => 'required',
        'message' => 'required',
      ]);

      $gs = GS::first();
      $from = $request->email;
      $to = $gs->email;
      $subject = $request->subject;
      $name = $request->name;
      $message = nl2br($request->message . "<br /><br />From <strong>" . $name . "</strong>");


      $headers = "From: $name <$from> \r\n";
      $headers .= "Reply-To: $name <$from> \r\n";
      $headers .= "MIME-Version: 1.0\r\n";
      $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";


       mail($to, $subject, $message, $headers);
      Session::flash('success', 'Mail sent successfully!');
      return redirect()->back();
    }

    public function dynamicPage($slug) {
      $data['menu'] = Menu::where('slug', $slug)->first();
      return view('user.dynamic', $data);
    }


}
