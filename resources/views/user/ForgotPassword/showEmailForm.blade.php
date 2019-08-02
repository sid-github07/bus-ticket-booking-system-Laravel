@extends('user.layout.master')

@section('title', 'Email Form')

@section('class', 'bc packeg hotel')

@section('content')
    <section id="breadcrumb">
      <div class="overly"></div>
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-lg-8 col-md-10 text-center">
            <div class="breadcrumbinfo">
              <article>
                <h2>Email</h2>
                <a href="{{route('user.home')}}">Home</a> <span>/</span>
                <a class="active" href="#">Email Form</a>
              </article>
            </div>
          </div>
        </div>
    </div>
  </section>
  <!-- =========== banner end =========== -->

  <div class="row py-5">
    <div class="col-md-6 offset-md-3">

      @if (session()->has('email_not_available'))
        <div class="alert alert-danger">
          {{session('email_not_available')}}
        </div>
      @endif
      @if (session()->has('message'))
        <div class="alert alert-success">
          {{session('message')}}
        </div>
      @endif

      <div class="card">
        <div class="card-header base-bg">
          <h3 style="color:white">Email</h3>
        </div>
        <div class="card-body">
          <form style="max-width:500px;margin:0 auto;" id="sendResetPassMailForm" action="{{route('user.sendResetPassMail')}}" class="" method="post">
            {{csrf_field()}}
            <div class="form-group login">
                <input name="resetEmail" type="text" placeholder="Enter your mail address...." class="form-control form-control-lg">
                @if ($errors->has('resetEmail'))
                  <p class="text-danger">{{$errors->first('resetEmail')}}</p>
                @endif
            </div>
            <div class="form-group text-center">
              <input class="btn btn-success" type="submit" name="" value="Send">
            </div>
          </form>
        </div>
      </div>

    </div>
  </div>
@endsection
