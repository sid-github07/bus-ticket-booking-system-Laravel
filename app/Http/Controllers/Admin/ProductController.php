<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Product;

class ProductController extends Controller
{
    public function all(Request $request) {
      if (empty($request->term)) {
        $data['term'] = '';
        $data['pros'] = Product::latest()->paginate(9);
      } else {
        $data['term'] = $request->term;
        $data['pros'] = Product::where('title', 'like', '%'.$request->term.'%')->latest()->paginate(9);
      }
      return view('admin.adman.index', $data);
    }

    public function pending(Request $request) {
      if (empty($request->term)) {
        $data['term'] = '';
        $data['pros'] = Product::where('published', 0)->latest()->paginate(9);
      } else {
        $data['term'] = $request->term;
        $data['pros'] = Product::where('title', 'like', '%'.$request->term.'%')->where('published', 0)->latest()->paginate(10);
      }
      return view('admin.adman.index', $data);
    }

    public function published(Request $request) {
      if (empty($request->term)) {
        $data['term'] = '';
        $data['pros'] = Product::where('published', 1)->latest()->paginate(9);
      } else {
        $data['term'] = $request->term;
        $data['pros'] = Product::where('title', 'like', '%'.$request->term.'%')->where('published', 1)->latest()->paginate(10);
      }

      return view('admin.adman.index', $data);
    }

    public function featured(Request $request) {
      if (empty($request->term)) {
        $data['term'] = '';
        $data['pros'] = Product::where('featured', 1)->latest()->paginate(9);
      } else {
        $data['term'] = $request->term;
        $data['pros'] = Product::where('title', 'like', '%'.$request->term.'%')->where('featured', 1)->latest()->paginate(10);
      }
      return view('admin.adman.index', $data);
    }

    public function unfeatured(Request $request) {
      if (empty($request->term)) {
        $data['term'] = '';
        $data['pros'] = Product::where('featured', 0)->latest()->paginate(9);
      } else {
        $data['term'] = $request->term;
        $data['pros'] = Product::where('title', 'like', '%'.$request->term.'%')->where('featured', 0)->latest()->paginate(10);
      }
      return view('admin.adman.index', $data);
    }

    public function hidden(Request $request) {
      if (empty($request->term)) {
        $data['term'] = '';
        $data['pros'] = Product::where('a_hidden', 1)->latest()->paginate(9);
      } else {
        $data['term'] = $request->term;
        $data['pros'] = Product::where('title', 'like', '%'.$request->term.'%')->where('a_hidden', 1)->latest()->paginate(10);
      }
      return view('admin.adman.index', $data);
    }

    public function shown(Request $request) {
      if (empty($request->term)) {
        $data['term'] = '';
        $data['pros'] = Product::where('a_hidden', 0)->latest()->paginate(9);
      } else {
        $data['term'] = $request->term;
        $data['pros'] = Product::where('title', 'like', '%'.$request->term.'%')->where('a_hidden', 0)->latest()->paginate(10);
      }
      return view('admin.adman.index', $data);
    }

    public function hide(Request $request) {
        $proID = $request->id;
        $pro = Product::find($proID);
        $pro->a_hidden = 1;
        $pro->save();
        return "success";
    }

    public function show(Request $request) {
        $proID = $request->id;
        $pro = Product::find($proID);
        $pro->a_hidden = 0;
        $pro->save();
        return "success";
    }

    public function changePublishStatus(Request $request) {
        $proID = $request->id;
        $publishStatus = $request->publishStatus;
        $pro = Product::find($proID);
        $pro->published = $publishStatus;
        $pro->save();
        return "success";
    }
}
