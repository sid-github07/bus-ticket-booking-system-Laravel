@extends('user.layout.master')

@section('title', 'About')

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
                <h2>About</h2>
                <a href="{{route('user.home')}}">Home</a> <span>/</span>
                <a class="active" href="#">About</a>
              </article>
            </div>
          </div>
        </div>
    </div>
  </section>
  <!-- =========== banner end =========== -->

  <!-- ============= About Us Area Start ============= -->
  <section id="aboutus">
  	<div class="container">
  		<div class="row">
  			<div class="col-md-6">
  				<div class="about-img">
  					<img class="img-fluid" src="{{asset('assets/user/img/'.$gs->about_img)}}" alt="">
  				</div>
  			</div>
  			<div class="col-md-6">
  				<h3>About Us</h3>
          <div class="">
            {!!$gs->about_content!!}
          </div>
  			</div>
  		</div>
  	</div>
  </section>


  <!-- ============= About Us Area End ============= -->
@endsection
