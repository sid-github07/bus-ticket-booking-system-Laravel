@extends('user.layout.master')

@section('title', 'SMS Verification')

@section('class', 'bc packeg hotel')

@section('content')
    <section id="breadcrumb">
      <div class="overly"></div>
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-lg-8 col-md-10 text-center">
            <div class="breadcrumbinfo">
              <article>
                <h2>SMS Verification</h2>
                <a href="{{route('user.home')}}">Home</a> <span>/</span>
                <a class="active" href="#">SMS Verification</a>
              </article>
            </div>
          </div>
        </div>
    </div>
  </section>
  <!-- =========== banner end =========== -->

  <div class="row py-5">
    <div class="col-md-6 offset-md-3 content" style="padding:331px 0px;">
      <div class="login-header">
        <h4 style="">A code has been sent to your phone please enter the code to verify your phone number</h4>
      </div>
      <div class="login-form">
        @if (session()->has('error'))
          <div class="alert alert-danger" role="alert">
            {{session('error')}}
          </div>
        @endif
        <form action="{{route('user.checkSmsVerification')}}" method="POST">
          {{csrf_field()}}
          <div class="form-group">
              <label>Phone
              </label>
              <input type="text" name="phone" value="{{Auth::user()->phone}}" placeholder="" class="form-control" readonly>
          </div>
          <div class="form-group">
              <label>Verification Code
                  <span>**</span>
              </label>
              <input type="text" name="sms_ver_code" value="" placeholder="Enter your verification code..." class="form-control">
              @if ($errors->has('sms_ver_code'))
                  <span style="color:red;">
                      <strong>{{ $errors->first('sms_ver_code') }}</strong>
                  </span>
              @endif
          </div>
          <div class="text-center">
            <input class="btn btn-success btn-block" type="submit" value="Submit">
          </div>
        </form>
        <form action="{{route('user.sendVcode')}}" method="POST">
            {{csrf_field()}}
              <input type="hidden" name="phone" value="{{Auth::user()->phone}}" placeholder="" class="input-field-square">
              <div>
                if you didn't get any mail <button class="btn btn-link" type="submit">click here</button> to resend
              </div>
        </form>
      </div>
    </div>
  </div>

@endsection
