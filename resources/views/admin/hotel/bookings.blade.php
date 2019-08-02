@extends('admin.layout.master')

@section('content')
  <main class="app-content">
     <div class="app-title">
        <div>
           <h1>
             @if (request()->path() == 'admin/room/all')
             All
             @elseif (request()->path() == 'admin/room/rejected')
             Rejected
             @endif
             @if (request()->path() == 'admin/room/rejrequest')
               Rejection Reuqest of
             @endif
             Room Bookings
           </h1>
        </div>
     </div>
     <div class="row">
        <div class="col-md-12">
          @if (count($roombookings) == 0)
            <div class="tile">
              <h2 class="text-center">
                NO DATA FOUND
              </h2>
            </div>
          @else
            <div class="tile">
               <div class="table-responsive">
                  <table class="table">
                     <thead>
                        <tr>
                           <th>Serial</th>
                           <th scope="col">Username</th>
                           <th scope="col">Phone</th>
                           <th>Room Name</th>
                           <th>Hotel Name</th>
                           <th scope="col">Total Price</th>
                           <th scope="col">Booking Date</th>
                           <th scope="col">Checkin Date</th>
                           <th scope="col">Duration</th>
                           @if (request()->path() == 'admin/room/rejrequest')
                           <th scope="col">Reason</th>
                           @endif
                           <th>Actions</th>
                        </tr>
                     </thead>
                     <tbody>
                       @php
                         $i = 0;
                       @endphp
                       @foreach ($roombookings as $roombooking)
                         <tr>
                            <td>{{++$i}}</td>
                            <td data-label="Name"><a target="_blank" href="{{route('admin.userDetails', $roombooking->user_id)}}">{{$roombooking->user->username}}</a></td>
                            <td data-label="Email">{{$roombooking->user->phone}}</td>
                            <td><a target="_blank" href="{{route('user.room.show', $roombooking->room_id)}}">{{$roombooking->room->name}}</a></td>
                            <td><a target="_blank" href="{{route('user.hotel.show', $roombooking->room->hotel_id)}}">{{$roombooking->room->hotel->name}}</a></td>
                            <td data-label="Mobile">{{$roombooking->payment*$roombooking->duration}} {{$gs->base_curr_text}}</td>
                            <td data-label="Balance">{{date('jS F, Y' ,strtotime($roombooking->created_at))}}</td>
                            <td data-label="Balance">{{date('jS F, Y' ,strtotime($roombooking->checkin_date))}}</td>
                            <td data-label="Balance">{{$roombooking->duration}} days</td>
                            @if (request()->path() == 'admin/room/rejrequest')
                            <td>
                              <button class="btn btn-primary" type="button" data-toggle="modal" data-target="#reason{{$roombooking->id}}">
                                <i class="fa fa-eye"></i> Show
                              </button>
                            </td>
                            @endif
                            <td>
                              @if ($roombooking->status == 0)
                                <form class="inline-block" action="{{route('admin.room.reject')}}" method="post">
                                  {{csrf_field()}}
                                  <input type="hidden" name="userid" value="{{$roombooking->user_id}}">
                                  <input type="hidden" name="roombookingid" value="{{$roombooking->id}}">
                                  <input type="hidden" name="roomid" value="{{$roombooking->room_id}}">
                                  <button type="submit" class="btn btn-danger" name="button"><i class="fa fa-times"></i> Reject</button>
                                </form>
                              @endif
                              @if ($roombooking->status == -1)
                                <form class="inline-block" action="{{route('admin.room.accept')}}" method="post">
                                  {{csrf_field()}}
                                  <input type="hidden" name="userid" value="{{$roombooking->user_id}}">
                                  <input type="hidden" name="roombookingid" value="{{$roombooking->id}}">
                                  <input type="hidden" name="roomid" value="{{$roombooking->room_id}}">
                                  <button type="submit" class="btn btn-success" name="button"><i class="fa fa-check"></i> Accept</button>
                                </form>
                              @endif

                              <a target="_blank" href="{{route('admin.emailToUser', $roombooking->user_id)}}" class="btn btn-warning"><i class="fa fa-envelope"></i> Send Mail</a>
                            </td>
                         </tr>

                         @if (request()->path() == 'admin/room/rejrequest')
                           <!-- Modal -->
                            <div class="modal fade" id="reason{{$roombooking->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                              <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                  <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLongTitle">Reason</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                      <span aria-hidden="true">&times;</span>
                                    </button>
                                  </div>
                                  <div class="modal-body">
                                    {{$roombooking->message}}
                                  </div>
                                  <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                  </div>
                                </div>
                              </div>
                            </div>
                         @endif
                       @endforeach
                     </tbody>
                  </table>
               </div>
               <div class="text-center">
                 {{$roombookings->links()}}
               </div>
            </div>
          @endif
        </div>
     </div>
  </main>
@endsection
