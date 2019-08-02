
@extends('user.layout.master')

@section('title', 'Package Details')
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
              <h2 style="font-size:32px;" class="base-txt">{{$package->name}}</h2>
           </div>
           <div class="row my-1">
              <div class="col-lg-8">
                 <div class="">
                   <div class="preview">

         						<div class="preview-pic tab-content">
                      @foreach ($package->packageimgs as $packageimg)
         						  <div class="tab-pane {{($loop->iteration==1)?'active' : ''}}" id="pic-{{$packageimg->id}}"><img style="width:100%" src="{{asset('assets/user/img/package_imgs/'.$packageimg->image)}}" /></div>
                      @endforeach
                    </div>
         						<ul class="preview-thumbnail nav nav-tabs">
                      @foreach ($package->packageimgs as $packageimg)
                      <li class="{{($loop->iteration==1)?'active' : ''}}"><a data-target="#pic-{{$packageimg->id}}" data-toggle="tab"><img style="width:200px;" src="{{asset('assets/user/img/package_imgs/'.$packageimg->image)}}" /></a></li>
                      @endforeach
         						</ul>

         					</div>
                 </div>
                 <br>
                 <div class="row">
             			<div class="col-xs-12 ">
             				<nav>
             					<div class="nav nav-tabs nav-fill" id="nav-tab" role="tablist">
             						<a class="nav-item nav-link active" id="nav-overview-tab" data-toggle="tab" href="#nav-overview" role="tab" aria-controls="nav-overview" aria-selected="true">OVERVIEW</a>
             						<a class="nav-item nav-link" id="nav-program-tab" data-toggle="tab" href="#nav-program" role="tab" aria-controls="nav-program" aria-selected="false">Program Schedules</a>
             					</div>
             				</nav>
             				<div class="tab-content px-sm-0" id="nav-tabContent">
             					<div class="tab-pane fade active show" id="nav-overview" role="tabpanel" aria-labelledby="nav-overview-tab">
                        @includeif('user.package.partials.overview')
             					</div>
             					<div class="tab-pane fade" id="nav-program" role="tabpanel" aria-labelledby="nav-program-tab">
                        @includeif('user.package.partials.program')
             					</div>
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
                      <strong class="card-title">Date:</strong><br>
                      <p class="card-text" style="display:inline-block;">{{$package->start_date}} until {{$package->closing_date}}</p>
                    </div>
                    <hr>
                    <div class="">
                      <strong class="card-title">Book Package:</strong><br>
                      <span>
                        <span>Per Person</span><br>
                        <span>{{$gs->base_curr_symbol}} {{$package->price}}</span>
                        <select class="float-right" onchange="clacTotal({{$package->price}}, this.value)">
                          @for ($i=$package->minimum_persons; $i <= $package->maximum_persons; $i++)
                            <option value="{{$i}}">{{$i}}</option>
                          @endfor
                        </select>
                      </span>
                    </div>
                    <hr>
                    <div class="">
                      <strong>Total:</strong>
                      <span class="float-right">
                        {{$gs->base_curr_symbol}}
                        <span id="totalPrice"></span>
                      </span>
                    </div>
                    <br>
                    @if (strtotime(date('Y-m-d')) >= strtotime($package->closing_date))
                      <div class="text-center">
                        <strong style="color:red;">Booking Closed</strong>
                      </div>
                    @elseif (Auth::check())
                      <div class="text-center">
                        <a id="buyNowBtn" href="#" class="btn base-bg btn-block" data-toggle="modal" data-target="#bookmodal" style="color:white;">Book Now</a>
                      </div>
                    @else
                      <div class="text-center">
                        <a href="{{route('user.showLoginForm')}}" class="btn base-bg btn-block" tyle="color:white;">Book Now</a>
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
  <div class="modal fade" id="bookmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLongTitle">Book Tour Package</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form class="" action="{{route('package.buy')}}" method="post">
            {{csrf_field()}}
            <input type="hidden" name="package_id" value="{{$package->id}}">
            @auth
              <input type="hidden" name="user_id" value="{{Auth::user()->id}}">
            @endauth
            <div class="form-group">
              <label for="">Checkin Date: <span class="required">**</span></label>
              <input type="text" name="checkin_date" data-toggle="datepicker" class="form-control" required autocomplete="off">
            </div>

            <input id="personin" type="hidden" name="persons" value="">

            <div class="form-group">
              @if (Auth::check())
                <button style="color:white;" type="submit" class="btn base-bg btn-block">Confirm Booking</button>
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
var persons;
$(".fb-comments").attr("data-width", $(".fb-comments").parent().width());
     $(window).on('resize', function () {
         resizeiframe();
     });

 function resizeiframe() {
     var src = $('.fb-comments iframe').attr('src').split('width='),
         width = $(".fb-comments").parent().width();

     $('.fb-comments iframe').attr('src', src[0] + 'width=' + width);
 }


 function clacTotal(pp_price, p_no) {
   persons = p_no;
   totalPrice = pp_price * p_no;
   document.getElementById('totalPrice').innerHTML = totalPrice;
   document.getElementById('personin').value = p_no;
 }


 $(document).ready(function() {
   clacTotal({{$package->price}}, {{$package->minimum_persons}});
 });


 $(document).ready(function() {
   var today = new Date();
     $('[data-toggle="datepicker"]').datepicker({
        numberOfMonths: 3,
        minDate: today,
      });
 });
</script>
@endpush
