@extends('user.layout.master')

@section('class', 'bc packeg hotel')

@section('title', "Sign up")

@push('styles')
<link rel="stylesheet" href="{{asset('assets/user/css/reglog.css')}}">
@endpush

@section('content')
    <section id="breadcrumb">
      <div class="overly"></div>
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-lg-8 col-md-10 text-center">
            <div class="breadcrumbinfo">
              <article>
                <h2>Register</h2>
                <a href="{{route('user.home')}}">Home</a> <span>/</span>
                <a class="active" href="#">Register</a>
              </article>
            </div>
          </div>
        </div>
    </div>
  </section>
  <!-- =========== banner end =========== -->

  <div class="py-5">
      <div class="container">
              <div class="row">
      <div class="col-lg-6 offset-lg-3">
        <form action="{{route('user.reg')}}" method="post">
          {{csrf_field()}}
          <div class="container">
            <label for="email"><b>Username</b></label>
            <input type="text" placeholder="Enter Username" name="username" value="{{old('username')}}">
            <p style="margin:0px;clear:both;"></p>
            @if ($errors->has('username'))
              <p class="em">{{$errors->first('username')}}</p>
            @endif
            <br />

            <label for="email"><b>Email</b></label>
            <input type="text" placeholder="Enter Email" name="email" value="{{old('email')}}">
            <p style="margin:0px;clear:both;"></p>
            @if ($errors->has('email'))
              <p class="em">{{$errors->first('email')}}</p>
            @endif
            <br />

            <label for="email"><b>Name</b></label>
            <input type="text" placeholder="Enter Name" name="name" value="{{old('name')}}">
            <p style="margin:0px;clear:both;"></p>
            @if ($errors->has('name'))
              <p class="em">{{$errors->first('name')}}</p>
            @endif
            <br />

            <label for="email"><b>Phone</b></label>
            <input type="text" placeholder="Enter Phone Number (use phone code)" name="phone" value="{{old('phone')}}">
            <p style="margin:0px;clear:both;"></p>
            @if ($errors->has('phone'))
              <p class="em">{{$errors->first('phone')}}</p>
            @endif
            <br />

            <label for="psw"><b>Password</b></label>
            <input type="password" placeholder="Enter Password" name="password">
            <p style="margin:0px;clear:both;"></p>
            @if ($errors->has('password'))
              <p class="em">{{$errors->first('password')}}</p>
            @endif
            <br>

            <label for="psw-repeat"><b>Repeat Password</b></label>
            <input type="password" placeholder="Repeat Password" name="password_confirmation">
            <p style="margin:0px;clear:both;"></p>
            <hr>
            <p>By creating an account you agree to our <a href="#" data-toggle="modal" data-target="#tosModal">Terms & Privacy</a>.</p>

            <button type="submit" class="registerbtn base-bg">Register</button>
          </div>
          <br>
          <div class="container signin">
            <p style="padding: 20px;">Already have an account? <a href="{{route('user.showLoginForm')}}" style="text-decoration:underline;">Sign in</a>.</p>
          </div>
        </form>
      </div>
    </div>
      </div>

  </div>

  <!-- TOS Modal -->
  <div class="modal fade" id="tosModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLongTitle">Terms & Privacy</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          {!!$gs->tos!!}
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
@endsection
