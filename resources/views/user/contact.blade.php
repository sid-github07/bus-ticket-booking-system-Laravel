@extends('user.layout.master')

@section('title', 'Contact')

@section('class', 'bc blog')

@push('styles')
  <link rel="stylesheet" type="text/css" href="{{asset('assets/user/css/contact.css')}}">
	<link rel="stylesheet" type="text/css" href="{{asset('assets/user/css/bc.css')}}">
@endpush

@section('content')
  <section id="breadcrumb">
    <div class="overly"></div>
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-lg-8 col-md-10 text-center">
          <div class="breadcrumbinfo">
            <article>
              <h2>Contacts Us</h2>
              <a href="{{route('user.home')}}">Home</a> <span>/</span>
              <a class="active" href="#">Contacts Us</a>
            </article>
          </div>
        </div>
      </div>
  </div>
  </section>
  <!-- =========== banner end =========== -->


  <!--================================
      contact us  part start
  =====================================-->
  <section id="contact-main">

    <div class="contact-form-area-padding">
      <div class="container">
        <div class="row contact-form-area">
          {{-- <div class="col-lg-6">
            <div class="img">

            </div>
          </div> --}}
          <div class="col-lg-8 offset-md-2 contact-form">
            <div class="row">
              <div class="col-12">
                <div class="contact-block-form">
                  <h4>Keep in touch</h4>
                  <p>There are many variations of passages of Lorem Ipsum available but the majority a have suffered alteration in some form by injected humour or randomised look even slightly believable. </p>
                </div>
              </div>
            </div>
            <form id="c-form" action="{{route('user.contactMail')}}" method="post">
              {{csrf_field()}}
              <div class="row">
                <div class="col-md-12">
                  <input type="text" class="form-control" placeholder="Enter Name" name="name" required>
                  @if ($errors->has('name'))
                    <p class="em no-margin">{{$errors->first('name')}}</p>
                  @endif
                </div>
                <div class="col-md-12">
                  <input type="email" class="form-control" placeholder="Eenter Mail" name="email" required>
                  @if ($errors->has('email'))
                    <p class="em no-margin">{{$errors->first('email')}}</p>
                  @endif
                </div>
                <div class="col-md-12">
                  <input type="text" class="form-control" placeholder="Subject" name="subject" required>
                  @if ($errors->has('subject'))
                    <p class="em no-margin">{{$errors->first('subject')}}</p>
                  @endif
                </div>
                <div class="col-12">
                  <textarea class="form-control" rows="3" id="comment" placeholder="Message" name="message" required></textarea>
                  @if ($errors->has('message'))
                    <p class="em no-margin">{{$errors->first('message')}}</p>
                  @endif
                </div>
                <div class="col-12">
                  <div class="btn-wrapper text-center margin-top-30">
                    <button type="submit" class="btn btn-contact" style="width:220px">Submit</button>
                  </div>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
     <div class="container-fluid">
        <div class="row">
           <div class="col-12">
              <div class="google_map_wrapper">
                  <div id="map"></div>
                </div>
             <div class="contact-address">
               <div class="con-num">
                 <div>
                    <div class="media">
                        <i class="fa fa-map-marker mr-3"></i>
                        <div class="media-body">
                          <h5>Address</h5>
                          <p>{{$gs->address}}</p>
                        </div>
                      </div>
                 </div>
                 <div>
                    <div class="media">
                        <i class="fa fa-mobile mr-3"></i>
                        <div class="media-body">
                          <h5>Phone</h5>
                            <a class="d-block" href="tel:+333123456789">
                                Mobile: {{$gs->phone}}
                            </a>
                        </div>
                      </div>
                 </div>
                 <div>
                    <div class="media mlc">
                        <i class="fa fa-envelope mr-3"></i>
                        <div class="media-body">
                          <h5>Email</h5>
                            <a class="d-block" href="mailto:example@gmail.com">
                                {{$gs->email}}
                              </a>
                        </div>
                      </div>
                 </div>

               </div>
             </div>
             </div>
        </div>
      </div>

   </section>
   <!--================================
       contact us part end
       =====================================-->
@endsection

@push('scripts')
  <!--    map js -->
  <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC7eALQrRUekFNQX71IBNkxUXcz-ALS-MY&sensor=false"></script>
  <script>
    var latitude = {{$gs->latitude}};
    var longitude = {{$gs->longitude}};
  </script>
  <script src="{{asset('assets/user/js/plugins/gmap.js')}}"></script>
@endpush
