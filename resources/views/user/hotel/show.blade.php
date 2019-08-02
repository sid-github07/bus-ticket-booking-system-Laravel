
@extends('user.layout.master')

@section('title', 'Hotel Details')
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
              <h2 style="font-size:32px;" class="base-txt">{{$hotel->name}}</h2>
           </div>
           <div class="row my-1">
              <div class="col-lg-8">
                 <div class="">
                   <div class="preview">

         						<div class="preview-pic tab-content">
                      @foreach ($hotel->hotelimgs as $hotelimg)
         						  <div class="tab-pane {{($loop->iteration==1)?'active' : ''}}" id="pic-{{$hotelimg->id}}"><img style="width:100%" src="{{asset('assets/user/img/hotel_imgs/'.$hotelimg->image)}}" /></div>
                      @endforeach
                    </div>
         						<ul class="preview-thumbnail nav nav-tabs">
                      @foreach ($hotel->hotelimgs as $hotelimg)
                      <li class="{{($loop->iteration==1)?'active' : ''}}"><a data-target="#pic-{{$hotelimg->id}}" data-toggle="tab"><img style="width:200px;" src="{{asset('assets/user/img/hotel_imgs/'.$hotelimg->image)}}" /></a></li>
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
             						<a class="nav-item nav-link" id="nav-rooms-tab" data-toggle="tab" href="#nav-rooms" role="tab" aria-controls="nav-rooms" aria-selected="false">ROOMS</a>
             						<a class="nav-item nav-link" id="nav-amenities-tab" data-toggle="tab" href="#nav-amenities" role="tab" aria-controls="nav-amenities" aria-selected="false">AMENITIES</a>
                        <a class="nav-item nav-link @if(session('rating')) active @endif" id="nav-reviews-tab" data-toggle="tab" href="#nav-reviews" role="tab" aria-controls="nav-reviews" aria-selected="false">REVIEWS</a>
                        @if (Auth::check() && $hotel->hotelreviews()->where('user_id', Auth::user()->id)->count() == 0)
                          <a class="nav-item nav-link @if(session('ratingerr')) active show @endif" id="nav-writereview-tab" data-toggle="tab" href="#nav-writereview" role="tab" aria-controls="nav-writereview" aria-selected="false">WRITE REVIEW</a>
                        @endif
                        @guest
                          <a class="nav-item nav-link" id="nav-writereview-tab" data-toggle="tab" href="#nav-writereview" role="tab" aria-controls="nav-writereview" aria-selected="false">WRITE REVIEW</a>
                        @endguest
                      </div>
             				</nav>
             				<div class="tab-content px-sm-0" id="nav-tabContent">
             					<div class="tab-pane fade show @if(!session('rating') && !session('ratingerr')) active show @endif" id="nav-overview" role="tabpanel" aria-labelledby="nav-overview-tab">
                        @includeif('user.hotel.partials.overview')
             					</div>
             					<div class="tab-pane fade" id="nav-rooms" role="tabpanel" aria-labelledby="nav-rooms-tab">
                        @includeif('user.hotel.partials.rooms')
             					</div>
             					<div class="tab-pane fade" id="nav-amenities" role="tabpanel" aria-labelledby="nav-amenities-tab">
                        @includeif('user.hotel.partials.amenities')
             					</div>
             					<div class="tab-pane fade @if(session('rating')) active show @endif" id="nav-reviews" role="tabpanel" aria-labelledby="nav-reviews-tab">
                        @includeif('user.hotel.partials.comments')
             					</div>
                      @if (Auth::check() && $hotel->hotelreviews()->where('user_id', Auth::user()->id)->count() == 0)
                        <div class="tab-pane fade @if(session('ratingerr')) active show @endif" id="nav-writereview" role="tabpanel" aria-labelledby="nav-writereview-tab">
                          @includeif('user.hotel.partials.writereview')
               					</div>
                      @endif
                      @guest
                        <div class="tab-pane fade" id="nav-writereview" role="tabpanel" aria-labelledby="nav-writereview-tab">
                          @includeif('user.hotel.partials.writereview')
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
                     <h4 class="caption no-margin" style="color:white;">Contact Hotel</h4>
                   </div>
                    <div class="card-body">
                       <div class="mb-10">
                          <strong style="display:inline-block;"><i class="fa fa-phone"></i></strong>
                          {{$hotel->phone}}
                       </div>
                       <div class="mb-10">
                          <strong class="card-title" style="display:inline-block;"><i class="fa fa-envelope" aria-hidden="true"></i></strong>
                          {{$hotel->email}}
                       </div>
                       <div class="">
                          <strong class="card-title" style="display:inline-block;"><i class="fa fa-map-marker"></i></strong>
                          {{$hotel->address}}
                       </div>
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

</script>
@endpush
