@extends('user.layout.master')

@section('title', "Change Password")

@section('content')

    <div style="padding:214px 0px;">
      <div class="container">
          <div class="row">
              <div class="col-md-8 offset-md-2">
                <div class="card">
                  <div class="card-header base-bg">
                    <h2 class="py-3 caption no-margin">CHANGE PASSWORD</h2>
                  </div>
                  <div class="card-body">
                    <form class="contact-from-wrapper" method="post" action="{{route('users.updatePassword')}}">
                        {{csrf_field()}}
                        <div class="form-group">
                            <label>Old Password
                                <span>**</span>
                            </label>
                            <input type="password" name="old_password" placeholder="Old Password...." class="form-control form-control-lg">
                            @if ($errors->has('old_password'))
                                <span style="color:red;">
                                    <strong>{{ $errors->first('old_password') }}</strong>
                                </span>
                            @else
                                @if ($errors->first('oldPassMatch'))
                                    <span style="color:red;">
                                        <strong>{{"Old password doesn't match with the existing password!"}}</strong>
                                    </span>
                                @endif
                            @endif
                        </div><br>


                        <div class="form-group">
                            <label>New Password
                                <span>**</span>
                            </label>
                            <input name="password" type="password" placeholder="New Password...." class="form-control form-control-lg">
                            @if ($errors->has('password'))
                                <span style="color:red;">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span>
                            @endif
                        </div><br>


                        <div class="form-group">
                            <label>Password Confirmation
                                <span>**</span>
                            </label>
                            <input name="password_confirmation" type="password" placeholder="Password Confirmation...." class="form-control form-control-lg">
                        </div><br>

                        <div class="text-center">
                          <button type="submit" class="btn btn-block base-bg form-control-lg" style="color:white;">Update Password</button>
                        </div>
                    </form>
                  </div>
                </div>

              </div>
          </div>
      </div>
    </div>

@endsection
