@extends('admin.layout.master')

@section('content')
  <main class="app-content">
     <div class="app-title">
        <div>
           <h1>
             @if (request()->path() == 'admin/rentcar/all')
             All
           @elseif (request()->path() == 'admin/rentcar/rejected')
             Rejected
             @endif
             @if (request()->path() == 'admin/rentcar/rejrequest')
               Rejection Reuqest of
             @endif
             Rent Car Bookings
           </h1>
        </div>
     </div>
     <div class="row">
        <div class="col-md-12">
          @if (count($rentcarbookings) == 0)
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
                           <th>Location</th>
                           <th scope="col">Total Payment</th>
                           <th scope="col">Booking Date</th>
                           <th scope="col">Rent Date</th>
                           <th scope="col">Duration</th>
                           @if (request()->path() == 'admin/rentcar/rejrequest')
                           <th scope="col">Reason</th>
                           @endif
                           <th>Actions</th>
                        </tr>
                     </thead>
                     <tbody>
                       @php
                         $i = 0;
                       @endphp
                       @foreach ($rentcarbookings as $rentcarbooking)
                         <tr>
                            <td>{{++$i}}</td>
                            <td data-label="Name"><a target="_blank" href="{{route('admin.userDetails', $rentcarbooking->user_id)}}">{{$rentcarbooking->user->username}}</a></td>
                            <td data-label="Email">{{$rentcarbooking->user->phone}}</td>
                            <td><a target="_blank" href="{{route('user.rentcar.show', $rentcarbooking->rent_car_id)}}">{{$rentcarbooking->rent_car->title}}</a></td>
                            <td data-label="Mobile">{{$rentcarbooking->rent_car->address}}</td>
                            <td data-label="Mobile">{{$rentcarbooking->payment*$rentcarbooking->duration}} {{$gs->base_curr_text}}</td>
                            <td data-label="Balance">{{date('jS F, Y' ,strtotime($rentcarbooking->created_at))}}</td>
                            <td data-label="Balance">{{date('jS F, Y' ,strtotime($rentcarbooking->rent_date))}}</td>
                            <td data-label="Balance" style="text-transform:uppercase;">{{$rentcarbooking->duration}} Days</td>
                            @if (request()->path() == 'admin/rentcar/rejrequest')
                            <td>
                              <button class="btn btn-primary" type="button" data-toggle="modal" data-target="#reason{{$rentcarbooking->id}}">
                                <i class="fa fa-eye"></i> Show
                              </button>
                            </td>
                            @endif
                            <td>
                              @if ($rentcarbooking->status == 0)
                                <form class="inline-block" action="{{route('admin.rentcar.reject')}}" method="post">
                                  {{csrf_field()}}
                                  <input type="hidden" name="userid" value="{{$rentcarbooking->user_id}}">
                                  <input type="hidden" name="rentcarbookingid" value="{{$rentcarbooking->id}}">
                                  <input type="hidden" name="rentcarid" value="{{$rentcarbooking->rentcar_id}}">
                                  <button type="submit" class="btn btn-danger" name="button"><i class="fa fa-times"></i> Reject</button>
                                </form>
                              @endif
                              @if ($rentcarbooking->status == -1)
                                <form class="inline-block" action="{{route('admin.rentcar.accept')}}" method="post">
                                  {{csrf_field()}}
                                  <input type="hidden" name="userid" value="{{$rentcarbooking->user_id}}">
                                  <input type="hidden" name="rentcarbookingid" value="{{$rentcarbooking->id}}">
                                  <input type="hidden" name="rentcarid" value="{{$rentcarbooking->rentcar_id}}">
                                  <button type="submit" class="btn btn-success" name="button"><i class="fa fa-check"></i> Accept</button>
                                </form>
                              @endif

                              <a target="_blank" href="{{route('admin.emailToUser', $rentcarbooking->user_id)}}" class="btn btn-warning"><i class="fa fa-envelope"></i> Send Mail</a>
                            </td>
                         </tr>

                         @if (request()->path() == 'admin/rentcar/rejrequest')
                           <!-- Modal -->
                            <div class="modal fade" id="reason{{$rentcarbooking->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                              <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                  <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLongTitle">Reason</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                      <span aria-hidden="true">&times;</span>
                                    </button>
                                  </div>
                                  <div class="modal-body">
                                    {{$rentcarbooking->message}}
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
                 {{$rentcarbookings->links()}}
               </div>
            </div>
          @endif
        </div>
     </div>
  </main>
@endsection
