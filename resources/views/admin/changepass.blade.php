@extends('admin.layout.master')

@section('content')
  <main class="app-content">
     <div class="app-title">
        <div>
           <h1>Change Password</h1>
        </div>
     </div>
     <div class="row">
        <div class="col-md-12">
           <div class="tile">
              <div class="tile-body">
                <div class="row">
                  <div class="col-md-6 offset-md-3">
                    <form action="{{route('admin.updatePassword')}}" method="post" role="form">
                       {{csrf_field()}}
                       <div class="form-body">
                          <div class="form-group">
                             <label class="control-label"><strong>Current Password</strong></label>
                             <div class="">
                                <input class="form-control input-lg" name="old_password" placeholder="Your Current Password" type="password">
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
                             </div>
                          </div>
                          <div class="form-group">
                             <label class="control-label"><strong>New Password</strong></label>
                             <div class="">
                                <input class="form-control input-lg" name="password" placeholder="New Password" type="password">
                                @if ($errors->has('password'))
                                <span style="color:red;">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span>
                                @endif
                             </div>
                          </div>
                          <div class="form-group">
                             <label class="control-label"><strong>New Password Again</strong></label>
                             <div class="">
                                <input class="form-control input-lg" name="password_confirmation" placeholder="New Password Again" type="password">
                             </div>
                          </div>
                          <div class="row">
                             <div class="col-md-12">
                                <button type="submit" class="btn btn-info btn-block">Submit</button>
                             </div>
                          </div>
                       </div>
                    </form>
                  </div>
                </div>

              </div>
           </div>
        </div>
     </div>
  </main>
@endsection
