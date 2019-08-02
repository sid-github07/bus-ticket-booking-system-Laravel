
@extends('user.layout.master')

@section('title', 'Lounge Details')
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
              <h2 style="font-size:32px;" class="base-txt">{{$lounge->name}}</h2>
           </div>
           <div class="row my-1">
              <div class="col-lg-8">
                 <div class="">
                   <div class="preview">

         						<div class="preview-pic tab-content">
                      @foreach ($lounge->loungeimgs as $loungeimg)
         						  <div class="tab-pane {{($loop->iteration==1)?'active' : ''}}" id="pic-{{$loungeimg->id}}"><img style="width:100%" src="{{asset('assets/user/img/lounge_imgs/'.$loungeimg->image)}}" /></div>
                      @endforeach
                    </div>
         						<ul class="preview-thumbnail nav nav-tabs">
                      @foreach ($lounge->loungeimgs as $loungeimg)
                      <li class="{{($loop->iteration==1)?'active' : ''}}"><a data-target="#pic-{{$loungeimg->id}}" data-toggle="tab"><img style="width:200px;" src="{{asset('assets/user/img/lounge_imgs/'.$loungeimg->image)}}" /></a></li>
                      @endforeach
         						</ul>

         					</div>
                 </div>
                 <br>
                 <div class="row">
             			<div class="col-md-12 ">
             				<nav>
             					<div class="nav nav-tabs nav-fill" id="nav-tab" role="tablist">
             						<a class="nav-item nav-link @if(!session('rating') && !session('ratingerr')) active show @endif" id="nav-overview-tab" data-toggle="tab" href="#nav-overview" role="tab" aria-controls="nav-overview" aria-selected="true">OVERVIEW</a>
                        <a class="nav-item nav-link" id="nav-amenities-tab" data-toggle="tab" href="#nav-amenities" role="tab" aria-controls="nav-amenities" aria-selected="false">AMENITIES</a>
                        <a class="nav-item nav-link @if(session('rating')) active show @endif" id="nav-reviews-tab" data-toggle="tab" href="#nav-reviews" role="tab" aria-controls="nav-reviews" aria-selected="false">REVIEWS</a>
                        @if (Auth::check() && $lounge->loungereviews()->where('user_id', Auth::user()->id)->count() == 0)
                          <a class="nav-item nav-link @if(session('ratingerr')) active show @endif" id="nav-writereview-tab" data-toggle="tab" href="#nav-writereview" role="tab" aria-controls="nav-writereview" aria-selected="false">WRITE REVIEW</a>
                        @endif
                        @guest
                          <a class="nav-item nav-link" id="nav-writereview-tab" data-toggle="tab" href="#nav-writereview" role="tab" aria-controls="nav-writereview" aria-selected="false">WRITE REVIEW</a>
                        @endguest
             					</div>
             				</nav>
             				<div class="tab-content px-sm-0" id="nav-tabContent">
             					<div class="tab-pane fade @if(!session('rating') && !session('ratingerr')) active show @endif" id="nav-overview" role="tabpanel" aria-labelledby="nav-overview-tab">
                        @includeif('user.lounge.partials.overview')
             					</div>
                      <div class="tab-pane fade" id="nav-amenities" role="tabpanel" aria-labelledby="nav-amenities-tab">
                        @includeif('user.lounge.partials.amenities')
             					</div>
             					<div class="tab-pane fade @if(session('rating')) active show @endif" id="nav-reviews" role="tabpanel" aria-labelledby="nav-reviews-tab">
                        @includeif('user.lounge.partials.comments')
             					</div>
                      @if (Auth::check() && $lounge->loungereviews()->where('user_id', Auth::user()->id)->count() == 0)
                        <div class="tab-pane fade @if(session('ratingerr')) active show @endif" id="nav-writereview" role="tabpanel" aria-labelledby="nav-writereview-tab">
                          @includeif('user.lounge.partials.writereview')
               					</div>
                      @endif
                      @guest
                        <div class="tab-pane fade" id="nav-writereview" role="tabpanel" aria-labelledby="nav-writereview-tab">
                          @includeif('user.lounge.partials.writereview')
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
                  <h4 class="card-header caption no-margin base-bg">Details</h4>
                  <div class="card-body">
                    <div class="">
                       <strong class="card-title" style="display:inline-block;"><i class="fa fa-map-marker"></i> Location: </strong>
                       {{$lounge->location}}
                    </div>
                    <div class="">
                       <strong class="card-title" style="display:inline-block;"><i class="fa fa-money"></i> Per Person:</strong>
                       {{$gs->base_curr_symbol}} {{$lounge->price}}
                    </div>
                    <div class="">
                       <strong class="card-title" style="display:inline-block;"><i class="fa fa-users"></i> Maximum Persons: </strong>
                       {{$lounge->persons}}
                    </div>
                    <div class="">
                       <strong class="card-title" style="display:inline-block;"><i class="fa fa-clock-o"></i> Opening Hour: </strong>
                       {{$lounge->opening_hour}} - {{$lounge->closing_hour}}
                    </div>
                    <div class="">
                       <strong class="card-title" style="display:inline-block;"><i class="fa fa-calendar"></i> Closing Days: </strong>
                       @foreach ($lounge->loungeclosingdays as $closingday)
                         @if ($closingday->closing_day == 1)
                           <strong class="badge badge-danger">Monday</strong>
                         @elseif ($closingday->closing_day == 2)
                           <strong class="badge badge-danger">Tuesday</strong>
                         @elseif ($closingday->closing_day == 3)
                           <strong class="badge badge-danger">Wednesday</strong>
                         @elseif ($closingday->closing_day == 4)
                           <strong class="badge badge-danger">Thursday</strong>
                         @elseif ($closingday->closing_day == 5)
                           <strong class="badge badge-danger">Friday</strong>
                         @elseif ($closingday->closing_day == 6)
                           <strong class="badge badge-danger">Saturday</strong>
                         @elseif ($closingday->closing_day == 0)
                           <strong class="badge badge-danger">Sunday</strong>
                         @endif
                       @endforeach
                    </div>

                    @if (Auth::check())
                      <div class="">
                        <button style="color:white;" type="button" class="btn btn-block base-bg" name="button" data-toggle="modal" data-target="#bookmodal">Book Now</button>
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


  {{-- Book Modal --}}
  <div class="modal fade" id="bookmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLongTitle">Book This Lounge</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form class="" action="{{route('user.lounge.booking')}}" method="post">
            {{csrf_field()}}
            <input type="hidden" name="lounge_id" value="{{$lounge->id}}">
            @auth
              <input type="hidden" name="user_id" value="{{Auth::user()->id}}">
            @endauth
            <div class="form-group">
              <label for="">Checkin Date:</label>
              <input type="text" data-toggle="datepicker" class="form-control" name="checkin_date" value="" required autocomplete="off">
            </div>
            <div class="form-group">
              <label for="">Checkin Time:</label>
              <input id="checkintime" type="text" class="form-control" name="checkin_time" value="" data-step="30" autocomplete="off" data-min-time="{{$lounge->opening_hour}}" data-max-time="{{$lounge->closing_hour}}" required>
            </div>
            <div class="form-group">
              <label for="">Number of Persons:</label>
              <select class="form-control" name="persons" onchange="clacTotal({{$lounge->price}}, this.value)">
                @for ($i=1; $i<=$lounge->persons; $i++)
                  <option value="{{$i}}">{{$i}}</option>
                @endfor
              </select>
            </div>
            <div class="form-group">
              <button style="color:white;" type="submit" class="btn btn-block base-bg">Confirm Booking <strong>(Total: <span id="totalprice">{{$lounge->price}} {{$gs->base_curr_text}}</span>)</strong></button>
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
      var today = new Date();
     $('[data-toggle="datepicker"]').datepicker({
        numberOfMonths: 2,
        minDate: today,
        beforeShowDay: function(date) {
            var day = date.getDay();
            return [day!={{empty($lounge->loungeclosingdays[0])?'null':$lounge->loungeclosingdays[0]->closing_day}} && day!={{empty($lounge->loungeclosingdays[1])?'null':$lounge->loungeclosingdays[1]->closing_day}} && day!={{empty($lounge->loungeclosingdays[2])?'null':$lounge->loungeclosingdays[2]->closing_day}} && day!={{empty($lounge->loungeclosingdays[3])?'null':$lounge->loungeclosingdays[3]->closing_day}} && day!={{empty($lounge->loungeclosingdays[4])?'null':$lounge->loungeclosingdays[4]->closing_day}} && day!={{empty($lounge->loungeclosingdays[5])?'null':$lounge->loungeclosingdays[5]->closing_day}} && day!={{empty($lounge->loungeclosingdays[6])?'null':$lounge->loungeclosingdays[6]->closing_day}}];
        }
      });
 });
 $( document ).ready(function() {
   // initialize input widgets first
   $('#checkintime').timepicker();
 });

 function clacTotal(pp_price, p_no) {
   totalPrice = pp_price * p_no;
   document.getElementById('totalprice').innerHTML = totalPrice;
 }
</script>
@endpush
