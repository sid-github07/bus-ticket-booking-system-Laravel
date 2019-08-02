
@extends('user.layout.master')

@section('title', 'Rent Car Details')
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
              <h2 style="font-size:32px;" class="base-txt">{{$rentcar->title}}</h2>
           </div>
           <div class="row my-1">
              <div class="col-lg-8">
                 <div class="">
                   <div class="preview">

         						<div class="preview-pic tab-content">
                      @foreach ($rentcar->rentcarimgs as $rentcarimg)
         						  <div class="tab-pane {{($loop->iteration==1)?'active' : ''}}" id="pic-{{$rentcarimg->id}}"><img style="width:100%" src="{{asset('assets/user/img/rentcar_imgs/'.$rentcarimg->image)}}" /></div>
                      @endforeach
                    </div>
         						<ul class="preview-thumbnail nav nav-tabs">
                      @foreach ($rentcar->rentcarimgs as $rentcarimg)
                      <li class="{{($loop->iteration==1)?'active' : ''}}"><a data-target="#pic-{{$rentcarimg->id}}" data-toggle="tab"><img style="width:200px;" src="{{asset('assets/user/img/rentcar_imgs/'.$rentcarimg->image)}}" /></a></li>
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
                        <a class="nav-item nav-link @if(session('rating')) active show @endif" id="nav-reviews-tab" data-toggle="tab" href="#nav-reviews" role="tab" aria-controls="nav-reviews" aria-selected="false">REVIEWS</a>
                        @if (Auth::check() && $rentcar->rentcarreviews()->where('user_id', Auth::user()->id)->count() == 0)
                          <a class="nav-item nav-link @if(session('ratingerr')) active show @endif" id="nav-writereview-tab" data-toggle="tab" href="#nav-writereview" role="tab" aria-controls="nav-writereview" aria-selected="false">WRITE REVIEW</a>
                        @endif
                        @guest
                          <a class="nav-item nav-link" id="nav-writereview-tab" data-toggle="tab" href="#nav-writereview" role="tab" aria-controls="nav-writereview" aria-selected="false">WRITE REVIEW</a>
                        @endguest
             					</div>
             				</nav>
             				<div class="tab-content px-sm-0" id="nav-tabContent">
             					<div class="tab-pane fade @if(!session('rating') && !session('ratingerr')) active show @endif" id="nav-overview" role="tabpanel" aria-labelledby="nav-overview-tab">
                        @includeif('user.rentcar.partials.overview')
             					</div>
             					<div class="tab-pane fade @if(session('rating')) active show @endif" id="nav-reviews" role="tabpanel" aria-labelledby="nav-reviews-tab">
                        @includeif('user.rentcar.partials.comments')
             					</div>
                      @if (Auth::check() && $rentcar->rentcarreviews()->where('user_id', Auth::user()->id)->count() == 0)
                        <div class="tab-pane fade @if(session('ratingerr')) active show @endif" id="nav-writereview" role="tabpanel" aria-labelledby="nav-writereview-tab">
                          @includeif('user.rentcar.partials.writereview')
               					</div>
                      @endif
                      @guest
                        <div class="tab-pane fade" id="nav-writereview" role="tabpanel" aria-labelledby="nav-writereview-tab">
                          @includeif('user.rentcar.partials.writereview')
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
                         {{$rentcar->capacity}} Persons
                      </div>
                      <div class="mb-10">
                         <strong style="display:inline-block;"><i class="fa fa-money" aria-hidden="true"></i> Payment: </strong>
                         {{$rentcar->payment}} {{$gs->base_curr_text}} / Day
                      </div>
                      <div class="mb-10">
                         <p class="no-margin"><strong style="display:inline-block;"><i class="fa fa-map-marker"></i> Address: </strong></p>
                         {{$rentcar->address}}
                      </div>
                      @if (Auth::check())
                        <div>
                          <button style="color:white;" class="btn base-bg btn-block" type="button" data-toggle="modal" data-target="#bookingmodal">Book Now</button>
                        </div>
                      @else
                        <div>
                          <a href="{{route('user.showLoginForm')}}" style="color:white;" class="btn base-bg btn-block">Book Now</a>
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
          <h5 class="modal-title" id="exampleModalLongTitle">Rent a Car</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form class="" action="{{route('user.rentcar.booking')}}" method="post">
            {{csrf_field()}}
            <input type="hidden" name="rent_car_id" value="{{$rentcar->id}}">
            <input type="hidden" name="payment" value="{{$rentcar->payment}}">
            @auth
              <input type="hidden" name="user_id" value="{{Auth::user()->id}}">
            @endauth
            <div class="form-group">
              <label for="">Rent Date: <span class="required">**</span></label>
              <input type="text" name="rent_date" data-toggle="datepicker" class="form-control" required autocomplete="off">
            </div>
            <div class="form-group">
              <label for="">Duration: <span class="required">**</span></label>
              <input class="form-control" type="number" name="duration" value="0" oninput="clacTotal({{$rentcar->payment}}, this.value)">
            </div>

            <div class="form-group">
              @if (Auth::check())
                <button style="color:white;" type="submit" class="btn base-bg btn-block">Confirm Booking ({{$gs->base_curr_symbol}} <span id="totalprice">{{$rentcar->payment * 0}}</span>)</button>
              @else
                <a style="color:white;" class="btn base-bg btn-block" href="{{route('user.showLoginForm')}}">BOOK NOW</a>
              @endif
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
@endsection

@push('scripts')
<script>
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

 function clacTotal(payment, duration) {
   totalPrice = payment * duration;
   document.getElementById('totalprice').innerHTML = totalPrice;
 }
</script>
@endpush
