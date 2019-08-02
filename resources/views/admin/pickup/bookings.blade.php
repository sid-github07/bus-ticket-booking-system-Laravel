@extends('admin.layout.master')

@section('content')
  <main class="app-content">
     <div class="app-title">
        <div>
           <h1>
             @if (request()->path() == 'admin/pickupcar/all')
             All
           @elseif (request()->path() == 'admin/pickupcar/rejected')
             Rejected
             @endif
             @if (request()->path() == 'admin/pickupcar/rejrequest')
               Rejection Reuqest of
             @endif
             Pickup Car Bookings
           </h1>
        </div>
     </div>
     <div class="row">
        <div class="col-md-12">
          @if (count($pickupcarbookings) == 0)
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
                           <th>Car Title</th>
                           <th>Pickup Location</th>
                           <th>Dropoff Location</th>
                           <th scope="col">Payment</th>
                           <th scope="col">Booking Date</th>
                           <th scope="col">Pickup Date</th>
                           <th scope="col">Pickup Time</th>
                           @if (request()->path() == 'admin/pickupcar/rejrequest')
                           <th scope="col">Reason</th>
                           @endif
                           <th>Actions</th>
                        </tr>
                     </thead>
                     <tbody>
                       @php
                         $i = 0;
                       @endphp
                       @foreach ($pickupcarbookings as $pickupcarbooking)
                         <tr>
                            <td>{{++$i}}</td>
                            <td data-label="Name"><a target="_blank" href="{{route('admin.userDetails', $pickupcarbooking->user_id)}}">{{$pickupcarbooking->user->username}}</a></td>
                            <td data-label="Email">{{$pickupcarbooking->user->phone}}</td>
                            <td><a target="_blank" href="{{route('user.pickup.show', $pickupcarbooking->pickup_car_id)}}">{{$pickupcarbooking->pickup_car->title}}</a></td>
                            <td data-label="Mobile">{{$pickupcarbooking->pickup_car->pickup_location}}</td>
                            <td data-label="Mobile">{{$pickupcarbooking->location}}</td>
                            <td data-label="Mobile">{{$pickupcarbooking->price}} {{$gs->base_curr_text}}</td>
                            <td data-label="Balance">{{date('jS F, Y' ,strtotime($pickupcarbooking->created_at))}}</td>
                            <td data-label="Balance">{{date('jS F, Y' ,strtotime($pickupcarbooking->pickup_date))}}</td>
                            <td data-label="Balance" style="text-transform:uppercase;">{{$pickupcarbooking->pickup_time}}</td>
                            @if (request()->path() == 'admin/pickupcar/rejrequest')
                            <td>
                              <button class="btn btn-primary" type="button" data-toggle="modal" data-target="#reason{{$pickupcarbooking->id}}">
                                <i class="fa fa-eye"></i> Show
                              </button>
                            </td>
                            @endif
                            <td>
                              @if ($pickupcarbooking->status == 0)
                                <form class="inline-block" action="{{route('admin.pickupcar.reject')}}" method="post">
                                  {{csrf_field()}}
                                  <input type="hidden" name="userid" value="{{$pickupcarbooking->user_id}}">
                                  <input type="hidden" name="pickupcarbookingid" value="{{$pickupcarbooking->id}}">
                                  <input type="hidden" name="pickupcarid" value="{{$pickupcarbooking->pickup_car_id}}">
                                  <button type="submit" class="btn btn-danger" name="button"><i class="fa fa-times"></i> Reject</button>
                                </form>
                              @endif
                              @if ($pickupcarbooking->status == -1)
                                <form class="inline-block" action="{{route('admin.pickupcar.accept')}}" method="post">
                                  {{csrf_field()}}
                                  <input type="hidden" name="userid" value="{{$pickupcarbooking->user_id}}">
                                  <input type="hidden" name="pickupcarbookingid" value="{{$pickupcarbooking->id}}">
                                  <input type="hidden" name="pickupcarid" value="{{$pickupcarbooking->pickup_car_id}}">
                                  <button type="submit" class="btn btn-success" name="button"><i class="fa fa-check"></i> Accept</button>
                                </form>
                              @endif

                              <a target="_blank" href="{{route('admin.emailToUser', $pickupcarbooking->user_id)}}" class="btn btn-warning"><i class="fa fa-envelope"></i> Send Mail</a>
                            </td>
                         </tr>

                         @if (request()->path() == 'admin/pickupcar/rejrequest')
                           <!-- Modal -->
                            <div class="modal fade" id="reason{{$pickupcarbooking->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                              <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                  <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLongTitle">Reason</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                      <span aria-hidden="true">&times;</span>
                                    </button>
                                  </div>
                                  <div class="modal-body">
                                    {{$pickupcarbooking->message}}
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
                 {{$pickupcarbookings->links()}}
               </div>
            </div>
          @endif
        </div>
     </div>
  </main>
@endsection
