@extends('user.layout.master')

@section('title', 'Lounges')

@section('class', 'bc packeg hotel')

@section('content')

  <section id="breadcrumb">
    <div class="overly"></div>
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-lg-8 col-md-10 text-center">
          <div class="breadcrumbinfo">
            <article>
              <h2>Lounges</h2>
              <a href="{{route('user.home')}}">Home</a>
              <span>/</span>
              <a class="active" href="#">Lounges</a>
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
        @foreach ($lounges as $lounge)
          <div class="col-lg-4 col-md-6">
            <div class="c-box">
              <div class="img">
                <img class="img-fluid" src="{{asset('assets/user/img/lounge_imgs/'.$lounge->loungeimgs()->first()->image)}}" alt="">
              </div>
              <article style="min-height: 205px;">
                <h4>{{strlen($lounge->name) > 20 ? substr($lounge->name, 0, 20) . '...' : $lounge->name}}</h4>

                <p>{!! (strlen(strip_tags($lounge->overview)) > 100) ? substr(strip_tags($lounge->overview), 0, 100) . '...' : strip_tags($lounge->overview) !!}</p>
                <div class="footer d-flex justify-content-between">
                  <a href="{{route('user.lounge.show', $lounge->id)}}">View Details</a>
                  <span class="align-self-center">{{$gs->base_curr_symbol}} {{$lounge->price}}/Person</span>
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
