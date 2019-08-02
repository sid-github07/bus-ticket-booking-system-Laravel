
@extends('user.layout.master')

@section('title', 'Lounge Search')

@section('class', 'bc packeg hotel')

@section('content')

  <section id="breadcrumb">
    <div class="overly"></div>
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-lg-8 col-md-10 text-center">
          <div class="breadcrumbinfo">
            <article>
              <h2>Pickup Cars</h2>
              <a href="#">Home</a>
              <span>/</span>
              <a class="active" href="#">Pickup Cars</a>
            </article>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- =========== banner end =========== -->

  <section id="popular_turs">
    <div class="container">
      <div class="row">
        @if (count($lounges) == 0)
          <div class="col-md-12">
            <div class="row">
              <div class="col-md-12 text-center">
                <h3>NO LOUNGE FOUND</h3>
              </div>
            </div>
          </div>
        @else
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
                    <span class="align-self-center">{{$gs->base_curr_symbol}} {{$lounge->price}}</span>
                  </div>
                </article>
              </div>
            </div>
          @endforeach
        @endif

      </div>
    </div>
  </section>
@endsection
