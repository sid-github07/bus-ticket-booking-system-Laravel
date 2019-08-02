<?php

namespace App\Http\Controllers\Admin\InterfaceControl;

use Illuminate\Http\Request;
use App\GeneralSetting as GS;
use App\Slider;
use App\Http\Controllers\Controller;
use Session;

class SliderController extends Controller
{
    public function index() {
      $data['sliders'] = Slider::all();
      return view('admin.interfaceControl.slider.index', $data);
    }

    public function store(Request $request) {
      if (Slider::count() == 3) {
        Session::flash('alert', 'You cannot add more than 3 slider texts!');
        return redirect()->back();
      }

      $messages = [
        'btext.required' => 'bold text field is required',
        'stext.required' => 'small text field is required',
      ];
      $validatedData = $request->validate([
          'btxt' => 'required',
          'stxt' => 'required'
      ], $messages);

      $slider = new Slider;
      $slider->small_text = $request->stxt;
      $slider->bold_text = $request->btxt;
      $slider->save();
      Session::flash('success', 'Slider text added successfully!');
      return redirect()->back();
    }

    public function delete(Request $request) {
      $slider = Slider::find($request->sliderID);
      $imagePath = './assets/user/interfaceControl/slider/' . $slider->image;
      @unlink($imagePath);
      $slider->delete();

      Session::flash('success', 'Slider image deleted successfully!');
      return redirect()->back();
    }
}
