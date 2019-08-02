@extends('user.layout.master')

@section('title', 'Rooms Search')

@section('class', 'bc packeg hotel')

@section('content')

  <section id="breadcrumb">
    <div class="overly"></div>
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-lg-8 col-md-10 text-center">
          <div class="breadcrumbinfo">
            <article>
              <h2>Rooms</h2>
              <a href="#">Home</a>
              <span>/</span>
              <a class="active" href="#">Rooms</a>
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
          <div class="col-md-12">
            <div id="hotelDetails">
              @if (count($rooms) == 0)
                  <div class="row">
                    <div class="col-md-12 text-center">
                      <h2>NO ROOM FOUND</h2>
                    </div>
                  </div>
              @else
                @foreach ($rooms as $room)
                  <div class="row">
                    <div class="col-lg-2 align-self-center">
                      <div class="box box-1">
                        <a href="{{route('user.room.show', $room->room_id)}}"><img style="width:100%" src="{{asset('assets/user/img/room_imgs/'.\App\RoomImg::where('room_id', $room->room_id)->first()->image)}}" alt="Room Image"></a>
                      </div>
                    </div>
                    <div class="col-lg-2 align-self-center">
                      <div class="box box-2">
                        <div class="media">
                          <div class="media-body align-self-center">
                            <p><a href="{{route('user.room.show', $room->room_id)}}">{{$room->room_name}} <br> ({{$room->name}})</a></p>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-lg-2 align-self-center">
                      <div class="box box-3">
                        <div class="media">
                          <div class="media-body align-self-center">
                            <p>{{$room->no_of_persons}} Adults</p>
                          </div>
                        </div>

                      </div>
                    </div>
                    <div class="col-lg-2 align-self-center">
                      <div class="box box-4">
                        <div class="media">
                          <div class="media-body">
                            <p>
                              @foreach (\App\AmenityRoom::where('room_id', $room->room_id)->get() as $amenityroom)
                                  <i title="{{\App\Amenity::find($amenityroom->amenity_id)->name}}" class="base-txt fa fa-{{\App\Amenity::find($amenityroom->amenity_id)->code}}"></i>
                              @endforeach
                            </p>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-lg-2 align-self-center">
                      <div class="box box-4">
                        <div class="media">
                          <div class="media-body">
                            <p>
                              {{$room->payment}}/Night
                            </p>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-lg-2 align-self-center">
                      <div class="box box-3">
                        <div class="media">


                          @if (Auth::check())
                            <div class="media-body align-self-center">
                              <button class="book-now" type="button" href="#" data-toggle="modal" data-target="#roombookingmodal{{$room->room_id}}">Book</button>
                            </div>
                          @else
                            <div class="media-body align-self-center">
                              <a class="book-now" href="{{route('user.showLoginForm')}}">Book</a>
                            </div>
                          @endif
                        </div>

                      </div>
                    </div>
                  </div>
                  <hr class="hd-hr">

                  {{-- Booking Modal --}}
                  <div class="modal fade" id="roombookingmodal{{$room->room_id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title" id="exampleModalLongTitle">Book This Room</h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <div class="modal-body">
                          <form class="" action="{{route('user.room.booking')}}" method="post">
                            {{csrf_field()}}
                            <input type="hidden" name="room_id" value="{{$room->room_id}}">
                            <input type="hidden" name="payment" value="{{$room->payment}}">
                            @auth
                              <input type="hidden" name="user_id" value="{{Auth::user()->id}}">
                            @endauth
                            <div class="form-group">
                              <label for="">Checkin Date: <span class="required">**</span></label>
                              <input id="checkin{{$room->room_id}}" name="checkin_date" data-toggle="datepicker" class="form-control" autocomplete="off" required>
                            </div>
                            <div class="form-group">
                              <label for="">Duration: <span class="required">**</span></label>
                              <input class="form-control" type="number" name="duration" value="" required>
                            </div>
                            <div class="form-group">
                              <button style="color:white;" type="submit" class="btn base-bg btn-block">BOOK ROOM</button>
                            </div>
                          </form>
                        </div>
                      </div>
                    </div>
                  </div>


                  @php
                    $roombookings = \App\RoomBooking::where('room_id', $room->room_id)
                                                ->where(function ($query) {
                                                    $query->where('status', 0)
                                                          ->orWhere('status', 1);
                                                })->get();
                    foreach ($roombookings as $roombooking) {
                      for ($i=0; $i < $roombooking->duration; $i++) {
                        $date = new \Carbon\Carbon($roombooking->checkin_date);
                        $newDate = $date->addDays($i);
                        $bookingdates[] = $newDate->format('Y-m-d');
                      }
                    }
                  @endphp


                  <script>
                  $(document).ready(function() {
                    var array = JSON.parse('<?php echo json_encode($bookingdates); ?>');
                    var today = new Date();
                    console.log(array);
                      $('#checkin{{$room->room_id}}').datepicker({
                         numberOfMonths: 3,
                         minDate: today,
                         beforeShowDay: function(date){
                             var string = jQuery.datepicker.formatDate('yy-mm-dd', date);
                             return [ array.indexOf(string) == -1 ]
                         }
                       });
                  });
                  </script>
                @endforeach
              @endif
            </div>
          </div>
				</div>
			</div>
    </section>

@endsection
