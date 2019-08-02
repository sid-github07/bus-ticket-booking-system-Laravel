
@extends('user.layout.master')

@section('title', 'Pickup Cars Search')

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

  <!-- =============== Rent Cars Area Start ============================ -->

  <section id="popular_turs">
    <div class="container">
      <div class="row">
        @if (count($pickups) == 0)
          <div class="col-md-12">
            <div class="row">
              <div class="col-md-12">
                <h3>NO PICKUP CAR FOUND</h3>
              </div>
            </div>
          </div>
        @else
          @foreach ($pickups as $pickup)
            <div class="col-lg-4 col-md-6">
              <div class="c-box">
                <div class="img">
                  <img class="img-fluid" src="{{asset('assets/user/img/pickup_imgs/'.\App\PickupCarImg::where('pickup_car_id', $pickup->pickup_id)->first()->image)}}" alt="">
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
                    <a href="{{route('user.pickup.show', $pickup->pickup_id)}}">View Details</a>
                  </div>
                </article>
              </div>
            </div>
          @endforeach
        @endif

      </div>
    </div>
  </section>
  <!-- =============== Packges  Area End ============================ -->
@endsection
