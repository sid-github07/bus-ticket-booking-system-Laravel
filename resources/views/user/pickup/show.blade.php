
@extends('user.layout.master')

@section('title', 'Pickup Car Details')
@section('class', 'bc packeg hotel')

@push('styles')
<link rel="stylesheet" href="{{asset('assets/user/css/details.css')}}">
<link rel="stylesheet" href="{{asset('assets/user/css/tab.css')}}">
<link rel="stylesheet" href="{{asset('assets/user/css/comments.css')}}">
@endpush

@section('content')
  <div class="details-content">
     <div class="container">
        <div class="">
           <div class="">
              <h2 style="font-size:32px;" class="base-txt">{{$pickup->title}}</h2>
           </div>
           <div class="row my-1">
              <div class="col-lg-8">
                 <div class="">
                   <div class="preview">

         						<div class="preview-pic tab-content">
                      @foreach ($pickup->pickupcarimgs as $pickupimg)
         						  <div class="tab-pane {{($loop->iteration==1)?'active' : ''}}" id="pic-{{$pickupimg->id}}"><img style="width:100%" src="{{asset('assets/user/img/pickup_imgs/'.$pickupimg->image)}}" /></div>
                      @endforeach
                    </div>
         						<ul class="preview-thumbnail nav nav-tabs">
                      @foreach ($pickup->pickupcarimgs as $pickupimg)
                      <li class="{{($loop->iteration==1)?'active' : ''}}"><a data-target="#pic-{{$pickupimg->id}}" data-toggle="tab"><img style="width:200px;" src="{{asset('assets/user/img/pickup_imgs/'.$pickupimg->image)}}" /></a></li>
                      @endforeach
         						</ul>

         					</div>
                 </div>
                 <br>
                 <div class="row">
             			<div class="col-md-12">
             				<nav>
             					<div class="nav nav-tabs nav-fill" id="nav-tab" role="tablist">
             						<a class="nav-item nav-link @if(!session('rating') && !session('ratingerr')) active show @endif" id="nav-overview-tab" data-toggle="tab" href="#nav-overview" role="tab" aria-controls="nav-overview" aria-selected="true">OVERVIEW</a>
                        <a class="nav-item nav-link" id="nav-dropoff-tab" data-toggle="tab" href="#nav-dropoff" role="tab" aria-controls="nav-dropoff" aria-selected="false">Dropoff Locations</a>
                        <a class="nav-item nav-link @if(session('rating')) active show @endif" id="nav-reviews-tab" data-toggle="tab" href="#nav-reviews" role="tab" aria-controls="nav-reviews" aria-selected="false">REVIEWS</a>
                        @if (Auth::check() && $pickup->pickupreviews()->where('user_id', Auth::user()->id)->count() == 0)
                          <a class="nav-item nav-link @if(session('ratingerr')) active show @endif" id="nav-writereview-tab" data-toggle="tab" href="#nav-writereview" role="tab" aria-controls="nav-writereview" aria-selected="false">WRITE REVIEW</a>
                        @endif
                        @guest
                          <a class="nav-item nav-link" id="nav-writereview-tab" data-toggle="tab" href="#nav-writereview" role="tab" aria-controls="nav-writereview" aria-selected="false">WRITE REVIEW</a>
                        @endguest
             					</div>
             				</nav>
             				<div class="tab-content px-sm-0" id="nav-tabContent">
             					<div class="tab-pane fade @if(!session('rating') && !session('ratingerr')) active show @endif" id="nav-overview" role="tabpanel" aria-labelledby="nav-overview-tab">
                        @includeif('user.pickup.partials.overview')
             					</div>
                      <div class="tab-pane fade" id="nav-dropoff" role="tabpanel" aria-labelledby="nav-dropoff-tab">
                        @includeif('user.pickup.partials.dropoff')
             					</div>
             					<div class="tab-pane fade @if(session('rating')) active show @endif" id="nav-reviews" role="tabpanel" aria-labelledby="nav-reviews-tab">
                        @includeif('user.pickup.partials.comments')
             					</div>
                      @if (Auth::check() && $pickup->pickupreviews()->where('user_id', Auth::user()->id)->count() == 0)
                        <div class="tab-pane fade @if(session('ratingerr')) active show @endif" id="nav-writereview" role="tabpanel" aria-labelledby="nav-writereview-tab">
                          @includeif('user.pickup.partials.writereview')
               					</div>
                      @endif
                      @guest
                        <div class="tab-pane fade" id="nav-writereview" role="tabpanel" aria-labelledby="nav-writereview-tab">
                          @includeif('user.pickup.partials.writereview')
                        </div>
                      @endguest
             				</div>

             			</div>
             		</div>
                <br>
                 <div class="text-center" style="margin-bottom: 20px;">
                    {!!show_ad(2)!!}
                 </div>
                 {{-- Facebook comments section --}}
                 <div class="fb-comments" data-href="{{url()->current()}}" data-numposts="5"></div>

                 <div class="text-center" style="margin-top: 20px;">
                    {!!show_ad(2)!!}
                 </div>
                 <br>
              </div>
              <div class="col-lg-4">
                <div class="card mb-20">
                  <div class="card-header base-bg">
                    <h4 class="caption no-margin" style="color:white;">Details</h4>
                  </div>
                   <div class="card-body">
                      <div class="mb-10">
                         <strong style="display:inline-block;"><i class="fa fa-users"></i> Capacity: </strong>
                         {{$pickup->capacity}} Persons
                      </div>
                      <div class="mb-10">
                         <p class="no-margin"><strong style="display:inline-block;"><i class="fa fa-map-marker"></i> Pickup Location: </strong></p>
                         {{$pickup->pickup_location}}
                      </div>
                      {{-- <div>
                        <button style="color:white;" class="btn base-bg btn-block" type="button" data-toggle="modal" data-target="#bookingmodal">Book Now</button>
                      </div> --}}
                      @if (Auth::check())
                        <div class="">
                          <button type="button" class="btn base-bg btn-block" style="color:white;" data-toggle="modal" data-target="#bookingmodal"> <i class="fa fa-shopping-cart"></i> Book Now</button>
                        </div>
                      @else
                        <div class="">
                          <a class="btn base-bg btn-block" style="color:white;" href="{{route('user.showLoginForm')}}"> <i class="fa fa-shopping-cart"></i> Book Now</a>
                        </div>
                      @endif
                   </div>
                </div>


                 <div class="card mb-20">
                   <div class="card-header base-bg">
                     <h4 class="caption no-margin" style="color:white;">Social Share</h4>
                   </div>
                    <div class="card-body">
                       <div class="social-icons">
                          <div class="col-md-12">
                             <ul class="social-network social-circle">
                               <a href="https://www.facebook.com/sharer/sharer.php?u={{urlencode(url()->current()) }}" class="fa fa-facebook"></a>
                               <a href="https://twitter.com/intent/tweet?text=my share text&amp;url={{urlencode(url()->current()) }}" class="fa fa-twitter"></a>
                               <a href="https://plus.google.com/share?url={{urlencode(url()->current()) }}" class="fa fa-google-plus"></a>
                               <a href="http://www.linkedin.com/shareArticle?mini=true&amp;url={{urlencode(url()->current()) }}&amp;title=my share text&amp;summary=dit is de linkedin summary" class="fa fa-linkedin"></a>
                             </ul>
                          </div>
                       </div>
                    </div>
                 </div>
                 <div class="">
                    <div class="text-center" style="margin-top:20px;">
                      {!!show_ad(1)!!}
                    </div>
                    <div class="text-center" style="margin-top:20px;">
                      {!!show_ad(3)!!}
                    </div>
                 </div>

              </div>
           </div>
        </div>
     </div>
  </div>


  <!-- Modal -->
  <div class="modal fade" id="bookingmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLongTitle">Pickup Car Booking</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form class="" action="{{route('user.pickup.booking')}}" method="post">
            {{csrf_field()}}
            <input type="hidden" name="pickup_car_id" value="{{$pickup->id}}">
            @auth
              <input type="hidden" name="user_id" value="{{Auth::user()->id}}">
            @endauth
            <div class="form-group">
              <label for="">Pickup Date: <span class="required">**</span></label>
              <input type="text" name="pickup_date" data-toggle="datepicker" class="form-control" required autocomplete="off">
            </div>
            <div class="form-group">
              <label for="">Pickup Time:</label>
              <input id="pickuptime" type="text" class="form-control" name="pickup_time" value="" data-step="30" autocomplete="off" required>
            </div>
            <div class="form-group">
              <label for="">Dropoff Location: <span class="required">**</span></label>
              <select id="dropoff" class="form-control" name="dropoff_id" required>
                @foreach ($pickup->dropofflocs as $dropoff)
                  <option value="{{$dropoff->id}}">{{$dropoff->location}} ({{$gs->base_curr_symbol}} {{$dropoff->price}})</option>
                @endforeach
              </select>
            </div>

            <div class="form-group">
              <button style="color:white;" type="submit" class="btn base-bg btn-block">Confirm Booking</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
@endsection

@push('scripts')
<script>
var did = document.getElementById('dropoff').value;
var pid = {{$pickup->id}};
$(".fb-comments").attr("data-width", $(".fb-comments").parent().width());
     $(window).on('resize', function () {
         resizeiframe();
     });

 function resizeiframe() {
     var src = $('.fb-comments iframe').attr('src').split('width='),
         width = $(".fb-comments").parent().width();

     $('.fb-comments iframe').attr('src', src[0] + 'width=' + width);
 }

 $(document).ready(function() {
   var array = JSON.parse('<?php echo json_encode($bookingdates); ?>');
   var today = new Date();
   console.log(array);
     $('[data-toggle="datepicker"]').datepicker({
        numberOfMonths: 3,
        minDate: today,
        beforeShowDay: function(date){
            var string = jQuery.datepicker.formatDate('yy-mm-dd', date);
            return [ array.indexOf(string) == -1 ]
        }
      });
 });
 $( document ).ready(function() {
   // initialize input widgets first
   $('#pickuptime').timepicker();
 });
</script>
@endpush
