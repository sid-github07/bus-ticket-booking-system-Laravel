@extends('user.layout.master')

@section('title', "$menu->title")

@section('class', 'bc blog')

@push('styles')
<link rel="stylesheet" type="text/css" href="{{asset('assets/user/css/aboutus.css')}}">
@endpush

@section('content')
  <section id="breadcrumb">
      <div class="overly"></div>
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-lg-8 col-md-10 text-center">
            <div class="breadcrumbinfo">
              <article>
                <h2>{{$menu->title}}</h2>
                <a href="{{route('user.home')}}">Home</a> <span>/</span>
                <a class="active" href="#">{{$menu->name}}</a>
              </article>
            </div>
          </div>
        </div>
    </div>
  </section>
  <!-- =========== banner end =========== -->


  <section id="aboutus">
  	<div class="container">
  		<div class="row">
  			<div class="col-md-12">
          <div class="" style="min-height: 250px;">
            {!!$menu->body!!}
          </div>
  			</div>
  		</div>
  	</div>
  </section>
@endsection
