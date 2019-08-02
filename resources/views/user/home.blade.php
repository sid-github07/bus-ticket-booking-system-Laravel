@extends('user.layout.master')

@section('title', 'Home')

@section('class', 'index-2')

@section('content')

  @includeif('user.layout.partials.banner-choose')

  <!-- =========== Popular Tours Start ============= -->

  <section id="popular_turs">
    <div class="overly"></div>
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-lg-7 col-md-10 text-center">
          <h2 class="section-heading">{{$gs->package_title}}</h2>
          <p class="section-paragraph">{{$gs->package_details}}</p>
        </div>
      </div>
      <div class="row tur-slider">

        @foreach ($buypackages as $pack)
          @php
            $package = \App\Package::find($pack->package_id);
          @endphp
          <div class="col-lg-4 col-md-6">
            <div class="c-box">
              <div class="img">
                <img class="img-fluid" src="{{asset('assets/user/img/package_imgs/'.$package->packageimgs()->first()->image)}}" alt="">
              </div>
              <article style="min-height: 246px;">
                <h4>{{strlen($package->name) > 20 ? substr($package->name, 0, 20) . '...' : $package->name}}</h4>
                <div class="b-c">
                  <ul>
                    <li>
                      <i class="fa fa-clock-o"></i> {{$package->duration}} Days</li>
                    <li>
                      <span class="span">|</span>
                    </li>
                    <li>
                      <i class="fa fa-user"></i> {{$package->minimum_persons}} - {{$package->maximum_persons}} People</li>
                  </ul>
                </div>
                <p>{!! (strlen(strip_tags($package->overview)) > 100) ? substr(strip_tags($package->overview), 0, 100) . '...' : strip_tags($package->overview) !!}</p>
                <div class="footer d-flex justify-content-between">
                  <a href="{{route('user.package.show', $package->id)}}">View Details</a>
                  <span class="align-self-center">{{$gs->base_curr_symbol}} {{$package->price}}/Day</span>
                </div>
              </article>
            </div>
          </div>
        @endforeach
      </div>
    </div>
  </section>
  <!-- =========== Popular Tours end ============= -->

  <!-- =============== popular Destinations Start ================= -->
  <section id="popular_destinations">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-lg-7 col-md-10 text-center">
          <h2 class="section-heading">{{$gs->hotel_title}}</h2>
          <p class="section-paragraph">{{$gs->hotel_details}}</p>
        </div>
      </div>
      <div class="row">
        @foreach ($roombookings as $roombooking)
          @php
            $hotel = \App\Room::find($roombooking->room_id)->hotel;
          @endphp
          <div class="col-lg-4 col-sm-6 p-0 mr-px-15">
            <div class="c-box">
              <div class="img">
                <img class="img-fluid" src="{{asset('assets/user/img/hotel_imgs/'.$hotel->hotelimgs()->first()->image)}}" alt="">
              </div>
              <article>
                <div class="footer d-flex justify-content-between">
                  <div>
                    <span><i class="fa fa-map-marker"></i> {{strlen($hotel->name) > 14 ? substr($hotel->name, 0, 14) . '...' : $hotel->name}}</span>
                    <a class="v-a" href="{{route('user.hotel.show', $hotel->id)}}">View Details</a>
                  </div>
                  <p class="align-self-center">{{$hotel->rooms()->count()}} Rooms</p>
                </div>
              </article>
            </div>
          </div>
        @endforeach
      </div>
    </div>
  </section>
  <!-- =============== popular Destinations End ================= -->


  <!--================ Our Offers Area Start ======================-->
  <section id="offers">
    <div class="overly-2"></div>
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-lg-7 col-md-10 newsletter">
          <div class="n-box">
            <article>
              <h2 class="seaction-heading text-center">{{$gs->subsc_title}}</h2>
              <p class="section-paragraph text-center">{{$gs->subsc_details}}</p>
              <form action="{{route('users.subsc.store')}}" method="post" class="text-center">
                {{csrf_field()}}
                <input type="email" name="email" class="mamunur_rashid_form" placeholder="Your Email Address" required>
                @if ($errors->has('email'))
                  <p class="em no-margin">{{$errors->first('email')}}</p>
                @endif
                <button style="width:200px;cursor:pointer;" type="submit" class="mamunur_rashid_form mr-btn">SUBSCRIBE</button>

              </form>
            </article>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!--================ Our Offers Area End ======================-->


  <!--================ top travelling Area Start ================= -->

  <section id="top_travell">
    <div class="overly"></div>
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-lg-7 col-md-10 text-center">
          <h2 class="section-heading">{{$gs->lounge_title}}</h2>
          <p class="section-paragraph">{{$gs->lounge_details}}</p>
        </div>
      </div>
      <div class="row top-t-slider">
        @foreach ($loungebookings as $loungebooking)
          @php
            $lounge = \App\Lounge::find($loungebooking->lounge_id)
          @endphp
          <div class="col-lg-4">
            <div class="c-box">
              <div class="img">
                <img class="img-fluid align-self-center" src="{{asset('assets/user/img/lounge_imgs/'.$lounge->loungeimgs()->first()->image)}}" alt="">
              </div>
              <article>
                <h4>{{strlen($lounge->name) > 14 ? substr($lounge->name, 0, 14) . '...' : $lounge->name}}</h4>
                <p><strong>{{$gs->base_curr_symbol}} {{$lounge->price}}/Person</strong></p>
                <p>
                  {!! (strlen(strip_tags($lounge->overview)) > 100) ? substr(strip_tags($lounge->overview), 0, 100) . '...' : strip_tags($lounge->overview) !!}
                </p>
                <div class="footer">
                  <a href="{{route('user.lounge.show', $lounge->id)}}">More Details</a>
                </div>
              </article>
            </div>
          </div>
        @endforeach

      </div>
    </div>
  </section>
  <!--================ top travelling Area End ================= -->

@endsection
