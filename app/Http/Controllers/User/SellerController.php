<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Image as Img;
use App\Category;
use Auth;
use Session;
use Illuminate\Support\Facades\Input;
use Image;

class SellerController extends Controller
{
    public function create() {
      $data['cats'] = Category::all();
      return view('user.seller.create', $data);
    }


    public function store(Request $request) {
      $allowedExts = array('jpg', 'jpeg', 'png');
      $zipExts = array('zip');
      $preview = $request->file('preview_image');
      $zip = $request->file('zip');
      $validatedRequest = $request->validate([
        'title' => 'required|max:80',
        'price' => 'required|numeric',
        'description' => 'required',
        'preview_image' => [
          'required',
          function($attribute, $value, $fail) use ($preview, $allowedExts) {
              if (!empty($preview)) {
                $ext = $preview->getClientOriginalExtension();
                if(!in_array($ext, $allowedExts)) {
                    return $fail('Only jpg, jpeg, png files are allowed');
                }
              }
          }
        ],
        'category' => 'required',
        'tags' => 'required',
        'zip' => [
          'required',
          function($attribute, $value, $fail) use ($zip, $zipExts) {
              if (!empty($zip)) {
                if ($zip->getClientSize() > 5000000) {
                    return $fail("Maximum 5 MB can be uploaded");
                }

                $ext = $zip->getClientOriginalExtension();
                if(!in_array($ext, $zipExts)) {
                    return $fail('Only zip file is allowed');
                }
              }
          }
        ],
      ]);


      $in =  Input::except('_token', 'zip', 'preview_image');
      $img = Img::create($in);

      if($request->hasFile('zip')) {
        $fileName = time() . '.zip';
        $zip->move('assets/user/sel_zip/',$fileName);
        $img->zip = $fileName;
        $img->original_zip = $zip->getClientOriginalName();
      }


      if($request->hasFile('preview_image')) {
        $preview = $request->file('preview_image');
        $fileName = time() . '.jpg';
        $location = './assets/user/sel_preview/' . $fileName;
        $background = Image::canvas(730, 490);
        $resizedImage = Image::make($preview)->resize(730, 490, function ($c) {
            $c->aspectRatio();
            $c->upsize();
        });
        $watermark = Image::make('assets/user/interfaceControl/logoIcon/logo.jpg')->opacity(50)->rotate(45)->greyscale();
        $resizedImage->insert($watermark, 'center');
        $resizedImage->insert($watermark, 'top-left', 10, 10);
        $resizedImage->insert($watermark, 'top-right', 10, 10);
        $resizedImage->insert($watermark, 'bottom-left', 10, 10);
        $resizedImage->insert($watermark, 'bottom-right', 10, 10);
        // insert resized image centered into background
        $background->insert($resizedImage, 'center');
        // save or do whatever you like
        $background->save($location);
        $img->preview_image = $fileName;
        $img->original_preview = $preview->getClientOriginalName();
        $img->save();

      }

      Session::flash('success', 'Request sent successfully!');
      return redirect()->back();
    }


    public function edit($id) {
      $data['img'] = Img::find($id);
      $data['cats'] = Category::where('deleted', 0)->get();
      return view('user.seller.edit', $data);
    }



    public function update(Request $request) {
      $allowedExts = array('jpg', 'jpeg', 'png');
      $zipExts = array('zip');
      $preview = $request->file('preview_image');
      $zip = $request->file('zip');
      $validatedRequest = $request->validate([
        'title' => 'required|max:80',
        'price' => 'required|numeric',
        'description' => 'required',
        'preview_image' => [
          function($attribute, $value, $fail) use ($preview, $allowedExts) {
              if (!empty($preview)) {
                $ext = $preview->getClientOriginalExtension();
                if(!in_array($ext, $allowedExts)) {
                    return $fail('Only jpg, jpeg, png files are allowed');
                }
              }
          }
        ],
        'category' => 'required',
        'tags' => 'required',
        'zip' => [
          function($attribute, $value, $fail) use ($zip, $zipExts) {
              if (!empty($zip)) {
                $ext = $zip->getClientOriginalExtension();
                if(!in_array($ext, $zipExts)) {
                    return $fail('Only zip file is allowed');
                }
              }
          }
        ],
      ]);


      $in =  Input::except('_token', 'zip', 'preview_image', 'imgId');
      $img = Img::find($request->imgId);
      $img->fill($in)->save();

      if($request->hasFile('zip')) {
        $path = './assets/user/sel_zip/' . $img->zip;
        @unlink($path);
        $fileName = time() . '.zip';
        $zip->move('assets/user/sel_zip/',$fileName);
        $img->zip = $fileName;
        $img->original_zip = $zip->getClientOriginalName();
        $img = $img->save();
      }


      if($request->hasFile('preview_image')) {
        $path = './assets/user/sel_preview/' . $img->preview_image;
        @unlink($path);
        $preview = $request->file('preview_image');
        $fileName = time() . '.jpg';
        $location = './assets/user/sel_preview/' . $fileName;
        $background = Image::canvas(730, 490);
        $resizedImage = Image::make($preview)->resize(730, 490, function ($c) {
            $c->aspectRatio();
            $c->upsize();
        });
        $watermark = Image::make('assets/user/interfaceControl/logoIcon/logo.jpg')->opacity(50)->rotate(45)->greyscale();
        $resizedImage->insert($watermark, 'center');
        $resizedImage->insert($watermark, 'top-left', 10, 10);
        $resizedImage->insert($watermark, 'top-right', 10, 10);
        $resizedImage->insert($watermark, 'bottom-left', 10, 10);
        $resizedImage->insert($watermark, 'bottom-right', 10, 10);
        // insert resized image centered into background
        $background->insert($resizedImage, 'center');
        // save or do whatever you like
        $background->save($location);
        $img->preview_image = $fileName;
        $img->original_preview = $preview->getClientOriginalName();
        $img = $img->save();
      }

      Session::flash('success', 'Updated successfully!');
      return redirect()->back();
    }


    public function manage() {
      $data['all'] = Img::where('user_id', Auth::user()->id)->latest()->get();
      $data['pending'] = Img::where('user_id', Auth::user()->id)->where('published', 0)->latest()->get();
      $data['published'] = Img::where('user_id', Auth::user()->id)->where('published', 1)->latest()->get();
      $data['featured'] = Img::where('user_id', Auth::user()->id)->where('featured', 1)->latest()->get();
      $data['unfeatured'] = Img::where('user_id', Auth::user()->id)->where('featured', 0)->latest()->get();
      $data['hidden'] = Img::where('user_id', Auth::user()->id)->where('u_hidden', 1)->latest()->get();
      $data['shown'] = Img::where('user_id', Auth::user()->id)->where('u_hidden', 0)->latest()->get();
      return view('user.seller.manage', $data);
    }

    public function hideImg(Request $request) {
        // return $serviceID;
        $imgID = $request->id;
        $img = Img::find($imgID);
        $img->u_hidden = 1;
        $img->save();
        return "success";
    }

    public function showImg(Request $request) {
        $imgID = $request->id;
        $img = Img::find($imgID);
        $img->u_hidden = 0;
        $img->save();
        return "success";
    }
}
