<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use App\User;
use App\Image as Img;
use Validator;
use Hash;
use Auth;
use Session;
use Image;

class ProfileController extends Controller
{
    public function profile($username) {
      // return $username;
      $user = User::where('username', $username)->first();
      $data['user'] = $user;
      if (Auth::check()) {
        if (Auth::user()->id == $user->id) {
          $data['imgs'] = Img::where('user_id', $user->id)->latest()->take(9)->get();
        } else {
          $data['imgs'] = Img::where('user_id', $user->id)->where('published', 1)->where('u_hidden', 0)->where('a_hidden', 0)->latest()->take(9)->get();
        }
      } else {
        $data['imgs'] = Img::where('user_id', $user->id)->where('published', 1)->where('u_hidden', 0)->where('a_hidden', 0)->latest()->take(9)->get();
      }

      return view('user.profile.profile', $data);
    }

    public function changePassword() {
        return view('user.profile.changePassword');
    }

    public function updatePassword(Request $request) {
        $messages = [
            'password.required' => 'The new password field is required',
            'password.confirmed' => "Password does'nt match"
        ];

        $validator = Validator::make($request->all(), [
            'old_password' => 'required',
            'password' => 'required|confirmed'
        ], $messages);
        // if given old password matches with the password of this authenticated user...
        if(Hash::check($request->old_password, Auth::user()->password)) {
            $oldPassMatch = 'matched';
        } else {
            $oldPassMatch = 'not_matched';
        }
        if ($validator->fails() || $oldPassMatch=='not_matched') {
            if($oldPassMatch == 'not_matched') {
              $validator->errors()->add('oldPassMatch', true);
            }
            return redirect()->route('users.editPassword')
                        ->withErrors($validator);
        }

        // updating password in database...
        $user = User::find(Auth::user()->id);
        $user->password = bcrypt($request->password);
        $user->save();

        Session::flash('success', 'Password changed successfully!');

        return redirect()->route('users.editPassword');
    }


    public function editprofile() {
        return view('user.profile.editprofile');
    }


    public function updateprofile(Request $request) {
      $request->validate([
        'address' => 'max:190',
        'name' => 'required'
      ]);

      $in = Input::except('_token', 'pro_pic');
      $user = User::find(Auth::user()->id);
      $user->fill($in)->save();

      if($request->hasFile('pro_pic')) {
        $imagePath = './assets/user/img/pro-pic/' . $user->pro_pic;
        @unlink($imagePath);

        $image = $request->file('pro_pic');
        $fileName = time() . '.jpg';
        $location = './assets/user/img/pro-pic/' . $fileName;
        Image::make($image)->resize(250, 250)->save($location);
        $user->pro_pic = $fileName;
        $user->save();
      }

      Session::flash('success', 'Profile updated successfully!');
      return back();

    }

    public function images($username) {
      $user = User::where('username', $username)->first();
      $data['user'] = $user;
      if (Auth::check()) {
        if (Auth::user()->id == $user->id) {
          $data['imgs'] = Img::where('user_id', $user->id)->latest()->paginate(9);
        } else {
          $data['imgs'] = Img::where('user_id', $user->id)->where('published', 1)->where('u_hidden', 0)->where('a_hidden', 0)->latest()->paginate(9);
        }
      } else {
        $data['imgs'] = Img::where('user_id', $user->id)->where('published', 1)->where('u_hidden', 0)->where('a_hidden', 0)->latest()->paginate(9);
      }

      return view('user.profile.images', $data);
    }
}
