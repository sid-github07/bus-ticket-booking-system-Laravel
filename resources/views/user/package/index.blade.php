@extends('user.layout.master')

@section('title', 'Packages')

@section('class', 'bc packeg hotel')

@section('content')

  <section id="breadcrumb">
    <div class="overly"></div>
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-lg-8 col-md-10 text-center">
          <div class="breadcrumbinfo">
            <article>
              <h2>Packages</h2>
              <a href="{{route('user.home')}}">Home</a>
              <span>/</span>
              <a class="active" href="#">Packeges</a>
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
        @foreach ($packages as $package)
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
                  <span class="align-self-center">{{$gs->base_curr_symbol}} {{$package->price}}/Person</span>
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
