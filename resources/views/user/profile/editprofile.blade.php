@extends('user.layout.master')

@section('title', "Edit Profile")

@section('content')

    <div style="padding:110px 0px 70px;">
      <div class="container">
          <div class="row">
              <div class="col-md-8 offset-md-2">
                <div class="card">
                  <div class="card-header base-bg">
                    <h2 class="py-3 caption no-margin">Edit Profile</h2>
                  </div>
                  <div class="card-body">
                    <form class="contact-from-wrapper" method="post" action="{{route('users.updateprofile')}}" enctype="multipart/form-data">
                        {{csrf_field()}}
                        <div class="fileinput fileinput-new" data-provides="fileinput">
                            <div class="fileinput-new thumbnail">
                                @if (empty(Auth::user()->pro_pic))
                                <img src="{{asset('assets/user/img/pro-pic/nopic.png')}}" alt="" />
                                @else
                                <img src="{{asset('assets/user/img/pro-pic/' . Auth::user()->pro_pic)}}" alt="" />
                                @endif
                            </div>
                            <div class="fileinput-preview fileinput-exists thumbnail" style="width: 250px;"> </div>
                            <p><strong>[images will be resized to 250X250]</strong></p>
                            <div>
                                <span class="btn btn-success btn-file">
                                    <span class="fileinput-new"> Choose Image </span>
                                    <span class="fileinput-exists"> Change </span>
                                    <input type="file" name="pro_pic">
                                </span>
                                <a href="javascript:;" class="btn btn-danger fileinput-exists" data-dismiss="fileinput"> Remove </a>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Name
                                <span>**</span>
                            </label>
                            <input type="text" name="name" placeholder="Enter Name" value="{{Auth::user()->name}}" class="form-control form-control-lg">
                            @if ($errors->has('name'))
                                <span style="color:red;">
                                    <strong>{{ $errors->first('name') }}</strong>
                                </span>
                            @endif
                        </div>


                        <div class="form-group">
                            <label>Address
                            </label>
                            <input name="address" type="text" placeholder="Enter Address...." value="{{Auth::user()->address}}" class="form-control form-control-lg">
                            @if ($errors->has('address'))
                                <span style="color:red;">
                                    <strong>{{ $errors->first('address') }}</strong>
                                </span>
                            @endif
                        </div>


                        <div class="form-group">
                            <label>Country
                            </label>
                            <input name="country" type="text" placeholder="Enter Country...." value="{{Auth::user()->country}}" class="form-control form-control-lg">
                        </div>

                        <div class="form-group">
                            <label>Zip
                            </label>
                            <input name="zip" type="text" placeholder="Enter Zip...." value="{{Auth::user()->zip}}" class="form-control form-control-lg">
                        </div>

                        <div class="text-center">
                          <button type="submit" class="btn btn-block base-bg form-control-lg" style="color:white;">Update Profile</button>
                        </div>
                    </form>
                  </div>
                </div>

              </div>
          </div>
      </div>
    </div>

@endsection
