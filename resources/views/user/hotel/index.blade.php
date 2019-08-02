@extends('user.layout.master')

@section('class', 'bc packeg hotel')

@section('title', 'Hotels')

@push('styles')
<link rel="stylesheet" href="{{asset('assets/user/css/details.css')}}">
@endpush

@section('content')
		<section id="breadcrumb">
			<div class="overly"></div>
			<div class="container">
				<div class="row justify-content-center">
					<div class="col-lg-8 col-md-10 text-center">
						<div class="breadcrumbinfo">
							<article>
								<h2>Hotels</h2>
								<a href="{{route('user.home')}}">Home</a> <span>/</span>
								<a class="active" href="#">Hotels</a>
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
          @foreach ($hotels as $hotel)
						@if ($hotel->rooms()->count() > 0)
							<div class="col-lg-4 col-md-6">
	  						<div class="c-box">
	  							<div class="img">
	  								<img class="img-fluid" src="{{asset("assets/user/img/hotel_imgs/".$hotel->hotelimgs()->first()->image)}}" alt="">
	  								<a href="{{route('user.hotel.show', $hotel->id)}}" class="sd-box">Show Datails</a>
	  							</div>
	  							<article>
	  								<div class="footer d-flex justify-content-between">
	  									<div class="left">

	  								<h3>{{strlen($hotel->name) > 13 ? substr($hotel->name, 0, 13) . '...' : $hotel->name}}</h3>
	  								<span>Starting From </span>
	  								<div class="stars">
	  									<ul>
												<div id="rateYo{{$hotel->id}}"></div>
	  									</ul>
	  								</div>
	  									</div>
	  									<div class="right align-self-center">{{$gs->base_curr_symbol}} {{$hotel->rooms()->min('payment')}} / Night</div>
	  								</div>
	  							</article>
	  						</div>
	  					</div>
							<script>
							$(document).ready(function() {
								$("#rateYo{{$hotel->id}}").rateYo({
									rating: {{$hotel->hotelreviews()->avg('rating')}},
									readOnly: true,
									starWidth: "16px"
								});
							});
							</script>
						@endif

          @endforeach
				</div>
			</div>
    </section>
	<!-- =============== Hotel  Area End ============================ -->
@endsection
