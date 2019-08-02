@extends('user.layout.master')

@section('title', 'Rent Cars')

@section('class', 'bc packeg hotel')

@section('content')

  <section id="breadcrumb">
    <div class="overly"></div>
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-lg-8 col-md-10 text-center">
          <div class="breadcrumbinfo">
            <article>
              <h2>Cars (for Rent)</h2>
              <a href="{{route('user.home')}}">Home</a>
              <span>/</span>
              <a class="active" href="#">Cars (for Rent)</a>
            </article>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- =========== banner end =========== -->

  <!-- =============== Rent Cars Area Start ============================ -->

  <section id="popular_turs">
    <div class="container">
      <div class="row">
        @foreach ($rentcars as $rentcar)
          <div class="col-lg-4 col-md-6">
            <div class="c-box">
              <div class="img">
                <img class="img-fluid" src="{{asset('assets/user/img/rentcar_imgs/'.$rentcar->rentcarimgs()->first()->image)}}" alt="">
              </div>
              <article style="min-height: 246px;">
                <h4>{{strlen($rentcar->title) > 20 ? substr($rentcar->title, 0, 20) . '...' : $rentcar->title}}</h4>
                <div class="b-c">
                  <ul>
                    <li>
                      <i class="fa fa-users"></i> {{$rentcar->capacity}} Persons (Adult)</li>
                  </ul>
                </div>
                <p>{!! (strlen(strip_tags($rentcar->overview)) > 100) ? substr(strip_tags($rentcar->overview), 0, 100) . '...' : strip_tags($rentcar->overview) !!}</p>
                <div class="footer d-flex justify-content-between">
                  <a href="{{route('user.rentcar.show', $rentcar->id)}}">View Details</a>
                  <span class="align-self-center">{{$gs->base_curr_symbol}} {{$rentcar->payment}}/Day</span>
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
