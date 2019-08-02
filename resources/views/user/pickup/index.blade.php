@extends('user.layout.master')

@section('title', 'Pickup Cars')

@section('class', 'bc packeg hotel')

@section('content')

  <section id="breadcrumb">
    <div class="overly"></div>
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-lg-8 col-md-10 text-center">
          <div class="breadcrumbinfo">
            <article>
              <h2>Cars (Pick up)</h2>
              <a href="{{route('user.home')}}">Home</a>
              <span>/</span>
              <a class="active" href="#">Cars (Pick up)</a>
            </article>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- =========== banner end =========== -->

  <!-- =============== Packges  Area Start ============================ -->

  <section id="popular_turs">
    <div class="container">
      <div class="row">
        @foreach ($pickups as $pickup)
          <div class="col-lg-4 col-md-6">
            <div class="c-box">
              <div class="img">
                <img class="img-fluid" src="{{asset('assets/user/img/pickup_imgs/'.$pickup->pickupcarimgs()->first()->image)}}" alt="">
              </div>
              <article style="min-height: 246px;">
                <h4>{{strlen($pickup->title) > 20 ? substr($pickup->title, 0, 20) . '...' : $pickup->title}}</h4>
                <div class="b-c">
                  <ul>
                    <li>
                      <i class="fa fa-users"></i> {{$pickup->capacity}} Persons (Adult)</li>
                  </ul>
                </div>
                <p>{!! (strlen(strip_tags($pickup->overview)) > 100) ? substr(strip_tags($pickup->overview), 0, 100) . '...' : strip_tags($pickup->overview) !!}</p>
                <div class="footer d-flex justify-content-between">
                  <a href="{{route('user.pickup.show', $pickup->id)}}">View Details</a>
                </div>
              </article>
            </div>
          </div>
        @endforeach
      </div>
    </div>
  </section>
  <!-- =============== Packges  Area End ============================ -->
@endsection
