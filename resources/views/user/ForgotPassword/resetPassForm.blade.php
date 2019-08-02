@extends('user.layout.master')

@section('title', 'Reset Password')

@section('class', 'bc packeg hotel')

@section('content')
  <section id="breadcrumb">
    <div class="overly"></div>
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-lg-8 col-md-10 text-center">
          <div class="breadcrumbinfo">
            <article>
              <h2>Reset Password</h2>
              <a href="{{route('user.home')}}">Home</a> <span>/</span>
              <a class="active" href="#">Reset Password</a>
            </article>
          </div>
        </div>
      </div>
  </div>
</section>
<!-- =========== banner end =========== -->

  <!-- Login Section Start -->

    <div class="col-md-6 offset-md-3 py-5">
      <div class="card">
        <div class="card-body">
          <form action="{{route('user.resetPassword')}}" method="post">
            {{csrf_field()}}
            <input type="hidden" name="code" value="{{$code}}">
            <input type="hidden" name="email" value="{{$email}}">

            <div class="form-group">
                <label>New Password
                    <span>**</span>
                </label>
                <input type="password" name="password" value="" placeholder="New Password...." class="form-control">
                @if ($errors->has('password'))
                    <span style="color:red;">
                        <strong>{{ $errors->first('password') }}</strong>
                    </span>
                @endif
            </div>

            <div class="form-group">
                <label>Password Confirmation
                    <span>**</span>
                </label>
                <input type="password" name="password_confirmation" value="" placeholder="Enter Password Again...." class="form-control">
                @if ($errors->has('password_confirmation'))
                    <span style="color:red;">
                        <strong>{{ $errors->first('password_confirmation') }}</strong>
                    </span>
                @endif
            </div>
            <div class="text-center">
              <input class="btn btn-success" type="submit" value="Update Password">
            </div>

          </form>
        </div>
      </div>

      </div>
    </div>
@endsection
