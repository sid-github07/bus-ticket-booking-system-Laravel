@extends('user.layout.master')

@section('class', 'bc packeg hotel')

@section('title', "Sign in")

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
              <h2>Login</h2>
              <a href="{{route('user.home')}}">Home</a> <span>/</span>
              <a class="active" href="#">Login</a>
            </article>
          </div>
        </div>
      </div>
  </div>
</section>
<!-- =========== banner end =========== -->


<!-- =============== Hotel  Area Start ============================ -->

<section id="popular_turs">
    <div class="container">
      <div class="row">
        <div class="col-lg-6 offset-lg-3">
          <form action="{{route('user.login')}}" method="post">
            {{csrf_field()}}
            <div class="container">
              @if (session()->has('missmatch'))
                <div class="alert alert-danger">
                  {{session('missmatch')}}
                </div>
              @endif
              <label for="email"><b>Username</b></label>
              <input type="text" placeholder="Enter Username" name="username">
              <p style="margin:0px;clear:both;"></p>
              @if ($errors->has('username'))
                <p class="em">{{$errors->first('username')}}</p>
              @endif
              <br />

              <label for="psw"><b>Password</b></label>
              <input type="password" placeholder="Enter Password" name="password">
              <p style="margin:0px;clear:both;"></p>
              @if ($errors->has('password'))
                <p class="em">{{$errors->first('password')}}</p>
              @endif
              <br />
              <hr>
              <p><a style="text-decoration:underline;" href="{{route('user.showEmailForm')}}">Forgot Password?</a></p>

              <button type="submit" class="registerbtn base-bg">Login</button>
            </div>
            <br>
            <div class="container signin">
              <p style="padding: 20px;">Don't have an account? <a href="{{route('user.showRegForm')}}" style="text-decoration:underline;">Sign up</a>.</p>
            </div>
          </form>
        </div>
      </div>
    </div>
  </section>
<!-- =============== Hotel  Area End ============================ -->
@endsection
