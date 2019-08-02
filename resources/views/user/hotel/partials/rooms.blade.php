<div id="hotelDetails">
  <div class="container">
    <h2 class="base-txt my-4">ROOM TYPES</h2>
    @foreach ($hotel->rooms()->where('a_hidden', 0)->get() as $room)
      <div class="row">
        <div class="col-lg-2 align-self-center">
          <div class="box box-1">
            <a href="{{route('user.room.show', $room->id)}}"><img style="width:100%" src="{{asset('assets/user/img/room_imgs/'.$room->roomimgs()->first()->image)}}" alt="Room Image"></a>
          </div>
        </div>
        <div class="col-lg-2 align-self-center">
          <div class="box box-2">
            <div class="media">
              <div class="media-body align-self-center">
                <p><a href="{{route('user.room.show', $room->id)}}">{{$room->name}}</a></p>
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
                  @foreach ($room->amenities as $amenity)
                    <i title="{{$amenity->name}}" class="base-txt fa fa-{{$amenity->code}}"></i>
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
                  <button class="book-now" type="button" href="#" data-toggle="modal" data-target="#roombookingmodal{{$room->id}}">Book</button>
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
      <div class="modal fade" id="roombookingmodal{{$room->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
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
                <input type="hidden" name="room_id" value="{{$room->id}}">
                <input type="hidden" name="payment" value="{{$room->payment}}">
                @auth
                  <input type="hidden" name="user_id" value="{{Auth::user()->id}}">
                @endauth
                <div class="form-group">
                  <label for="">Checkin Date: <span class="required">**</span></label>
                  <input id="checkin{{$room->id}}" name="checkin_date" data-toggle="datepicker" class="form-control" required autocomplete="off">
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
        $roombookings = \App\RoomBooking::where('room_id', $room->id)->where('status', 0)->get();
        $bookingdates = [];
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
          $('#checkin{{$room->id}}').datepicker({
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

  </div>
</div>
